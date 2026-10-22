<?php

use App\Models\AdminActivityLog;
use App\Services\MonitoringHeartbeats;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(fn () => AdminActivityLog::query()->olderThanRetentionPeriod()->delete())
    ->dailyAt('03:00')
    ->name('prune-admin-activity-log');

Schedule::command('orders:dispatch-notifications')->everyMinute()->withoutOverlapping();

Schedule::command('telegram:monitor-notifications')->everyFiveMinutes()->withoutOverlapping();

Schedule::call(fn () => app(MonitoringHeartbeats::class)->succeed('scheduler'))
    ->everyMinute()
    ->name('monitoring:scheduler-heartbeat');
