<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VehicleBodyStyle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleRoofType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVehicleConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_manage_vehicle_configuration_directory(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        [$make, $model] = $this->vehicle();

        $this->actingAs($admin)->post(route('admin.vehicles.vehicle-body-styles.store'), [
            'name' => 'Тестовый кроссовер конфигурации', 'slug' => '', 'sort_order' => 1, 'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();
        $bodyStyle = VehicleBodyStyle::query()->where('slug', 'testovyi-krossover-konfiguracii')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.vehicles.vehicle-roof-types.store'), [
            'name' => 'Тестовые интегрированные рейлинги', 'slug' => '', 'sort_order' => 1, 'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();
        $roofType = VehicleRoofType::query()->where('slug', 'testovye-integrirovannye-reilingi')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.vehicles.vehicle-generations.store', [$make, $model]), [
            'name' => 'V поколение', 'slug' => '', 'year_from' => 2021, 'year_to' => 2025,
            'sort_order' => 1, 'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();
        $generation = VehicleGeneration::query()->where('vehicle_model_id', $model->id)->firstOrFail();

        $this->actingAs($admin)->post(route('admin.vehicles.vehicle-configurations.store', [$make, $model, $generation]), [
            'display_name' => 'Кроссовер, интегрированные рейлинги',
            'vehicle_body_style_id' => $bodyStyle->id,
            'vehicle_roof_type_id' => $roofType->id,
            'year_from' => 2021, 'year_to' => 2025, 'doors_count' => 5,
            'verification_status' => 'verified', 'sort_order' => 1, 'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $configuration = VehicleConfiguration::query()
            ->where('vehicle_generation_id', $generation->id)
            ->firstOrFail();
        $this->assertSame($generation->id, $configuration->vehicle_generation_id);
        $this->assertSame($bodyStyle->id, $configuration->vehicle_body_style_id);
        $this->assertSame($roofType->id, $configuration->vehicle_roof_type_id);

        $this->actingAs($admin)->get(route('admin.vehicles.vehicle-body-styles.index'))->assertOk()->assertSee('Тестовый кроссовер конфигурации');
        $this->actingAs($admin)->get(route('admin.vehicles.vehicle-body-styles.edit', $bodyStyle))->assertOk();
        $this->actingAs($admin)->get(route('admin.vehicles.vehicle-roof-types.index'))->assertOk()->assertSee('Тестовые интегрированные рейлинги');
        $this->actingAs($admin)->get(route('admin.vehicles.vehicle-generations.index', [$make, $model]))
            ->assertOk()
            ->assertSee('V поколение')
            ->assertDontSee('Проверка');
        $this->actingAs($admin)->get(route('admin.vehicles.vehicle-generations.edit', [$make, $model, $generation]))
            ->assertOk()
            ->assertDontSee('name="verification_status"', false);

        $this->actingAs($admin)
            ->get(route('admin.vehicles.vehicle-configurations.index', [$make, $model, $generation]))
            ->assertOk()->assertSee('Кроссовер, интегрированные рейлинги');
        $this->actingAs($admin)
            ->get(route('admin.vehicles.vehicle-configurations.edit', [$make, $model, $generation, $configuration]))
            ->assertOk();

        $this->actingAs($admin)
            ->delete(route('admin.vehicles.vehicle-body-styles.destroy', $bodyStyle))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('vehicle_body_styles', ['id' => $bodyStyle->id]);
    }

    public function test_nested_vehicle_resources_reject_models_from_another_make(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        [$make] = $this->vehicle();
        [, $otherModel] = $this->vehicle('Test Hyundai Configurations', 'Test Tucson Configurations');

        $this->actingAs($admin)
            ->get(route('admin.vehicles.vehicle-generations.index', [$make, $otherModel]))
            ->assertNotFound();
    }

    private function vehicle(string $makeName = 'Test Kia Configurations', string $modelName = 'Test Sportage Configurations'): array
    {
        $make = VehicleMake::query()->create([
            'name' => $makeName, 'slug' => str($makeName)->slug(), 'is_active' => true,
        ]);
        $model = $make->models()->create([
            'name' => $modelName, 'slug' => str($modelName)->slug(), 'is_active' => true,
        ]);

        return [$make, $model];
    }
}
