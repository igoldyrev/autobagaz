<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class OrderResponseTime
{
    public function deadline(CarbonInterface $from): CarbonImmutable
    {
        $cursor = CarbonImmutable::instance($from)->timezone(config('orders.response_time.timezone'));
        $remaining = (int) config('orders.response_time.minutes') * 60;

        while (true) {
            [$opens, $closes] = $this->window($cursor);
            if ($opens !== null && $cursor->lessThan($closes)) {
                $cursor = $cursor->max($opens);
                $available = $cursor->diffInSeconds($closes);
                if ($remaining <= $available) {
                    return $cursor->addSeconds($remaining)->utc();
                }
                $remaining -= $available;
            }
            $cursor = $cursor->addDay()->startOfDay();
        }
    }

    public function workingMinutesBetween(CarbonInterface $from, CarbonInterface $to): int
    {
        $cursor = CarbonImmutable::instance($from)->timezone(config('orders.response_time.timezone'));
        $end = CarbonImmutable::instance($to)->timezone(config('orders.response_time.timezone'));
        $seconds = 0;
        while ($cursor->lessThan($end)) {
            [$opens, $closes] = $this->window($cursor);
            if ($opens !== null) {
                $start = $cursor->max($opens);
                $finish = $end->min($closes);
                if ($start->lessThan($finish)) {
                    $seconds += $start->diffInSeconds($finish);
                }
            }
            $cursor = $cursor->addDay()->startOfDay();
        }

        return (int) ceil($seconds / 60);
    }

    private function window(CarbonImmutable $day): array
    {
        foreach (config('orders.response_time.schedule') as $hours) {
            if (in_array($day->isoWeekday(), $hours['days'], true)) {
                return [$day->setTimeFromTimeString($hours['opens']), $day->setTimeFromTimeString($hours['closes'])];
            }
        }

        return [null, null];
    }
}
