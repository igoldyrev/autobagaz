<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use App\Models\User;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminVehicleDirectoryTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_vehicle_make_admin_pages_are_protected(): void
    {
        $this->get(route('admin.vehicles.vehicle-makes.index'))
            ->assertRedirect(route('login'));
    }

    public function test_administrator_can_view_vehicle_makes_and_models(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $audi = VehicleMake::query()->where('slug', 'audi')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.vehicles.vehicle-makes.index'))
            ->assertOk()
            ->assertSee('Марки автомобилей')
            ->assertSee('admin-shortcuts__link', false)
            ->assertSee('Типы кузова')
            ->assertSee('Типы крыши')
            ->assertSee('Audi');

        $this->actingAs($admin)
            ->get(route('admin.vehicles.vehicle-models.index', $audi))
            ->assertOk()
            ->assertSee('A4')
            ->assertSee('80/90');
    }

    public function test_administrator_can_create_vehicle_make_and_it_appears_in_public_catalog(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.vehicles.vehicle-makes.store'), [
            'name' => 'Новая Марка',
            'slug' => '',
            'catalog_category_ids' => [$this->rootCategory()->id],
            'is_active' => '1',
            'image' => UploadedFile::fake()->createWithContent(
                'new-make.png',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='),
            ),
        ]);

        $response->assertSessionDoesntHaveErrors();

        $vehicleMake = VehicleMake::query()->where('slug', 'novaia-marka')->firstOrFail();
        $rootCategory = $this->rootCategory();

        $response->assertRedirect(route('admin.vehicles.vehicle-makes.edit', $vehicleMake));
        $this->assertTrue($rootCategory->vehicleMakes()->whereKey($vehicleMake->id)->exists());
        Storage::disk('public')->assertExists(substr($vehicleMake->image_path, strlen('storage/')));

        $this->get(route('catalog.autobagazhniki.index'))
            ->assertOk()
            ->assertSee('Новая Марка');
    }

    public function test_administrator_can_edit_and_hide_vehicle_make(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $vehicleMake = VehicleMake::query()->where('slug', 'audi')->firstOrFail();

        $this->actingAs($admin)->put(route('admin.vehicles.vehicle-makes.update', $vehicleMake), [
            'name' => 'Audi Updated',
            'slug' => 'audi-updated',
            'catalog_category_ids' => [$this->rootCategory()->id],
            'is_active' => '0',
        ])->assertRedirect();

        $vehicleMake->refresh();
        $this->assertSame('Audi Updated', $vehicleMake->name);
        $this->assertFalse($vehicleMake->is_active);
        $this->get(route('catalog.autobagazhniki.show', 'audi-updated'))->assertNotFound();
    }

    public function test_removing_make_from_section_preserves_global_directory(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $vehicleMake = VehicleMake::query()->where('slug', 'audi')->firstOrFail();
        $modelsCount = $vehicleMake->models()->count();

        $this->actingAs($admin)
            ->put(route('admin.vehicles.vehicle-makes.update', $vehicleMake), [
                'name' => $vehicleMake->name,
                'slug' => $vehicleMake->slug,
                'is_active' => '1',
                'catalog_category_ids' => [],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('vehicle_makes', ['id' => $vehicleMake->id]);
        $this->assertSame($modelsCount, VehicleModel::query()->where('vehicle_make_id', $vehicleMake->id)->count());
        $this->assertFalse($this->rootCategory()->vehicleMakes()->whereKey($vehicleMake->id)->exists());
        $this->actingAs($admin)
            ->get(route('admin.vehicles.vehicle-makes.index'))
            ->assertOk()
            ->assertSee('Audi')
            ->assertSee('Не привязана');
        $this->actingAs($admin)
            ->get(route('admin.vehicles.vehicle-models.index', $vehicleMake))
            ->assertOk();
        $this->get(route('catalog.autobagazhniki.show', 'audi'))->assertNotFound();
    }

    public function test_administrator_can_attach_existing_make_again(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $vehicleMake = VehicleMake::query()->where('slug', 'audi')->firstOrFail();
        $this->rootCategory()->vehicleMakes()->detach($vehicleMake->id);

        $this->actingAs($admin)->put(route('admin.vehicles.vehicle-makes.update', $vehicleMake), [
            'name' => $vehicleMake->name,
            'slug' => $vehicleMake->slug,
            'is_active' => '1',
            'catalog_category_ids' => [$this->rootCategory()->id],
        ])->assertRedirect();

        $attachedMake = $this->rootCategory()->vehicleMakes()->findOrFail($vehicleMake->id);
        $this->assertGreaterThanOrEqual(1, $attachedMake->pivot->sort_order);
        $this->assertSame(1, VehicleMake::query()->where('slug', 'audi')->count());
    }

    public function test_same_make_can_be_attached_to_another_catalog_section(): void
    {
        $vehicleMake = VehicleMake::query()->where('slug', 'audi')->firstOrFail();
        $anotherSection = CatalogCategory::query()->create([
            'kind' => 'section',
            'name' => 'Фаркопы',
            'slug' => 'farkopy',
            'is_active' => true,
        ]);

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->put(route('admin.vehicles.vehicle-makes.update', $vehicleMake), [
            'name' => $vehicleMake->name,
            'slug' => $vehicleMake->slug,
            'is_active' => '1',
            'catalog_category_ids' => [$this->rootCategory()->id, $anotherSection->id],
        ])->assertRedirect();

        $this->assertSame(2, $vehicleMake->catalogCategories()->count());
        $this->assertSame(1, VehicleMake::query()->where('slug', 'audi')->count());
        $this->assertTrue($anotherSection->vehicleMakes()->whereKey($vehicleMake->id)->exists());
    }

    public function test_administrator_can_create_update_and_delete_vehicle_model(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $vehicleMake = VehicleMake::query()->where('slug', 'audi')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.vehicles.vehicle-models.store', $vehicleMake), [
            'name' => 'Test Model',
            'slug' => '',
            'sort_order' => 999,
            'is_active' => '1',
        ])->assertRedirect();

        $vehicleModel = $vehicleMake->models()->where('slug', 'test-model')->firstOrFail();
        $this->get(route('catalog.autobagazhniki.model.show', [$vehicleMake->slug, $vehicleModel->slug]))
            ->assertOk()
            ->assertSee('Test Model');

        $this->actingAs($admin)->put(route('admin.vehicles.vehicle-models.update', [$vehicleMake, $vehicleModel]), [
            'name' => 'Updated Model',
            'slug' => 'updated-model',
            'sort_order' => 1000,
            'is_active' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('vehicle_models', [
            'id' => $vehicleModel->id,
            'name' => 'Updated Model',
            'slug' => 'updated-model',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.vehicles.vehicle-models.destroy', [$vehicleMake, $vehicleModel]))
            ->assertRedirect(route('admin.vehicles.vehicle-models.index', $vehicleMake));

        $this->assertDatabaseMissing('vehicle_models', ['id' => $vehicleModel->id]);
    }

    public function test_model_slug_must_be_unique_only_inside_its_make(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $audi = VehicleMake::query()->where('slug', 'audi')->firstOrFail();
        $bmw = VehicleMake::query()->where('slug', 'bmw')->firstOrFail();

        $payload = [
            'name' => 'A4 duplicate',
            'slug' => 'a4',
            'sort_order' => 1,
            'is_active' => '1',
        ];

        $this->actingAs($admin)
            ->post(route('admin.vehicles.vehicle-models.store', $audi), $payload)
            ->assertSessionHasErrors('slug');

        $this->actingAs($admin)
            ->post(route('admin.vehicles.vehicle-models.store', $bmw), $payload)
            ->assertSessionDoesntHaveErrors('slug');

        $this->assertDatabaseHas('vehicle_models', [
            'vehicle_make_id' => $bmw->id,
            'slug' => 'a4',
        ]);
    }

    private function rootCategory(): CatalogCategory
    {
        return CatalogCategory::query()->where('slug', 'autobagazhniki')->firstOrFail();
    }
}
