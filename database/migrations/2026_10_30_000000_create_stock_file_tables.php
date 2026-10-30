<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_file_exports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->longText('products');
            $table->timestamps();
        });

        Schema::create('stock_file_imports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('stock_file_export_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('filename');
            $table->longText('changes');
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_file_imports');
        Schema::dropIfExists('stock_file_exports');
    }
};
