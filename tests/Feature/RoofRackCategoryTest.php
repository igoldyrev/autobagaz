<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
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

        $this->assertSame(3, $rootCategory->children()->count());
        $this->assertSame(78, $rootCategory->vehicleMakes()->count());
        $this->assertSame(3, $rootCategory->children()->where('kind', 'special')->count());
        $this->assertSame(852, VehicleModel::query()->count());

        foreach ($rootCategory->vehicleMakes as $make) {
            $this->assertGreaterThan(0, $make->models()->count());
        }
    }

    public function test_catalog_page_lists_all_top_level_categories(): void
    {
        $response = $this->get(route('catalog.autobagazhniki.index'));

        $response
            ->assertOk()
            ->assertSee('Автобагажники по маркам автомобилей')
            ->assertSee('Audi')
            ->assertSee('Lada (ВАЗ)')
            ->assertSee('Багажники на рейлинги')
            ->assertDontSee('Марка автомобиля')
            ->assertDontSee('>Категория<', escape: false);

        $this->assertSame(81, substr_count($response->getContent(), 'data-category-card'));
    }

    public function test_audi_category_page_lists_models(): void
    {
        $this->get(route('catalog.autobagazhniki.show', 'audi'))
            ->assertOk()
            ->assertSee('Багажники для автомобилей Audi')
            ->assertSee('Audi A4')
            ->assertSee('80/90')
            ->assertDontSee('Нет записей')
            ->assertSee(route('catalog.autobagazhniki.model.show', ['audi', 'a4']));

        $audi = VehicleMake::query()->where('slug', 'audi')->firstOrFail();

        $this->assertSame(16, $audi->models()->count());
    }

    public function test_special_category_without_models_is_available(): void
    {
        $this->get(route('catalog.autobagazhniki.show', 'bagazhniki-aps'))
            ->assertOk()
            ->assertSee('Багажники АПС')
            ->assertSee('Нет записей');
    }

    public function test_audi_model_page_is_available(): void
    {
        $this->get(route('catalog.autobagazhniki.model.show', ['audi', 'a4']))
            ->assertOk()
            ->assertSee('Багажники для Audi A4')
            ->assertSee('Нет записей');

        $this->get(route('catalog.autobagazhniki.model.show', ['audi', 'unknown']))
            ->assertNotFound();
    }

    public function test_models_are_available_for_other_vehicle_makes(): void
    {
        $response = $this->get(route('catalog.autobagazhniki.show', 'toyota'));

        $response
            ->assertOk()
            ->assertSee('Багажники для автомобилей Toyota')
            ->assertSee('Camry')
            ->assertSee(route('catalog.autobagazhniki.model.show', ['toyota', 'camry']));

        $this->assertSame(57, substr_count($response->getContent(), 'data-model-card'));
    }

    public function test_unknown_or_inactive_category_is_not_available(): void
    {
        $this->get(route('catalog.autobagazhniki.show', 'unknown'))->assertNotFound();

        VehicleMake::query()->where('slug', 'audi')->update(['is_active' => false]);

        $this->get(route('catalog.autobagazhniki.show', 'audi'))->assertNotFound();
    }

    public function test_category_seeder_is_idempotent(): void
    {
        $categoryCount = CatalogCategory::query()->count();
        $makeCount = VehicleMake::query()->count();
        $modelCount = VehicleModel::query()->count();
        $audi = VehicleMake::query()->where('slug', 'audi')->firstOrFail();
        $rootCategory = CatalogCategory::query()->where('slug', 'autobagazhniki')->firstOrFail();
        $audi->update(['name' => 'Audi edited']);
        $rootCategory->vehicleMakes()->updateExistingPivot($audi->id, ['sort_order' => 999]);
        $audi->models()->create([
            'name' => 'Admin model',
            'slug' => 'admin-model',
            'sort_order' => 999,
            'is_active' => true,
        ]);

        $this->seed(RoofRackCategorySeeder::class);

        $this->assertSame($categoryCount, CatalogCategory::query()->count());
        $this->assertSame($makeCount, VehicleMake::query()->count());
        $this->assertSame($modelCount + 1, VehicleModel::query()->count());
        $this->assertSame('Audi edited', $audi->fresh()->name);
        $this->assertSame(999, $rootCategory->vehicleMakes()->findOrFail($audi->id)->pivot->sort_order);
        $this->assertTrue($audi->models()->where('slug', 'admin-model')->exists());
    }

    public function test_category_image_exists(): void
    {
        $category = VehicleMake::query()->where('slug', 'audi')->firstOrFail();

        $this->assertFileExists(public_path($category->image_path));
        $this->assertStringEndsWith('bagazhniki_dlya_audi-1.png', $category->image_path);
    }

    public function test_vehicle_model_images_exist(): void
    {
        foreach (VehicleModel::query()->get() as $model) {
            $this->assertFileExists(public_path($model->image_path));
            $this->assertStringContainsString('/models/', $model->image_path);
        }
    }

    public function test_only_categories_without_provided_images_use_the_placeholder(): void
    {
        $placeholder = 'images/catalog/autobagazhniki/category-background.webp';
        $expectedPlaceholderSlugs = ['forthing', 'omoda'];

        $categories = VehicleMake::query()->get();

        $this->assertEqualsCanonicalizing(
            $expectedPlaceholderSlugs,
            $categories->where('image_path', $placeholder)->pluck('slug')->all(),
        );

        foreach ($categories->where('image_path', '!=', $placeholder) as $category) {
            $this->assertFileExists(public_path($category->image_path));
        }
    }
}
