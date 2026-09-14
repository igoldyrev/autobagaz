<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Builder; use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\HasMany;
class SkiRackManufacturer extends Model { protected $fillable=['name','is_active']; protected function casts(): array{return ['is_active'=>'boolean'];} public function skiRackProducts(): HasMany{return $this->hasMany(SkiRackProduct::class,'manufacturer_id');} public function scopeActive(Builder $query): Builder{return $query->where('is_active',true);} }
