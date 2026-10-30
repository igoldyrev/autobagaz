<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/** Integration boundary: call only after checking the provider signature and retrieving its authoritative payment status. */
class OrderPayments
{
    public function confirm(Order $order, string $provider, string $reference, string $amount, string $currency = 'RUB'): void
    {
        $this->record($order, $provider, $reference, $amount, $currency, 'captured');
    }

    public function refund(Order $order, string $provider, string $reference, string $amount, string $currency = 'RUB'): void
    {
        $this->record($order, $provider, $reference, $amount, $currency, 'refunded');
    }

    private function record(Order $order, string $provider, string $reference, string $amount, string $currency, string $type): void
    {
        if (! in_array($provider, ['sberbank', 'yookassa'], true) || $reference === '' || strlen($reference) > 128 || $currency !== 'RUB' || ! preg_match('/^\d{1,10}\.\d{2}$/D', $amount)) {
            $this->fail('Некорректное подтверждение платёжного провайдера.');
        }
        DB::transaction(function () use ($order, $provider, $reference, $amount, $type) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            $event = DB::table('order_payment_events')->where(compact('provider', 'reference', 'type'))->first();
            if ($event) {
                if ((int) $event->order_id !== $locked->id || number_format((float) $event->amount, 2, '.', '') !== $amount) {
                    $this->fail('Подтверждение оплаты уже связано с другой операцией.');
                }

                return;
            }
            if (! $locked->reservation_started_at) {
                $this->fail('Этот заказ создан до подключения резервирования. Требуется отдельная сверка оплаты.');
            }
            if ($type === 'captured') {
                $latest = $locked->latestTermsVersion;
                $expected = $locked->acceptedTermsVersion?->goods_total ?? $locked->total;
                if ($locked->payment_status !== 'unpaid' || ($latest && ! $latest->accepted_at) || $amount !== $expected) {
                    $this->fail('Статус оплаты или сумма не соответствует согласованной стоимости заказа. Нужна сверка платежа.');
                }
            } elseif ($locked->payment_status !== 'paid' || $amount !== $locked->paid_amount) {
                $this->fail('Автоматически поддерживается полный возврат подтверждённой оплаты. Частичный возврат требует отдельной сверки.');
            }
            DB::table('order_payment_events')->insert([
                'order_id' => $locked->id, 'provider' => $provider, 'reference' => $reference, 'type' => $type,
                'amount' => $amount, 'created_at' => now(), 'updated_at' => now(),
            ]);
            $reservations = app(OrderReservations::class);
            $reservations->expireLocked($locked);
            if ($type === 'captured') {
                $locked->forceFill(['payment_status' => 'paid', 'paid_amount' => $amount, 'paid_at' => now()])->save();
                if (! $locked->isClosed() && $locked->status !== Order::STATUS_SHIPPED) {
                    $locked->reservations()->where('state', 'active')->where('expires_at', '>', now())->update(['state' => 'paid', 'expires_at' => null]);
                }
                $reservations->log($locked, 'Оплата подтверждена провайдером. Статус: «Оплачен». Сумма: '.$amount.' ₽. Действующий резерв сохранён до выдачи.');
                if ($locked->isClosed() || $locked->reservation_expires_at->lessThanOrEqualTo(now())) {
                    $reservations->log($locked, 'Оплата получена после истечения резерва или закрытия заказа. Требуется проверка менеджером; чужие резервы не затронуты.');
                }
            } else {
                $locked->forceFill(['payment_status' => 'refunded'])->save();
                $reservations->release($locked, 'Полный возврат оплаты');
                $reservations->log($locked, 'Провайдер подтвердил полный возврат оплаты. Физический остаток не увеличен: возврат товара принимается отдельно.');
            }
        });
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['payment' => $message]);
    }
}
