<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('product_types')
            ->where('code', 'roof_box')
            ->update([
                'compatibility_strategy' => 'universal',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('product_types')
            ->where('code', 'roof_box')
            ->update([
                'compatibility_strategy' => 'technical',
                'updated_at' => now(),
            ]);
    }
};
