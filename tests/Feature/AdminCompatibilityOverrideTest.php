<?php

namespace Tests\Feature;

use App\Models\CompatibilityOverride;
use App\Models\Product;
use App\Models\User;
use App\Models\VehicleMake;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCompatibilityOverrideTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_create_override_and_see_it_in_explained_preview(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $make = VehicleMake::query()->create(['name' => 'Override Test', 'slug' => 'override-test', 'is_active' => true]);
        $model = $make->models()->create(['name' => 'Model', 'slug' => 'model', 'is_active' => true]);
        $generation = $model->generations()->create(['name' => 'Generation', 'slug' => 'generation', 'is_active' => true]);
        $configuration = $generation->configurations()->create(['display_name' => 'Configuration', 'verification_status' => 'verified', 'is_active' => true]);
        $base = Product::query()->create(['name' => 'Override Base', 'slug' => 'override-base', 'price' => 1000, 'stock' => 1, 'is_active' => true]);
        $base->roofRack()->create();

        $this->actingAs($admin)->get(route('admin.compatibility-overrides.index'))
            ->assertOk()
            ->assertSee('Когда нужны ручные исключения')
            ->assertSee('Фильтр ниже показывает исключения только с выбранным принудительным результатом');
        $this->actingAs($admin)->get(route('admin.compatibility-overrides.create'))
            ->assertOk()
            ->assertSee('Как задать область действия')
            ->assertSee('Базовый багажник обязателен');

        $this->actingAs($admin)->post(route('admin.compatibility-overrides.store'), [
            'vehicle_configuration_id' => $configuration->id,
            'base_product_id' => $base->id,
            'status' => 'compatible',
            'reason' => 'Подтверждено установкой.',
            'priority' => 10,
            'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $override = CompatibilityOverride::query()->firstOrFail();
        $this->actingAs($admin)->get(route('admin.compatibility.preview', [
            'vehicle_configuration_id' => $configuration->id,
            'product_id' => $base->id,
        ]))
            ->assertOk()
            ->assertSee('Как пользоваться проверкой')
            ->assertSee('Базовый багажник необязателен и нужен только для проверки конкретной пары')
            ->assertSee('Результат: Совместимо')
            ->assertSee('обязательные условия установки выполнены')
            ->assertSee('Объяснение проверки')
            ->assertDontSee('Результат: compatible')
            ->assertSee('Подтверждено установкой.');
        $this->assertSame($admin->id, $override->created_by);
    }
}
