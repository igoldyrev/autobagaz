<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('product_base_product');
        Schema::dropIfExists('product_vehicle_body_type');
        Schema::dropIfExists('product_vehicle_model');

        Schema::table('fitment_vehicle_configuration', function (Blueprint $table): void {
            $table->index(['vehicle_configuration_id', 'fitment_id'], 'fitment_config_fitment_idx');
        });
        Schema::table('fitment_product', function (Blueprint $table): void {
            $table->index(['fitment_id', 'status', 'product_id'], 'fitment_status_product_idx');
        });
        Schema::table('compatibility_overrides', function (Blueprint $table): void {
            $table->index(
                ['is_active', 'vehicle_configuration_id', 'base_product_id', 'accessory_product_id', 'priority'],
                'compatibility_override_lookup_idx',
            );
        });
    }

    public function down(): void
    {
        Schema::table('compatibility_overrides', function (Blueprint $table): void {
            $table->dropIndex('compatibility_override_lookup_idx');
        });
        Schema::table('fitment_product', function (Blueprint $table): void {
            $table->dropIndex('fitment_status_product_idx');
        });
        Schema::table('fitment_vehicle_configuration', function (Blueprint $table): void {
            $table->dropIndex('fitment_config_fitment_idx');
        });

        Schema::create('product_vehicle_model', function (Blueprint $table): void {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_model_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['product_id', 'vehicle_model_id']);
        });
        Schema::create('product_vehicle_body_type', function (Blueprint $table): void {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_body_type_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['product_id', 'vehicle_body_type_id']);
        });
        Schema::create('product_base_product', function (Blueprint $table): void {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('base_product_id')->constrained('products')->cascadeOnDelete();
            $table->string('compatibility_type')->default('via_base_product');
            $table->timestamps();
            $table->primary(['product_id', 'base_product_id']);
        });
    }
};
