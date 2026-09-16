<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\RoofRackManufacturer;
use App\Models\VehicleBodyStyle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleRoofType;
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
            ->assertSee('data-brand-search', escape: false)
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

    public function test_vehicle_make_page_has_a_searchable_collapsed_model_list(): void
    {
        $this->get(route('catalog.autobagazhniki.show', 'toyota'))
            ->assertOk()
            ->assertSee('data-model-search', escape: false)
            ->assertSee('Все модели')
            ->assertSee('data-model-list', escape: false)
            ->assertSee('data-model-name="camry"', escape: false)
            ->assertSee('Camry')
            ->assertSee('RAV 4');
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

    public function test_model_page_lists_generations_with_local_images(): void
    {
        $response = $this->get(route('catalog.autobagazhniki.model.show', ['lada-vaz', 'vesta']));

        $response
            ->assertOk()
            ->assertSee('2015')
            ->assertDontSee('vehicle-fitment-meta', escape: false)
            ->assertSee('data-generation-card', escape: false);

        $vesta = VehicleModel::query()
            ->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'vesta')
            ->firstOrFail();

        $this->assertGreaterThanOrEqual(1, $vesta->generations()->count());

        $generation = $vesta->generations()->firstOrFail();
        $response->assertSee(route('catalog.autobagazhniki.generation.show', [
            'lada-vaz',
            'vesta',
            $generation->slug,
        ]));
    }

    public function test_configuration_page_lists_only_products_compatible_with_the_selected_variant(): void
    {
        $vesta = VehicleModel::query()
            ->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'vesta')
            ->firstOrFail();
        $sedanConfiguration = VehicleConfiguration::query()
            ->whereHas('generation', fn ($query) => $query->where('vehicle_model_id', $vesta->id))
            ->whereHas('bodyStyle', fn ($query) => $query->where('name', 'Седан'))
            ->with('generation')
            ->firstOrFail();
        $wagonConfiguration = VehicleConfiguration::query()
            ->whereHas('generation', fn ($query) => $query->where('vehicle_model_id', $vesta->id))
            ->whereHas('bodyStyle', fn ($query) => $query->where('name', 'Универсал'))
            ->with('generation')
            ->firstOrFail();
        $allBodies = $this->createRoofRackProduct('Для всех Vesta', 'all-vesta-bodies', 5000, 'Inter', 1, 75, 'Аэродинамическая', 120);
        $sedanOnly = $this->createRoofRackProduct('Только для седана', 'vesta-sedan-only', 6000, 'Inter', 1, 75, 'Аэродинамическая', 120);
        $wagonOnly = $this->createRoofRackProduct('Только для универсала', 'vesta-wagon-only', 7000, 'Inter', 1, 75, 'Аэродинамическая', 120);
        $this->attachFitment($allBodies, [$sedanConfiguration, $wagonConfiguration]);
        $this->attachFitment($sedanOnly, [$sedanConfiguration]);
        $this->attachFitment($wagonOnly, [$wagonConfiguration]);

        $this->get(route('catalog.autobagazhniki.configuration.show', [
            $vesta->make->slug,
            $vesta->slug,
            $sedanConfiguration->generation->slug,
            $sedanConfiguration->slug,
        ]))
            ->assertOk()
            ->assertSee($sedanConfiguration->display_name)
            ->assertSee('Кузов')
            ->assertSee('Годы выпуска')
            ->assertSee($allBodies->name)
            ->assertSee($sedanOnly->name)
            ->assertDontSee($wagonOnly->name);

        $this->get(route('catalog.autobagazhniki.configuration.show', [
            $vesta->make->slug,
            $vesta->slug,
            $sedanConfiguration->generation->slug,
            'unknown-configuration',
        ]))->assertNotFound();
    }

    public function test_legacy_variant_url_redirects_to_the_configuration_page(): void
    {
        $configuration = VehicleConfiguration::query()
            ->whereHas('generation.vehicleModel.make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->whereHas('generation.vehicleModel', fn ($query) => $query->where('slug', 'vesta'))
            ->with('generation.vehicleModel.make')
            ->firstOrFail();
        $model = $configuration->generation->vehicleModel;

        $this->get('/autobagazhniki/'.$model->make->slug.'/'.$model->slug.'/'.$configuration->slug)
            ->assertRedirectToRoute('catalog.autobagazhniki.configuration.show', [
                $model->make->slug,
                $model->slug,
                $configuration->generation->slug,
                $configuration->slug,
            ], 301);
    }

    public function test_imported_generation_images_exist(): void
    {
        $this->assertGreaterThan(1000, VehicleGeneration::query()->count());

        foreach (VehicleGeneration::query()->get() as $generation) {
            if ($generation->image_path) {
                $this->assertFileExists(public_path($generation->image_path));
            }
        }
    }

    public function test_imported_configurations_are_unique_per_source_card(): void
    {
        $duplicates = VehicleConfiguration::query()
            ->selectRaw('source, source_reference, count(*) as total')
            ->whereNotNull('source_reference')
            ->groupBy('source', 'source_reference')
            ->havingRaw('count(*) > 1')
            ->count();

        $this->assertSame(0, $duplicates);

        $priora = VehicleModel::query()
            ->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'priora')
            ->firstOrFail();

        $prioraConfigurations = VehicleConfiguration::query()
            ->whereHas('generation', fn ($query) => $query->where('vehicle_model_id', $priora->id));
        $this->assertSame(1, (clone $prioraConfigurations)->where('display_name', 'Приора 4/5дв. Седан/Хэтчбек 2007-2018')->count());
        $this->assertSame('Седан / Хэтчбек', (clone $prioraConfigurations)
            ->where('display_name', 'Приора 4/5дв. Седан/Хэтчбек 2007-2018')
            ->firstOrFail()
            ->bodyStyle
            ->name);

        $response = $this->get(route('catalog.autobagazhniki.model.show', ['lada-vaz', 'priora']));

        $response->assertOk()->assertSee('data-generation-card', escape: false);
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
        $configuration = $this->configurationFor($a4);
        $this->attachFitment($available, [$configuration]);
        $this->attachFitment($toOrder, [$configuration]);

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
        $this->attachFitment($aero, [$this->configurationFor($models[0])]);
        $this->attachFitment($square, [$this->configurationFor($models[1])]);

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

    private function configurationFor(VehicleModel $model): VehicleConfiguration
    {
        $generation = VehicleGeneration::query()->firstOrCreate(
            ['vehicle_model_id' => $model->id, 'slug' => 'test-generation'],
            ['name' => 'Тестовое поколение', 'year_from' => 2020, 'is_active' => true],
        );
        $bodyStyle = VehicleBodyStyle::query()->firstOrCreate(
            ['slug' => 'test-'.$model->id],
            ['name' => 'Кузов', 'is_active' => true],
        );
        $roofType = VehicleRoofType::query()->firstOrCreate(
            ['slug' => 'test-roof'],
            ['name' => 'Гладкая крыша', 'is_active' => true],
        );

        return VehicleConfiguration::query()->create([
            'vehicle_generation_id' => $generation->id,
            'vehicle_body_style_id' => $bodyStyle->id,
            'vehicle_roof_type_id' => $roofType->id,
            'slug' => 'test-configuration-'.VehicleConfiguration::query()->count(),
            'display_name' => 'Тестовая конфигурация',
            'year_from' => 2020,
            'is_active' => true,
        ]);
    }

    /** @param array<int, VehicleConfiguration> $configurations */
    private function attachFitment(Product $product, array $configurations): void
    {
        $fitment = Fitment::query()->create([
            'code' => 'TEST-'.$product->id.'-'.count($configurations),
            'name' => 'Тестовая применяемость',
            'is_active' => true,
        ]);
        $fitment->products()->attach($product, ['status' => 'active']);
        $fitment->configurations()->attach(collect($configurations)->pluck('id')->all());
    }
}
