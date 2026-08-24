<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitments', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('roof_rack_manufacturer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('source')->nullable();
            $table->string('source_reference')->nullable();
            $table->string('verification_status')->default('draft');
            $table->text('notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['source', 'source_reference']);
            $table->index(['verification_status', 'is_active']);
        });

        Schema::create('fitment_vehicle_configuration', function (Blueprint $table): void {
            $table->foreignId('fitment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_configuration_id')->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->primary(['fitment_id', 'vehicle_configuration_id'], 'fitment_vehicle_configuration_pk');
            $table->index('vehicle_configuration_id');
        });

        Schema::create('fitment_product', function (Blueprint $table): void {
            $table->foreignId('fitment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->primary(['fitment_id', 'product_id']);
            $table->index(['product_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitment_product');
        Schema::dropIfExists('fitment_vehicle_configuration');
        Schema::dropIfExists('fitments');
    }
};
