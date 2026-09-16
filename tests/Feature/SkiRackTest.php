<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\SkiRackManufacturer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkiRackTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_ski_racks_are_listed_and_filtered(): void
    {
        $manufacturer = SkiRackManufacturer::query()->create(['name' => 'Thule']);
        $match = Product::query()->create(['product_type_id' => ProductType::query()->where('code', 'ski_rack')->value('id'), 'name' => 'Крепление Thule', 'slug' => 'ski-thule', 'price' => 10000, 'stock' => 1, 'is_active' => true]);
        $match->skiRack()->create(['manufacturer_id' => $manufacturer->id, 'ski_pairs_capacity' => 4, 'snowboard_capacity' => 2]);
        $other = Product::query()->create(['product_type_id' => ProductType::query()->where('code', 'ski_rack')->value('id'), 'name' => 'Крепление другое', 'slug' => 'ski-other', 'price' => 20000, 'stock' => 0, 'is_active' => true]);
        $other->skiRack()->create(['ski_pairs_capacity' => 6]);
        $this->get(route('catalog.ski-racks.index', ['manufacturer' => [(string) $manufacturer->id], 'ski_pairs' => ['4']]))->assertOk()->assertSee('Фильтры товаров')->assertSee($match->name)->assertDontSee($other->name);

        $this->get(route('products.show', $match))
            ->assertOk()
            ->assertSee('Требуется багажник на крышу')
            ->assertSee('Этот товар устанавливается на поперечины багажника.')
            ->assertSee('Нет поперечин? Подберите багажник для вашего автомобиля.')
            ->assertSee(route('catalog.vehicle-fitment.index', ['redirect_to' => 'roof-racks']));
    }
}
