<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        DB::table('product_types')->updateOrInsert(
            ['code' => 'bike_rack'],
            [
                'name' => 'Велокрепление',
                'compatibility_strategy' => 'universal',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        Schema::create('bike_rack_products', function (Blueprint $table): void {
            $table->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $table->string('mounting_type')->nullable();
            $table->unsignedTinyInteger('bike_capacity')->nullable();
            $table->decimal('load_capacity_kg', 6, 1)->nullable();
            $table->timestamps();
        });

        DB::table('catalog_categories')->updateOrInsert(
            ['parent_id' => null, 'slug' => 'velokrepleniya'],
            [
                'kind' => 'section',
                'name' => 'Велокрепления',
                'description' => 'Каталог велокреплений для перевозки велосипедов на автомобиле.',
                'sort_order' => 2,
                'is_active' => true,
                'meta_title' => 'Велокрепления для автомобиля в Перми',
                'meta_description' => 'Каталог велокреплений для перевозки велосипедов на автомобиле.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('bike_rack_products');
        DB::table('catalog_categories')->whereNull('parent_id')->where('slug', 'velokrepleniya')->delete();
        DB::table('product_types')->where('code', 'bike_rack')->delete();
    }
};
