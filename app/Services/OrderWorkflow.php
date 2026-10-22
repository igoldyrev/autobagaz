<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderWorkflow
{
    public function managers(): Collection
    {
        return User::query()->where('is_admin', true)->orderBy('name')->get()
            ->filter(fn (User $user) => $user->hasPermission(User::PERMISSION_ORDERS));
    }

    public function history(Order|CallbackRequest $record): LengthAwarePaginator
    {
        return AdminActivityLog::query()->where('subject_type', $record instanceof Order ? 'order' : 'callback_request')
            ->where('subject_id', $record->id)->latest('id')->paginate(20);
    }

    public function update(Order|CallbackRequest $record, User $actor, array $data): void
    {
        DB::transaction(function () use ($record, $actor, $data) {
            $locked = $record->newQuery()->lockForUpdate()->findOrFail($record->id);
            $changes = [];

            if (isset($data['status'])) {
                if ($locked->status !== $data['expected_status']) {
                    throw ValidationException::withMessages(['status' => 'Запись уже изменена другим сотрудником. Обновите страницу.']);
                }
                $target = $data['status'];
                $reopen = $locked->isClosed() && $target === 'in_progress' && $actor->canReopenOrders();
                if (! array_key_exists($target, $locked->availableActions()) && ! $reopen) {
                    throw ValidationException::withMessages(['status' => 'Этот переход статуса недоступен.']);
                }
                $changes[] = 'Статус: «'.$locked->statusLabel().'» → «'.$locked::statusLabels()[$target].'»';
                if ($target === 'in_progress' && ($locked->status === 'new' || ! $locked->assignee_id)) {
                    $data['assignee_id'] = $actor->id;
                }
                $locked->status = $target;
            }

            if (array_key_exists('assignee_id', $data)) {
                $assignee = User::query()->find($data['assignee_id']);
                if (! $assignee || ! $assignee->is_admin || ! $assignee->hasPermission(User::PERMISSION_ORDERS)) {
                    throw ValidationException::withMessages(['assignee_id' => 'Выберите сотрудника с правом обработки заказов.']);
                }
                if ((int) $locked->assignee_id !== $assignee->id) {
                    $changes[] = 'Ответственный: «'.($locked->assignee?->name ?? 'Не назначен').'» → «'.$assignee->name.'»';
                    $locked->assignee_id = $assignee->id;
                }
            }

            if ($changes === []) {
                return;
            }
            $locked->save();
            app(AdminActivityLogger::class)->record($actor, AdminActivityLog::ACTION_UPDATED, implode('. ', $changes),
                $locked instanceof Order ? 'order' : 'callback_request', $locked->id,
                $locked instanceof Order ? $locked->number : $locked->name);
        });
    }
}
