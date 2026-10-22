<?php

namespace App\Console\Commands;

use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\OrderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArchiveCallbackRequests extends Command
{
    protected $signature = 'callbacks:archive';

    protected $description = 'Remove callback personal data after 90 days and keep a record without contacts';

    public function handle(): int
    {
        $now = now();
        $cutoff = $now->copy()->subDays(90);
        $count = 0;
        CallbackRequest::query()->whereNull('anonymized_at')->where('created_at', '<=', $cutoff)
            ->select('id')->chunkById(100, function ($records) use ($cutoff, $now, &$count) {
                foreach ($records as $record) {
                    $count += DB::transaction(function () use ($record, $cutoff, $now) {
                        // Match the notification worker's lock order before clearing the callback.
                        $notifications = OrderNotification::query()->where('callback_request_id', $record->id)
                            ->orderBy('id')->lockForUpdate()->get();
                        $callback = CallbackRequest::query()->lockForUpdate()->find($record->id);
                        if (! $callback || $callback->anonymized_at || $callback->created_at->greaterThan($cutoff)) {
                            return 0;
                        }

                        $callback->forceFill([
                            'name' => 'Контактные данные удалены',
                            'phone' => '',
                            'consent_accepted_at' => null,
                            'consent_version' => null,
                            'consent_text' => null,
                            'archived_at' => $callback->archived_at ?? $now,
                            'anonymized_at' => $now,
                        ])->save();

                        AdminActivityLog::query()->where('subject_type', 'callback_request')
                            ->where('subject_id', $callback->id)->delete();
                        OrderNotification::query()->whereKey($notifications->modelKeys())->delete();

                        return 1;
                    });
                }
            });

        $this->components->info("Очищено заявок: {$count}");

        return self::SUCCESS;
    }
}
