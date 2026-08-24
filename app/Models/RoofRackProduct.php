<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoofRackProduct extends Model
{
    protected $primaryKey = 'product_id';

    public $incrementing = false;

    protected $fillable = [
        'manufacturer_id',
        'bar_length_cm',
        'load_capacity_kg',
        'installation_method',
        'bar_type',
        'rack_color',
        'bar_length_mm',
        'bar_width_mm',
        'bar_height_mm',
        'profile_type',
        't_slot_width_mm',
    ];

    protected function casts(): array
    {
        return [
            'bar_length_cm' => 'decimal:1',
            'load_capacity_kg' => 'decimal:1',
            'bar_length_mm' => 'integer',
            'bar_width_mm' => 'integer',
            'bar_height_mm' => 'integer',
            't_slot_width_mm' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(RoofRackManufacturer::class, 'manufacturer_id');
    }

    public function hasCharacteristics(): bool
    {
        return collect([
            $this->bar_length_cm,
            $this->load_capacity_kg,
            $this->installation_method,
            $this->bar_type,
            $this->rack_color,
            $this->bar_length_mm,
            $this->bar_width_mm,
            $this->bar_height_mm,
            $this->profile_type,
            $this->t_slot_width_mm,
        ])->contains(fn ($value): bool => filled($value));
    }
}
