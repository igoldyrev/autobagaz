<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('vehicle_body_types')
            || ! Schema::hasTable('vehicle_generations')
            || ! Schema::hasTable('vehicle_configurations')) {
            return;
        }

        DB::table('vehicle_body_types')
            ->orderBy('vehicle_model_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->chunkById(200, function ($bodyTypes): void {
                foreach ($bodyTypes as $bodyType) {
                    [$yearFrom, $yearTo] = $this->yearRange($bodyType->year_label);
                    $generationKey = implode('|', [$bodyType->vehicle_model_id, $yearFrom, $yearTo, $bodyType->year_label]);
                    $generationReference = 'legacy-model:'.$bodyType->vehicle_model_id.':'.sha1($generationKey);
                    $generation = DB::table('vehicle_generations')
                        ->where('source', 'legacy_vehicle_body_types')
                        ->where('source_reference', $generationReference)
                        ->first();

                    if (! $generation) {
                        $generationName = $bodyType->year_label ?: 'Годы не указаны';
                        $generationId = DB::table('vehicle_generations')->insertGetId([
                            'vehicle_model_id' => $bodyType->vehicle_model_id,
                            'name' => $generationName,
                            'slug' => $this->uniqueGenerationSlug($bodyType->vehicle_model_id, $generationName),
                            'year_from' => $yearFrom,
                            'year_to' => $yearTo,
                            'source' => 'legacy_vehicle_body_types',
                            'source_reference' => $generationReference,
                            'sort_order' => $bodyType->sort_order,
                            'is_active' => $bodyType->is_active,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $generationId = $generation->id;
                    }

                    $bodyStyleId = $bodyType->name !== 'Кузов не указан'
                        ? $this->lookupId('vehicle_body_styles', $bodyType->name)
                        : null;
                    $roofTypeId = $bodyType->mounting_type
                        ? $this->lookupId('vehicle_roof_types', $bodyType->mounting_type)
                        : null;

                    DB::table('vehicle_configurations')->updateOrInsert(
                        ['legacy_vehicle_body_type_id' => $bodyType->id],
                        [
                            'vehicle_generation_id' => $generationId,
                            'vehicle_body_style_id' => $bodyStyleId,
                            'vehicle_roof_type_id' => $roofTypeId,
                            'display_name' => $bodyType->source_name ?: $bodyType->name,
                            'year_from' => $yearFrom,
                            'year_to' => $yearTo,
                            'source' => 'legacy_vehicle_body_types',
                            'source_reference' => 'legacy-body-type:'.$bodyType->id,
                            'verification_status' => 'needs_review',
                            'notes' => $bodyType->source_url ? 'Источник: '.$bodyType->source_url : null,
                            'sort_order' => $bodyType->sort_order,
                            'is_active' => $bodyType->is_active,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                    );
                }
            }, 'id');
    }

    public function down(): void
    {
        // Перенесённые записи сохраняются: удалять их при откате небезопасно.
    }

    private function lookupId(string $table, string $name): int
    {
        $slug = Str::slug($name) ?: 'value-'.sha1($name);
        $id = DB::table($table)->where('slug', $slug)->value('id');

        return $id ?: DB::table($table)->insertGetId([
            'name' => $name,
            'slug' => $slug,
            'sort_order' => 0,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function uniqueGenerationSlug(int $modelId, string $name): string
    {
        $base = 'legacy-'.(Str::slug(str_replace(['н.в.', 'нв'], 'nv', mb_strtolower($name))) ?: 'years-unknown');
        $slug = $base;
        $suffix = 2;

        while (DB::table('vehicle_generations')->where('vehicle_model_id', $modelId)->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    /** @return array{0: ?int, 1: ?int} */
    private function yearRange(?string $label): array
    {
        preg_match_all('/(?:19|20)\d{2}/', (string) $label, $matches);
        $years = array_map('intval', $matches[0]);

        if ($years === []) {
            return [null, null];
        }
        if (str_starts_with(mb_strtolower(trim((string) $label)), 'до ')) {
            return [null, $years[0]];
        }

        return [$years[0], count($years) > 1 ? $years[array_key_last($years)] : null];
    }
};
