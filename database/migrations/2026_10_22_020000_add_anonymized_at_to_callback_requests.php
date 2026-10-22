<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('callback_requests', function (Blueprint $table) {
            $table->timestamp('anonymized_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('callback_requests', function (Blueprint $table) {
            $table->dropIndex(['anonymized_at']);
            $table->dropColumn('anonymized_at');
        });
    }
};
