<?php

namespace Tests\Feature;

use App\Models\VehicleConfiguration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OctoberVehicleConfigurationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_requested_configurations_have_correct_roofs_bodies_and_images(): void
    {
        $vehicles = json_decode(file_get_contents(database_path('data/requested_vehicles_2026_10_17.json')), true, flags: JSON_THROW_ON_ERROR);
        $this->assertCount(37, $vehicles);
        $catalog = $this->get(route('catalog.autobagazhniki.index'))->assertOk();
        foreach ($vehicles as $vehicle) {
            $catalog->assertSee($vehicle['make_name']);
            $configuration = VehicleConfiguration::query()->where('source_reference', '2026-10-17:'.$vehicle['make_slug'].':'.$vehicle['model_slug'].':'.$vehicle['year_from'])->sole();
            $this->assertSame($vehicle['body_slug'], $configuration->bodyStyle->slug);
            $this->assertSame($vehicle['doors_count'], $configuration->doors_count);
            $roof = match ($vehicle['roof']) {
                'smooth' => 'Гладкая крыша',
                'integrated' => 'Интегрированные рейлинги',
                'fixed' => 'Штатные места',
            };
            $this->assertSame($roof, $configuration->roofType->name);
            $this->assertSame($vehicle['image_path'], $configuration->generation->image_path);
            $this->assertFileExists(public_path($vehicle['image_path']));
            $this->assertSame(0, $configuration->fitments()->count());
            $this->getJson('/podbor-avto/configurations?model_id='.$configuration->generation->vehicle_model_id)
                ->assertOk()->assertJsonFragment([
                    'id' => $configuration->id,
                    'year_from' => $vehicle['year_from'], 'year_to' => $vehicle['year_to'],
                    'mounting' => ['label' => $roof],
                ]);
        }
    }

    public function test_new_vehicle_makes_use_logos_and_repair_preserves_custom_images(): void
    {
        $logos = json_decode(file_get_contents(database_path('data/vehicle_make_logos.json')), true, flags: JSON_THROW_ON_ERROR);
        foreach ($logos as $slug => $logo) {
            $this->assertDatabaseHas('vehicle_makes', ['slug' => $slug, 'image_path' => $logo['image_path']]);
            $this->assertFileExists(public_path($logo['image_path']));
        }

        DB::table('vehicle_makes')->where('slug', 'zeekr')->update([
            'image_path' => 'images/catalog/autobagazhniki/models/zeekr/009-2022-generated.webp',
        ]);
        DB::table('vehicle_makes')->where('slug', 'belgee')->update(['image_path' => 'storage/custom-logo.png']);
        $migration = require database_path('migrations/2026_10_20_000000_replace_vehicle_make_photos_with_logos.php');
        $migration->up();
        $migration->up();

        $this->assertDatabaseHas('vehicle_makes', ['slug' => 'zeekr', 'image_path' => $logos['zeekr']['image_path']]);
        $this->assertDatabaseHas('vehicle_makes', ['slug' => 'belgee', 'image_path' => 'storage/custom-logo.png']);
    }

    public function test_repeated_import_preserves_records_and_administrator_edits(): void
    {
        $tables = ['vehicle_makes', 'vehicle_models', 'vehicle_generations', 'vehicle_body_styles', 'vehicle_roof_types', 'vehicle_configurations'];
        $counts = [];
        foreach ($tables as $table) {
            $counts[$table] = DB::table($table)->count();
        }
        $configuration = VehicleConfiguration::query()->where('source_reference', 'like', '2026-10-17:%')->firstOrFail();
        $configuration->update(['notes' => 'Заметка администратора', 'is_active' => false]);
        $generation = $configuration->generation;
        $generation->update(['image_path' => 'custom-image.webp']);

        (require database_path('migrations/2026_10_17_000000_add_requested_vehicle_configurations.php'))->up();

        foreach ($counts as $table => $count) {
            $this->assertDatabaseCount($table, $count);
        }
        $this->assertSame('Заметка администратора', $configuration->fresh()->notes);
        $this->assertFalse($configuration->fresh()->is_active);
        $this->assertSame('custom-image.webp', $generation->fresh()->image_path);
    }

    public function test_existing_configuration_covering_requested_years_is_skipped(): void
    {
        $configuration = VehicleConfiguration::query()->where('source_reference', '2026-10-17:audi:q5:2008')->sole();
        $configuration->update(['year_from' => 2007, 'year_to' => 2016, 'source' => 'legacy', 'source_reference' => 'legacy-q5']);
        $count = VehicleConfiguration::count();

        (require database_path('migrations/2026_10_17_000000_add_requested_vehicle_configurations.php'))->up();

        $this->assertDatabaseCount('vehicle_configurations', $count);
        $this->assertSame('legacy-q5', $configuration->fresh()->source_reference);
    }

    public function test_open_ended_older_generation_does_not_replace_requested_generation(): void
    {
        $configuration = VehicleConfiguration::query()->where('source_reference', '2026-10-17:nissan:x-trail:2021')->sole();
        $generation = $configuration->generation;
        $configuration->update(['year_from' => 2014, 'display_name' => 'X-Trail T32 2014–н.в.', 'source_reference' => 'legacy-t32']);
        $generation->update(['year_from' => 2014, 'name' => 'T32 2014–н.в.', 'slug' => 'test-t32']);
        $count = VehicleConfiguration::count();

        (require database_path('migrations/2026_10_17_000000_add_requested_vehicle_configurations.php'))->up();

        $this->assertDatabaseCount('vehicle_configurations', $count + 1);
        $this->assertDatabaseHas('vehicle_configurations', ['source_reference' => '2026-10-17:nissan:x-trail:2021', 'year_from' => 2021]);
        $this->assertModelExists($configuration);
    }
}
