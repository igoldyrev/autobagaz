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

    public function defaultAssigneeId(): ?int
    {
        $id = config('orders.default_assignee_id');
        $candidates = User::query()->where('is_admin', true)
            ->when($id, fn ($query) => $query->whereKey($id), fn ($query) => $query->where('name', config('orders.default_assignee_name')))
            ->get()->filter(fn (User $user) => $user->hasPermission(User::PERMISSION_ORDERS));

        return $candidates->count() === 1 ? $candidates->first()->id : null;
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
            if ($locked instanceof CallbackRequest && $locked->anonymized_at) {
                throw ValidationException::withMessages(['status' => 'Контактные данные заявки удалены. Изменение обработки недоступно.']);
            }
            $changes = [];
            $previousStatus = $locked->status;

            if (isset($data['status'])) {
                if ($locked->status !== $data['expected_status']) {
                    throw ValidationException::withMessages(['status' => 'Запись уже изменена другим сотрудником. Обновите страницу.']);
                }
                $target = $data['status'];
                $reopen = $locked->isClosed() && $target === 'in_progress' && $actor->canReopenOrders();
                if (! array_key_exists($target, $locked->availableActions()) && ! $reopen) {
                    throw ValidationException::withMessages(['status' => 'Этот переход статуса недоступен.']);
                }
                if ($locked instanceof Order && in_array($target, [Order::STATUS_READY, Order::STATUS_SHIPPED, Order::STATUS_COMPLETED], true)) {
                    if (($locked->latestTermsVersion?->version ?? 0) !== (int) ($data['expected_terms_version'] ?? 0)) {
                        throw ValidationException::withMessages(['expected_terms_version' => 'Условия заказа изменились. Обновите страницу перед продолжением обработки.']);
                    }
                    if ($target === Order::STATUS_COMPLETED && ! ($data['fulfillment_confirmed'] ?? false)) {
                        throw ValidationException::withMessages(['fulfillment_confirmed' => 'Подтвердите получение всего заказа покупателем или завершение установки в магазине.']);
                    }
                }
                if ($target === 'cancelled' && trim($data['cancellation_reason'] ?? '') === '') {
                    throw ValidationException::withMessages(['cancellation_reason' => 'Укажите причину отмены.']);
                }
                $previousLabel = $locked->statusLabel();
                if ($target === 'in_progress' && ! $locked->assignee_id) {
                    $data['assignee_id'] = $actor->id;
                }
                $locked->status = $target;
                if (! $locked->first_response_at) {
                    $locked->response_stopped_at = $locked->isClosed() ? now() : null;
                }
                $changes[] = 'Статус: «'.$previousLabel.'» → «'.$locked->statusLabel().'»';
                if ($target === 'cancelled') {
                    $changes[] = 'Причина отмены: '.trim($data['cancellation_reason']);
                }
                if ($locked instanceof Order && $target === Order::STATUS_COMPLETED) {
                    $changes[] = 'Менеджер подтвердил получение всего заказа покупателем или завершение установки в магазине';
                }
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

            if (isset($data['contact_result'])) {
                if ($locked->isClosed() || ! in_array($data['contact_result'], ['reached', 'not_reached'], true)) {
                    throw ValidationException::withMessages(['contact_result' => 'Фиксация контакта недоступна.']);
                }
                if (trim($data['internal_comment'] ?? '') === '') {
                    throw ValidationException::withMessages(['internal_comment' => 'Кратко опишите результат контакта.']);
                }
                if ($data['contact_result'] === 'reached') {
                    if ($locked->first_response_at) {
                        throw ValidationException::withMessages(['contact_result' => 'Первый контакт уже зафиксирован. Обновите страницу.']);
                    }
                    $locked->first_response_at = now();
                    $locked->first_response_by = $actor->id;
                    $locked->first_response_by_name = $actor->name;
                    $changes[] = 'Первый контакт с покупателем состоялся';
                } else {
                    $changes[] = 'Попытка связаться с покупателем: контакт не состоялся';
                }
            }

            if (trim($data['internal_comment'] ?? '') !== '') {
                $changes[] = 'Внутренний комментарий: '.trim($data['internal_comment']);
            }

            if ($changes === []) {
                return;
            }
            $locked->save();
            app(AdminActivityLogger::class)->record($actor, AdminActivityLog::ACTION_UPDATED, implode('. ', $changes),
                $locked instanceof Order ? 'order' : 'callback_request', $locked->id,
                $locked instanceof Order ? $locked->number : $locked->name);
            if ($locked instanceof Order && app(OrderNotifications::class)->recordStatusChange($locked, $previousStatus)) {
                DB::afterCommit(fn () => app(OrderNotifications::class)->dispatchPending(orderId: $locked->id));
            }
        });
    }
}
