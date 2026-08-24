<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('fitments') || ! Schema::hasTable('fitment_product')) {
            return;
        }

        $hasModelLinks = Schema::hasTable('product_vehicle_model');
        $hasBodyTypeLinks = Schema::hasTable('product_vehicle_body_type');
        if (! $hasModelLinks && ! $hasBodyTypeLinks) {
            return;
        }

        DB::table('products')
            ->join('roof_rack_products', 'roof_rack_products.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', 'roof_rack_products.manufacturer_id')
            ->orderBy('products.id')
            ->chunkById(100, function ($products) use ($hasModelLinks, $hasBodyTypeLinks): void {
                foreach ($products as $product) {
                    $configurationIds = collect();

                    if ($hasBodyTypeLinks) {
                        $configurationIds = $configurationIds->merge(
                            DB::table('product_vehicle_body_type')
                                ->join('vehicle_configurations', 'vehicle_configurations.legacy_vehicle_body_type_id', '=', 'product_vehicle_body_type.vehicle_body_type_id')
                                ->where('product_vehicle_body_type.product_id', $product->id)
                                ->pluck('vehicle_configurations.id'),
                        );
                    }
                    if ($hasModelLinks) {
                        $modelIds = DB::table('product_vehicle_model')
                            ->where('product_id', $product->id)
                            ->pluck('vehicle_model_id');
                        foreach ($modelIds as $modelId) {
                            $modelConfigurationIds = DB::table('vehicle_generations')
                                ->join('vehicle_configurations', 'vehicle_configurations.vehicle_generation_id', '=', 'vehicle_generations.id')
                                ->where('vehicle_generations.vehicle_model_id', $modelId)
                                ->pluck('vehicle_configurations.id');
                            if ($modelConfigurationIds->isEmpty()) {
                                $modelConfigurationIds = collect([$this->fallbackConfiguration((int) $modelId)]);
                            }
                            $configurationIds = $configurationIds->merge($modelConfigurationIds);
                        }
                    }

                    $configurationIds = $configurationIds->map(fn ($id): int => (int) $id)->unique()->values();
                    if ($configurationIds->isEmpty()) {
                        continue;
                    }

                    $sourceReference = 'legacy-product:'.$product->id;
                    $fitmentId = DB::table('fitments')
                        ->where('source', 'legacy_product_applicability')
                        ->where('source_reference', $sourceReference)
                        ->value('id');
                    if (! $fitmentId) {
                        $fitmentId = DB::table('fitments')->insertGetId([
                            'code' => 'LEGACY-PRODUCT-'.$product->id,
                            'name' => $product->name,
                            'roof_rack_manufacturer_id' => $product->manufacturer_id,
                            'source' => 'legacy_product_applicability',
                            'source_reference' => $sourceReference,
                            'verification_status' => 'migrated',
                            'notes' => 'Создано автоматически из прямых связей товара с моделями и вариантами автомобиля.',
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    DB::table('fitment_product')->insertOrIgnore([
                        'fitment_id' => $fitmentId,
                        'product_id' => $product->id,
                        'status' => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    foreach ($configurationIds as $configurationId) {
                        DB::table('fitment_vehicle_configuration')->insertOrIgnore([
                            'fitment_id' => $fitmentId,
                            'vehicle_configuration_id' => $configurationId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }, 'products.id', 'id');
    }

    public function down(): void
    {
        // Перенесённую применяемость сохраняем, чтобы откат не удалял рабочие связи.
    }

    private function fallbackConfiguration(int $modelId): int
    {
        $generationReference = 'legacy-model-fallback:'.$modelId;
        $generationId = DB::table('vehicle_generations')
            ->where('source', 'legacy_product_applicability')
            ->where('source_reference', $generationReference)
            ->value('id');
        if (! $generationId) {
            $slug = 'legacy-fitment';
            $suffix = 2;
            while (DB::table('vehicle_generations')->where('vehicle_model_id', $modelId)->where('slug', $slug)->exists()) {
                $slug = 'legacy-fitment-'.$suffix++;
            }
            $generationId = DB::table('vehicle_generations')->insertGetId([
                'vehicle_model_id' => $modelId,
                'name' => 'Годы не указаны',
                'slug' => $slug,
                'source' => 'legacy_product_applicability',
                'source_reference' => $generationReference,
                'verification_status' => 'draft',
                'sort_order' => 4294967295,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $configurationReference = 'legacy-model-fallback:'.$modelId;
        $configurationId = DB::table('vehicle_configurations')
            ->where('source', 'legacy_product_applicability')
            ->where('source_reference', $configurationReference)
            ->value('id');

        return $configurationId ?: DB::table('vehicle_configurations')->insertGetId([
            'vehicle_generation_id' => $generationId,
            'display_name' => 'Все варианты модели',
            'source' => 'legacy_product_applicability',
            'source_reference' => $configurationReference,
            'verification_status' => 'needs_review',
            'notes' => 'Создано из прямой связи товара с моделью без уточнения кузова и годов.',
            'sort_order' => 4294967295,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
