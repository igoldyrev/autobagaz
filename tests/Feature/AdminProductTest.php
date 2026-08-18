<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\RoofRackManufacturer;
use App\Models\User;
use App\Models\VehicleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_product_admin_is_protected(): void
    {
        $this->get(route('admin.products.index'))->assertRedirect(route('login'));
        $this->get(route('admin.products.roof-racks.index'))->assertRedirect(route('login'));
    }

    public function test_product_admin_is_split_into_product_type_sections(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Типы товаров')
            ->assertSee('Автобагажники')
            ->assertSee('Автомобильные боксы')
            ->assertSee(route('admin.products.roof-racks.index'));

        $this->actingAs($admin)
            ->get(route('admin.products.roof-racks.index'))
            ->assertOk()
            ->assertSee('Список содержит только автобагажники')
            ->assertSee(route('admin.products.roof-racks.create'));
    }

    public function test_roof_rack_form_has_search_fields_for_categories_and_vehicle_models(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $manufacturer = RoofRackManufacturer::query()->create(['name' => 'Thule']);
        $product = Product::query()->create([
            'name' => 'Товар для редактирования',
            'slug' => 'searchable-product-form',
            'price' => 1000,
        ]);
        $product->roofRack()->create(['manufacturer_id' => $manufacturer->id]);

        $this->actingAs($admin)
            ->get(route('admin.products.roof-racks.edit', $product))
            ->assertOk()
            ->assertSee('data-select-search="category_ids"', escape: false)
            ->assertSee('placeholder="Найти категорию"', escape: false)
            ->assertSee('data-select-search="vehicle_model_ids"', escape: false)
            ->assertSee('placeholder="Найти марку или модель"', escape: false)
            ->assertSee('name="manufacturer_id"', escape: false)
            ->assertSee('<option', escape: false)
            ->assertSee('Thule')
            ->assertDontSee('name="manufacturer"', escape: false)
            ->assertSee(route('admin.products.roof-racks.manufacturers.index'))
            ->assertSee('/js/searchable-select.js', escape: false);
    }

    public function test_administrator_can_create_product_with_multiple_categories_models_and_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $roofRackSection = CatalogCategory::query()->where('slug', 'autobagazhniki')->firstOrFail();
        $categories = CatalogCategory::query()
            ->whereKey($roofRackSection->id)
            ->orWhere('parent_id', $roofRackSection->id)
            ->limit(2)
            ->pluck('id')
            ->all();
        $models = VehicleModel::query()->limit(3)->pluck('id')->all();
        $manufacturer = RoofRackManufacturer::query()->create(['name' => 'Inter']);

        $response = $this->actingAs($admin)->post(route('admin.products.roof-racks.store'), [
            'name' => 'Багажник тестовый',
            'slug' => '',
            'price' => '15990.50',
            'manufacturer_id' => $manufacturer->id,
            'country_of_origin' => 'Россия',
            'product_model' => '5517+1002',
            'bar_length_cm' => '120',
            'load_capacity_kg' => '75',
            'installation_method' => 'На интегрированные рейлинги',
            'bar_type' => 'Прямоугольная',
            'rack_color' => 'Чёрный',
            'description' => 'Описание товара',
            'stock' => 12,
            'is_active' => '1',
            'category_ids' => $categories,
            'vehicle_model_ids' => $models,
            'images' => [$this->fakePng('first.png'), $this->fakePng('second.png')],
        ]);

        $response->assertSessionDoesntHaveErrors();
        $product = Product::query()->where('slug', 'bagaznik-testovyi')->firstOrFail();

        $response->assertRedirect(route('admin.products.roof-racks.edit', $product));
        $this->assertSame('15990.50', $product->price);
        $this->assertNull($product->manufacturer);
        $this->assertSame($manufacturer->id, $product->roofRack->manufacturer_id);
        $this->assertSame('Inter', $product->roofRack->manufacturer->name);
        $this->assertSame('Россия', $product->country_of_origin);
        $this->assertSame('5517+1002', $product->product_model);
        $this->assertSame('120.0', $product->roofRack->bar_length_cm);
        $this->assertSame('75.0', $product->roofRack->load_capacity_kg);
        $this->assertSame('На интегрированные рейлинги', $product->roofRack->installation_method);
        $this->assertSame('Прямоугольная', $product->roofRack->bar_type);
        $this->assertSame('Чёрный', $product->roofRack->rack_color);
        $this->assertDatabaseHas('roof_rack_products', ['product_id' => $product->id]);
        $this->assertTrue($product->categories()->where('slug', 'autobagazhniki')->exists());
        $this->assertSame(12, $product->stock);
        $this->assertTrue($product->is_active);
        $this->assertEqualsCanonicalizing($categories, $product->categories()->pluck('catalog_categories.id')->all());
        $this->assertEqualsCanonicalizing($models, $product->vehicleModels()->pluck('vehicle_models.id')->all());
        $this->assertCount(2, $product->images);

        foreach ($product->images as $image) {
            Storage::disk('public')->assertExists(substr($image->path, strlen('storage/')));
        }
    }

    public function test_administrator_can_update_hide_and_remove_product_image_without_deleting_product(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $product = Product::query()->create([
            'name' => 'Первое имя',
            'slug' => 'first-name',
            'price' => 100,
            'stock' => 2,
            'is_active' => true,
        ]);
        $path = 'products/'.$product->id.'/photo.png';
        Storage::disk('public')->put($path, 'image');
        $image = $product->images()->create(['path' => 'storage/'.$path]);
        $product->roofRack()->create();

        $this->actingAs($admin)->put(route('admin.products.roof-racks.update', $product), [
            'name' => 'Новое имя',
            'slug' => 'new-name',
            'price' => '250.00',
            'stock' => 0,
            'category_ids' => [],
            'vehicle_model_ids' => [],
            'remove_image_ids' => [$image->id],
            'bar_length_cm' => 135,
            'rack_color' => 'Серебристый',
        ])->assertRedirect();

        $product->refresh();
        $this->assertSame('Новое имя', $product->name);
        $this->assertFalse($product->is_active);
        $this->assertSame('135.0', $product->roofRack->bar_length_cm);
        $this->assertSame('Серебристый', $product->roofRack->rack_color);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('product_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($path);
        $this->get('/products/new-name')->assertNotFound();
    }

    public function test_public_product_page_and_model_page_show_only_published_products(): void
    {
        $model = VehicleModel::query()->whereHas('make', fn ($query) => $query->where('slug', 'audi'))->firstOrFail();
        $published = Product::query()->create([
            'name' => 'Опубликованный товар',
            'slug' => 'published-product',
            'price' => 1000,
            'manufacturer' => 'Inter',
            'country_of_origin' => 'Россия',
            'product_model' => 'TEST-100',
            'description' => 'Подробное описание товара',
            'stock' => 1,
            'is_active' => true,
        ]);
        $hidden = Product::query()->create([
            'name' => 'Скрытый товар',
            'slug' => 'hidden-product',
            'price' => 2000,
            'stock' => 1,
            'is_active' => false,
        ]);
        $published->vehicleModels()->attach($model);
        $hidden->vehicleModels()->attach($model);

        $this->get(route('catalog.autobagazhniki.model.show', [$model->make->slug, $model->slug]))
            ->assertOk()
            ->assertSee('Опубликованный товар')
            ->assertDontSee('Скрытый товар');

        $this->get(route('products.show', $published))
            ->assertOk()
            ->assertSee('Опубликованный товар')
            ->assertSee('Характеристики товара')
            ->assertDontSee('>Характеристики<', escape: false)
            ->assertSee('Производитель')
            ->assertSee('Inter')
            ->assertSee('Страна производства')
            ->assertSee('Россия')
            ->assertSee('Модель')
            ->assertSee('TEST-100')
            ->assertSee('Наличие')
            ->assertSee('1 шт.')
            ->assertSeeInOrder(['Производитель', '1 000,00 ₽', 'Описание']);

        $this->get('/products/hidden-product')->assertNotFound();
    }

    public function test_slug_must_be_unique(): void
    {
        Product::query()->create([
            'name' => 'Existing',
            'slug' => 'existing',
            'price' => 10,
        ]);
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.products.roof-racks.store'), [
            'name' => 'Duplicate',
            'slug' => 'existing',
            'price' => 20,
            'stock' => 0,
        ])->assertSessionHasErrors('slug');
    }

    public function test_roof_rack_characteristics_are_shown_only_for_roof_rack_product_type(): void
    {
        $roofRacks = CatalogCategory::query()->where('slug', 'autobagazhniki')->firstOrFail();
        $roofRackCategory = CatalogCategory::query()->where('slug', 'bagazhniki-aps')->firstOrFail();
        $otherSection = CatalogCategory::query()->create([
            'kind' => 'section',
            'name' => 'Автобоксы',
            'slug' => 'avtoboksy',
            'is_active' => true,
        ]);

        $roofRackProduct = Product::query()->create([
            'name' => 'Автобагажник с характеристиками',
            'slug' => 'roof-rack-characteristics',
            'price' => 5000,
            'stock' => 1,
            'is_active' => true,
        ]);
        $roofRackProduct->roofRack()->create([
            'bar_length_cm' => 120,
            'load_capacity_kg' => 75,
            'installation_method' => 'На рейлинги',
            'bar_type' => 'Аэродинамическая',
            'rack_color' => 'Чёрный',
        ]);
        $roofRackProduct->categories()->attach($roofRackCategory);

        $otherProduct = Product::query()->create([
            'name' => 'Другой товар',
            'slug' => 'other-product-characteristics',
            'price' => 6000,
            'stock' => 1,
            'is_active' => true,
        ]);
        $otherProduct->categories()->attach($otherSection);

        $this->assertSame($roofRacks->id, $roofRackCategory->parent_id);

        $this->get(route('products.show', $roofRackProduct))
            ->assertOk()
            ->assertSee('Характеристики автобагажника')
            ->assertSee('Длина дуги, см')
            ->assertSee('120')
            ->assertSee('Нагрузка, кг')
            ->assertSee('75')
            ->assertSee('Способ установки')
            ->assertSee('На рейлинги')
            ->assertSee('Тип дуги')
            ->assertSee('Аэродинамическая')
            ->assertSee('Цвет багажника')
            ->assertSee('Чёрный');

        $this->get(route('products.show', $otherProduct))
            ->assertOk()
            ->assertDontSee('Характеристики автобагажника')
            ->assertDontSee('Длина дуги, см')
            ->assertDontSee('Способ установки');
    }

    private function fakePng(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            $name,
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='),
        );
    }
}
