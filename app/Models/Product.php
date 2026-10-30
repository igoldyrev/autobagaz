<?php

namespace App\Models;

use App\Services\OrderReservations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function save(array $options = [])
    {
        if ($this->exists && $this->isDirty('stock') && DB::transactionLevel() === 0) {
            return DB::transaction(fn () => parent::save($options));
        }

        return parent::save($options);
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if ($product->exists && $product->isDirty('stock')) {
                app(OrderReservations::class)->assertPhysicalStock($product, (int) $product->stock);
            }
        });
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(OrderReservation::class);
    }

    public function getAvailableStockAttribute(): int
    {
        $reserved = array_key_exists('reserved_stock', $this->attributes)
            ? $this->attributes['reserved_stock']
            : $this->reservations()->live()->sum('quantity');

        return max(0, $this->stock - (int) $reserved);
    }

    public function scopeWithAvailability(Builder $query): Builder
    {
        return $query->withSum(['reservations as reserved_stock' => fn ($q) => $q->live()], 'quantity');
    }

    public static function availableStockSql(): string
    {
        return "(products.stock - COALESCE((SELECT SUM(r.quantity) FROM order_reservations r WHERE r.product_id = products.id AND (r.state = 'paid' OR (r.state = 'active' AND r.expires_at > ?))), 0))";
    }

    public function scopeWhereAvailable(Builder $query, bool $available): Builder
    {
        return $query->whereRaw(self::availableStockSql().($available ? ' > 0' : ' <= 0'), [now()]);
    }

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
        'old_price',
        'manufacturer',
        'country_of_origin',
        'product_model',
        'description',
        'stock',
        'is_active',
        'badges',
        'is_on_sale',
        'promotion_label',
        'promotion_starts_at',
        'promotion_ends_at',
        'catalog_priority',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
            'badges' => 'array',
            'is_on_sale' => 'boolean',
            'promotion_starts_at' => 'datetime',
            'promotion_ends_at' => 'datetime',
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

    public function scopeOnSale(Builder $query): Builder
    {
        return $query
            ->where('is_on_sale', true)
            ->whereNotNull('old_price')
            ->whereColumn('old_price', '>', 'price')
            ->where(fn (Builder $query) => $query->whereNull('promotion_starts_at')->orWhere('promotion_starts_at', '<=', now()))
            ->where(fn (Builder $query) => $query->whereNull('promotion_ends_at')->orWhere('promotion_ends_at', '>=', now()));
    }

    public function hasActivePromotion(): bool
    {
        $now = now();

        return $this->is_on_sale
            && $this->old_price !== null
            && (float) $this->old_price > (float) $this->price
            && ($this->promotion_starts_at === null || $this->promotion_starts_at->lessThanOrEqualTo($now))
            && ($this->promotion_ends_at === null || $this->promotion_ends_at->greaterThanOrEqualTo($now));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
