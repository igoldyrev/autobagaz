<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            Schema::table('vehicle_configurations', function (Blueprint $table): void {
                $table->dropUnique('vehicle_configurations_legacy_vehicle_body_type_id_unique');
                $table->dropConstrainedForeignId('legacy_vehicle_body_type_id');
            });

            Schema::dropIfExists('vehicle_body_types');

            return;
        }

        Schema::table('vehicle_configurations', function (Blueprint $table): void {
            $table->dropForeign('vehicle_configurations_legacy_vehicle_body_type_id_foreign');
            $table->dropUnique('vehicle_configurations_legacy_vehicle_body_type_id_unique');
            $table->dropColumn('legacy_vehicle_body_type_id');
        });

        Schema::dropIfExists('vehicle_body_types');
    }

    public function down(): void
    {
        Schema::create('vehicle_body_types', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vehicle_model_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('source_name')->nullable();
            $table->string('slug');
            $table->string('year_label')->nullable();
            $table->string('mounting_type')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('source_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['vehicle_model_id', 'slug']);
        });
        Schema::table('vehicle_configurations', function (Blueprint $table): void {
            $table->foreignId('legacy_vehicle_body_type_id')->nullable()->unique()->constrained('vehicle_body_types')->nullOnDelete();
        });
    }
};
