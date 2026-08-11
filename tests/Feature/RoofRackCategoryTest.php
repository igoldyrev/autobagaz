<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use Database\Seeders\RoofRackCategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoofRackCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_catalog_has_a_root_category_and_top_level_categories(): void
    {
        $rootCategory = CatalogCategory::query()
            ->whereNull('parent_id')
            ->where('slug', 'autobagazhniki')
            ->firstOrFail();

        $this->assertSame(81, $rootCategory->children()->count());
        $this->assertSame(78, $rootCategory->children()->where('kind', 'vehicle_make')->count());
        $this->assertSame(3, $rootCategory->children()->where('kind', 'special')->count());
    }

    public function test_catalog_page_lists_all_top_level_categories(): void
    {
        $response = $this->get(route('catalog.autobagazhniki.index'));

        $response
            ->assertOk()
            ->assertSee('Автобагажники по маркам автомобилей')
            ->assertSee('Audi')
            ->assertSee('Lada (ВАЗ)')
            ->assertSee('Багажники на рейлинги');

        $this->assertSame(81, substr_count($response->getContent(), 'data-category-card'));
    }

    public function test_empty_category_page_is_available(): void
    {
        $this->get(route('catalog.autobagazhniki.show', 'audi'))
            ->assertOk()
            ->assertSee('Багажники для автомобилей Audi')
            ->assertSee('Нет записей');
    }

    public function test_unknown_or_inactive_category_is_not_available(): void
    {
        $this->get(route('catalog.autobagazhniki.show', 'unknown'))->assertNotFound();

        CatalogCategory::query()->where('slug', 'audi')->update(['is_active' => false]);

        $this->get(route('catalog.autobagazhniki.show', 'audi'))->assertNotFound();
    }

    public function test_category_seeder_is_idempotent(): void
    {
        $count = CatalogCategory::query()->count();

        $this->seed(RoofRackCategorySeeder::class);

        $this->assertSame($count, CatalogCategory::query()->count());
    }

    public function test_category_image_exists(): void
    {
        $category = CatalogCategory::query()->where('slug', 'audi')->firstOrFail();

        $this->assertFileExists(public_path($category->image_path));
    }
}
