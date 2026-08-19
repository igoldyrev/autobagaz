<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
        $path = database_path('data/vehicle_body_types.json');

        if (! File::exists($path)) {
            throw new RuntimeException("Vehicle body type data is missing: {$path}");
        }

        $groups = json_decode(File::get($path), true, flags: JSON_THROW_ON_ERROR);
        $makeIds = DB::table('vehicle_makes')->pluck('id', 'slug');

        // Fresh test/install databases are populated by the category seeder later.
        if ($makeIds->isEmpty()) {
            return;
        }

        $modelIds = DB::table('vehicle_models')
            ->get(['id', 'vehicle_make_id', 'slug'])
            ->keyBy(fn ($model): string => $model->vehicle_make_id.':'.$model->slug);
        $timestamp = now();
        $rows = [];

        foreach ($groups as $makeSlug => $modelGroups) {
            $makeId = $makeIds->get($makeSlug);

            if (! $makeId) {
                throw new RuntimeException("Vehicle make not found for body type import: {$makeSlug}");
            }

            foreach ($modelGroups as $modelSlug => $bodyTypes) {
                $model = $modelIds->get($makeId.':'.$modelSlug);

                if (! $model) {
                    throw new RuntimeException("Vehicle model not found for body type import: {$makeSlug}/{$modelSlug}");
                }

                foreach ($bodyTypes as $bodyType) {
                    $rows[] = [
                        'vehicle_model_id' => $model->id,
                        'name' => $bodyType['name'],
                        'source_name' => $bodyType['source_name'],
                        'slug' => $bodyType['slug'],
                        'year_label' => $bodyType['year_label'],
                        'mounting_type' => $bodyType['mounting_type'],
                        'image_path' => $bodyType['image_path'],
                        'image_alt' => $bodyType['image_alt'],
                        'source_url' => $bodyType['source_url'],
                        'sort_order' => $bodyType['sort_order'],
                        'is_active' => $bodyType['is_active'],
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                }
            }
        }

        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('vehicle_body_types')->upsert(
                $chunk,
                ['vehicle_model_id', 'slug'],
                [
                    'name',
                    'source_name',
                    'year_label',
                    'mounting_type',
                    'image_path',
                    'image_alt',
                    'source_url',
                    'sort_order',
                    'is_active',
                    'updated_at',
                ],
            );
        }
    }

    public function down(): void
    {
        // Imported fitments may already be linked to products, so rollback keeps the data.
    }
};
