<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const PREVIOUS_DESCRIPTION = 'Аренда автобоксов, багажников, велокреплений, лыжных креплений и другого багажного оборудования для разовых поездок и путешествий.';

    private const DESCRIPTION = "Случается так, что багажник, автобокс (бокс на крышу), велокрепление, лыжное крепление и другое багажное оборудование нужны разово или время от времени.\n\nВ этом случае удобно воспользоваться арендой багажного оборудования: быстро и надёжно закрепить лестницу или длинномерный груз, отправиться на отдых с автобоксом, перевезти велосипед либо установить лыжное крепление и защитить салон автомобиля от снега и грязи.\n\nВ сложных дорожных условиях, во время путешествия, охоты или рыбалки можно воспользоваться прокатом браслетов или цепей противоскольжения.";

    public function up(): void
    {
        DB::table('rental_services')->where('id', 1)->where('description', self::PREVIOUS_DESCRIPTION)
            ->update(['description' => self::DESCRIPTION, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('rental_services')->where('id', 1)->where('description', self::DESCRIPTION)
            ->update(['description' => self::PREVIOUS_DESCRIPTION, 'updated_at' => now()]);
    }
};
