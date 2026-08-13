<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roof_rack_products', function (Blueprint $table) {
            $table->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $table->decimal('bar_length_cm', 6, 1)->nullable();
            $table->decimal('load_capacity_kg', 6, 1)->nullable();
            $table->string('installation_method')->nullable();
            $table->string('bar_type')->nullable();
            $table->string('rack_color')->nullable();
            $table->timestamps();
        });

        $this->moveExistingData();

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'bar_length_cm',
                'load_capacity_kg',
                'installation_method',
                'bar_type',
                'rack_color',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('bar_length_cm', 6, 1)->nullable()->after('product_model');
            $table->decimal('load_capacity_kg', 6, 1)->nullable()->after('bar_length_cm');
            $table->string('installation_method')->nullable()->after('load_capacity_kg');
            $table->string('bar_type')->nullable()->after('installation_method');
            $table->string('rack_color')->nullable()->after('bar_type');
        });

        DB::table('roof_rack_products')->orderBy('product_id')->each(function (object $details): void {
            DB::table('products')->where('id', $details->product_id)->update([
                'bar_length_cm' => $details->bar_length_cm,
                'load_capacity_kg' => $details->load_capacity_kg,
                'installation_method' => $details->installation_method,
                'bar_type' => $details->bar_type,
                'rack_color' => $details->rack_color,
            ]);
        });

        Schema::dropIfExists('roof_rack_products');
    }

    private function moveExistingData(): void
    {
        $roofRackCategoryIds = $this->roofRackCategoryIds();
        $categoryProductIds = $roofRackCategoryIds === []
            ? []
            : DB::table('catalog_category_product')
                ->whereIn('catalog_category_id', $roofRackCategoryIds)
                ->pluck('product_id')
                ->all();

        DB::table('products')
            ->where(function ($query) use ($categoryProductIds): void {
                if ($categoryProductIds !== []) {
                    $query->whereIn('id', $categoryProductIds);
                }

                $query->orWhereNotNull('bar_length_cm')
                    ->orWhereNotNull('load_capacity_kg')
                    ->orWhereNotNull('installation_method')
                    ->orWhereNotNull('bar_type')
                    ->orWhereNotNull('rack_color');
            })
            ->orderBy('id')
            ->each(function (object $product): void {
                DB::table('roof_rack_products')->insert([
                    'product_id' => $product->id,
                    'bar_length_cm' => $product->bar_length_cm,
                    'load_capacity_kg' => $product->load_capacity_kg,
                    'installation_method' => $product->installation_method,
                    'bar_type' => $product->bar_type,
                    'rack_color' => $product->rack_color,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    /** @return array<int> */
    private function roofRackCategoryIds(): array
    {
        $rootId = DB::table('catalog_categories')
            ->whereNull('parent_id')
            ->where('slug', 'autobagazhniki')
            ->value('id');

        if (! $rootId) {
            return [];
        }

        $ids = [(int) $rootId];
        $pending = [(int) $rootId];

        while ($pending !== []) {
            $children = DB::table('catalog_categories')->whereIn('parent_id', $pending)->pluck('id')->map(fn ($id): int => (int) $id)->all();
            $ids = [...$ids, ...$children];
            $pending = $children;
        }

        return $ids;
    }
};
