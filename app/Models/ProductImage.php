<?php

namespace App\Models;

use App\Services\ProductImageVariants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'path',
        'alt',
        'sort_order',
    ];

    protected function casts(): array
    {
        return ['variants' => 'array'];
    }

    public function availableVariants(): array
    {
        $available = [];
        foreach (ProductImageVariants::SIZES as $size) {
            $variant = $this->variants[$size] ?? null;
            if (is_array($variant) && ($variant['width'] ?? 0) > 0 && ($variant['height'] ?? 0) > 0
                && str_starts_with($variant['path'] ?? '', 'storage/products/'.$this->product_id.'/')
                && ! str_contains($variant['path'], '..') && Storage::disk('public')->exists(substr($variant['path'], strlen('storage/')))) {
                $available[$size] = $variant;
            }
        }

        return $available;
    }

    public function variant(int $size): ?array
    {
        return $this->availableVariants()[$size] ?? null;
    }

    public function displayPath(int $size = 480): string
    {
        return $this->variant($size)['path'] ?? $this->path;
    }

    public function srcset(int $maxSize = 960): string
    {
        return collect($this->availableVariants())->filter(fn ($variant, $size) => $size <= $maxSize)
            ->keyBy('width')->sortKeys()->map(fn ($variant) => asset($variant['path']).' '.$variant['width'].'w')->implode(', ');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
