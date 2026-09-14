<?php

namespace Tests\Feature;

use App\Models\BikeRackManufacturer;
use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BikeRackTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_administrator_can_create_bike_rack_and_it_is_shown_in_catalog(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $manufacturer = BikeRackManufacturer::query()->create(['name' => 'Thule']);

        $response = $this->actingAs($admin)->post(route('admin.products.bike-racks.store'), [
            'name' => 'Велокрепление на фаркоп',
            'slug' => '',
            'price' => 24990,
            'stock' => 2,
            'manufacturer_id' => $manufacturer->id,
            'mounting_type' => 'На фаркоп',
            'bike_capacity' => 3,
            'load_capacity_kg' => 60,
            'is_active' => '1',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $product = Product::query()->where('slug', 'velokreplenie-na-farkop')->firstOrFail();
        $response->assertRedirect(route('admin.products.bike-racks.edit', $product));
        $this->assertTrue($product->bikeRack()->exists());
        $this->assertSame($manufacturer->id, $product->bikeRack->manufacturer_id);
        $this->assertSame('universal', $product->productType->compatibility_strategy);
        $this->assertTrue($product->categories()->where('slug', 'velokrepleniya')->exists());

        $this->get(route('catalog.bike-racks.index'))
            ->assertOk()
            ->assertSee('Фильтры товаров')
            ->assertSee($product->name);
        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Характеристики велокрепления')
            ->assertSee('Thule')
            ->assertSee('На фаркоп')
            ->assertSee('Вместимость, велосипедов');
    }

    public function test_bike_rack_type_and_section_are_available(): void
    {
        $this->assertSame('universal', ProductType::query()->where('code', 'bike_rack')->value('compatibility_strategy'));
        $this->assertTrue(CatalogCategory::query()->where('slug', 'velokrepleniya')->exists());
    }

    public function test_bike_racks_can_be_filtered_by_common_and_specific_properties(): void
    {
        $manufacturer = BikeRackManufacturer::query()->create(['name' => 'Thule']);
        $matching = $this->bikeRack('Велокрепление на крышу', 'bike-rack-roof', $manufacturer->id, 'На крышу', 1, 20, 15000, 1);
        $other = $this->bikeRack('Велокрепление на фаркоп', 'bike-rack-hitch', null, 'На фаркоп', 3, 60, 28000, 0);

        $this->get(route('catalog.bike-racks.index', [
            'manufacturer' => [(string) $manufacturer->id],
            'price_from' => 14000,
            'price_to' => 16000,
            'availability' => ['in_stock'],
            'mounting_type' => ['На крышу'],
            'bike_capacity' => ['1'],
            'load_capacity' => ['20'],
        ]))
            ->assertOk()
            ->assertSee($matching->name)
            ->assertDontSee($other->name)
            ->assertSee('Найдено товаров: 1');
    }

    public function test_administrator_can_manage_bike_rack_manufacturers(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.products.bike-racks.manufacturers.store'), [
            'name' => 'Atera',
            'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $this->actingAs($admin)->get(route('admin.products.bike-racks.manufacturers.index'))
            ->assertOk()
            ->assertSee('Atera');
    }

    private function bikeRack(string $name, string $slug, ?int $manufacturerId, string $mountingType, int $bikeCapacity, int $loadCapacity, int $price, int $stock): Product
    {
        $product = Product::query()->create([
            'product_type_id' => ProductType::query()->where('code', 'bike_rack')->value('id'),
            'name' => $name,
            'slug' => $slug,
            'price' => $price,
            'stock' => $stock,
            'is_active' => true,
        ]);
        $product->bikeRack()->create([
            'manufacturer_id' => $manufacturerId,
            'mounting_type' => $mountingType,
            'bike_capacity' => $bikeCapacity,
            'load_capacity_kg' => $loadCapacity,
        ]);

        return $product;
    }
}
