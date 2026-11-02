<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', fn (Blueprint $table) => $table->unsignedInteger('fulfillment_version')->default(0));
        Schema::table('order_reservations', fn (Blueprint $table) => $table->unsignedInteger('fulfilled_quantity')->default(0));
        // Previously consumed rows already represent goods physically issued before this migration.
        DB::table('order_reservations')->whereIn('state', ['consumed', 'returned'])
            ->update(['fulfilled_quantity' => DB::raw('quantity')]);
    }

    public function down(): void
    {
        if (DB::table('orders')->where('fulfillment_version', '>', 0)->exists()) {
            throw new RuntimeException('Нельзя удалить учёт частичной выдачи после начала передачи товаров.');
        }
        Schema::table('order_reservations', fn (Blueprint $table) => $table->dropColumn('fulfilled_quantity'));
        Schema::table('orders', fn (Blueprint $table) => $table->dropColumn('fulfillment_version'));
    }
};
