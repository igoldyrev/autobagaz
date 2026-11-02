<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductImageService;
use App\Services\ProductImageVariants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\ComponentAttributeBag;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProductImageVariantsTest extends TestCase
{
    use RefreshDatabase;

    public function test_old_and_missing_variants_fall_back_to_original_without_srcset(): void
    {
        Storage::fake('public');
        $image = $this->record();
        $this->assertSame($image->path, $image->displayPath());
        $this->assertSame('', $image->srcset());
        $image->forceFill(['variants' => [480 => ['path' => 'storage/products/'.$image->product_id.'/variants/missing.webp', 'width' => 480, 'height' => 320]]]);
        $html = view('components.product-image', ['image' => $image, 'attributes' => new ComponentAttributeBag])->render();
        $this->assertStringContainsString('src="'.asset($image->path).'"', $html);
        $this->assertStringNotContainsString('srcset=', $html);
    }

    public function test_responsive_sources_use_actual_widths_and_exclude_missing_files(): void
    {
        Storage::fake('public');
        $image = $this->record();
        $variants = [];
        foreach ([160 => [100, 160], 480 => [300, 480], 960 => [600, 960]] as $size => [$w, $h]) {
            $path = 'products/'.$image->product_id.'/variants/'.$size.'.webp';
            Storage::disk('public')->put($path, 'fixture');
            $variants[$size] = ['path' => 'storage/'.$path, 'width' => $w, 'height' => $h];
        }
        $image->forceFill(['variants' => $variants])->save();
        $this->assertStringContainsString('100w', $image->srcset());
        $this->assertStringContainsString('300w', $image->srcset());
        $this->assertStringContainsString('600w', $image->srcset());
        $this->assertStringNotContainsString('300w', $image->srcset(160));
        Storage::disk('public')->delete(substr($variants[480]['path'], 8));
        $this->assertSame($image->path, $image->displayPath(480));
        $this->assertStringNotContainsString('300w', $image->srcset());
    }

    public function test_product_page_keeps_original_links_and_uses_variants_for_gallery(): void
    {
        Storage::fake('public');
        $image = $this->record();
        $path = 'products/'.$image->product_id.'/variants/large.webp';
        Storage::disk('public')->put($path, 'fixture');
        $image->forceFill(['variants' => [960 => ['path' => 'storage/'.$path, 'width' => 960, 'height' => 600]]])->save();
        $image->product->images()->create(['path' => $image->path, 'alt' => 'Второй ракурс']);
        $this->get(route('products.show', $image->product))->assertOk()
            ->assertSee('src="'.asset('storage/'.$path).'"', false)
            ->assertSee('data-image-srcset=', false)
            ->assertSee('id="product-original-link"', false)
            ->assertSee('href="'.asset($image->path).'"', false);
    }

    public function test_removing_an_image_removes_only_its_variants_and_original(): void
    {
        Storage::fake('public');
        $image = $this->record();
        $variant = 'products/'.$image->product_id.'/variants/one.webp';
        $other = 'products/'.$image->product_id.'/variants/other.webp';
        Storage::disk('public')->put(substr($image->path, 8), 'original');
        Storage::disk('public')->put($variant, 'variant');
        Storage::disk('public')->put($other, 'other image');
        $image->forceFill(['variants' => [480 => ['path' => 'storage/'.$variant, 'width' => 480, 'height' => 320]]])->save();
        app(ProductImageService::class)->remove($image->product, [$image->id]);
        Storage::disk('public')->assertMissing($variant);
        Storage::disk('public')->assertMissing(substr($image->path, 8));
        Storage::disk('public')->assertExists($other);
        $this->assertModelMissing($image);
    }

    public function test_generation_preserves_original_and_is_idempotent_and_repairs_missing_variant(): void
    {
        $this->requireGd();
        Storage::fake('public');
        $image = $this->record();
        $original = $this->pattern();
        Storage::disk('public')->put(substr($image->path, 8), $original);
        $service = app(ProductImageVariants::class);
        $this->assertSame('generated', $service->generate($image));
        $this->assertSame($original, Storage::disk('public')->get(substr($image->path, 8)));
        foreach (ProductImageVariants::SIZES as $size) {
            $variant = $image->variant($size);
            $this->assertNotNull($variant);
            $info = getimagesize(Storage::disk('public')->path(substr($variant['path'], 8)));
            $this->assertSame('image/webp', $info['mime']);
            $this->assertLessThanOrEqual($size, max($info[0], $info[1]));
            $this->assertLessThan(strlen($original), $variant['bytes']);
        }
        $this->assertSame('unchanged', $service->generate($image));
        Storage::disk('public')->delete(substr($image->variant(480)['path'], 8));
        $this->assertSame('generated', $service->generate($image));
        $this->assertCount(3, $image->availableVariants());
    }

    public function test_transparency_is_preserved_and_small_images_are_not_upscaled(): void
    {
        $this->requireGd();
        Storage::fake('public');
        $image = $this->record();
        $canvas = imagecreatetruecolor(32, 16);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
        imagesetpixel($canvas, 16, 8, imagecolorallocatealpha($canvas, 255, 0, 0, 0));
        ob_start();
        imagepng($canvas);
        $png = ob_get_clean();
        Storage::disk('public')->put(substr($image->path, 8), $png);
        app(ProductImageVariants::class)->generate($image);
        foreach ($image->availableVariants() as $variant) {
            $this->assertSame([32, 16], [$variant['width'], $variant['height']]);
            $decoded = imagecreatefromstring(Storage::disk('public')->get(substr($variant['path'], 8)));
            $this->assertSame(127, imagecolorsforindex($decoded, imagecolorat($decoded, 0, 0))['alpha']);
        }
    }

    public function test_new_uploads_receive_variants_and_animated_gifs_keep_original(): void
    {
        $this->requireGd();
        Storage::fake('public');
        $product = $this->record()->product;
        app(ProductImageService::class)->store($product, [UploadedFile::fake()->createWithContent('photo.png', $this->pattern())]);
        $image = $product->images()->reorder('id', 'desc')->first();
        $this->assertCount(3, $image->availableVariants());
        $gif = $product->images()->create(['path' => 'storage/products/'.$product->id.'/animated.gif']);
        Storage::disk('public')->put(substr($gif->path, 8), base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'));
        $this->assertSame('unsupported', app(ProductImageVariants::class)->generate($gif));
        $this->assertSame($gif->path, $gif->displayPath());
    }

    public function test_command_bounds_and_processing_existing_images(): void
    {
        $this->requireGd();
        Storage::fake('public');
        $image = $this->record();
        Storage::disk('public')->put(substr($image->path, 8), $this->pattern());
        $this->artisan('products:optimize-images', ['--limit' => 0])->assertExitCode(2);
        $this->artisan('products:optimize-images', ['--limit' => 1])->expectsOutput($image->id.': generated')->assertSuccessful();
        $this->assertCount(3, $image->fresh()->availableVariants());
        $this->artisan('products:optimize-images', ['--after' => $image->id, '--limit' => 1])->assertSuccessful();
    }

    public static function orientations(): array
    {
        return [[3, 160, 80, [255, 255, 0]], [5, 80, 160, [255, 0, 0]], [6, 80, 160, [0, 0, 255]], [7, 80, 160, [255, 255, 0]], [8, 80, 160, [0, 255, 0]]];
    }

    #[DataProvider('orientations')]
    public function test_jpeg_orientation_is_preserved(int $orientation, int $width, int $height, array $colour): void
    {
        $this->requireGd();
        if (! function_exists('exif_read_data')) {
            $this->markTestSkipped('EXIF extension required for orientation tests.');
        }
        Storage::fake('public');
        $image = $this->record();
        $canvas = imagecreatetruecolor(400, 200);
        foreach ([[0, 0, 255, 0, 0], [200, 0, 0, 255, 0], [0, 100, 0, 0, 255], [200, 100, 255, 255, 0]] as [$x, $y, $r, $g, $b]) {
            imagefilledrectangle($canvas, $x, $y, $x + 199, $y + 99, imagecolorallocate($canvas, $r, $g, $b));
        }
        ob_start();
        imagejpeg($canvas, null, 100);
        $jpeg = ob_get_clean();
        $exif = "Exif\0\0II\x2a\0\x08\0\0\0\x01\0\x12\x01\x03\0\x01\0\0\0".pack('v', $orientation)."\0\0\0\0\0\0";
        $jpeg = substr($jpeg, 0, 2)."\xff\xe1".pack('n', strlen($exif) + 2).$exif.substr($jpeg, 2);
        Storage::disk('public')->put(substr($image->path, 8), $jpeg);
        $this->assertSame('generated', app(ProductImageVariants::class)->generate($image));
        $variant = $image->variant(160);
        $this->assertSame([$width, $height], [$variant['width'], $variant['height']]);
        $decoded = imagecreatefromstring(Storage::disk('public')->get(substr($variant['path'], 8)));
        $pixel = imagecolorsforindex($decoded, imagecolorat($decoded, 5, 5));
        foreach (['red', 'green', 'blue'] as $index => $channel) {
            $this->assertEqualsWithDelta($colour[$index], $pixel[$channel], 40);
        }
        $this->assertSame($jpeg, Storage::disk('public')->get(substr($image->path, 8)));
    }

    private function requireGd(): void
    {
        if (! function_exists('imagewebp')) {
            $this->markTestSkipped('GD with WebP support is required for image generation tests.');
        }
    }

    private function record(): ProductImage
    {
        $product = Product::create(['name' => 'Фото товара', 'slug' => 'image-test', 'price' => 100, 'stock' => 1, 'is_active' => true]);

        return $product->images()->create(['path' => 'storage/products/'.$product->id.'/source.png', 'alt' => $product->name]);
    }

    private function pattern(): string
    {
        $canvas = imagecreatetruecolor(1600, 1000);
        for ($i = 0; $i < 4000; $i++) {
            imagefilledrectangle($canvas, ($i * 37) % 1600, ($i * 23) % 1000, min(1599, ($i * 37) % 1600 + 30), min(999, ($i * 23) % 1000 + 30), imagecolorallocate($canvas, $i % 256, ($i * 11) % 256, ($i * 17) % 256));
        }
        ob_start();
        imagejpeg($canvas, null, 100);
        $contents = ob_get_clean();

        return $contents;
    }
}
