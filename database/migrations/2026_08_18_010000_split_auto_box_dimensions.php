<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auto_box_products', function (Blueprint $table) {
            $table->decimal('length_cm', 7, 1)->nullable();
            $table->decimal('width_cm', 7, 1)->nullable();
            $table->decimal('height_cm', 7, 1)->nullable();
        });

        DB::table('auto_box_products')
            ->whereNotNull('dimensions_cm')
            ->orderBy('product_id')
            ->each(function (object $autoBox): void {
                $parts = preg_split('/\s*[×xх*]\s*/ui', trim($autoBox->dimensions_cm));

                if (count($parts) !== 3) {
                    return;
                }

                $dimensions = array_map(
                    fn (string $value): string => str_replace(',', '.', preg_replace('/[^\d,.]/u', '', $value)),
                    $parts,
                );

                if (collect($dimensions)->contains(fn (string $value): bool => $value === '' || ! is_numeric($value))) {
                    return;
                }

                DB::table('auto_box_products')->where('product_id', $autoBox->product_id)->update([
                    'length_cm' => $dimensions[0],
                    'width_cm' => $dimensions[1],
                    'height_cm' => $dimensions[2],
                ]);
            });

        Schema::table('auto_box_products', function (Blueprint $table) {
            $table->dropColumn('dimensions_cm');
        });
    }

    public function down(): void
    {
        Schema::table('auto_box_products', function (Blueprint $table) {
            $table->string('dimensions_cm')->nullable();
        });

        DB::table('auto_box_products')->orderBy('product_id')->each(function (object $autoBox): void {
            $dimensions = collect([$autoBox->length_cm, $autoBox->width_cm, $autoBox->height_cm]);

            if ($dimensions->every(fn ($value): bool => $value !== null)) {
                DB::table('auto_box_products')->where('product_id', $autoBox->product_id)->update([
                    'dimensions_cm' => $dimensions->map(fn ($value): string => rtrim(rtrim((string) $value, '0'), '.'))->implode(' × '),
                ]);
            }
        });

        Schema::table('auto_box_products', function (Blueprint $table) {
            $table->dropColumn(['length_cm', 'width_cm', 'height_cm']);
        });
    }
};
