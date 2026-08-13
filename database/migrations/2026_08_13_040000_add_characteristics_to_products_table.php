<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('manufacturer')->nullable()->after('price');
            $table->string('country_of_origin')->nullable()->after('manufacturer');
            $table->string('product_model')->nullable()->after('country_of_origin');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['manufacturer', 'country_of_origin', 'product_model']);
        });
    }
};
