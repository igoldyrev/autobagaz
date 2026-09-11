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
            ->assertSee('Как работают группы применяемости')
            ->assertSee('Поиск ниже фильтрует список только по названию или стабильному коду группы')
            ->assertDontSee('Все статусы проверки')
            ->assertDontSee('>Проверка<', false)
            ->assertDontSee('>Fitments<', false);
        $this->actingAs($admin)->get(route('admin.fitments.edit', $fitment))
            ->assertOk()
            ->assertSee('Статус проверки')
            ->assertSee('Требует проверки')
            ->assertSee('Группа применяемости активна')
            ->assertSee('Как заполнить группу')
            ->assertSee('Каждый из них будет считаться подходящим ко всем автомобилям группы')
            ->assertSee('Настроить автомобили')
            ->assertSee('Добавлено конфигураций: 0')
            ->assertSee('Открыть предпросмотр')
            ->assertSee('fitment-form-action--vehicles', false)
            ->assertSee('fitment-form-action--preview', false);

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
            ->assertSee('Как выбрать автомобили')
            ->assertSee('Фильтры применяются одновременно')
            ->assertSee('Параметры сохраняются только для уже добавленных в группу автомобилей')
            ->assertSee('placeholder="Поиск по названию конфигурации"', false);
        $this->actingAs($admin)->get(route('admin.fitments.preview', $fitment))
            ->assertOk()
            ->assertSee('1 конфигураций × 1 товаров')
            ->assertSee($product->name)
            ->assertSee($generation->display_name)
            ->assertSee($generation->name)
            ->assertSee('Что показывает предпросмотр')
            ->assertSee('Каждый показанный товар считается совместимым с каждым показанным автомобилем')
            ->assertSee('fitment-preview-table', false)
            ->assertDontSee('>Проверка<', false);

        $this->actingAs($admin)->delete(route('admin.fitments.destroy', $fitment))->assertSessionHas('error');

        $this->actingAs($admin)->post(route('admin.fitments.configurations.update', $fitment), [
            'action' => 'remove', 'configuration_ids' => [$configuration->id],
        ])->assertSessionDoesntHaveErrors();
        $this->assertFalse($fitment->configurations()->whereKey($configuration->id)->exists());
    }

    public function test_administrator_can_copy_fitment_with_configurations_and_parameters(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        [, , , $configuration] = $this->configuration();
        $fitment = Fitment::query()->create([
            'code' => 'ORIGINAL-FITMENT',
            'name' => 'Исходная группа',
            'source' => 'supplier',
            'source_reference' => 'original-fitment',
            'verification_status' => 'verified',
            'is_active' => true,
        ]);
        $fitment->configurations()->attach($configuration, [
            'crossbar_spacing_min_mm' => 550,
            'crossbar_spacing_max_mm' => 900,
            'max_dynamic_load_kg' => 75,
        ]);

        $this->actingAs($admin)->post(route('admin.fitments.copy', $fitment))
            ->assertRedirect();

        $copy = Fitment::query()->where('code', 'ORIGINAL-FITMENT-COPY')->firstOrFail();
        $this->assertSame('Исходная группа (копия)', $copy->name);
        $this->assertNull($copy->verified_at);
        $this->assertSame('draft', $copy->verification_status);
        $this->assertNull($copy->source);
        $this->assertNull($copy->source_reference);
        $this->assertTrue($copy->configurations()->whereKey($configuration->id)->exists());
        $pivot = $copy->configurations()->whereKey($configuration->id)->firstOrFail()->pivot;
        $this->assertSame(550, $pivot->crossbar_spacing_min_mm);
        $this->assertSame(900, $pivot->crossbar_spacing_max_mm);
        $this->assertEquals(75, $pivot->max_dynamic_load_kg);

        $this->actingAs($admin)->get(route('admin.fitments.edit', $fitment))
            ->assertOk()
            ->assertSee('Копировать группу')
            ->assertSee('Будут скопированы автомобили и их монтажные параметры');
    }

    public function test_administrator_can_save_fitment_without_products(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $fitment = Fitment::query()->create([
            'code' => 'EMPTY-FITMENT',
            'name' => 'Группа без товаров',
            'verification_status' => 'draft',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->put(route('admin.fitments.update', $fitment), [
            'code' => $fitment->code,
            'name' => $fitment->name,
            'verification_status' => 'draft',
            'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $this->assertFalse($fitment->fresh()->products()->exists());

        $this->actingAs($admin)->post(route('admin.fitments.store'), [
            'code' => 'NEW-EMPTY-FITMENT',
            'name' => 'Новая группа без товаров',
            'verification_status' => 'draft',
            'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('fitments', ['code' => 'NEW-EMPTY-FITMENT']);
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
