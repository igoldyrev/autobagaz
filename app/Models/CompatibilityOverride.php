<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompatibilityOverride extends Model
{
    public const STATUSES = ['compatible', 'incompatible'];

    protected $fillable = [
        'vehicle_configuration_id', 'fitment_id', 'base_product_id', 'accessory_product_id',
        'status', 'reason', 'source', 'priority', 'is_active', 'valid_from', 'valid_to',
        'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'priority' => 'integer', 'is_active' => 'boolean',
            'valid_from' => 'datetime', 'valid_to' => 'datetime',
        ];
    }

    public function vehicleConfiguration(): BelongsTo
    {
        return $this->belongsTo(VehicleConfiguration::class);
    }

    public function fitment(): BelongsTo
    {
        return $this->belongsTo(Fitment::class);
    }

    public function baseProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'base_product_id');
    }

    public function accessoryProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'accessory_product_id');
    }

    public function scopeEffective(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(fn (Builder $query) => $query->whereNull('valid_from')->orWhere('valid_from', '<=', now()))
            ->where(fn (Builder $query) => $query->whereNull('valid_to')->orWhere('valid_to', '>=', now()));
    }
}
