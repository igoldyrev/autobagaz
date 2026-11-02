<?php

namespace App\Services;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ProductImageVariants
{
    public const SIZES = [160, 480, 960];

    private const VERSION = 1;

    public function generate(ProductImage $image, bool $force = false): string
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            return 'unavailable';
        }
        $prefix = 'storage/products/'.$image->product_id.'/';
        if (! str_starts_with($image->path, $prefix) || str_contains($image->path, '..')) {
            return 'unsupported';
        }
        $disk = Storage::disk('public');
        $original = substr($image->path, strlen('storage/'));
        if (! $disk->exists($original)) {
            throw new RuntimeException('Исходная фотография не найдена: №'.$image->id);
        }
        $path = $disk->path($original);
        $info = @getimagesize($path);
        if (! $info || ! in_array($info['mime'], ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return 'unsupported';
        }
        $hash = hash_file('sha256', $path);
        if (! $force && ($image->variants['version'] ?? null) === self::VERSION && ($image->variants['sha256'] ?? null) === $hash
            && count($image->availableVariants()) === count(self::SIZES)) {
            return 'unchanged';
        }
        $orientation = $info['mime'] === 'image/jpeg' && function_exists('exif_read_data') ? (int) (@exif_read_data($path)['Orientation'] ?? 1) : 1;
        // Decode only images that fit alongside Laravel and a resized true-colour canvas.
        $limit = $this->memoryLimit();
        $estimate = $info[0] * $info[1] * (in_array($orientation, [3, 4, 5, 6, 7, 8], true) ? 10 : 6) + filesize($path) + 960 * 960 * 8 + 16 * 1024 * 1024;
        if ($info[0] < 1 || $info[1] < 1 || ($limit > 0 && memory_get_usage(true) + $estimate > $limit)) {
            return 'too_large';
        }
        $contents = file_get_contents($path);
        if (($info['mime'] === 'image/png' && str_contains($contents, 'acTL')) || ($info['mime'] === 'image/webp' && str_contains($contents, 'ANIM'))) {
            return 'unsupported'; // Preserve animation by serving the original.
        }
        if ($info['mime'] === 'image/jpeg' && str_contains($contents, 'Exif') && ! function_exists('exif_read_data')) {
            return 'unsupported'; // Do not lose a possible EXIF orientation.
        }
        $source = @imagecreatefromstring($contents);
        unset($contents);
        if (! $source) {
            throw new RuntimeException('Не удалось декодировать фотографию №'.$image->id);
        }
        $written = [];
        $previousPaths = array_column(array_filter($image->variants ?? [], 'is_array'), 'path');
        $variants = ['version' => self::VERSION, 'sha256' => $hash];
        try {
            if ($info['mime'] === 'image/jpeg' && function_exists('exif_read_data')) {
                if (in_array($orientation, [2, 4, 5, 7], true)) {
                    imageflip($source, IMG_FLIP_HORIZONTAL);
                }
                $angle = match ($orientation) {
                    3, 4 => 180, 6, 7 => -90, 5, 8 => 90, default => 0
                };
                if ($angle !== 0) {
                    $source = imagerotate($source, $angle, 0);
                }
            }
            $width = imagesx($source);
            $height = imagesy($source);
            foreach (self::SIZES as $size) {
                $scale = min(1, $size / max($width, $height));
                $w = max(1, (int) round($width * $scale));
                $h = max(1, (int) round($height * $scale));
                $canvas = imagecreatetruecolor($w, $h);
                imagealphablending($canvas, false);
                imagesavealpha($canvas, true);
                imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
                imagecopyresampled($canvas, $source, 0, 0, 0, 0, $w, $h, $width, $height);
                ob_start();
                try {
                    $ok = imagewebp($canvas, null, 85);
                    $encoded = ob_get_contents();
                } finally {
                    ob_end_clean();
                    unset($canvas);
                }
                if (! $ok || $encoded === '') {
                    throw new RuntimeException('Не удалось создать WebP для фотографии №'.$image->id);
                }
                if (strlen($encoded) >= filesize($path)) {
                    $variants[$size] = ['path' => $image->path, 'width' => $width, 'height' => $height, 'bytes' => filesize($path)];

                    continue;
                }
                $variant = 'products/'.$image->product_id.'/variants/'.$image->id.'-'.substr($hash, 0, 16).'-v'.self::VERSION.'-'.$size.'.webp';
                if (! $disk->put($variant, $encoded)) {
                    throw new RuntimeException('Не удалось сохранить WebP для фотографии №'.$image->id);
                }
                $written[] = $variant;
                $variants[$size] = ['path' => 'storage/'.$variant, 'width' => $w, 'height' => $h, 'bytes' => strlen($encoded)];
            }
            $old = $image->variants;
            $image->forceFill(['variants' => $variants])->save();
            foreach (self::SIZES as $size) {
                $previous = $old[$size]['path'] ?? null;
                if ($previous && $previous !== $variants[$size]['path'] && str_starts_with($previous, $prefix.'variants/') && ! str_contains($previous, '..')) {
                    $disk->delete(substr($previous, strlen('storage/')));
                }
            }
        } catch (\Throwable $exception) {
            // Do not delete an already published variant while rebuilding it.
            foreach ($written as $file) {
                if (! in_array('storage/'.$file, $previousPaths, true)) {
                    $disk->delete($file);
                }
            }
            throw $exception;
        } finally {
            unset($source);
        }

        return 'generated';
    }

    private function memoryLimit(): int
    {
        $value = trim(ini_get('memory_limit'));
        $multiplier = match (strtolower(substr($value, -1))) {
            'g' => 1024 ** 3, 'm' => 1024 ** 2, 'k' => 1024, default => 1
        };

        return (int) $value * $multiplier;
    }
}
