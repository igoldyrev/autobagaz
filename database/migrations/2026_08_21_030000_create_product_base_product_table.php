<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_base_product', function (Blueprint $table): void {
            $table->foreignId('base_product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('compatibility_type')->default('via_base_product');

            $table->primary(['base_product_id', 'product_id']);
            $table->index(['product_id', 'compatibility_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_base_product');
    }
};
