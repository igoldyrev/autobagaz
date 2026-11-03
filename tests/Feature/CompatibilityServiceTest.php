<?php

namespace Tests\Feature;

use App\Compatibility\CompatibilityContext;
use App\Compatibility\CompatibilityResult;
use App\Models\CompatibilityOverride;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\VehicleConfiguration;
use App\Models\VehicleMake;
use App\Services\CompatibilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CompatibilityServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_result_codes_have_manager_friendly_labels_and_explanations(): void
    {
        $compatible = new CompatibilityResult(CompatibilityResult::COMPATIBLE);
        $incompatible = new CompatibilityResult(CompatibilityResult::INCOMPATIBLE);
        $unknown = new CompatibilityResult(CompatibilityResult::UNKNOWN);

        $this->assertSame('Совместимо', $compatible->statusLabel());
        $this->assertStringContainsString('условия установки выполнены', $compatible->statusExplanation());
        $this->assertSame('Несовместимо', $incompatible->statusLabel());
        $this->assertStringContainsString('не выполнены', $incompatible->statusExplanation());
        $this->assertSame('Недостаточно данных', $unknown->statusLabel());
        $this->assertStringContainsString('технические параметры', $unknown->statusExplanation());
    }

    public function test_auto_box_is_universally_compatible(): void
    {
        [$vehicle, $base, $box] = $this->compatibleContext();

        $result = app(CompatibilityService::class)->check($box, new CompatibilityContext($vehicle, $base));

        $this->assertSame(CompatibilityResult::COMPATIBLE, $result->status);
        $this->assertNull($result->matchedBaseProductId);
        $this->assertStringContainsString('универсальную стратегию', implode(' ', $result->reasons));
    }

    public function test_auto_box_does_not_require_technical_mounting_data(): void
    {
        [$vehicle, $base, $box] = $this->compatibleContext();
        $box->autoBox()->update(['clamp_width_max_mm' => 60]);

        $failed = app(CompatibilityService::class)->check($box->fresh(), new CompatibilityContext($vehicle, $base));
        $this->assertSame(CompatibilityResult::COMPATIBLE, $failed->status);

        $box->autoBox()->update(['clamp_width_min_mm' => null, 'clamp_width_max_mm' => null]);
        $withoutMountingData = app(CompatibilityService::class)->check($box->fresh(), new CompatibilityContext($vehicle, $base));
        $this->assertSame(CompatibilityResult::COMPATIBLE, $withoutMountingData->status);
    }

    public function test_auto_box_ignores_pair_specific_override(): void
    {
        [$vehicle, $base, $box, $fitment] = $this->compatibleContext();
        $override = CompatibilityOverride::query()->create([
            'vehicle_configuration_id' => $vehicle->id,
            'fitment_id' => $fitment->id,
            'base_product_id' => $base->id,
            'accessory_product_id' => $box->id,
            'status' => 'incompatible',
            'reason' => 'Мешает открытию пятой двери.',
            'priority' => 100,
            'is_active' => true,
        ]);

        $result = app(CompatibilityService::class)->check($box, new CompatibilityContext($vehicle, $base));

        $this->assertSame(CompatibilityResult::COMPATIBLE, $result->status);
        $this->assertNull($result->appliedOverrideId);
    }

    public function test_auto_box_does_not_need_a_compatible_base(): void
    {
        [$vehicle, $base, $box] = $this->compatibleContext();

        $result = app(CompatibilityService::class)->check($box, new CompatibilityContext($vehicle));

        $this->assertSame(CompatibilityResult::COMPATIBLE, $result->status);
        $this->assertNull($result->matchedBaseProductId);
    }

    public function test_batch_checks_preserve_override_scopes_precedence_and_validity(): void
    {
        $this->freezeTime();
        [$vehicle, $base, $box, $fitment] = $this->compatibleContext();
        [$otherVehicle, $otherBase, , $otherFitment] = $this->compatibleContext();
        $products = Product::query()->whereKey([$base->id, $otherBase->id])
            ->with(['productType', 'roofRack', 'autoBox', 'fitments.configurations'])->get();
        $context = new CompatibilityContext($vehicle);
        $service = app(CompatibilityService::class);
        $defaults = [
            'base_product_id' => $base->id, 'status' => 'incompatible',
            'reason' => 'Batch override', 'priority' => 10, 'is_active' => true,
        ];
        $rows = [
            ['priority' => 999],
            ['fitment_id' => $fitment->id],
            ['vehicle_configuration_id' => $vehicle->id, 'priority' => 0],
            ['vehicle_configuration_id' => $vehicle->id, 'fitment_id' => $fitment->id, 'priority' => 0],
            ['vehicle_configuration_id' => $vehicle->id, 'fitment_id' => $fitment->id, 'priority' => 20],
            ['vehicle_configuration_id' => $vehicle->id, 'fitment_id' => $fitment->id, 'priority' => 20, 'status' => 'compatible', 'valid_from' => now(), 'valid_to' => now()],
        ];
        foreach ($rows as $attributes) {
            $expected = CompatibilityOverride::query()->create(array_replace($defaults, $attributes));
            $result = $service->checkMany($products, $context);
            $this->assertEquals($service->check($base, $context), $result[$base->id]);
            $this->assertSame($expected->id, $result[$base->id]->appliedOverrideId);
            $this->assertSame($expected->status, $result[$base->id]->status);
            $this->assertSame(CompatibilityResult::INCOMPATIBLE, $result[$otherBase->id]->status);
            $this->assertNull($result[$otherBase->id]->appliedOverrideId);
        }

        foreach ([
            ['is_active' => false],
            ['valid_from' => now()->addSecond()],
            ['valid_to' => now()->subSecond()],
            ['vehicle_configuration_id' => $otherVehicle->id],
            ['fitment_id' => $otherFitment->id],
            ['accessory_product_id' => $box->id],
        ] as $attributes) {
            CompatibilityOverride::query()->create(array_replace($defaults, [
                'priority' => 1000, 'vehicle_configuration_id' => $vehicle->id,
                'fitment_id' => $fitment->id,
            ], $attributes));
        }
        DB::enableQueryLog();
        DB::flushQueryLog();
        $results = $service->checkMany($products, $context);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        $this->assertCount(1, $queries);
        $this->assertEquals($service->check($base, $context), $results[$base->id]);
        $this->assertSame($expected->id, $results[$base->id]->appliedOverrideId);
        $this->assertNull($results[$otherBase->id]->appliedOverrideId);
    }

    public function test_batch_checks_apply_general_override_without_a_matching_fitment(): void
    {
        [$vehicle, $base] = $this->compatibleContext();
        $base->fitments()->detach();
        $override = CompatibilityOverride::query()->create([
            'base_product_id' => $base->id, 'status' => 'compatible',
            'reason' => 'Manually confirmed', 'is_active' => true,
        ]);
        $context = new CompatibilityContext($vehicle);
        $service = app(CompatibilityService::class);
        $result = $service->checkMany(collect([$base]), $context)[$base->id];
        $this->assertSame($override->id, $result->appliedOverrideId);
        $this->assertEquals($service->check($base, $context), $result);
        $this->assertTrue($service->checkMany(collect(), $context)->isEmpty());
    }

    /** @return array{VehicleConfiguration, Product, Product, Fitment} */
    private function compatibleContext(): array
    {
        $suffix = strtolower(str()->random(8));
        $make = VehicleMake::query()->create(['name' => 'Compatibility '.$suffix, 'slug' => 'compatibility-'.$suffix, 'is_active' => true]);
        $model = $make->models()->create(['name' => 'Model '.$suffix, 'slug' => 'model-'.$suffix, 'is_active' => true]);
        $generation = $model->generations()->create([
            'name' => 'Generation', 'slug' => 'generation-'.$suffix,
            'is_active' => true,
        ]);
        $vehicle = $generation->configurations()->create([
            'display_name' => 'Rails '.$suffix, 'verification_status' => 'verified', 'is_active' => true,
        ]);
        $base = Product::query()->create([
            'product_type_id' => ProductType::query()->where('code', 'roof_rack')->value('id'),
            'name' => 'Base '.$suffix, 'slug' => 'base-'.$suffix, 'price' => 1000, 'stock' => 1, 'is_active' => true,
        ]);
        $base->roofRack()->create([
            'bar_width_mm' => 75, 'bar_height_mm' => 28, 't_slot_width_mm' => 20,
        ]);
        $box = Product::query()->create([
            'product_type_id' => ProductType::query()->where('code', 'roof_box')->value('id'),
            'name' => 'Box '.$suffix, 'slug' => 'box-'.$suffix, 'price' => 2000, 'stock' => 1, 'is_active' => true,
        ]);
        $box->autoBox()->create([
            'clamp_width_min_mm' => 20, 'clamp_width_max_mm' => 90, 'clamp_height_max_mm' => 40,
            'crossbar_spacing_min_mm' => 550, 'crossbar_spacing_max_mm' => 900,
        ]);
        $fitment = Fitment::query()->create([
            'code' => 'COMPATIBILITY-'.$suffix, 'name' => 'Compatibility '.$suffix,
            'verification_status' => 'verified', 'is_active' => true,
        ]);
        $fitment->products()->attach($base, ['status' => 'active']);
        $fitment->configurations()->attach($vehicle, [
            'crossbar_spacing_min_mm' => 600, 'crossbar_spacing_max_mm' => 800,
        ]);

        return [$vehicle, $base, $box, $fitment];
    }
}
