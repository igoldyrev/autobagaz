<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalService extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['groups' => 'array', 'rates' => 'array', 'is_available' => 'boolean'];
    }

    public static function current(): self
    {
        return static::query()->findOrFail(1);
    }

    public function documentUrl(string $kind): string
    {
        return route('rental.document', $kind);
    }

    public function dailyPrice(int $group, int $days): string
    {
        foreach ($this->rates as $rate) {
            if ($days >= $rate['min_days'] && ($rate['max_days'] === null || $days <= $rate['max_days'])) {
                return number_format((float) $rate['prices'][$group], 2, '.', '');
            }
        }
        throw new \LogicException('Для срока проката не задан тариф.');
    }
}
