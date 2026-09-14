<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SkiRackProduct extends Model { protected $primaryKey='product_id'; public $incrementing=false; protected $fillable=['manufacturer_id','ski_pairs_capacity','snowboard_capacity']; protected function casts(): array{return ['ski_pairs_capacity'=>'integer','snowboard_capacity'=>'integer'];} public function product(): BelongsTo{return $this->belongsTo(Product::class);} public function manufacturer(): BelongsTo{return $this->belongsTo(SkiRackManufacturer::class,'manufacturer_id');} public function hasCharacteristics(): bool{return collect($this->only(['ski_pairs_capacity','snowboard_capacity']))->contains(fn($value): bool=>filled($value));} }
