<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\VehicleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleFitmentPickerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_home_page_contains_vehicle_picker(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('ПОДБОР ПО АВТОМОБИЛЮ')
            ->assertSee('data-vehicle-picker', escape: false);
    }

    public function test_picker_returns_models_and_body_types_for_the_selected_car(): void
    {
        $model = $this->model();

        $this->getJson(route('catalog.vehicle-fitment.models', ['make_id' => $model->vehicle_make_id]))
            ->assertOk()
            ->assertJsonFragment(['id' => $model->id, 'name' => $model->name]);

        $bodyType = $model->bodyTypes()->firstOrFail();

        $this->getJson(route('catalog.vehicle-fitment.body-types', ['model_id' => $model->id]))
            ->assertOk()
            ->assertJsonFragment(['id' => $bodyType->id]);
    }

    public function test_picker_shows_direct_roof_racks_and_accessories_compatible_through_them(): void
    {
        $model = $this->model();
        $bodyType = $model->bodyTypes()->firstOrFail();
        $rack = $this->product('Подходящий автобагажник', 'compatible-roof-rack');
        $rack->roofRack()->create();
        $rack->vehicleBodyTypes()->attach($bodyType);

        $box = $this->product('Подходящий автобокс', 'compatible-auto-box');
        $box->autoBox()->create();
        $rack->compatibleAccessories()->attach($box->id, ['compatibility_type' => 'via_base_product']);

        $unrelatedBox = $this->product('Неподходящий автобокс', 'incompatible-auto-box');
        $unrelatedBox->autoBox()->create();

        $this->get(route('catalog.vehicle-fitment.index', [
            'make_id' => $model->vehicle_make_id,
            'model_id' => $model->id,
            'body_type_id' => $bodyType->id,
        ]))
            ->assertOk()
            ->assertSee($rack->name)
            ->assertSee($box->name)
            ->assertDontSee($unrelatedBox->name)
            ->assertSee('Товары для:')
            ->assertSee('Автомобильные боксы');
    }

    public function test_empty_picker_results_do_not_show_mounting_type(): void
    {
        $model = $this->model();
        $bodyType = $model->bodyTypes()->whereNotNull('mounting_type')->firstOrFail();

        $this->get(route('catalog.vehicle-fitment.index', [
            'make_id' => $model->vehicle_make_id,
            'model_id' => $model->id,
            'body_type_id' => $bodyType->id,
        ]))
            ->assertOk()
            ->assertSee('Для этого автомобиля автобагажники пока не добавлены.')
            ->assertDontSee('Тип крепления:');
    }

    public function test_roof_rack_editor_offers_accessories_for_indirect_compatibility(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $box = $this->product('Автобокс для выбора', 'box-for-admin-picker');
        $box->autoBox()->create();

        $this->actingAs($admin)
            ->get(route('admin.products.roof-racks.create'))
            ->assertOk()
            ->assertSee('Автомобильные боксы, совместимые с этим багажником')
            ->assertSee($box->name);
    }

    private function model(): VehicleModel
    {
        return VehicleModel::query()->whereHas('make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->where('slug', 'vesta')
            ->firstOrFail();
    }

    private function product(string $name, string $slug): Product
    {
        return Product::query()->create([
            'name' => $name,
            'slug' => $slug,
            'price' => 1000,
            'stock' => 1,
            'is_active' => true,
        ]);
    }
}
