<?php

namespace Database\Seeders;

use App\Models\CatalogCategory;
use Illuminate\Database\Seeder;

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
        $imagePath = 'images/catalog/autobagazhniki/category-background.webp';

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
                    'image_path' => $imagePath,
                    'image_alt' => $category['name'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );
        }
    }
}
