<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auto_box_products', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $table->string('dimensions_cm')->nullable();
            $table->decimal('volume_l', 7, 1)->nullable();
            $table->decimal('load_capacity_kg', 6, 1)->nullable();
            $table->string('opening_type')->nullable();
            $table->string('mounting_type')->nullable();
            $table->string('box_color')->nullable();
            $table->timestamps();
        });

        DB::table('catalog_categories')->updateOrInsert(
            ['parent_id' => null, 'slug' => 'autobox'],
            [
                'kind' => 'section',
                'name' => 'Автомобильные боксы',
                'description' => 'Автомобильные боксы на крышу для безопасной и удобной перевозки багажа.',
                'sort_order' => 1,
                'is_active' => true,
                'meta_title' => 'Автомобильные боксы на крышу в Перми',
                'meta_description' => 'Каталог автомобильных боксов на крышу. Продажа автобоксов в Перми.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('auto_box_products');
        DB::table('catalog_categories')->whereNull('parent_id')->where('slug', 'autobox')->delete();
    }
};
