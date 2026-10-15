<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            $vehicles = [
                ['chery', 'Chery', 'tiggo-7-pro', 'Tiggo 7 Pro', null, 2020, null],
                ['chevrolet', 'Chevrolet', 'orlando', 'Orlando', null, 2010, 2015],
                ['datsun', 'Datsun', 'mi-do', 'Mi-Do', null, 2014, 2020],
                ['datsun', 'Datsun', 'on-do', 'On-Do', null, 2014, 2020],
                ['exeed', 'Exeed', 'txl', 'TXL', null, 2020, null],
                ['exeed', 'Exeed', 'vx', 'VX', null, 2021, null],
                ['geely', 'Geely', 'atlas', 'Atlas', 'I', 2017, 2022],
                ['geely', 'Geely', 'monjaro', 'Monjaro', null, 2021, null],
                ['geely', 'Geely', 'tugella', 'Tugella', null, 2020, null],
                ['haval', 'HAVAL', 'h6', 'H6', null, 2014, null],
                ['lada-vaz', 'Lada (ВАЗ)', '2121-2131-niva', 'Niva 4x4 (Legend)', null, 2021, null],
                ['lexus', 'Lexus', 'rx', 'RX', 'IV', 2015, null],
                ['lifan', 'Lifan', 'x70', 'X70', null, 2017, 2020],
            ];

            foreach ($vehicles as [$makeSlug, $makeName, $modelSlug, $modelName, $generationName, $yearFrom, $yearTo]) {
                $imagePath = 'images/catalog/autobagazhniki/models/'.$makeSlug.'/'.$modelSlug.'-'.$yearFrom.'-generated.webp';
                $imageAlt = $makeName.' '.($makeSlug === 'lada-vaz' ? 'Niva Legend' : $modelName)
                    .($generationName ? ' '.$generationName : '').' '.$yearFrom.'–'.($yearTo ?? 'н.в.');
                $makeImage = match ($makeSlug) {
                    'exeed' => 'bagazhniki_dlya_exeed_1.png',
                    'haval' => 'bagazhniki_dlya_haval_1.jpg',
                    default => 'bagazhniki_dlya_'.str_replace('-', '_', $makeSlug).'-1.png',
                };
                $makeId = $this->findOrCreate('vehicle_makes', ['slug' => $makeSlug], [
                    'name' => $makeName,
                    'image_path' => 'images/catalog/autobagazhniki/brands/'.$makeImage,
                    'image_alt' => $makeName,
                ]);
                $modelId = $this->findOrCreate('vehicle_models', [
                    'vehicle_make_id' => $makeId,
                    'slug' => $modelSlug,
                ], ['name' => $modelName, 'image_path' => $imagePath, 'image_alt' => $imageAlt]);

                $years = $yearFrom.'–'.($yearTo ?? 'н.в.');
                $generationId = $this->findOrCreate('vehicle_generations', [
                    'vehicle_model_id' => $modelId,
                    'year_from' => $yearFrom,
                    'year_to' => $yearTo,
                ], [
                    'name' => $generationName ? $generationName.' '.$years : $years,
                    'slug' => $yearFrom.'-'.($yearTo ?? 'nv'),
                    'source' => 'manual_request',
                    'image_path' => $imagePath,
                    'image_alt' => $imageAlt,
                ]);

                $isNiva = $makeSlug === 'lada-vaz';
                $roofName = $isNiva ? 'Штатные места' : 'Интегрированные рейлинги';
                $roofId = $this->findOrCreate('vehicle_roof_types', ['name' => $roofName], [
                    'slug' => $isNiva ? 'statnye-mesta' : 'integrirovannye-reilingi',
                ]);

                $this->findOrCreate('vehicle_configurations', [
                    'vehicle_generation_id' => $generationId,
                    'vehicle_roof_type_id' => $roofId,
                    'year_from' => $yearFrom,
                    'year_to' => $yearTo,
                ], [
                    'display_name' => ($isNiva ? 'Niva Legend' : $modelName)
                        .($generationName ? ' '.$generationName : '').' '.$years.' ('.mb_strtolower($roofName).')',
                    'slug' => $yearFrom.'-'.($yearTo ?? 'nv').'-'.($isNiva ? 'fixed-points' : 'integrated-rails'),
                    'source' => 'manual_request',
                    'source_reference' => '2026-10-15:'.$makeSlug.':'.$modelSlug,
                    'verification_status' => 'verified',
                    'notes' => 'Годы выпуска и тип крепления указаны владельцем сайта. Совместимость с товарами не задана.',
                ]);
            }
        });
    }

    public function down(): void
    {
        // Сохраняем записи при откате: к ним уже могут быть привязаны товары.
    }

    private function findOrCreate(string $table, array $identity, array $values): int
    {
        return DB::table($table)->where($identity)->value('id')
            ?? DB::table($table)->insertGetId(array_merge($identity, $values, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
    }
};
