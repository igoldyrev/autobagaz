<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('product_base_product') || ! Schema::hasTable('compatibility_overrides')) {
            return;
        }

        DB::table('product_base_product')->orderBy('base_product_id')->each(function ($pair): void {
            DB::table('compatibility_overrides')->updateOrInsert(
                [
                    'base_product_id' => $pair->base_product_id,
                    'accessory_product_id' => $pair->product_id,
                    'source' => 'legacy_product_base_product',
                ],
                [
                    'vehicle_configuration_id' => null,
                    'fitment_id' => null,
                    'status' => 'compatible',
                    'reason' => 'Перенесено из ранее подтверждённой связи товаров.',
                    'priority' => -100,
                    'is_active' => true,
                    'valid_from' => null,
                    'valid_to' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        });
    }

    public function down(): void
    {
        // Ручные исключения сохраняем, чтобы не потерять подтверждённые пары товаров.
    }
};
