<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_heartbeats', function (Blueprint $table) {
            $table->string('task')->primary();
            $table->timestamp('last_succeeded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_heartbeats');
    }
};
