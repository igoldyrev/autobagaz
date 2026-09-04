<?php

namespace Tests\Feature;

use App\Models\AutoBoxManufacturer;
use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoBoxTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_previous_auto_box_address_shows_paginated_published_products(): void
    {
        $section = CatalogCategory::query()->where('slug', 'autobox')->firstOrFail();

        foreach (range(1, 13) as $number) {
            $product = Product::query()->create([
                'name' => sprintf('Автобокс %02d', $number),
                'slug' => 'autobox-'.$number,
                'price' => 10000 + $number,
                'stock' => 1,
                'is_active' => true,
            ]);
            $product->autoBox()->create(['volume_l' => 400]);
            $product->categories()->attach($section);
        }

        $hidden = Product::query()->create([
            'name' => 'Скрытый автобокс',
            'slug' => 'hidden-auto-box',
            'price' => 9000,
            'is_active' => false,
        ]);
        $hidden->autoBox()->create();
        $hidden->categories()->attach($section);

        $this->get('/autobox')
            ->assertOk()
            ->assertSee('Автомобильные боксы')
            ->assertSee('Найдено товаров: 13')
            ->assertSee('Автобокс 01')
            ->assertDontSee('Автобокс 13')
            ->assertDontSee('Скрытый автобокс')
            ->assertSee('Каким бы просторным ни был автомобиль')
            ->assertSee('Автобоксы являются простым и надежным средством')
            ->assertSeeInOrder(['Автобокс 01', 'Каким бы просторным ни был автомобиль'])
            ->assertSee('/autobox?page=2', escape: false);

        $this->get('/autobox?page=2')
            ->assertOk()
            ->assertSee('Автобокс 13')
            ->assertDontSee('Автобокс 01');
    }

    public function test_auto_boxes_can_be_filtered_by_common_and_specific_properties(): void
    {
        $section = CatalogCategory::query()->where('slug', 'autobox')->firstOrFail();
        $terraDrive = AutoBoxManufacturer::query()->create(['name' => 'Terra Drive']);
        $koffer = AutoBoxManufacturer::query()->create(['name' => 'Koffer']);

        $matching = Product::query()->create([
            'name' => 'Подходящий автобокс',
            'slug' => 'matching-auto-box',
            'price' => 28500,
            'stock' => 2,
            'is_active' => true,
        ]);
        $matching->autoBox()->create([
            'manufacturer_id' => $terraDrive->id,
            'length_cm' => 196,
            'width_cm' => 78,
            'height_cm' => 43,
            'volume_l' => 480,
            'load_capacity_kg' => 70,
            'opening_type' => 'Двухстороннее',
            'mounting_type' => 'U-скоба',
            'box_color' => 'Черный карбон',
        ]);
        $matching->categories()->attach($section);

        $other = Product::query()->create([
            'name' => 'Другой автобокс',
            'slug' => 'other-auto-box',
            'price' => 19000,
            'stock' => 0,
            'is_active' => true,
        ]);
        $other->autoBox()->create([
            'manufacturer_id' => $koffer->id,
            'length_cm' => 175,
            'width_cm' => 80,
            'height_cm' => 40,
            'volume_l' => 430,
            'load_capacity_kg' => 50,
            'opening_type' => 'Одностороннее',
            'mounting_type' => 'Быстросъем',
            'box_color' => 'Белый глянец',
        ]);
        $other->categories()->attach($section);

        $this->get(route('catalog.auto-boxes.index'))
            ->assertOk()
            ->assertSee('Фильтры товаров')
            ->assertSee('catalog-filters--horizontal', escape: false)
            ->assertSee('Производитель')
            ->assertSee('Цена, ₽')
            ->assertSee('В наличии')
            ->assertSee('Под заказ')
            ->assertSee('Длина, см')
            ->assertSee('Ширина, см')
            ->assertSee('Высота, см')
            ->assertSee('Объём, л')
            ->assertSee('Грузоподъёмность, кг')
            ->assertSee('Тип открывания')
            ->assertSee('Тип крепления')
            ->assertSee('Цвет')
            ->assertSee($matching->name)
            ->assertSee($other->name);

        $this->get(route('catalog.auto-boxes.index', [
            'manufacturer' => [(string) $terraDrive->id],
            'price_from' => 28000,
            'price_to' => 29000,
            'availability' => ['in_stock'],
            'length' => ['196.0'],
            'width' => ['78.0'],
            'height' => ['43.0'],
            'volume' => ['480.0'],
            'load_capacity' => ['70.0'],
            'opening_type' => ['Двухстороннее'],
            'mounting_type' => ['U-скоба'],
            'box_color' => ['Черный карбон'],
        ]))
            ->assertOk()
            ->assertSee($matching->name)
            ->assertDontSee($other->name)
            ->assertSee('Найдено товаров: 1');

        $this->get(route('catalog.auto-boxes.index', ['availability' => ['to_order']]))
            ->assertOk()
            ->assertSee($other->name)
            ->assertDontSee($matching->name);
    }

    public function test_administrator_can_create_and_edit_auto_box(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $manufacturer = AutoBoxManufacturer::query()->create(['name' => 'Terra Drive']);

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee(route('admin.products.auto-boxes.index'));

        $this->actingAs($admin)
            ->get(route('admin.products.auto-boxes.create'))
            ->assertOk()
            ->assertSee('name="opening_type"', escape: false)
            ->assertSee('<option value="Одностороннее"', escape: false)
            ->assertSee('<option value="Двухстороннее"', escape: false)
            ->assertSee('name="mounting_type"', escape: false)
            ->assertSee('<option value="U-скоба"', escape: false)
            ->assertSee('<option value="Быстросъем"', escape: false)
            ->assertSee('<option value="Лапа быстросъем"', escape: false)
            ->assertSee('name="box_color"', escape: false)
            ->assertSee('<option value="Белый глянец"', escape: false)
            ->assertSee('<option value="Белый карбон"', escape: false)
            ->assertSee('<option value="Белый матовый"', escape: false)
            ->assertSee('<option value="Серый глянец"', escape: false)
            ->assertSee('<option value="Серый карбон"', escape: false)
            ->assertSee('<option value="Серый матовый"', escape: false)
            ->assertSee('<option value="Черный глянец"', escape: false)
            ->assertSee('<option value="Черный карбон"', escape: false)
            ->assertSee('<option value="Черный матовый"', escape: false)
            ->assertSee('Это допустимые параметры багажника, на который можно установить автобокс')
            ->assertSee('Минимальная внешняя ширина дуги, которую может обхватить крепление')
            ->assertSee('Минимальное расстояние между центрами передней и задней дуг')
            ->assertSee('Для крепления без T-паза оставьте поле пустым')
            ->assertSee('name="manufacturer_id"', escape: false)
            ->assertSee('Terra Drive')
            ->assertDontSee('name="manufacturer"', escape: false)
            ->assertSee(route('admin.products.auto-boxes.manufacturers.index'));

        $response = $this->actingAs($admin)->post(route('admin.products.auto-boxes.store'), [
            'name' => 'Terra Drive 480',
            'slug' => '',
            'price' => '28500.00',
            'manufacturer_id' => $manufacturer->id,
            'country_of_origin' => 'Украина',
            'product_model' => '480',
            'length_cm' => 196,
            'width_cm' => 78,
            'height_cm' => 43,
            'volume_l' => 480,
            'load_capacity_kg' => 70,
            'opening_type' => 'Двухстороннее',
            'mounting_type' => 'U-скоба',
            'box_color' => 'Черный карбон',
            'stock' => 2,
            'is_active' => '1',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $product = Product::query()->where('slug', 'terra-drive-480')->firstOrFail();
        $response->assertRedirect(route('admin.products.auto-boxes.edit', $product));
        $this->assertSame('196.0', $product->autoBox->length_cm);
        $this->assertSame('78.0', $product->autoBox->width_cm);
        $this->assertSame('43.0', $product->autoBox->height_cm);
        $this->assertSame('480.0', $product->autoBox->volume_l);
        $this->assertSame($manufacturer->id, $product->autoBox->manufacturer_id);
        $this->assertSame('Terra Drive', $product->autoBox->manufacturer->name);
        $this->assertNull($product->manufacturer);
        $this->assertTrue($product->categories()->where('slug', 'autobox')->exists());
        $this->assertFalse($product->roofRack()->exists());

        $this->get('/autobox')->assertOk()->assertSee('Terra Drive 480');
        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Характеристики автомобильного бокса')
            ->assertSee('Длина, см')
            ->assertSee('Ширина, см')
            ->assertSee('Высота, см')
            ->assertSee('Двухстороннее')
            ->assertSee('U-скоба')
            ->assertSee('Черный карбон');
    }

    public function test_auto_box_rejects_unknown_select_values(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.products.auto-boxes.store'), [
            'name' => 'Автобокс с неизвестным креплением',
            'slug' => '',
            'price' => 10000,
            'stock' => 1,
            'mounting_type' => 'Самодельное крепление',
            'box_color' => 'Розовый',
        ])->assertSessionHasErrors(['mounting_type', 'box_color']);
    }

    public function test_auto_box_shows_mounting_range_validation_in_russian(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.products.auto-boxes.store'), [
            'name' => 'Автобокс с неверным диапазоном',
            'slug' => '',
            'price' => 10000,
            'stock' => 1,
            'clamp_width_min_mm' => 120,
            'clamp_width_max_mm' => 100,
        ])->assertSessionHasErrors([
            'clamp_width_max_mm' => 'Значение поля «Ширина дуги до, мм» должно быть не меньше 120.',
        ]);
    }
}
