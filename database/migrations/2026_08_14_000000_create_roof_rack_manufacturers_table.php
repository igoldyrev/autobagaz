<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roof_rack_manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'name']);
        });

        Schema::table('roof_rack_products', function (Blueprint $table) {
            $table->foreignId('manufacturer_id')
                ->nullable()
                ->after('product_id')
                ->constrained('roof_rack_manufacturers')
                ->nullOnDelete();
        });

        $this->moveExistingManufacturers();
    }

    public function down(): void
    {
        DB::table('roof_rack_products')
            ->join('roof_rack_manufacturers', 'roof_rack_manufacturers.id', '=', 'roof_rack_products.manufacturer_id')
            ->select(['roof_rack_products.product_id', 'roof_rack_manufacturers.name'])
            ->orderBy('roof_rack_products.product_id')
            ->each(function (object $manufacturer): void {
                DB::table('products')->where('id', $manufacturer->product_id)->update([
                    'manufacturer' => $manufacturer->name,
                ]);
            });

        Schema::table('roof_rack_products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('manufacturer_id');
        });

        Schema::dropIfExists('roof_rack_manufacturers');
    }

    private function moveExistingManufacturers(): void
    {
        $manufacturerIds = [];

        DB::table('roof_rack_products')
            ->join('products', 'products.id', '=', 'roof_rack_products.product_id')
            ->whereNotNull('products.manufacturer')
            ->where('products.manufacturer', '!=', '')
            ->select(['roof_rack_products.product_id', 'products.manufacturer'])
            ->orderBy('roof_rack_products.product_id')
            ->each(function (object $product) use (&$manufacturerIds): void {
                $name = trim($product->manufacturer);
                $key = mb_strtolower($name);

                if (! isset($manufacturerIds[$key])) {
                    $manufacturerIds[$key] = DB::table('roof_rack_manufacturers')->insertGetId([
                        'name' => $name,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('roof_rack_products')->where('product_id', $product->product_id)->update([
                    'manufacturer_id' => $manufacturerIds[$key],
                ]);
            });
    }
};
