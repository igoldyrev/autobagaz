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
                $table->timestamp('consent_accepted_at')->nullable();
                $table->string('consent_version', 32)->nullable();
                $table->longText('consent_text')->nullable();
            });
        }

        Schema::table('callback_requests', function (Blueprint $table) {
            $table->timestamp('archived_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('callback_requests', function (Blueprint $table) {
            $table->dropIndex(['archived_at']);
            $table->dropColumn('archived_at');
        });

        foreach (['orders', 'callback_requests'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropColumn(['consent_accepted_at', 'consent_version', 'consent_text']);
            });
        }
    }
};
