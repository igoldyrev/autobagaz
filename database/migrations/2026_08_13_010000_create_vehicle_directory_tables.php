<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_makes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_make_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['vehicle_make_id', 'slug']);
            $table->index(['vehicle_make_id', 'is_active', 'sort_order']);
        });

        Schema::create('catalog_category_vehicle_make', function (Blueprint $table) {
            $table->foreignId('catalog_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_make_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->primary(['catalog_category_id', 'vehicle_make_id']);
            $table->index(
                ['catalog_category_id', 'sort_order'],
                'ccvm_category_sort_idx',
            );
        });

        $this->migrateLegacyCategories();
    }

    public function down(): void
    {
        $this->restoreLegacyCategories();

        Schema::dropIfExists('catalog_category_vehicle_make');
        Schema::dropIfExists('vehicle_models');
        Schema::dropIfExists('vehicle_makes');
    }

    private function migrateLegacyCategories(): void
    {
        $legacyMakes = DB::table('catalog_categories')
            ->where('kind', 'vehicle_make')
            ->orderBy('id')
            ->get();

        foreach ($legacyMakes as $legacyMake) {
            $vehicleMakeId = DB::table('vehicle_makes')->insertGetId([
                'name' => $legacyMake->name,
                'slug' => $legacyMake->slug,
                'description' => $legacyMake->description,
                'image_path' => $legacyMake->image_path,
                'image_alt' => $legacyMake->image_alt,
                'meta_title' => $legacyMake->meta_title,
                'meta_description' => $legacyMake->meta_description,
                'is_active' => $legacyMake->is_active,
                'created_at' => $legacyMake->created_at,
                'updated_at' => $legacyMake->updated_at,
            ]);

            DB::table('catalog_category_vehicle_make')->insert([
                'catalog_category_id' => $legacyMake->parent_id,
                'vehicle_make_id' => $vehicleMakeId,
                'sort_order' => $legacyMake->sort_order,
                'created_at' => $legacyMake->created_at,
                'updated_at' => $legacyMake->updated_at,
            ]);

            DB::table('catalog_categories')
                ->where('parent_id', $legacyMake->id)
                ->where('kind', 'vehicle_model')
                ->orderBy('id')
                ->each(function (object $legacyModel) use ($vehicleMakeId): void {
                    DB::table('vehicle_models')->insert([
                        'vehicle_make_id' => $vehicleMakeId,
                        'name' => $legacyModel->name,
                        'slug' => $legacyModel->slug,
                        'description' => $legacyModel->description,
                        'image_path' => $legacyModel->image_path,
                        'image_alt' => $legacyModel->image_alt,
                        'meta_title' => $legacyModel->meta_title,
                        'meta_description' => $legacyModel->meta_description,
                        'sort_order' => $legacyModel->sort_order,
                        'is_active' => $legacyModel->is_active,
                        'created_at' => $legacyModel->created_at,
                        'updated_at' => $legacyModel->updated_at,
                    ]);
                });
        }

        DB::table('catalog_categories')->where('kind', 'vehicle_model')->delete();
        DB::table('catalog_categories')->where('kind', 'vehicle_make')->delete();
    }

    private function restoreLegacyCategories(): void
    {
        DB::table('catalog_category_vehicle_make')
            ->join('vehicle_makes', 'vehicle_makes.id', '=', 'catalog_category_vehicle_make.vehicle_make_id')
            ->select('catalog_category_vehicle_make.*', 'vehicle_makes.name', 'vehicle_makes.slug', 'vehicle_makes.description', 'vehicle_makes.image_path', 'vehicle_makes.image_alt', 'vehicle_makes.meta_title', 'vehicle_makes.meta_description', 'vehicle_makes.is_active')
            ->orderBy('catalog_category_vehicle_make.catalog_category_id')
            ->orderBy('catalog_category_vehicle_make.sort_order')
            ->get()
            ->each(function (object $make): void {
                $legacyMakeId = DB::table('catalog_categories')->insertGetId([
                    'parent_id' => $make->catalog_category_id,
                    'kind' => 'vehicle_make',
                    'name' => $make->name,
                    'slug' => $make->slug,
                    'description' => $make->description,
                    'image_path' => $make->image_path,
                    'image_alt' => $make->image_alt,
                    'meta_title' => $make->meta_title,
                    'meta_description' => $make->meta_description,
                    'sort_order' => $make->sort_order,
                    'is_active' => $make->is_active,
                    'created_at' => $make->created_at,
                    'updated_at' => $make->updated_at,
                ]);

                DB::table('vehicle_models')
                    ->where('vehicle_make_id', $make->vehicle_make_id)
                    ->orderBy('sort_order')
                    ->get()
                    ->each(function (object $model) use ($legacyMakeId): void {
                        DB::table('catalog_categories')->insert([
                            'parent_id' => $legacyMakeId,
                            'kind' => 'vehicle_model',
                            'name' => $model->name,
                            'slug' => $model->slug,
                            'description' => $model->description,
                            'image_path' => $model->image_path,
                            'image_alt' => $model->image_alt,
                            'meta_title' => $model->meta_title,
                            'meta_description' => $model->meta_description,
                            'sort_order' => $model->sort_order,
                            'is_active' => $model->is_active,
                            'created_at' => $model->created_at,
                            'updated_at' => $model->updated_at,
                        ]);
                    });
            });
    }
};
