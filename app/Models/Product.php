<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'manufacturer',
        'country_of_origin',
        'product_model',
        'description',
        'stock',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CatalogCategory::class);
    }

    public function vehicleModels(): BelongsToMany
    {
        return $this->belongsToMany(VehicleModel::class);
    }

    public function vehicleBodyTypes(): BelongsToMany
    {
        return $this->belongsToMany(VehicleBodyType::class);
    }

    /** Базовые товары, через которые этот аксессуар устанавливается на автомобиль. */
    public function baseProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'product_base_product',
            'product_id',
            'base_product_id',
        )->withPivot('compatibility_type');
    }

    /** Аксессуары, совместимые с этим базовым товаром. */
    public function compatibleAccessories(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'product_base_product',
            'base_product_id',
            'product_id',
        )->withPivot('compatibility_type');
    }

    public function roofRack(): HasOne
    {
        return $this->hasOne(RoofRackProduct::class);
    }

    public function autoBox(): HasOne
    {
        return $this->hasOne(AutoBoxProduct::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
