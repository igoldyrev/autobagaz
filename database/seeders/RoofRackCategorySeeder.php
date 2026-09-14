<?php

namespace Database\Seeders;

use App\Models\CatalogCategory;
use App\Models\VehicleBodyStyle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleRoofType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RoofRackCategorySeeder extends Seeder
{
    public function run(): void
    {
        $rootCategory = CatalogCategory::query()->firstOrCreate(
            [
                'parent_id' => null,
                'slug' => 'autobagazhniki',
            ],
            [
                'kind' => 'section',
                'name' => 'Автобагажники',
                'description' => 'Каталог автомобильных багажников по маркам автомобилей.',
                'sort_order' => 0,
                'is_active' => true,
                'meta_title' => 'Автобагажники по маркам автомобилей в Перми',
                'meta_description' => 'Каталог багажников на крышу автомобиля по маркам автомобилей.',
            ],
        );

        $categories = require database_path('data/roof_rack_categories.php');
        foreach ($categories as $index => $category) {
            if ($category['kind'] === 'special') {
                CatalogCategory::query()->firstOrCreate(
                    [
                        'parent_id' => $rootCategory->id,
                        'slug' => $category['slug'],
                    ],
                    [
                        'kind' => $category['kind'],
                        'name' => $category['name'],
                        'description' => $category['description'] ?? null,
                        'image_path' => $this->imagePath($category),
                        'image_alt' => $category['name'],
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ],
                );

                continue;
            }

            $make = VehicleMake::query()->firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'] ?? null,
                    'image_path' => $this->imagePath($category),
                    'image_alt' => $category['name'],
                    'is_active' => true,
                ],
            );

            if (! $rootCategory->vehicleMakes()->whereKey($make->id)->exists()) {
                $rootCategory->vehicleMakes()->attach($make->id, [
                    'sort_order' => $index + 1,
                ]);
            }
        }

        $modelGroups = require database_path('data/roof_rack_models.php');
        foreach ($modelGroups as $makeSlug => $models) {
            $make = VehicleMake::query()->where('slug', $makeSlug)->firstOrFail();

            foreach ($models as $index => $model) {
                VehicleModel::query()->firstOrCreate(
                    [
                        'vehicle_make_id' => $make->id,
                        'slug' => $model['slug'],
                    ],
                    [
                        'name' => $model['name'],
                        'description' => null,
                        'image_path' => "images/catalog/autobagazhniki/models/{$makeSlug}/{$model['image']}",
                        'image_alt' => "{$make->name} {$model['name']}",
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ],
                );
            }
        }

        $bodyTypesPath = database_path('data/vehicle_body_types.json');
        $bodyTypeGroups = File::exists($bodyTypesPath)
            ? json_decode(File::get($bodyTypesPath), true, flags: JSON_THROW_ON_ERROR)
            : [];

        foreach ($bodyTypeGroups as $makeSlug => $modelGroups) {
            $make = VehicleMake::query()->where('slug', $makeSlug)->firstOrFail();

            foreach ($modelGroups as $modelSlug => $bodyTypes) {
                $model = $make->models()->where('slug', $modelSlug)->firstOrFail();

                foreach ($bodyTypes as $bodyType) {
                    [$yearFrom, $yearTo] = $this->yearRange($bodyType['year_label'] ?? null);
                    $yearLabel = $bodyType['year_label'] ?: 'Годы не указаны';
                    $generationSlug = Str::slug(str_replace('н.в.', 'present', $yearLabel)) ?: 'years-unknown';
                    $generationReference = "vehicle-generation:{$makeSlug}/{$modelSlug}/{$generationSlug}";
                    $generation = VehicleGeneration::query()->updateOrCreate(
                        ['source' => 'vehicle_body_types_import', 'source_reference' => $generationReference],
                        [
                            'vehicle_model_id' => $model->id,
                            'name' => $yearLabel,
                            'slug' => $generationSlug,
                            'year_from' => $yearFrom,
                            'year_to' => $yearTo,
                            'sort_order' => $bodyType['sort_order'],
                            'is_active' => $bodyType['is_active'],
                        ],
                    );

                    if (! $generation->image_path && $bodyType['image_path']) {
                        $generation->update([
                            'image_path' => $bodyType['image_path'],
                            'image_alt' => $bodyType['image_alt'],
                        ]);
                    }

                    $bodyStyle = ($bodyType['name'] ?? null) && $bodyType['name'] !== 'Кузов не указан'
                        ? VehicleBodyStyle::query()->firstOrCreate(
                            ['slug' => Str::slug($bodyType['name'])],
                            ['name' => $bodyType['name'], 'is_active' => true],
                        )
                        : null;
                    $roofType = $bodyType['mounting_type']
                        ? VehicleRoofType::query()->firstOrCreate(
                            ['slug' => Str::slug($bodyType['mounting_type'])],
                            ['name' => $bodyType['mounting_type'], 'is_active' => true],
                        )
                        : null;

                    VehicleConfiguration::query()->updateOrCreate(
                        [
                            'source' => 'vehicle_body_types_import',
                            'source_reference' => "vehicle-configuration:{$makeSlug}/{$modelSlug}/{$bodyType['slug']}",
                        ],
                        [
                            'vehicle_generation_id' => $generation->id,
                            'vehicle_body_style_id' => $bodyStyle?->id,
                            'vehicle_roof_type_id' => $roofType?->id,
                            'slug' => $bodyType['slug'],
                            'display_name' => $bodyType['source_name'] ?: $bodyType['name'],
                            'year_from' => $yearFrom,
                            'year_to' => $yearTo,
                            'verification_status' => 'migrated',
                            'sort_order' => $bodyType['sort_order'],
                            'is_active' => $bodyType['is_active'],
                        ],
                    );
                }
            }
        }

        CatalogCategory::query()->firstOrCreate(
            ['parent_id' => null, 'slug' => 'autobox'],
            [
                'kind' => 'section',
                'name' => 'Автомобильные боксы',
                'description' => 'Автомобильные боксы на крышу для безопасной и удобной перевозки багажа.',
                'sort_order' => 1,
                'is_active' => true,
                'meta_title' => 'Автомобильные боксы на крышу в Перми',
                'meta_description' => 'Каталог автомобильных боксов на крышу. Продажа автобоксов в Перми.',
            ],
        );

        CatalogCategory::query()->firstOrCreate(
            ['parent_id' => null, 'slug' => 'velokrepleniya'],
            [
                'kind' => 'section',
                'name' => 'Велокрепления',
                'description' => 'Каталог велокреплений для перевозки велосипедов на автомобиле.',
                'sort_order' => 2,
                'is_active' => true,
                'meta_title' => 'Велокрепления для автомобиля в Перми',
                'meta_description' => 'Каталог велокреплений для перевозки велосипедов на автомобиле.',
            ],
        );

        CatalogCategory::query()->firstOrCreate(
            ['parent_id' => null, 'slug' => 'krepleniya-dlya-lyzh-i-snoubordov'],
            ['kind' => 'section', 'name' => 'Крепления для лыж и сноубордов', 'description' => 'Каталог автомобильных креплений для лыж и сноубордов.', 'sort_order' => 3, 'is_active' => true, 'meta_title' => 'Крепления для лыж и сноубордов в Перми', 'meta_description' => 'Каталог креплений для лыж и сноубордов на автомобиль.'],
        );
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

    /**
     * @param  array{kind: string, name: string, slug: string}  $category
     */
    private function imagePath(array $category): string
    {
        $placeholder = 'images/catalog/autobagazhniki/category-background.webp';
        $directory = 'images/catalog/autobagazhniki/brands';
        $specialImages = [
            'bagazhniki-aps' => 'bagazhniki_aps_1.png',
            'v-shtatnoe-mesto' => 'bagazhniki_v_shtatnoe_mesto_1.png',
            'na-reylingi' => 'bagazhnik_na_reylingi_1.jpg',
        ];
        $exceptionImages = [
            'changan' => 'bagazhniki_dlya_changan_1.png',
            'exeed' => 'bagazhniki_dlya_exeed_1.png',
            'gaz' => 'bagazhniki_dlya_gaz_gaz-1.png',
            'haima' => 'bagazhniki_dlya_haima_1.jpg',
            'haval' => 'bagazhniki_dlya_haval_1.jpg',
            'iveco' => 'bagazhniki_dlya_iveso-1.png',
            'jetour' => 'bagazhniki_dlya_jetour_1.png',
            'mg' => 'bagazhniki_dlya_mg-1.gif',
            'ravon' => 'bagazhniki_dlya_ravon_1.png',
            'tank' => 'bagazhniki_dlya_tank_1.png',
        ];

        $filename = $specialImages[$category['slug']]
            ?? $exceptionImages[$category['slug']]
            ?? 'bagazhniki_dlya_'.str_replace('-', '_', $category['slug']).'-1.png';
        $path = "{$directory}/{$filename}";

        return File::exists(public_path($path)) ? $path : $placeholder;
    }
}
