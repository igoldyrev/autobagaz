<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_terms_versions', function (Blueprint $table): void {
            $table->text('change_reason')->nullable();
            $table->unsignedInteger('baseline_version')->nullable();
            $table->decimal('goods_difference', 12, 2)->nullable();
            $table->decimal('delivery_difference', 12, 2)->nullable();
            $table->decimal('total_difference', 12, 2)->nullable();
            $table->string('accepted_via', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('order_terms_versions', function (Blueprint $table): void {
            $table->dropColumn(['change_reason', 'baseline_version', 'goods_difference', 'delivery_difference', 'total_difference', 'accepted_via']);
        });
    }
};
