<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_page_information', function (Blueprint $table): void {
            $table->id();
            $table->text('delivery_content');
            $table->text('payment_content');
            $table->text('warranty_content');
            $table->timestamps();
        });

        $now = now();
        DB::table('product_page_information')->insert([
            'delivery_content' => "Самовывоз\nЗаказ можно получить в магазине в Перми: ул. Дзержинского, 15. Перед визитом уточните наличие и резерв товара по телефону.\n\nДоставка\nДоставляем по Перми и отправляем заказы в другие регионы. Способ, срок и стоимость доставки менеджер согласует после уточнения товара и адреса получения.",
            'payment_content' => "Способ оплаты согласуется при подтверждении заказа. Доступные варианты зависят от способа получения товара. Перед оплатой менеджер подтвердит наличие, итоговую стоимость и условия получения.",
            'warranty_content' => "На товары действует гарантия производителя. Срок и условия зависят от бренда и указаны в сопроводительных документах к товару. Сохраняйте чек и документы о покупке на весь гарантийный срок.",
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('product_page_information');
    }
};
