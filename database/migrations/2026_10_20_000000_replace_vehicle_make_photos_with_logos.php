<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $logos = json_decode(file_get_contents(database_path('data/vehicle_make_logos.json')), true, flags: JSON_THROW_ON_ERROR);

        foreach ($logos as $slug => $logo) {
            // Заменяем только фотографии, назначенные импортом, сохраняя ручные изменения.
            DB::table('vehicle_makes')
                ->where('slug', $slug)
                ->where('image_path', 'like', 'images/catalog/autobagazhniki/models/'.$slug.'/%')
                ->update(['image_path' => $logo['image_path'], 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        // Сохраняем логотипы и последующие изменения администратора.
    }
};
