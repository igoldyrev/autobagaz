<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auto_box_manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'name']);
        });

        Schema::table('auto_box_products', function (Blueprint $table) {
            $table->foreignId('manufacturer_id')
                ->nullable()
                ->constrained('auto_box_manufacturers')
                ->nullOnDelete();
        });

        $this->moveExistingManufacturers();
    }

    public function down(): void
    {
        DB::table('auto_box_products')
            ->join('auto_box_manufacturers', 'auto_box_manufacturers.id', '=', 'auto_box_products.manufacturer_id')
            ->select(['auto_box_products.product_id', 'auto_box_manufacturers.name'])
            ->orderBy('auto_box_products.product_id')
            ->each(function (object $manufacturer): void {
                DB::table('products')->where('id', $manufacturer->product_id)->update([
                    'manufacturer' => $manufacturer->name,
                ]);
            });

        Schema::table('auto_box_products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('manufacturer_id');
        });

        Schema::dropIfExists('auto_box_manufacturers');
    }

    private function moveExistingManufacturers(): void
    {
        $manufacturerIds = [];

        DB::table('auto_box_products')
            ->join('products', 'products.id', '=', 'auto_box_products.product_id')
            ->whereNotNull('products.manufacturer')
            ->where('products.manufacturer', '!=', '')
            ->select(['auto_box_products.product_id', 'products.manufacturer'])
            ->orderBy('auto_box_products.product_id')
            ->each(function (object $product) use (&$manufacturerIds): void {
                $name = trim($product->manufacturer);
                $key = mb_strtolower($name);

                if (! isset($manufacturerIds[$key])) {
                    $manufacturerIds[$key] = DB::table('auto_box_manufacturers')->insertGetId([
                        'name' => $name,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('auto_box_products')->where('product_id', $product->product_id)->update([
                    'manufacturer_id' => $manufacturerIds[$key],
                ]);
            });
    }
};
