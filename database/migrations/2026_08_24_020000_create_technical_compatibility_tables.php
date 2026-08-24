<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_types', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('compatibility_strategy');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('product_types')->insert([
            ['code' => 'roof_rack', 'name' => 'Багажник на крышу', 'compatibility_strategy' => 'vehicle_fitment', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'roof_box', 'name' => 'Автомобильный бокс', 'compatibility_strategy' => 'technical', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'universal', 'name' => 'Универсальный аксессуар', 'compatibility_strategy' => 'universal', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        Schema::table('products', function (Blueprint $table): void {
            $table->foreignId('product_type_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->index(['product_type_id', 'is_active']);
        });

        DB::table('products')->whereExists(function ($query): void {
            $query->selectRaw('1')->from('roof_rack_products')->whereColumn('roof_rack_products.product_id', 'products.id');
        })->update(['product_type_id' => DB::table('product_types')->where('code', 'roof_rack')->value('id')]);
        DB::table('products')->whereExists(function ($query): void {
            $query->selectRaw('1')->from('auto_box_products')->whereColumn('auto_box_products.product_id', 'products.id');
        })->update(['product_type_id' => DB::table('product_types')->where('code', 'roof_box')->value('id')]);

        Schema::table('roof_rack_products', function (Blueprint $table): void {
            $table->unsignedInteger('bar_length_mm')->nullable();
            $table->unsignedInteger('bar_width_mm')->nullable();
            $table->unsignedInteger('bar_height_mm')->nullable();
            $table->string('profile_type')->nullable();
            $table->unsignedInteger('t_slot_width_mm')->nullable();
        });

        DB::table('roof_rack_products')->whereNotNull('bar_length_cm')->update([
            'bar_length_mm' => DB::raw('ROUND(bar_length_cm * 10)'),
        ]);

        Schema::table('auto_box_products', function (Blueprint $table): void {
            $table->unsignedInteger('clamp_width_min_mm')->nullable();
            $table->unsignedInteger('clamp_width_max_mm')->nullable();
            $table->unsignedInteger('clamp_height_max_mm')->nullable();
            $table->unsignedInteger('crossbar_spacing_min_mm')->nullable();
            $table->unsignedInteger('crossbar_spacing_max_mm')->nullable();
            $table->unsignedInteger('required_t_slot_width_mm')->nullable();
        });

        Schema::table('fitment_vehicle_configuration', function (Blueprint $table): void {
            $table->unsignedInteger('crossbar_spacing_min_mm')->nullable();
            $table->unsignedInteger('crossbar_spacing_max_mm')->nullable();
            $table->decimal('max_dynamic_load_kg', 6, 1)->nullable();
        });

        Schema::create('compatibility_overrides', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vehicle_configuration_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('fitment_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('base_product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('accessory_product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->string('status');
            $table->text('reason');
            $table->string('source')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['base_product_id', 'accessory_product_id', 'is_active'], 'compatibility_override_products_idx');
            $table->index(['vehicle_configuration_id', 'fitment_id'], 'compatibility_override_context_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compatibility_overrides');

        Schema::table('fitment_vehicle_configuration', function (Blueprint $table): void {
            $table->dropColumn(['crossbar_spacing_min_mm', 'crossbar_spacing_max_mm', 'max_dynamic_load_kg']);
        });
        Schema::table('auto_box_products', function (Blueprint $table): void {
            $table->dropColumn(['clamp_width_min_mm', 'clamp_width_max_mm', 'clamp_height_max_mm', 'crossbar_spacing_min_mm', 'crossbar_spacing_max_mm', 'required_t_slot_width_mm']);
        });
        Schema::table('roof_rack_products', function (Blueprint $table): void {
            $table->dropColumn(['bar_length_mm', 'bar_width_mm', 'bar_height_mm', 'profile_type', 't_slot_width_mm']);
        });
        Schema::table('products', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('product_type_id');
        });
        Schema::dropIfExists('product_types');
    }
};
