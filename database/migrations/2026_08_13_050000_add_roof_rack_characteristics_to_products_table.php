<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('bar_length_cm', 6, 1)->nullable()->after('product_model');
            $table->decimal('load_capacity_kg', 6, 1)->nullable()->after('bar_length_cm');
            $table->string('installation_method')->nullable()->after('load_capacity_kg');
            $table->string('bar_type')->nullable()->after('installation_method');
            $table->string('rack_color')->nullable()->after('bar_type');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'bar_length_cm',
                'load_capacity_kg',
                'installation_method',
                'bar_type',
                'rack_color',
            ]);
        });
    }
};
