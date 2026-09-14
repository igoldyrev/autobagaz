<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bike_rack_manufacturers', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('bike_rack_products', function (Blueprint $table): void {
            $table->foreignId('manufacturer_id')->nullable()->after('product_id')->constrained('bike_rack_manufacturers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bike_rack_products', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('manufacturer_id');
        });
        Schema::dropIfExists('bike_rack_manufacturers');
    }
};
