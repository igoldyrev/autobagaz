<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->string('access_token', 64)->nullable()->unique();
        });

        DB::table('orders')->select('id')->orderBy('id')->chunkById(100, function ($orders): void {
            foreach ($orders as $order) {
                DB::table('orders')->where('id', $order->id)->update([
                    'access_token' => bin2hex(random_bytes(32)),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropUnique(['access_token']);
            $table->dropColumn('access_token');
        });
    }
};
