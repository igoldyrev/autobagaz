<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoofRackProduct extends Model
{
    protected $primaryKey = 'product_id';

    public $incrementing = false;

    protected $fillable = [
        'bar_length_cm',
        'load_capacity_kg',
        'installation_method',
        'bar_type',
        'rack_color',
    ];

    protected function casts(): array
    {
        return [
            'bar_length_cm' => 'decimal:1',
            'load_capacity_kg' => 'decimal:1',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function hasCharacteristics(): bool
    {
        return collect([
            $this->bar_length_cm,
            $this->load_capacity_kg,
            $this->installation_method,
            $this->bar_type,
            $this->rack_color,
        ])->contains(fn ($value): bool => filled($value));
    }
}
