<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\VehicleMake;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ReleaseDataMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_vehicle_and_product_links_are_migrated_before_cleanup(): void
    {
        Schema::create('vehicle_body_types', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vehicle_model_id');
            $table->string('name');
            $table->string('source_name')->nullable();
            $table->string('slug');
            $table->string('year_label')->nullable();
            $table->string('mounting_type')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('source_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::table('vehicle_configurations', function (Blueprint $table): void {
            $table->unsignedBigInteger('legacy_vehicle_body_type_id')->nullable();
        });
        Schema::create('product_vehicle_model', function (Blueprint $table): void {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('vehicle_model_id');
        });
        Schema::create('product_vehicle_body_type', function (Blueprint $table): void {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('vehicle_body_type_id');
        });
        Schema::create('product_base_product', function (Blueprint $table): void {
            $table->unsignedBigInteger('base_product_id');
            $table->unsignedBigInteger('product_id');
            $table->string('compatibility_type')->default('via_base_product');
        });

        $make = VehicleMake::query()->create(['name' => 'Release Kia', 'slug' => 'release-kia', 'is_active' => true]);
        $model = $make->models()->create(['name' => 'Release Sportage', 'slug' => 'release-sportage', 'is_active' => true]);
        $bodyTypeId = DB::table('vehicle_body_types')->insertGetId([
            'vehicle_model_id' => $model->id,
            'name' => 'Кроссовер',
            'source_name' => 'Sportage 2021-н.в., интегрированные рейлинги',
            'slug' => 'sportage-2021-integrated',
            'year_label' => '2021–н.в.',
            'mounting_type' => 'Интегрированные рейлинги',
            'image_path' => 'images/test-sportage.png',
            'sort_order' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        (require database_path('migrations/2026_08_24_005000_migrate_vehicle_body_types_to_configurations.php'))->up();

        $configurationId = DB::table('vehicle_configurations')->where('legacy_vehicle_body_type_id', $bodyTypeId)->value('id');
        $this->assertNotNull($configurationId);
        $this->assertDatabaseHas('vehicle_generations', [
            'vehicle_model_id' => $model->id,
            'year_from' => 2021,
            'year_to' => null,
        ]);
        $this->assertDatabaseHas('vehicle_body_styles', ['name' => 'Кроссовер']);
        $this->assertDatabaseHas('vehicle_roof_types', ['name' => 'Интегрированные рейлинги']);

        $product = Product::query()->create([
            'name' => 'Release roof rack',
            'slug' => 'release-roof-rack',
            'price' => 1000,
            'is_active' => true,
        ]);
        $product->roofRack()->create();
        DB::table('product_vehicle_body_type')->insert([
            'product_id' => $product->id,
            'vehicle_body_type_id' => $bodyTypeId,
        ]);

        (require database_path('migrations/2026_08_24_015000_migrate_roof_rack_applicability_to_fitments.php'))->up();

        $fitmentId = DB::table('fitments')->where('source_reference', 'legacy-product:'.$product->id)->value('id');
        $this->assertNotNull($fitmentId);
        $this->assertDatabaseHas('fitment_product', ['fitment_id' => $fitmentId, 'product_id' => $product->id]);
        $this->assertDatabaseHas('fitment_vehicle_configuration', [
            'fitment_id' => $fitmentId,
            'vehicle_configuration_id' => $configurationId,
        ]);

        $autoBox = Product::query()->create([
            'name' => 'Release auto box',
            'slug' => 'release-auto-box',
            'price' => 2000,
            'is_active' => true,
        ]);
        $autoBox->autoBox()->create();
        DB::table('product_base_product')->insert([
            'base_product_id' => $product->id,
            'product_id' => $autoBox->id,
        ]);

        (require database_path('migrations/2026_08_24_025000_migrate_product_pairs_to_overrides.php'))->up();

        $this->assertDatabaseHas('compatibility_overrides', [
            'base_product_id' => $product->id,
            'accessory_product_id' => $autoBox->id,
            'status' => 'compatible',
            'source' => 'legacy_product_base_product',
        ]);
    }
}
