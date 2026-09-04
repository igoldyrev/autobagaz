<?php

use App\Models\AdminActivityLog;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(fn () => AdminActivityLog::query()->olderThanRetentionPeriod()->delete())
    ->dailyAt('03:00')
    ->name('prune-admin-activity-log');
