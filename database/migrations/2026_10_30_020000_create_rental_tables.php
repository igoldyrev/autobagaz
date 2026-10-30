<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('conditions');
            $table->boolean('is_available')->default(true);
            $table->json('groups');
            $table->json('rates');
            $table->string('contract_path')->nullable();
            $table->string('rules_path')->nullable();
            $table->timestamps();
        });
        DB::table('rental_services')->insert([
            'id' => 1,
            'name' => 'Прокат багажников и боксов в Перми',
            'description' => 'Аренда автобоксов, багажников, велокреплений, лыжных креплений и другого багажного оборудования для разовых поездок и путешествий.',
            'conditions' => 'Стоимость рассчитывается в календарных днях, включая день получения и возврата. Монтаж и демонтаж оплачиваются отдельно. Оборудование, сроки и залог согласовываются с менеджером. Денежный залог можно зачесть в стоимость выкупа; аренда оплачивается отдельно.',
            'is_available' => true,
            'groups' => json_encode(['Дуги багажника, крепления для велосипеда на крышу, лыж, лодки, браслеты противоскольжения', 'Автобокс, велокрепление на фаркоп или заднюю дверь, цепи противоскольжения'], JSON_UNESCAPED_UNICODE),
            'rates' => json_encode([['min_days' => 1, 'max_days' => 14, 'prices' => [130, 270]], ['min_days' => 15, 'max_days' => 21, 'prices' => [110, 240]], ['min_days' => 22, 'max_days' => null, 'prices' => [90, 210]]]),
            'created_at' => now(), 'updated_at' => now(),
        ]);
        Schema::create('rental_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('submission_token')->unique();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 120);
            $table->string('phone', 32);
            $table->string('vehicle')->nullable();
            $table->text('comment')->nullable();
            $table->json('original_request');
            $table->string('equipment');
            $table->unsignedInteger('quantity');
            $table->date('starts_on');
            $table->date('ends_on');
            $table->decimal('daily_price', 12, 2);
            $table->decimal('rental_total', 12, 2);
            $table->decimal('rental_paid', 12, 2)->default(0);
            $table->decimal('buyout_price', 12, 2)->default(0);
            $table->string('status')->default('new')->index();
            $table->string('deposit_type')->nullable();
            $table->string('deposit_document')->nullable();
            $table->decimal('deposit_required', 12, 2)->default(0);
            $table->decimal('deposit_received', 12, 2)->default(0);
            $table->decimal('deposit_returned', 12, 2)->default(0);
            $table->decimal('deposit_withheld', 12, 2)->default(0);
            $table->decimal('deposit_applied', 12, 2)->default(0);
            $table->decimal('buyout_paid', 12, 2)->default(0);
            $table->timestamp('deposit_received_at')->nullable();
            $table->timestamp('deposit_returned_at')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->timestamp('consent_accepted_at');
            $table->string('consent_version');
            $table->text('consent_text');
            $table->timestamp('response_due_at')->nullable();
            $table->timestamp('first_response_at')->nullable();
            $table->unsignedBigInteger('first_response_by')->nullable();
            $table->string('first_response_by_name')->nullable();
            $table->timestamp('response_stopped_at')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_requests');
        Schema::dropIfExists('rental_services');
    }
};
