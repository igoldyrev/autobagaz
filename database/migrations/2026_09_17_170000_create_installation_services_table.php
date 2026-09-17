<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installation_services', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->string('description', 500)->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('installation_services')->insert([
            'name' => 'Установка в магазине',
            'price' => 2500,
            'description' => 'По предварительной записи.',
            'is_available' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('installation_services');
    }
};
