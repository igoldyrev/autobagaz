<?php

namespace Tests\Feature;

use App\Models\Fitment;
use App\Models\Product;
use App\Models\User;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFitmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_manage_fitment_configurations_and_preview(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::query()->create([
            'name' => 'Test Fitment Roof Rack', 'slug' => 'test-fitment-roof-rack',
            'price' => 5000, 'stock' => 1, 'is_active' => true,
        ]);
        $product->roofRack()->create();
        [$make, $model, $generation, $configuration] = $this->configuration();

        $this->actingAs($admin)->post(route('admin.fitments.store'), [
            'code' => 'TEST-RAILS-120', 'name' => 'Test Rails 120',
            'verification_status' => 'draft', 'product_ids' => [$product->id], 'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $fitment = Fitment::query()->where('code', 'TEST-RAILS-120')->firstOrFail();
        $this->assertTrue($fitment->products()->whereKey($product->id)->exists());

        $this->actingAs($admin)->get(route('admin.fitments.index'))
            ->assertOk()
            ->assertSee('Группы применяемости')
            ->assertSee('admin-shortcuts__link', false)
            ->assertSee('Проверить совместимость')
            ->assertSee('Ручные исключения')
            ->assertDontSee('Все статусы проверки')
            ->assertDontSee('>Проверка<', false)
            ->assertDontSee('>Fitments<', false);
        $this->actingAs($admin)->get(route('admin.fitments.edit', $fitment))
            ->assertOk()
            ->assertSee('Статус проверки')
            ->assertSee('Требует проверки')
            ->assertSee('Группа применяемости активна');

        $this->actingAs($admin)->post(route('admin.fitments.configurations.update', $fitment), [
            'action' => 'add', 'configuration_ids' => [$configuration->id],
        ])->assertSessionDoesntHaveErrors();
        $this->assertTrue($fitment->configurations()->whereKey($configuration->id)->exists());

        $this->actingAs($admin)->post(route('admin.fitments.configurations.update', $fitment), [
            'action' => 'save_parameters',
            'configuration_ids' => [$configuration->id],
            'parameters' => [$configuration->id => [
                'crossbar_spacing_min_mm' => 550,
                'crossbar_spacing_max_mm' => 900,
                'max_dynamic_load_kg' => 75,
            ]],
        ])->assertSessionDoesntHaveErrors();
        $pivot = $fitment->configurations()->whereKey($configuration->id)->firstOrFail()->pivot;
        $this->assertSame(550, $pivot->crossbar_spacing_min_mm);
        $this->assertSame(900, $pivot->crossbar_spacing_max_mm);

        $this->actingAs($admin)
            ->get(route('admin.fitments.configurations', [$fitment, 'make_id' => $make->id, 'model_id' => $model->id]))
            ->assertOk()
            ->assertSee($configuration->display_name)
            ->assertSee('placeholder="Поиск по названию конфигурации"', false);
        $this->actingAs($admin)->get(route('admin.fitments.preview', $fitment))
            ->assertOk()
            ->assertSee('1 конфигураций × 1 товаров')
            ->assertSee($product->name)
            ->assertSee($generation->display_name)
            ->assertSee($generation->name);

        $this->actingAs($admin)->delete(route('admin.fitments.destroy', $fitment))->assertSessionHas('error');

        $this->actingAs($admin)->post(route('admin.fitments.configurations.update', $fitment), [
            'action' => 'remove', 'configuration_ids' => [$configuration->id],
        ])->assertSessionDoesntHaveErrors();
        $this->assertFalse($fitment->configurations()->whereKey($configuration->id)->exists());
    }

    /** @return array{VehicleMake, VehicleModel, VehicleGeneration, VehicleConfiguration} */
    private function configuration(): array
    {
        $make = VehicleMake::query()->create(['name' => 'Fitment Test Make', 'slug' => 'fitment-test-make', 'is_active' => true]);
        $model = $make->models()->create(['name' => 'Fitment Test Model', 'slug' => 'fitment-test-model', 'is_active' => true]);
        $generation = $model->generations()->create([
            'name' => 'Test Generation', 'slug' => 'test-generation', 'year_from' => 2020,
            'is_active' => true,
        ]);
        $configuration = $generation->configurations()->create([
            'display_name' => 'Test configuration with rails', 'year_from' => 2020,
            'verification_status' => 'verified', 'is_active' => true,
        ]);

        return [$make, $model, $generation, $configuration];
    }
}
