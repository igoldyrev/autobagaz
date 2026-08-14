<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\RoofRackManufacturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoofRackManufacturerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_manufacturer_directory_is_protected(): void
    {
        $this->get(route('admin.products.roof-racks.manufacturers.index'))
            ->assertRedirect(route('login'));
    }

    public function test_administrator_can_create_and_update_roof_rack_manufacturer(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.products.roof-racks.manufacturers.store'), [
            'name' => '  Thule  ',
            'is_active' => '1',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $manufacturer = RoofRackManufacturer::query()->where('name', 'Thule')->firstOrFail();
        $response->assertRedirect(route('admin.products.roof-racks.manufacturers.edit', $manufacturer));
        $this->assertTrue($manufacturer->is_active);

        $this->actingAs($admin)->put(route('admin.products.roof-racks.manufacturers.update', $manufacturer), [
            'name' => 'Thule Group',
        ])->assertRedirect();

        $this->assertSame('Thule Group', $manufacturer->fresh()->name);
        $this->assertFalse($manufacturer->fresh()->is_active);
    }

    public function test_manufacturer_name_must_be_unique(): void
    {
        RoofRackManufacturer::query()->create(['name' => 'Amos']);
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.products.roof-racks.manufacturers.store'), [
            'name' => 'Amos',
            'is_active' => '1',
        ])->assertSessionHasErrors('name');
    }

    public function test_hiding_manufacturer_preserves_product_link(): void
    {
        $manufacturer = RoofRackManufacturer::query()->create(['name' => 'Inter']);
        $product = Product::query()->create([
            'name' => 'Автобагажник',
            'slug' => 'roof-rack-with-manufacturer',
            'price' => 1000,
        ]);
        $product->roofRack()->create(['manufacturer_id' => $manufacturer->id]);
        $manufacturer->update(['is_active' => false]);

        $this->assertSame($manufacturer->id, $product->roofRack->fresh()->manufacturer_id);
        $this->assertSame('Inter', $product->roofRack->fresh()->manufacturer->name);
    }

    public function test_directory_lists_manufacturers_and_product_counts(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $manufacturer = RoofRackManufacturer::query()->create(['name' => 'Lux']);
        $product = Product::query()->create([
            'name' => 'Автобагажник Lux',
            'slug' => 'lux-rack',
            'price' => 5000,
        ]);
        $product->roofRack()->create(['manufacturer_id' => $manufacturer->id]);

        $this->actingAs($admin)
            ->get(route('admin.products.roof-racks.manufacturers.index'))
            ->assertOk()
            ->assertSee('Производители')
            ->assertSee('Lux')
            ->assertSee(route('admin.products.roof-racks.manufacturers.create'))
            ->assertSeeInOrder(['Lux', '1', 'Активен']);
    }
}
