<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 12, 2);
            $table->longText('description')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->index(['is_active', 'name']);
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'sort_order']);
        });

        Schema::create('catalog_category_product', function (Blueprint $table) {
            $table->foreignId('catalog_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->primary(['catalog_category_id', 'product_id']);
        });

        Schema::create('product_vehicle_model', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_model_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'vehicle_model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_vehicle_model');
        Schema::dropIfExists('catalog_category_product');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
