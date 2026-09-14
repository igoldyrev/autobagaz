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
        DB::table('product_types')->updateOrInsert(['code' => 'ski_rack'], ['name' => 'Крепление для лыж и сноубордов', 'compatibility_strategy' => 'universal', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);
        Schema::create('ski_rack_manufacturers', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('ski_rack_products', function (Blueprint $table): void {
            $table->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $table->foreignId('manufacturer_id')->nullable()->constrained('ski_rack_manufacturers')->nullOnDelete();
            $table->unsignedTinyInteger('ski_pairs_capacity')->nullable();
            $table->unsignedTinyInteger('snowboard_capacity')->nullable();
            $table->timestamps();
        });
        DB::table('catalog_categories')->updateOrInsert(['parent_id' => null, 'slug' => 'krepleniya-dlya-lyzh-i-snoubordov'], ['kind' => 'section', 'name' => 'Крепления для лыж и сноубордов', 'description' => 'Каталог автомобильных креплений для лыж и сноубордов.', 'sort_order' => 3, 'is_active' => true, 'meta_title' => 'Крепления для лыж и сноубордов в Перми', 'meta_description' => 'Каталог креплений для лыж и сноубордов на автомобиль.', 'created_at' => $now, 'updated_at' => $now]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ski_rack_products');
        Schema::dropIfExists('ski_rack_manufacturers');
        DB::table('catalog_categories')->whereNull('parent_id')->where('slug', 'krepleniya-dlya-lyzh-i-snoubordov')->delete();
        DB::table('product_types')->where('code', 'ski_rack')->delete();
    }
};
