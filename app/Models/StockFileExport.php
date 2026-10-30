<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class StockFileExport extends Model
{
    use HasUuids;

    protected $fillable = ['user_id', 'products'];

    protected function casts(): array
    {
        return ['products' => 'array'];
    }
}
