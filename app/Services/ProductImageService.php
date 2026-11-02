<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /** @param array<UploadedFile> $images */
    public function store(Product $product, array $images): void
    {
        $nextOrder = ((int) $product->images()->max('sort_order')) + 1;

        foreach ($images as $image) {
            $record = $product->images()->create([
                'path' => 'storage/'.$image->store('products/'.$product->id, 'public'),
                'alt' => $product->name,
                'sort_order' => $nextOrder++,
            ]);
            try {
                app(ProductImageVariants::class)->generate($record);
            } catch (\Throwable $exception) {
                Log::warning('Product image variants could not be generated.', ['image_id' => $record->id, 'exception' => $exception::class]);
            }
        }
    }

    /** @param array<int|string> $imageIds */
    public function remove(Product $product, array $imageIds): void
    {
        $product->images()
            ->whereKey($imageIds)
            ->get()
            ->each(function ($image): void {
                foreach ($image->availableVariants() as $variant) {
                    if (str_starts_with($variant['path'], 'storage/products/'.$image->product_id.'/variants/')) {
                        Storage::disk('public')->delete(substr($variant['path'], strlen('storage/')));
                    }
                }
                if (str_starts_with($image->path, 'storage/')) {
                    Storage::disk('public')->delete(substr($image->path, strlen('storage/')));
                }

                $image->delete();
            });
    }
}
