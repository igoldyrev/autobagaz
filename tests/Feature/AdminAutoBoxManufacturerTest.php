<?php

namespace Tests\Feature;

use App\Models\AutoBoxManufacturer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAutoBoxManufacturerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_manufacturer_directory_is_protected(): void
    {
        $this->get(route('admin.products.auto-boxes.manufacturers.index'))
            ->assertRedirect(route('login'));
    }

    public function test_administrator_can_create_and_update_auto_box_manufacturer(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.products.auto-boxes.manufacturers.store'), [
            'name' => '  Terra Drive  ',
            'is_active' => '1',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $manufacturer = AutoBoxManufacturer::query()->where('name', 'Terra Drive')->firstOrFail();
        $response->assertRedirect(route('admin.products.auto-boxes.manufacturers.edit', $manufacturer));
        $this->assertTrue($manufacturer->is_active);

        $this->actingAs($admin)->put(route('admin.products.auto-boxes.manufacturers.update', $manufacturer), [
            'name' => 'Terra Drive Ukraine',
        ])->assertRedirect();

        $this->assertSame('Terra Drive Ukraine', $manufacturer->fresh()->name);
        $this->assertFalse($manufacturer->fresh()->is_active);
    }

    public function test_manufacturer_name_must_be_unique(): void
    {
        AutoBoxManufacturer::query()->create(['name' => 'Koffer']);
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.products.auto-boxes.manufacturers.store'), [
            'name' => 'Koffer',
            'is_active' => '1',
        ])->assertSessionHasErrors('name');
    }

    public function test_hiding_manufacturer_preserves_product_link_and_directory_shows_count(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $manufacturer = AutoBoxManufacturer::query()->create(['name' => 'Lux']);
        $product = Product::query()->create([
            'name' => 'Автобокс Lux',
            'slug' => 'lux-auto-box',
            'price' => 15000,
        ]);
        $product->autoBox()->create(['manufacturer_id' => $manufacturer->id]);
        $manufacturer->update(['is_active' => false]);

        $this->assertSame($manufacturer->id, $product->autoBox->fresh()->manufacturer_id);
        $this->assertSame('Lux', $product->autoBox->fresh()->manufacturer->name);

        $this->actingAs($admin)
            ->get(route('admin.products.auto-boxes.manufacturers.index'))
            ->assertOk()
            ->assertSee('Производители')
            ->assertSee('Lux')
            ->assertSee(route('admin.products.auto-boxes.manufacturers.create'))
            ->assertSeeInOrder(['Lux', '1', 'Скрыт']);
    }
}
