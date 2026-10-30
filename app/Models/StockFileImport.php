<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockFileImport extends Model
{
    use HasUuids;

    protected $fillable = ['stock_file_export_id', 'user_id', 'filename', 'changes', 'applied_at'];

    protected function casts(): array
    {
        return ['changes' => 'array', 'applied_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
