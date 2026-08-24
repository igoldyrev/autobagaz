<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VehicleConfiguration extends Model
{
    public const VERIFICATION_STATUSES = ['draft', 'migrated', 'needs_review', 'verified'];

    protected $fillable = [
        'vehicle_generation_id', 'vehicle_body_style_id', 'vehicle_roof_type_id',
        'slug', 'display_name', 'year_from', 'year_to',
        'doors_count', 'source', 'source_reference', 'verification_status',
        'notes', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year_from' => 'integer', 'year_to' => 'integer', 'doors_count' => 'integer',
            'sort_order' => 'integer', 'is_active' => 'boolean',
        ];
    }

    public function generation(): BelongsTo
    {
        return $this->belongsTo(VehicleGeneration::class, 'vehicle_generation_id');
    }

    public function bodyStyle(): BelongsTo
    {
        return $this->belongsTo(VehicleBodyStyle::class, 'vehicle_body_style_id');
    }

    public function roofType(): BelongsTo
    {
        return $this->belongsTo(VehicleRoofType::class, 'vehicle_roof_type_id');
    }

    public function fitments(): BelongsToMany
    {
        return $this->belongsToMany(Fitment::class)
            ->withPivot(['notes', 'crossbar_spacing_min_mm', 'crossbar_spacing_max_mm', 'max_dynamic_load_kg'])
            ->withTimestamps();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getYearLabelAttribute(): string
    {
        $yearFrom = $this->year_from ?: $this->generation?->year_from;
        $yearTo = $this->year_to ?: $this->generation?->year_to;

        if ($yearFrom && $yearTo) {
            return $yearFrom === $yearTo ? (string) $yearFrom : $yearFrom.'–'.$yearTo;
        }

        return $yearFrom ? $yearFrom.'–н.в.' : ($yearTo ? 'до '.$yearTo : 'годы не указаны');
    }

    public function getVehicleLabelAttribute(): string
    {
        return $this->labelForYear();
    }

    public function labelForYear(?int $year = null): string
    {
        $model = $this->generation?->vehicleModel;
        $parts = array_filter([
            $model?->make?->name,
            $model?->name,
            $year ?: $this->year_label,
        ]);

        return implode(' ', $parts);
    }
}
