<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('reservation_started_at')->nullable();
            $table->timestamp('reservation_expires_at')->nullable();
            $table->string('payment_status', 32)->default('unpaid');
            $table->decimal('paid_amount', 12, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
        });
        Schema::create('order_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('returned_quantity')->default(0);
            $table->string('state', 24);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
            $table->unique(['order_id', 'product_id']);
            $table->index(['product_id', 'state', 'expires_at']);
            $table->index(['state', 'expires_at']);
        });
        Schema::create('order_payment_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->restrictOnDelete();
            $table->string('provider', 32);
            $table->string('reference', 128);
            $table->string('type', 16);
            $table->decimal('amount', 12, 2);
            $table->timestamps();
            $table->unique(['provider', 'reference', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payment_events');
        Schema::dropIfExists('order_reservations');
        Schema::table('orders', fn (Blueprint $table) => $table->dropColumn(['reservation_started_at', 'reservation_expires_at', 'payment_status', 'paid_amount', 'paid_at']));
    }
};
