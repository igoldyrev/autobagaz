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

    public function test_it_explains_compatible_technical_pair(): void
    {
        [$vehicle, $base, $box] = $this->compatibleContext();

        $result = app(CompatibilityService::class)->check($box, new CompatibilityContext($vehicle, $base));

        $this->assertSame(CompatibilityResult::COMPATIBLE, $result->status);
        $this->assertSame($base->id, $result->matchedBaseProductId);
        $this->assertStringContainsString('Ширина дуги 75 мм', implode(' ', $result->reasons));
        $this->assertStringContainsString('пересекается', implode(' ', $result->reasons));
    }

    public function test_known_failed_rule_is_incompatible_and_missing_data_is_unknown(): void
    {
        [$vehicle, $base, $box] = $this->compatibleContext();
        $box->autoBox()->update(['clamp_width_max_mm' => 60]);

        $failed = app(CompatibilityService::class)->check($box->fresh(), new CompatibilityContext($vehicle, $base));
        $this->assertSame(CompatibilityResult::INCOMPATIBLE, $failed->status);
        $this->assertStringContainsString('не входит', implode(' ', $failed->reasons));

        $box->autoBox()->update(['clamp_width_min_mm' => null, 'clamp_width_max_mm' => null]);
        $unknown = app(CompatibilityService::class)->check($box->fresh(), new CompatibilityContext($vehicle, $base));
        $this->assertSame(CompatibilityResult::UNKNOWN, $unknown->status);
        $this->assertContains('ширина профиля или допустимый диапазон крепления', $unknown->missingData);
    }

    public function test_manual_override_has_priority_over_technical_rules(): void
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

        $this->assertSame(CompatibilityResult::INCOMPATIBLE, $result->status);
        $this->assertSame($override->id, $result->appliedOverrideId);
        $this->assertStringContainsString('пятой двери', implode(' ', $result->reasons));
    }

    public function test_service_can_find_compatible_base_automatically(): void
    {
        [$vehicle, $base, $box] = $this->compatibleContext();

        $result = app(CompatibilityService::class)->check($box, new CompatibilityContext($vehicle));

        $this->assertSame(CompatibilityResult::COMPATIBLE, $result->status);
        $this->assertSame($base->id, $result->matchedBaseProductId);
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
