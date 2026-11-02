<?php

namespace App\Console\Commands;

use App\Models\ProductImage;
use App\Services\ProductImageVariants;
use Illuminate\Console\Command;

class OptimizeProductImages extends Command
{
    protected $signature = 'products:optimize-images {--after=0 : Process IDs above this value} {--limit=20 : Maximum images per run} {--force : Rebuild existing variants}';

    protected $description = 'Создать уменьшенные фотографии товаров, сохранив оригиналы';

    public function handle(ProductImageVariants $variants): int
    {
        $after = filter_var($this->option('after'), FILTER_VALIDATE_INT);
        $limit = filter_var($this->option('limit'), FILTER_VALIDATE_INT);
        if ($after === false || $after < 0 || $limit === false || $limit < 1 || $limit > 100) {
            $this->error('Укажите after >= 0 и limit от 1 до 100.');

            return self::INVALID;
        }
        $failed = false;
        foreach (ProductImage::where('id', '>', $after)->orderBy('id')->limit($limit)->get() as $image) {
            try {
                $status = $variants->generate($image, (bool) $this->option('force'));
                $this->line($image->id.': '.$status);
                if ($status === 'unavailable') {
                    $this->error('Для генерации необходим GD с поддержкой WebP.');

                    return self::FAILURE;
                }
            } catch (\Throwable $exception) {
                $this->error($image->id.': '.$exception->getMessage());
                $failed = true;
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
