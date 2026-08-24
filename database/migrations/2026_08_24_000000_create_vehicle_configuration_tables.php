<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_body_styles', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('vehicle_roof_types', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('vehicle_generations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vehicle_model_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedSmallInteger('year_from')->nullable();
            $table->unsignedSmallInteger('year_to')->nullable();
            $table->string('source')->nullable();
            $table->string('source_reference')->nullable();
            $table->string('verification_status')->default('draft');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['vehicle_model_id', 'slug']);
            $table->unique(['source', 'source_reference']);
            $table->index(['vehicle_model_id', 'is_active', 'sort_order']);
        });

        Schema::create('vehicle_configurations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vehicle_generation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_body_style_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('vehicle_roof_type_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('legacy_vehicle_body_type_id')->nullable()->unique()->constrained('vehicle_body_types')->nullOnDelete();
            $table->string('display_name');
            $table->unsignedSmallInteger('year_from')->nullable();
            $table->unsignedSmallInteger('year_to')->nullable();
            $table->unsignedTinyInteger('doors_count')->nullable();
            $table->string('source')->nullable();
            $table->string('source_reference')->nullable();
            $table->string('verification_status')->default('draft');
            $table->text('notes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['source', 'source_reference']);
            $table->index(['vehicle_generation_id', 'is_active', 'sort_order'], 'vehicle_config_generation_active_sort_idx');
            $table->index(['vehicle_body_style_id', 'vehicle_roof_type_id'], 'vehicle_config_body_roof_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_configurations');
        Schema::dropIfExists('vehicle_generations');
        Schema::dropIfExists('vehicle_roof_types');
        Schema::dropIfExists('vehicle_body_styles');
    }
};
