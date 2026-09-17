<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->decimal('old_price', 12, 2)->nullable()->after('price');
            $table->boolean('is_on_sale')->default(false)->after('badges');
            $table->string('promotion_label', 100)->nullable()->after('is_on_sale');
            $table->timestamp('promotion_starts_at')->nullable()->after('promotion_label');
            $table->timestamp('promotion_ends_at')->nullable()->after('promotion_starts_at');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn(['old_price', 'is_on_sale', 'promotion_label', 'promotion_starts_at', 'promotion_ends_at']);
        });
    }
};
