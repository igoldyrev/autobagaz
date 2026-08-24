<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_generations', function (Blueprint $table): void {
            $table->string('image_path')->nullable()->after('year_to');
            $table->string('image_alt')->nullable()->after('image_path');
        });
        Schema::table('vehicle_configurations', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('display_name');
        });

        DB::table('vehicle_generations')->orderBy('id')->chunkById(200, function ($generations): void {
            foreach ($generations as $generation) {
                $image = DB::table('vehicle_configurations')
                    ->join('vehicle_body_types', 'vehicle_body_types.id', '=', 'vehicle_configurations.legacy_vehicle_body_type_id')
                    ->where('vehicle_configurations.vehicle_generation_id', $generation->id)
                    ->whereNotNull('vehicle_body_types.image_path')
                    ->orderBy('vehicle_configurations.sort_order')
                    ->orderBy('vehicle_configurations.id')
                    ->first(['vehicle_body_types.image_path', 'vehicle_body_types.image_alt']);

                if ($image) {
                    DB::table('vehicle_generations')->where('id', $generation->id)->update([
                        'image_path' => $image->image_path,
                        'image_alt' => $image->image_alt,
                    ]);
                }
            }
        });

        DB::table('vehicle_configurations')
            ->leftJoin('vehicle_body_types', 'vehicle_body_types.id', '=', 'vehicle_configurations.legacy_vehicle_body_type_id')
            ->select('vehicle_configurations.id', 'vehicle_configurations.vehicle_generation_id', 'vehicle_configurations.display_name', 'vehicle_body_types.slug as legacy_slug')
            ->orderBy('vehicle_configurations.id')
            ->get()
            ->each(function ($configuration): void {
                $base = $configuration->legacy_slug ?: Str::slug($configuration->display_name);
                $base = $base !== '' ? $base : 'configuration-'.$configuration->id;
                $slug = $base;
                $suffix = 2;

                while (DB::table('vehicle_configurations')
                    ->where('vehicle_generation_id', $configuration->vehicle_generation_id)
                    ->where('slug', $slug)
                    ->where('id', '!=', $configuration->id)
                    ->exists()) {
                    $slug = $base.'-'.$suffix++;
                }

                DB::table('vehicle_configurations')->where('id', $configuration->id)->update(['slug' => $slug]);
            });

        Schema::table('vehicle_configurations', function (Blueprint $table): void {
            $table->unique(['vehicle_generation_id', 'slug'], 'vehicle_config_generation_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_configurations', function (Blueprint $table): void {
            $table->dropUnique('vehicle_config_generation_slug_unique');
            $table->dropColumn('slug');
        });
        Schema::table('vehicle_generations', function (Blueprint $table): void {
            $table->dropColumn(['image_path', 'image_alt']);
        });
    }
};
