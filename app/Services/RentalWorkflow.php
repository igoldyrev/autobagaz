<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\RentalRequest;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RentalWorkflow
{
    public function update(RentalRequest $record, User $actor, array $data): void
    {
        DB::transaction(function () use ($record, $actor, $data): void {
            $r = RentalRequest::query()->lockForUpdate()->findOrFail($record->id);
            $this->check($r->version === (int) $data['version'], 'Заявка уже изменена. Обновите страницу перед продолжением.');
            $action = $data['action'];
            $note = trim($data['note'] ?? '');
            $this->check(! $r->isClosed() || $action === 'comment', 'Заявка закрыта.');
            $description = '';
            $amount = RentalRequest::cents($data['amount'] ?? 0);
            switch ($action) {
                case 'terms':
                    $this->check(in_array($r->status, ['new', 'in_progress'], true) && ! $r->deposit_received_at && RentalRequest::cents($r->rental_paid) === 0, 'Условия доступны до подтверждения, получения залога и оплаты аренды.');
                    $days = (int) CarbonImmutable::parse($data['starts_on'])->diffInDays(CarbonImmutable::parse($data['ends_on'])) + 1;
                    $this->check($days <= 731, 'Срок проката не может превышать 731 день.');
                    $fields = array_intersect_key($data, array_flip(['equipment', 'quantity', 'starts_on', 'ends_on', 'daily_price', 'buyout_price', 'deposit_type', 'deposit_required', 'deposit_document']));
                    if ($data['deposit_type'] === 'money') {
                        $this->check(RentalRequest::cents($data['deposit_required']) > 0, 'Укажите положительную сумму залога.');
                        $fields['deposit_document'] = null;
                    } else {
                        $fields['deposit_required'] = '0.00';
                    }
                    $fields['rental_total'] = $this->money(RentalRequest::cents($data['daily_price']) * $days * $data['quantity']);
                    $this->check(RentalRequest::cents($fields['rental_total']) <= 999999999999, 'Стоимость аренды превышает допустимую сумму.');
                    $r->fill($fields);
                    $description = 'Условия проката: '.$r->equipment.' × '.$r->quantity.'; '.$data['starts_on'].' — '.$data['ends_on'].'; тариф '.$r->daily_price.' ₽/день; аренда '.$r->rental_total.' ₽; выкуп '.$r->buyout_price.' ₽; залог '.($r->deposit_type === 'money' ? $r->deposit_required.' ₽' : $r->deposit_document);
                    break;
                case 'assign':
                    $manager = User::query()->findOrFail($data['assignee_id']);
                    $this->check($manager->is_admin && $manager->hasPermission(User::PERMISSION_ORDERS), 'Выберите сотрудника с правом обработки заказов.');
                    $r->assignee_id = $manager->id;
                    $description = 'Ответственный: '.$manager->name;
                    break;
                case 'comment':
                    $description = 'Внутренний комментарий';
                    break;
                case 'contact':
                case 'contact_failed':
                    if ($action === 'contact' && ! $r->first_response_at) {
                        $r->first_response_at = now();
                        $r->first_response_by = $actor->id;
                        $r->first_response_by_name = $actor->name;
                    }
                    $description = $action === 'contact' ? 'Связался с покупателем' : 'Не удалось связаться';
                    break;
                case 'receive_deposit':
                    $this->check($r->status === 'confirmed' && ! $r->deposit_received_at && in_array($r->deposit_type, ['money', 'document'], true), 'Получение залога недоступно.');
                    if ($r->deposit_type === 'money') {
                        $this->check($amount === RentalRequest::cents($r->deposit_required) && $amount > 0, 'Полученный залог должен соответствовать согласованной сумме.');
                        $r->deposit_received = $this->money($amount);
                    }
                    $r->deposit_received_at = now();
                    $description = 'Получен залог: '.($r->deposit_type === 'money' ? $r->deposit_received.' ₽' : $r->deposit_document);
                    break;
                case 'return_deposit':
                    $this->check($r->deposit_received_at !== null && in_array($r->status, ['confirmed', 'returned'], true), 'Возврат залога доступен до выдачи или после возврата оборудования.');
                    if ($r->deposit_type === 'money') {
                        $this->check($amount > 0 && $amount <= $r->depositBalance(), 'Сумма возврата превышает остаток залога либо равна нулю.');
                        $r->deposit_returned = $this->money(RentalRequest::cents($r->deposit_returned) + $amount);
                        $description = 'Возвращён денежный залог: '.$this->money($amount).' ₽';
                    } else {
                        $this->check(! $r->deposit_returned_at, 'Документ уже возвращён.');
                        $description = 'Возвращён документ: '.$r->deposit_document;
                    }
                    if ($r->deposit_type === 'document' || $r->depositBalance() === 0) {
                        $r->deposit_returned_at = now();
                    }
                    break;
                case 'withhold_deposit':
                    $this->check($r->status === 'returned' && $r->deposit_type === 'money' && $amount > 0 && $amount <= $r->depositBalance(), 'Удержание доступно после возврата оборудования в пределах остатка денежного залога.');
                    $r->deposit_withheld = $this->money(RentalRequest::cents($r->deposit_withheld) + $amount);
                    $description = 'Удержано из залога: '.$this->money($amount).' ₽';
                    break;
                case 'extend':
                    $this->check($r->status === 'rented', 'Продление доступно только во время проката.');
                    $end = CarbonImmutable::parse($data['ends_on']);
                    $days = (int) $r->starts_on->diffInDays($end) + 1;
                    $this->check($data['ends_on'] > $r->ends_on->toDateString() && $days <= 731, 'Новая дата должна быть позже текущей; срок — не более 731 дня.');
                    $total = RentalRequest::cents($r->daily_price) * $days * $r->quantity;
                    $this->check($total <= 999999999999, 'Стоимость аренды превышает допустимую сумму.');
                    $r->ends_on = $data['ends_on'];
                    $r->rental_total = $this->money($total);
                    $description = 'Прокат продлён до '.$data['ends_on'].' по согласованному тарифу '.$r->daily_price.' ₽/день; аренда '.$r->rental_total.' ₽';
                    break;
                case 'rental_refund':
                    $this->check($r->status === 'confirmed' && $amount > 0 && $amount <= RentalRequest::cents($r->rental_paid), 'Возврат оплаты доступен до выдачи в пределах полученной суммы.');
                    $r->rental_paid = $this->money(RentalRequest::cents($r->rental_paid) - $amount);
                    $description = 'Возвращена оплата аренды: '.$this->money($amount).' ₽';
                    break;
                case 'rental_payment':
                    $this->check(in_array($r->status, ['confirmed', 'rented', 'returned'], true) && $amount > 0 && $amount <= RentalRequest::cents($r->rental_total) - RentalRequest::cents($r->rental_paid), 'Укажите оплату в пределах неоплаченной стоимости аренды.');
                    $r->rental_paid = $this->money(RentalRequest::cents($r->rental_paid) + $amount);
                    $description = 'Получена оплата аренды: '.$this->money($amount).' ₽';
                    break;
                default:
                    $this->check(array_key_exists($action, $r->availableActions()), 'Этот переход недоступен.');
                    $old = $r->statusLabel();
                    $r->status = match ($action) {
                        'start', 'revise' => 'in_progress', 'confirm' => 'confirmed', 'issue' => 'rented',
                        'return_equipment' => 'returned', 'complete' => 'completed', 'cancel' => 'cancelled', 'purchase' => 'purchased',
                    };
                    if ($action === 'start' && ! $r->assignee_id) {
                        $r->assignee_id = $actor->id;
                    }
                    if ($action === 'confirm') {
                        $this->check(in_array($r->deposit_type, ['money', 'document'], true), 'Откройте блок «Условия проката и залога», выберите тип залога, укажите сумму или документ и нажмите «Сохранить условия». Затем подтвердите заявку.');
                    }
                    if ($action === 'revise') {
                        $this->check(! $r->deposit_received_at && RentalRequest::cents($r->rental_paid) === 0, 'После получения залога или оплаты изменение условий недоступно.');
                    }
                    if ($action === 'issue') {
                        $this->check($r->deposit_received_at && ! $r->deposit_returned_at && ($r->deposit_type === 'document' || $r->depositBalance() >= RentalRequest::cents($r->deposit_required)), 'Перед выдачей получите полный согласованный залог.');
                        $r->issued_at = now();
                    }
                    if ($action === 'return_equipment') {
                        $r->returned_at = now();
                    }
                    if ($action === 'complete' || $action === 'purchase') {
                        $this->check(RentalRequest::cents($r->rental_paid) === RentalRequest::cents($r->rental_total), 'Сначала закройте оплату аренды.');
                    }
                    if ($action === 'purchase') {
                        $this->check(RentalRequest::cents($r->buyout_price) > 0, 'Стоимость выкупа должна быть положительной.');
                        $paid = RentalRequest::cents($data['buyout_paid']);
                        $balance = $r->deposit_type === 'money' ? $r->depositBalance() : 0;
                        $price = RentalRequest::cents($r->buyout_price);
                        $this->check($paid === max(0, $price - $balance), 'Доплата должна равняться цене выкупа за вычетом денежного залога.');
                        if ($r->deposit_type === 'money') {
                            $r->deposit_applied = $this->money(min($balance, $price));
                            // Подтверждение выкупа включает фактический возврат излишка залога.
                            $r->deposit_returned = $this->money(RentalRequest::cents($r->deposit_returned) + max(0, $balance - $price));
                        }
                        $r->deposit_returned_at = now();
                        $r->buyout_paid = $this->money($paid);
                        $r->purchased_at = now();
                    }
                    if (in_array($action, ['complete', 'cancel'], true)) {
                        $this->check($r->depositSettled(), 'Сначала закройте расчёты по залогу или верните документ.');
                    }
                    if ($action === 'cancel') {
                        $this->check(RentalRequest::cents($r->rental_paid) === 0, 'При полученной оплате аренды отмена недоступна; требуется отдельное урегулирование возврата оплаты.');
                    }
                    if ($r->isClosed() && ! $r->first_response_at) {
                        $r->response_stopped_at = now();
                    }
                    $description = 'Статус: «'.$old.'» → «'.$r->statusLabel().'»';
                    if ($action === 'purchase') {
                        $description .= '; выкуп '.$r->buyout_price.' ₽; зачёт залога '.$r->deposit_applied.' ₽; доплата '.$r->buyout_paid.' ₽; возвращено из залога '.$r->deposit_returned.' ₽'.($r->deposit_type === 'document' ? '; документ возвращён' : '');
                    }
            }
            $r->version++;
            $r->save();
            app(AdminActivityLogger::class)->record(
                $actor, AdminActivityLog::ACTION_UPDATED,
                $description.($note !== '' ? '. '.$note : ''),
                'rental_request', $r->id, 'Прокат №'.$r->id,
            );
        });
    }

    private function check(bool $condition, string $message): void
    {
        if (! $condition) {
            throw ValidationException::withMessages(['action' => $message]);
        }
    }

    private function money(int $cents): string
    {
        return number_format($cents / 100, 2, '.', '');
    }
}
