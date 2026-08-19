<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\RoofRackManufacturer;
use App\Models\VehicleBodyType;
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
            ->assertSee('Багажники на крышу автомобиля')
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

    public function test_model_page_lists_imported_body_types_with_local_images(): void
    {
        $response = $this->get(route('catalog.autobagazhniki.model.show', ['lada-vaz', 'vesta']));

        $response
            ->assertOk()
            ->assertDontSee('Кузов, годы и крепление для Vesta')
            ->assertSee('Седан')
            ->assertSee('Универсал')
            ->assertSee('2015-нв')
            ->assertSee('интегрированные рейлинги')
            ->assertDontSee('vehicle-fitment-meta', escape: false)
            ->assertSee('data-body-type-card', escape: false);

        $vesta = VehicleModel::query()
            ->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'vesta')
            ->firstOrFail();

        $this->assertGreaterThanOrEqual(2, $vesta->bodyTypes()->count());

        $bodyType = $vesta->bodyTypes()->firstOrFail();
        $response->assertSee(route('catalog.autobagazhniki.body-type.show', [
            'lada-vaz',
            'vesta',
            $bodyType->slug,
        ]));
    }

    public function test_body_type_page_lists_only_products_compatible_with_the_selected_variant(): void
    {
        $vesta = VehicleModel::query()
            ->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'vesta')
            ->firstOrFail();
        $sedan = $vesta->bodyTypes()->where('name', 'Седан')->firstOrFail();
        $wagon = $vesta->bodyTypes()->where('name', 'Универсал')->firstOrFail();
        $allBodies = $this->createRoofRackProduct('Для всех Vesta', 'all-vesta-bodies', 5000, 'Inter', 1, 75, 'Аэродинамическая', 120);
        $sedanOnly = $this->createRoofRackProduct('Только для седана', 'vesta-sedan-only', 6000, 'Inter', 1, 75, 'Аэродинамическая', 120);
        $wagonOnly = $this->createRoofRackProduct('Только для универсала', 'vesta-wagon-only', 7000, 'Inter', 1, 75, 'Аэродинамическая', 120);
        $allBodies->vehicleModels()->attach($vesta);
        $sedanOnly->vehicleBodyTypes()->attach($sedan);
        $wagonOnly->vehicleBodyTypes()->attach($wagon);

        $this->get(route('catalog.autobagazhniki.body-type.show', [
            $vesta->make->slug,
            $vesta->slug,
            $sedan->slug,
        ]))
            ->assertOk()
            ->assertSee($sedan->source_name)
            ->assertSee('Кузов')
            ->assertSee('Годы выпуска')
            ->assertSee($allBodies->name)
            ->assertSee($sedanOnly->name)
            ->assertDontSee($wagonOnly->name);

        $this->get(route('catalog.autobagazhniki.body-type.show', [
            $vesta->make->slug,
            $vesta->slug,
            'unknown-body-type',
        ]))->assertNotFound();
    }

    public function test_imported_body_type_images_exist(): void
    {
        $this->assertGreaterThan(1000, VehicleBodyType::query()->count());

        foreach (VehicleBodyType::query()->get() as $bodyType) {
            if ($bodyType->image_path) {
                $this->assertFileExists(public_path($bodyType->image_path));
            }
        }
    }

    public function test_imported_fitment_variants_are_unique_per_source_card(): void
    {
        $duplicates = VehicleBodyType::query()
            ->selectRaw('vehicle_model_id, source_url, count(*) as total')
            ->whereNotNull('source_url')
            ->groupBy('vehicle_model_id', 'source_url')
            ->havingRaw('count(*) > 1')
            ->count();

        $this->assertSame(0, $duplicates);

        $priora = VehicleModel::query()
            ->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'priora')
            ->firstOrFail();

        $this->assertSame(1, $priora->bodyTypes()->where('source_name', 'Приора 4/5дв. Седан/Хэтчбек 2007-2018')->count());
        $this->assertSame('Седан / Хэтчбек', $priora->bodyTypes()->where('source_name', 'Приора 4/5дв. Седан/Хэтчбек 2007-2018')->value('name'));

        $response = $this->get(route('catalog.autobagazhniki.model.show', ['lada-vaz', 'priora']));

        $response->assertOk()->assertSee('Приора 4/5дв. Седан/Хэтчбек 2007-2018');
        $this->assertSame(2, substr_count($response->getContent(), 'data-body-type-card'));
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

    public function test_model_products_can_be_filtered_by_common_and_roof_rack_fields(): void
    {
        $a4 = VehicleModel::query()->whereHas('make', fn ($query) => $query->where('slug', 'audi'))->where('slug', 'a4')->firstOrFail();
        $available = $this->createRoofRackProduct('Аэродинамический багажник', 'aero-rack', 12500, 'Thule', 3, 75, 'Аэродинамическая', 120);
        $toOrder = $this->createRoofRackProduct('Прямоугольный багажник', 'square-rack', 18900, 'Amos', 0, 100, 'Прямоугольная', 130);
        $a4->products()->attach([$available->id, $toOrder->id]);

        $response = $this->get(route('catalog.autobagazhniki.model.show', ['audi', 'a4']));

        $response
            ->assertOk()
            ->assertSee('Фильтры товаров')
            ->assertSee('catalog-filters--horizontal', escape: false)
            ->assertSee('Производитель')
            ->assertSee('Цена, ₽')
            ->assertSee('Товар')
            ->assertSee('В наличии')
            ->assertSee('Под заказ')
            ->assertSee('Нагрузка, кг')
            ->assertSee('Тип дуги')
            ->assertSee('Длина дуги, см')
            ->assertSee($available->name)
            ->assertSee($toOrder->name);

        $this->get(route('catalog.autobagazhniki.model.show', [
            'audi',
            'a4',
            'manufacturer' => [(string) $available->roofRack->manufacturer_id],
            'price_from' => 12000,
            'price_to' => 13000,
            'availability' => ['in_stock'],
            'load_capacity' => ['75.0'],
            'bar_type' => ['Аэродинамическая'],
            'bar_length' => ['120.0'],
        ]))
            ->assertOk()
            ->assertSee($available->name)
            ->assertDontSee($toOrder->name)
            ->assertSee('Найдено товаров: 1');

        $this->get(route('catalog.autobagazhniki.model.show', [
            'audi',
            'a4',
            'availability' => ['to_order'],
        ]))
            ->assertOk()
            ->assertSee($toOrder->name)
            ->assertSee('Под заказ')
            ->assertDontSee($available->name);
    }

    public function test_make_page_collects_and_filters_products_from_all_its_models(): void
    {
        $audi = VehicleMake::query()->where('slug', 'audi')->firstOrFail();
        $models = $audi->models()->take(2)->get();
        $aero = $this->createRoofRackProduct('Товар для первой модели', 'first-model-rack', 10000, 'Thule', 2, 75, 'Аэродинамическая', 120);
        $square = $this->createRoofRackProduct('Товар для второй модели', 'second-model-rack', 15000, 'Amos', 0, 100, 'Прямоугольная', 130);
        $models[0]->products()->attach($aero);
        $models[1]->products()->attach($square);

        $response = $this->get(route('catalog.autobagazhniki.show', 'audi'));

        $response
            ->assertOk()
            ->assertDontSee('Товары для Audi')
            ->assertSee($aero->name)
            ->assertSee($square->name);

        $this->assertLessThan(
            strpos($response->getContent(), 'data-model-card'),
            strpos($response->getContent(), 'Фильтры товаров'),
        );

        $this->get(route('catalog.autobagazhniki.show', [
            'category' => 'audi',
            'bar_type' => ['Прямоугольная'],
        ]))
            ->assertOk()
            ->assertSee($square->name)
            ->assertDontSee($aero->name)
            ->assertSee('Найдено товаров: 1');
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

    private function createRoofRackProduct(
        string $name,
        string $slug,
        float $price,
        string $manufacturer,
        int $stock,
        float $loadCapacity,
        string $barType,
        float $barLength,
    ): Product {
        $roofRackManufacturer = RoofRackManufacturer::query()->firstOrCreate(['name' => $manufacturer]);
        $product = Product::query()->create([
            'name' => $name,
            'slug' => $slug,
            'price' => $price,
            'stock' => $stock,
            'is_active' => true,
        ]);
        $product->roofRack()->create([
            'manufacturer_id' => $roofRackManufacturer->id,
            'load_capacity_kg' => $loadCapacity,
            'bar_type' => $barType,
            'bar_length_cm' => $barLength,
        ]);

        return $product;
    }
}
