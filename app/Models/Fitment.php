<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fitment extends Model
{
    public const VERIFICATION_STATUSES = ['draft', 'migrated', 'needs_review', 'verified'];

    public const VERIFICATION_STATUS_LABELS = [
        'draft' => 'Черновик',
        'migrated' => 'Перенесено',
        'needs_review' => 'Требует проверки',
        'verified' => 'Проверено',
    ];

    protected $fillable = [
        'code', 'name', 'roof_rack_manufacturer_id', 'source', 'source_reference',
        'verification_status', 'notes', 'verified_at', 'created_by', 'updated_by', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(RoofRackManufacturer::class, 'roof_rack_manufacturer_id');
    }

    public function configurations(): BelongsToMany
    {
        return $this->belongsToMany(VehicleConfiguration::class)
            ->withPivot(['notes', 'crossbar_spacing_min_mm', 'crossbar_spacing_max_mm', 'max_dynamic_load_kg'])
            ->withTimestamps();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['status', 'notes'])
            ->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function verificationStatusLabel(string $status): string
    {
        return self::VERIFICATION_STATUS_LABELS[$status] ?? $status;
    }
}
