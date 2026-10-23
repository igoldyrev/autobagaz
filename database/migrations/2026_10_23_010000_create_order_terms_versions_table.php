<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->json('checkout_terms')->nullable();
        });

        Schema::create('order_terms_versions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('version');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('created_by_name');
            $table->json('items');
            $table->string('delivery_method', 20);
            $table->string('delivery_address', 500)->nullable();
            $table->text('delivery_terms');
            $table->decimal('delivery_cost', 12, 2)->nullable();
            $table->string('payment_method', 30);
            $table->text('payment_terms');
            $table->decimal('goods_total', 12, 2);
            $table->decimal('total', 12, 2)->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->unique(['order_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_terms_versions');
        Schema::table('orders', fn (Blueprint $table) => $table->dropColumn('checkout_terms'));
    }
};
