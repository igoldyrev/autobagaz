<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    private const PREFIX = 'Предварительное поколение:';

    public function up(): void
    {
        DB::table('vehicle_generations')
            ->where('name', 'like', self::PREFIX.'%')
            ->orderBy('id')
            ->chunkById(200, function ($generations): void {
                foreach ($generations as $generation) {
                    DB::table('vehicle_generations')
                        ->where('id', $generation->id)
                        ->update(['name' => trim(Str::after($generation->name, self::PREFIX))]);
                }
            });
    }

    public function down(): void
    {
        DB::table('vehicle_generations')
            ->where('slug', 'like', 'legacy-%')
            ->where('name', 'not like', self::PREFIX.'%')
            ->orderBy('id')
            ->chunkById(200, function ($generations): void {
                foreach ($generations as $generation) {
                    DB::table('vehicle_generations')
                        ->where('id', $generation->id)
                        ->update(['name' => self::PREFIX.' '.$generation->name]);
                }
            });
    }
};
