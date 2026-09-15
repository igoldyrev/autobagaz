<?php

namespace Tests\Feature;

use App\Http\Middleware\ResolveVehicleConfiguration;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\ProductPageInformation;
use App\Models\ProductType;
use App\Models\User;
use App\Models\VehicleBodyStyle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleRoofType;
use App\Services\VehicleCatalogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class VehicleFitmentPickerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_home_page_contains_configuration_picker(): void
    {
        $configuration = $this->configuration();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Подберите оборудование для автомобиля')
            ->assertSee('data-vehicle-configuration', escape: false)
            ->assertSee('data-vehicle-bodywork', escape: false)
            ->assertSee('data-vehicle-mounting', escape: false)
            ->assertDontSee('data-vehicle-year', escape: false)
            ->assertDontSee('data-vehicle-generation', escape: false)
            ->assertDontSee('data-vehicle-body-style', escape: false)
            ->assertDontSee('data-vehicle-roof-type', escape: false)
            ->assertSee($configuration->generation->vehicleModel->make->name);
    }

    public function test_picker_returns_models_and_new_configurations(): void
    {
        $configuration = $this->configuration();
        $model = $configuration->generation->vehicleModel;
        $configuration->bodyStyle->update(['name' => 'Кроссовер']);

        $this->getJson(route('catalog.vehicle-fitment.models', ['make_id' => $model->vehicle_make_id]))
            ->assertOk()
            ->assertJsonFragment(['id' => $model->id, 'name' => $model->name]);

        $this->getJson(route('catalog.vehicle-fitment.configurations', ['model_id' => $model->id]))
            ->assertOk()
            ->assertJsonFragment([
                'id' => $configuration->id,
                'display_name' => $configuration->display_name,
                'year_from' => 2021,
            ])
            ->assertJsonPath('0.generation.id', $configuration->generation->id)
            ->assertJsonPath('0.body_style.id', $configuration->bodyStyle->id)
            ->assertJsonPath('0.roof_type.id', $configuration->roofType->id)
            ->assertJsonPath('0.bodywork.label', 'Кроссовер — 2021–н.в.')
            ->assertJsonPath('0.mounting.label', $configuration->roofType->name);
    }

    public function test_picker_lists_active_makes_and_models_without_configurations(): void
    {
        $make = VehicleMake::query()->create([
            'name' => 'Марка без конфигураций',
            'slug' => 'make-without-configurations',
            'is_active' => true,
        ]);
        $model = $make->models()->create([
            'name' => 'Модель без конфигураций',
            'slug' => 'model-without-configurations',
            'is_active' => true,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($make->name);

        $this->getJson(route('catalog.vehicle-fitment.models', ['make_id' => $make->id]))
            ->assertOk()
            ->assertJsonFragment(['id' => $model->id, 'name' => $model->name]);

        $this->getJson(route('catalog.vehicle-fitment.configurations', ['model_id' => $model->id]))
            ->assertOk()
            ->assertExactJson([]);
    }

    public function test_selection_is_saved_in_cookie_and_displayed_in_header(): void
    {
        $configuration = $this->configuration();

        $this->get(route('catalog.vehicle-fitment.index', [
            'vehicle_configuration_id' => $configuration->id,
            'vehicle_year' => 2022,
        ]))
            ->assertOk()
            ->assertCookie(ResolveVehicleConfiguration::COOKIE_NAME, (string) $configuration->id)
            ->assertCookie(ResolveVehicleConfiguration::YEAR_COOKIE_NAME, '2022')
            ->assertSee('<strong>'.$configuration->vehicle_label.'</strong>', escape: false)
            ->assertSee('Lada (ВАЗ) Vesta 2022')
            ->assertSee('изменить')
            ->assertSee('сбросить');

        $this->withCookies([
            ResolveVehicleConfiguration::COOKIE_NAME => (string) $configuration->id,
            ResolveVehicleConfiguration::YEAR_COOKIE_NAME => '2022',
        ])
            ->get(route('catalog.auto-boxes.index'))
            ->assertOk()
            ->assertSee('<strong>'.$configuration->vehicle_label.'</strong>', escape: false)
            ->assertSee('Lada (ВАЗ) Vesta 2022');
    }

    public function test_picker_shows_category_counts_and_only_confirmed_products(): void
    {
        $configuration = $this->configuration();
        $rack = $this->roofRack('Подходящий автобагажник', 'compatible-roof-rack', 80, 25);
        $fitment = Fitment::query()->create([
            'code' => 'TEST-FITMENT',
            'name' => 'Тестовый Fitment',
            'verification_status' => 'verified',
            'is_active' => true,
        ]);
        $fitment->configurations()->attach($configuration, [
            'crossbar_spacing_min_mm' => 600,
            'crossbar_spacing_max_mm' => 900,
        ]);
        $fitment->products()->attach($rack, ['status' => 'active']);

        $box = $this->autoBox('Подходящий автобокс', 'compatible-auto-box', 60, 100, 35, 500, 800);
        $unrelatedRack = $this->roofRack('Неподходящий автобагажник', 'incompatible-roof-rack', 80, 25);
        $unrelatedBox = $this->autoBox('Универсальный автобокс', 'universal-auto-box', 20, 60, 20, 500, 800);

        $response = $this->get(route('catalog.vehicle-fitment.index', [
            'vehicle_configuration_id' => $configuration->id,
        ]));

        $response
            ->assertOk()
            ->assertSee('Подходит для '.$configuration->vehicle_label)
            ->assertSee('Подходит для вашей '.$configuration->vehicle_label)
            ->assertSee($rack->name)
            ->assertSee($box->name)
            ->assertDontSee($unrelatedRack->name)
            ->assertSee($unrelatedBox->name)
            ->assertSeeInOrder(['Багажники', '1', 'Автобоксы', '2']);

        $this->get(route('catalog.autobagazhniki.index', ['vehicle_configuration_id' => $configuration->id]))
            ->assertOk()
            ->assertSee('catalog-filters--horizontal', escape: false)
            ->assertSeeInOrder(['Фильтры товаров', $rack->name])
            ->assertSee($rack->name)
            ->assertDontSee($unrelatedRack->name);

        $this->get(route('catalog.auto-boxes.index', ['vehicle_configuration_id' => $configuration->id]))
            ->assertOk()
            ->assertSee($box->name)
            ->assertSee($unrelatedBox->name);

        $this->get(route('products.show', [
            'product' => $rack,
            'vehicle_configuration_id' => $configuration->id,
        ]))
            ->assertOk()
            ->assertSee('Ваш автомобиль:')
            ->assertSee('Подходит для вашей Lada (ВАЗ) Vesta')
            ->assertSee('Подходит для 1 автомобиля')
            ->assertSee($configuration->bodyStyle->name)
            ->assertSee($configuration->roofType->name)
            ->assertDontSee('Совместимость с автомобилями');

        $this->get(route('products.show', [
            'product' => $unrelatedRack,
            'vehicle_configuration_id' => $configuration->id,
        ]))
            ->assertOk()
            ->assertSee('Не подходит для выбранного автомобиля')
            ->assertSee('Показать подходящие аналоги')
            ->assertSee(route('catalog.autobagazhniki.index', [
                'vehicle_configuration_id' => $configuration->id,
            ]));
    }

    public function test_clear_query_removes_selected_vehicle_cookie(): void
    {
        $configuration = $this->configuration();

        $this->withCookie(ResolveVehicleConfiguration::COOKIE_NAME, (string) $configuration->id)
            ->get(route('home', ['vehicle_configuration_id' => 'clear']))
            ->assertOk()
            ->assertCookieExpired(ResolveVehicleConfiguration::COOKIE_NAME)
            ->assertDontSee('selected-vehicle', escape: false);
    }

    public function test_product_page_displays_shared_purchase_information(): void
    {
        $product = $this->roofRack('Товар с условиями', 'product-with-information', 80, 25);
        ProductPageInformation::query()->firstOrFail()->update([
            'delivery_content' => 'Черновик доставки для Перми',
            'payment_content' => 'Черновик оплаты',
            'warranty_content' => 'Черновик гарантии',
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Доставка')
            ->assertSee('Оплата')
            ->assertSee('Гарантия')
            ->assertSee('Черновик доставки для Перми')
            ->assertSee('Черновик оплаты')
            ->assertSee('Черновик гарантии');
    }

    public function test_roof_rack_editor_uses_fitments_without_legacy_compatibility_fields(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)
            ->get(route('admin.products.roof-racks.create'))
            ->assertOk()
            ->assertSee('Группы применяемости')
            ->assertDontSee('name="vehicle_model_ids[]"', escape: false)
            ->assertDontSee('name="vehicle_body_type_ids[]"', escape: false)
            ->assertDontSee('name="compatibility_product_ids[]"', escape: false);
    }

    public function test_legacy_product_compatibility_tables_are_removed(): void
    {
        $this->assertFalse(Schema::hasTable('product_vehicle_model'));
        $this->assertFalse(Schema::hasTable('product_vehicle_body_type'));
        $this->assertFalse(Schema::hasTable('product_base_product'));
        $this->assertFalse(Schema::hasTable('vehicle_body_types'));
    }

    public function test_vehicle_catalog_cache_is_invalidated_when_a_product_changes(): void
    {
        $configuration = $this->configuration();
        $rack = $this->roofRack('Кэшируемый багажник', 'cached-roof-rack', 80, 25);
        $fitment = Fitment::query()->create([
            'code' => 'CACHE-FITMENT',
            'name' => 'Кэшируемая применяемость',
            'is_active' => true,
        ]);
        $fitment->configurations()->attach($configuration);
        $fitment->products()->attach($rack, ['status' => 'active']);

        $catalog = app(VehicleCatalogService::class);
        $this->assertSame(1, $catalog->summary($configuration)['roof_rack_count']);

        $rack->update(['is_active' => false]);

        $this->assertSame(0, $catalog->summary($configuration)['roof_rack_count']);
    }

    private function configuration(): VehicleConfiguration
    {
        $model = VehicleModel::query()
            ->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'vesta')
            ->firstOrFail();
        $generation = VehicleGeneration::query()->create([
            'vehicle_model_id' => $model->id,
            'name' => 'I поколение',
            'slug' => 'test-generation',
            'year_from' => 2021,
            'is_active' => true,
        ]);
        $bodyStyle = VehicleBodyStyle::query()->create(['name' => 'Универсал', 'slug' => 'test-wagon', 'is_active' => true]);
        $roofType = VehicleRoofType::query()->create(['name' => 'Интегрированные рейлинги', 'slug' => 'test-integrated-rails', 'is_active' => true]);

        return VehicleConfiguration::query()->create([
            'vehicle_generation_id' => $generation->id,
            'vehicle_body_style_id' => $bodyStyle->id,
            'vehicle_roof_type_id' => $roofType->id,
            'slug' => 'test-configuration',
            'display_name' => 'Универсал с интегрированными рейлингами',
            'year_from' => 2021,
            'verification_status' => 'verified',
            'is_active' => true,
        ])->load(['generation.vehicleModel.make', 'bodyStyle', 'roofType']);
    }

    private function roofRack(string $name, string $slug, int $width, int $height): Product
    {
        $product = $this->product($name, $slug, 'roof_rack');
        $product->roofRack()->create([
            'bar_length_mm' => 1200,
            'bar_width_mm' => $width,
            'bar_height_mm' => $height,
        ]);

        return $product;
    }

    private function autoBox(string $name, string $slug, int $minWidth, int $maxWidth, int $maxHeight, int $minSpacing, int $maxSpacing): Product
    {
        $product = $this->product($name, $slug, 'roof_box');
        $product->autoBox()->create([
            'clamp_width_min_mm' => $minWidth,
            'clamp_width_max_mm' => $maxWidth,
            'clamp_height_max_mm' => $maxHeight,
            'crossbar_spacing_min_mm' => $minSpacing,
            'crossbar_spacing_max_mm' => $maxSpacing,
        ]);

        return $product;
    }

    private function product(string $name, string $slug, string $type): Product
    {
        return Product::query()->create([
            'product_type_id' => ProductType::query()->where('code', $type)->value('id'),
            'name' => $name,
            'slug' => $slug,
            'price' => 1000,
            'stock' => 1,
            'is_active' => true,
        ]);
    }
}
