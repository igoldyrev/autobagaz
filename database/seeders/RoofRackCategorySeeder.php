<?php

namespace Database\Seeders;

use App\Models\CatalogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RoofRackCategorySeeder extends Seeder
{
    public function run(): void
    {
        $rootCategory = CatalogCategory::query()->updateOrCreate(
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
            CatalogCategory::query()->updateOrCreate(
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
        }
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
