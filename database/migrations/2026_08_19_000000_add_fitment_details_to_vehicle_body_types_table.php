<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_body_types', function (Blueprint $table) {
            $table->string('source_name')->nullable()->after('name');
            $table->string('year_label')->nullable()->after('slug');
            $table->string('mounting_type')->nullable()->after('year_label');
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_body_types', function (Blueprint $table) {
            $table->dropColumn(['source_name', 'year_label', 'mounting_type']);
        });
    }
};
