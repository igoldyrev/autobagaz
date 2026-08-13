<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /** @param array<UploadedFile> $images */
    public function store(Product $product, array $images): void
    {
        $nextOrder = ((int) $product->images()->max('sort_order')) + 1;

        foreach ($images as $image) {
            $product->images()->create([
                'path' => 'storage/'.$image->store('products/'.$product->id, 'public'),
                'alt' => $product->name,
                'sort_order' => $nextOrder++,
            ]);
        }
    }

    /** @param array<int|string> $imageIds */
    public function remove(Product $product, array $imageIds): void
    {
        $product->images()
            ->whereKey($imageIds)
            ->get()
            ->each(function ($image): void {
                if (str_starts_with($image->path, 'storage/')) {
                    Storage::disk('public')->delete(substr($image->path, strlen('storage/')));
                }

                $image->delete();
            });
    }
}
