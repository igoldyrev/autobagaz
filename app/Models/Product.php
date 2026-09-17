<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    public const BADGES = [
        'hit' => 'Хит',
        'new' => 'Новинка',
        'recommended' => 'Рекомендуем',
        'budget' => 'Бюджетный',
        'optimal' => 'Оптимальный',
        'premium' => 'Премиум',
    ];

    public const POSITIONING_BADGES = ['budget', 'optimal', 'premium'];

    protected $fillable = [
        'name',
        'product_type_id',
        'slug',
        'meta_title',
        'meta_description',
        'price',
        'manufacturer',
        'country_of_origin',
        'product_model',
        'description',
        'stock',
        'is_active',
        'badges',
        'catalog_priority',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
            'badges' => 'array',
            'catalog_priority' => 'integer',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CatalogCategory::class);
    }

    public function fitments(): BelongsToMany
    {
        return $this->belongsToMany(Fitment::class)
            ->withPivot(['status', 'notes'])
            ->withTimestamps();
    }

    public function roofRack(): HasOne
    {
        return $this->hasOne(RoofRackProduct::class);
    }

    public function autoBox(): HasOne
    {
        return $this->hasOne(AutoBoxProduct::class);
    }

    public function bikeRack(): HasOne
    {
        return $this->hasOne(BikeRackProduct::class);
    }

    public function skiRack(): HasOne
    {
        return $this->hasOne(SkiRackProduct::class);
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
