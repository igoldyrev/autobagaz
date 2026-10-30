<?php

namespace App\Console\Commands;

use App\Services\MonitoringHeartbeats;
use App\Services\OrderReservations;
use Illuminate\Console\Command;

class ExpireOrderReservations extends Command
{
    protected $signature = 'orders:expire-reservations';

    protected $description = 'Освободить неоплаченные резервы, срок которых истёк';

    public function handle(OrderReservations $reservations, MonitoringHeartbeats $heartbeats): int
    {
        $count = $reservations->expireDue();
        $heartbeats->succeed('expire_reservations');
        $this->components->info('Освобождено резервов: '.$count);

        return self::SUCCESS;
    }
}
