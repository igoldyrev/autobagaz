<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutoBoxProduct extends Model
{
    protected $primaryKey = 'product_id';

    public $incrementing = false;

    protected $fillable = [
        'manufacturer_id',
        'length_cm',
        'width_cm',
        'height_cm',
        'volume_l',
        'load_capacity_kg',
        'opening_type',
        'mounting_type',
        'box_color',
    ];

    protected function casts(): array
    {
        return [
            'length_cm' => 'decimal:1',
            'width_cm' => 'decimal:1',
            'height_cm' => 'decimal:1',
            'volume_l' => 'decimal:1',
            'load_capacity_kg' => 'decimal:1',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(AutoBoxManufacturer::class, 'manufacturer_id');
    }

    public function hasCharacteristics(): bool
    {
        return collect($this->only([
            'length_cm',
            'width_cm',
            'height_cm',
            'volume_l',
            'load_capacity_kg',
            'opening_type',
            'mounting_type',
            'box_color',
        ]))->contains(fn ($value): bool => filled($value));
    }
}
