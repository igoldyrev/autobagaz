<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VehicleConfiguration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RequestedVehicleConfigurationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_requested_vehicles_are_available_in_public_picker(): void
    {
        $expected = [
            ['Chery', 'Tiggo 7 Pro', 2020, null],
            ['Chevrolet', 'Orlando', 2010, 2015],
            ['Datsun', 'Mi-Do', 2014, 2020],
            ['Datsun', 'On-Do', 2014, 2020],
            ['Exeed', 'TXL', 2020, null],
            ['Exeed', 'VX', 2021, null],
            ['Geely', 'Atlas', 2017, 2022],
            ['Geely', 'Monjaro', 2021, null],
            ['Geely', 'Tugella', 2020, null],
            ['HAVAL', 'H6', 2014, null],
            ['Lada (ВАЗ)', 'Niva 4x4 (Legend)', 2021, null],
            ['Lexus', 'RX', 2015, null],
            ['Lifan', 'X70', 2017, 2020],
        ];

        foreach ($expected as [$make, $model, $from, $to]) {
            $configuration = VehicleConfiguration::query()
                ->whereHas('generation.vehicleModel', fn ($query) => $query
                    ->where('name', $model)
                    ->whereHas('make', fn ($query) => $query->where('name', $make)))
                ->where('year_from', $from)->where('year_to', $to)->sole();
            $generation = $configuration->generation;
            $this->assertFileExists(public_path($generation->image_path));
            $this->assertNotEmpty($generation->image_alt);
            $this->getJson('/podbor-avto/models?make_id='.$generation->vehicleModel->vehicle_make_id)
                ->assertOk()->assertJsonFragment(['id' => $generation->vehicle_model_id, 'name' => $model]);
            $this->getJson('/podbor-avto/configurations?model_id='.$generation->vehicle_model_id)
                ->assertOk()->assertJsonFragment([
                    'id' => $configuration->id,
                    'year_from' => $from,
                    'year_to' => $to,
                    'mounting' => ['label' => $make === 'Lada (ВАЗ)' ? 'Штатные места' : 'Интегрированные рейлинги'],
                ]);
            $this->assertSame(0, $configuration->fitments()->count());
            if (in_array($model, ['Atlas', 'RX'])) {
                $this->assertStringStartsWith($model === 'Atlas' ? 'I ' : 'IV ', $generation->name);
            }
        }
    }

    public function test_repeated_import_preserves_existing_records_and_edits(): void
    {
        $tables = ['vehicle_makes', 'vehicle_models', 'vehicle_generations', 'vehicle_roof_types', 'vehicle_configurations'];
        $counts = [];
        foreach ($tables as $table) {
            $counts[$table] = DB::table($table)->count();
        }
        $configuration = VehicleConfiguration::query()->where('source', 'manual_request')->firstOrFail();
        $configuration->update(['notes' => 'Заметка администратора']);
        $model = $configuration->generation->vehicleModel;
        $model->update(['description' => 'Описание администратора']);
        $legacy = $model->generations()->create([
            'name' => 'Другое поколение', 'slug' => 'other', 'year_from' => 2000, 'year_to' => 2005,
        ]);
        $counts['vehicle_generations']++;

        (require database_path('migrations/2026_10_15_000000_add_requested_vehicle_configurations.php'))->up();

        foreach ($counts as $table => $count) {
            $this->assertDatabaseCount($table, $count);
        }
        $this->assertSame('Заметка администратора', $configuration->fresh()->notes);
        $this->assertSame('Описание администратора', $model->fresh()->description);
        $this->assertModelExists($legacy);
    }

    public function test_generated_images_are_displayed_in_admin_generation_forms(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $configurations = VehicleConfiguration::query()->where('source_reference', 'like', '2026-10-15:%')->get();
        $this->assertCount(13, $configurations);

        foreach ($configurations as $configuration) {
            $generation = $configuration->generation;
            $model = $generation->vehicleModel;
            $this->get(route('admin.vehicles.vehicle-generations.edit', [$model->make, $model, $generation]))
                ->assertOk()
                ->assertSee('src="'.asset($generation->image_path).'"', false);
        }
    }
}
