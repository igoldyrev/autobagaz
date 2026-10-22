<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['orders', 'callback_requests'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        foreach (['orders', 'callback_requests'] as $name) {
            Schema::table($name, fn (Blueprint $table) => $table->dropConstrainedForeignId('assignee_id'));
        }
    }
};
