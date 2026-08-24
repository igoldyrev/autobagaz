<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleGeneration extends Model
{
    protected $fillable = [
        'vehicle_model_id', 'name', 'slug', 'year_from', 'year_to', 'source',
        'source_reference', 'image_path', 'image_alt', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year_from' => 'integer', 'year_to' => 'integer',
            'sort_order' => 'integer', 'is_active' => 'boolean',
        ];
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function configurations(): HasMany
    {
        return $this->hasMany(VehicleConfiguration::class)
            ->orderBy('sort_order')->orderBy('display_name');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getYearLabelAttribute(): string
    {
        if ($this->year_from && $this->year_to) {
            return $this->year_from === $this->year_to ? (string) $this->year_from : $this->year_from.'–'.$this->year_to;
        }

        return $this->year_from ? $this->year_from.'–н.в.' : ($this->year_to ? 'до '.$this->year_to : 'годы не указаны');
    }

    public function getDisplayNameAttribute(): string
    {
        return str_starts_with($this->name, 'Предварительное поколение:')
            ? $this->year_label
            : $this->name;
    }
}
