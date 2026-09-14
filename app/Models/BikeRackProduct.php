<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BikeRackProduct extends Model
{
    protected $primaryKey = 'product_id';

    public $incrementing = false;

    protected $fillable = ['manufacturer_id', 'mounting_type', 'bike_capacity', 'load_capacity_kg'];

    protected function casts(): array
    {
        return [
            'bike_capacity' => 'integer',
            'load_capacity_kg' => 'decimal:1',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(BikeRackManufacturer::class, 'manufacturer_id');
    }

    public function hasCharacteristics(): bool
    {
        return collect($this->only(['mounting_type', 'bike_capacity', 'load_capacity_kg']))
            ->contains(fn ($value): bool => filled($value));
    }
}
