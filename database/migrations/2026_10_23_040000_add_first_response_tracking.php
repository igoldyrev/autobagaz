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
                $table->timestamp('response_due_at')->nullable()->index();
                $table->timestamp('first_response_at')->nullable();
                $table->foreignId('first_response_by')->nullable()->constrained('users')->nullOnDelete();
                $table->string('first_response_by_name')->nullable();
                $table->timestamp('response_stopped_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['orders', 'callback_requests'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropConstrainedForeignId('first_response_by');
                $table->dropIndex(['response_due_at']);
                $table->dropColumn(['response_due_at', 'first_response_at', 'first_response_by_name', 'response_stopped_at']);
            });
        }
    }
};
