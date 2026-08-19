<?php

namespace App\Services;

class VehicleBodyTypeDetector
{
    /** @var array<string, array<string>> */
    private const PATTERNS = [
        'Седан' => ['седан', 'sedan'],
        'Универсал' => ['универсал', 'wagon', 'estate'],
        'Хэтчбек' => ['хэтчбек', 'хетчбек', 'hatchback'],
        'Лифтбек' => ['лифтбек', 'лифтбэк', 'liftback'],
        'Купе' => ['купе', 'coupe', 'coupé'],
        'Кабриолет' => ['кабриолет', 'cabriolet', 'convertible'],
        'Минивэн' => ['минивэн', 'минивен', 'minivan', 'mpv'],
        'Фургон' => ['фургон', 'van'],
        'Пикап' => ['пикап', 'pickup'],
        'Внедорожник' => ['внедорожник', 'джип', 'suv'],
        'Кроссовер' => ['кроссовер', 'crossover'],
        'Родстер' => ['родстер', 'roadster'],
        'Микроавтобус' => ['микроавтобус', 'minibus'],
    ];

    public function detect(string $value): ?string
    {
        return $this->detectAll($value)[0] ?? null;
    }

    /** @return array<string> */
    public function detectAll(string $value): array
    {
        $normalized = mb_strtolower(str_replace(['‑', '–', '—'], '-', $value));
        $detected = [];

        foreach (self::PATTERNS as $bodyType => $patterns) {
            foreach ($patterns as $pattern) {
                if (preg_match('/(?<![\p{L}\p{N}])'.preg_quote($pattern, '/').'(?![\p{L}\p{N}])/u', $normalized)) {
                    $detected[] = $bodyType;

                    break;
                }
            }
        }

        return $detected;
    }
}
