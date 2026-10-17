<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $vehicles = json_decode(file_get_contents(database_path('data/requested_vehicles_2026_10_17.json')), true, flags: JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($vehicles): void {
            $categoryId = $this->findOrCreate('catalog_categories', ['parent_id' => null, 'slug' => 'autobagazhniki'], [
                'kind' => 'section', 'name' => 'Автобагажники',
                'description' => 'Каталог автомобильных багажников по маркам автомобилей.',
            ]);
            $knownMakes = array_column(require database_path('data/roof_rack_categories.php'), 'slug');
            foreach ($vehicles as $vehicle) {
                $makeImage = 'images/catalog/autobagazhniki/brands/'.match ($vehicle['make_slug']) {
                    'haval' => 'bagazhniki_dlya_haval_1.jpg',
                    'jetour' => 'bagazhniki_dlya_jetour_1.png',
                    default => 'bagazhniki_dlya_'.str_replace('-', '_', $vehicle['make_slug']).'-1.png',
                };
                if (! is_file(public_path($makeImage))) {
                    $makeImage = in_array($vehicle['make_slug'], $knownMakes, true)
                        ? 'images/catalog/autobagazhniki/category-background.webp'
                        : $vehicle['image_path'];
                }
                $makeId = $this->findOrCreate('vehicle_makes', ['slug' => $vehicle['make_slug']], [
                    'name' => $vehicle['make_name'], 'image_path' => $makeImage, 'image_alt' => $vehicle['make_name'],
                ]);
                DB::table('catalog_category_vehicle_make')->insertOrIgnore([
                    'catalog_category_id' => $categoryId, 'vehicle_make_id' => $makeId,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
                $years = $vehicle['year_from'].'–'.($vehicle['year_to'] ?? 'н.в.');
                $label = $vehicle['model_name'].($vehicle['generation'] ? ' '.$vehicle['generation'] : '').' '.$years;
                $image = ['image_path' => $vehicle['image_path'], 'image_alt' => $vehicle['make_name'].' '.$label];
                $modelId = $this->findOrCreate('vehicle_models', [
                    'vehicle_make_id' => $makeId, 'slug' => $vehicle['model_slug'],
                ], array_merge(['name' => $vehicle['model_name']], $image));
                [$roofName, $roofSlug] = match ($vehicle['roof']) {
                    'smooth' => ['Гладкая крыша', 'gladkaia-krysa'],
                    'integrated' => ['Интегрированные рейлинги', 'integrirovannye-reilingi'],
                    'fixed' => ['Штатные места', 'statnye-mesta'],
                };
                $roofId = $this->findOrCreate('vehicle_roof_types', ['slug' => $roofSlug], ['name' => $roofName]);
                $bodyName = match ($vehicle['body_slug']) {
                    'liftbek' => 'Лифтбек',
                    'sedan' => 'Седан',
                    'miniven' => 'Минивэн',
                    'pikap' => 'Пикап',
                    'vnedoroznik' => 'Внедорожник',
                };
                $bodyId = $this->findOrCreate('vehicle_body_styles', ['slug' => $vehicle['body_slug']], ['name' => $bodyName]);

                // Старые записи могут охватывать более широкий диапазон лет.
                // Неизвестный тип крыши не считаем совпадением с указанным типом.
                $existing = DB::table('vehicle_configurations as c')
                    ->join('vehicle_generations as g', 'g.id', '=', 'c.vehicle_generation_id')
                    ->where('g.vehicle_model_id', $modelId)
                    ->when($vehicle['generation'], function ($query) use ($vehicle): void {
                        $query->where(function ($generation) use ($vehicle): void {
                            $generation->where('g.year_from', $vehicle['year_from'])
                                ->orWhere('g.name', 'like', $vehicle['generation'].' %')
                                ->orWhere('c.display_name', 'like', '% '.$vehicle['generation'].' %');
                        });
                    })
                    ->where('c.vehicle_roof_type_id', $roofId)
                    ->where('c.vehicle_body_style_id', $bodyId)
                    ->where('c.doors_count', $vehicle['doors_count'])
                    ->where('c.year_from', '<=', $vehicle['year_from'])
                    ->where(function ($query) use ($vehicle): void {
                        $query->whereNull('c.year_to');
                        if ($vehicle['year_to'] !== null) {
                            $query->orWhere('c.year_to', '>=', $vehicle['year_to']);
                        }
                    })->exists();
                if ($existing) {
                    continue;
                }

                $generationId = $this->findOrCreate('vehicle_generations', [
                    'vehicle_model_id' => $modelId,
                    'year_from' => $vehicle['year_from'], 'year_to' => $vehicle['year_to'],
                ], array_merge([
                    'name' => ($vehicle['generation'] ? $vehicle['generation'].' ' : '').$years,
                    'slug' => $vehicle['year_from'].'-'.($vehicle['year_to'] ?? 'nv'),
                    'source' => 'manual_request',
                ], $image));
                $this->findOrCreate('vehicle_configurations', [
                    'vehicle_generation_id' => $generationId,
                    'vehicle_body_style_id' => $bodyId,
                    'vehicle_roof_type_id' => $roofId,
                    'year_from' => $vehicle['year_from'], 'year_to' => $vehicle['year_to'],
                    'doors_count' => $vehicle['doors_count'],
                ], [
                    'display_name' => $label.' ('.mb_strtolower($roofName).')',
                    'slug' => $vehicle['year_from'].'-'.($vehicle['year_to'] ?? 'nv').'-'.$vehicle['roof'],
                    'source' => 'manual_request',
                    'source_reference' => '2026-10-17:'.$vehicle['make_slug'].':'.$vehicle['model_slug'].':'.$vehicle['year_from'],
                    'verification_status' => 'verified',
                    'notes' => 'Годы выпуска, кузов и тип крыши указаны владельцем сайта. Совместимость с товарами не задана.',
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
                'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ]));
    }
};
