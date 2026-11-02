<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderReservations
{
    public const MINUTES = 15;

    /** Called inside checkout's transaction, after locking the products. */
    public function create(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            if ($locked->reservation_started_at) {
                return;
            }
            $locked->forceFill(['reservation_started_at' => now(), 'reservation_expires_at' => now()->addMinutes(self::MINUTES)])->save();
            $this->allocate($locked);
        }, 3);
        $order->refresh();
    }

    /** Original order items remain immutable; accepted terms define the current composition. */
    public function items(Order $order): array
    {
        $accepted = $order->acceptedTermsVersion;

        return $accepted ? $accepted->items : $order->items->map(fn ($item) => $item->only(['product_id', 'product_name', 'quantity', 'unit_price']))->all();
    }

    private function quantities(Order $order): array
    {
        $quantities = [];
        foreach ($this->items($order) as $item) {
            if ($item['product_id'] !== null && $item['quantity'] > 0) {
                $quantities[$item['product_id']] = ($quantities[$item['product_id']] ?? 0) + $item['quantity'];
            }
        }
        ksort($quantities);

        return $quantities;
    }

    /** Caller holds the order lock. Never extends the original deadline. */
    public function allocate(Order $order): void
    {
        if (! $order->reservation_started_at || $order->isClosed() || $order->status === Order::STATUS_SHIPPED) {
            return;
        }
        $this->expireLocked($order);
        if ($order->payment_status !== 'paid' && ! $order->reservation_expires_at->isFuture()) {
            return;
        }
        if ($order->payment_status === 'refunded') {
            return;
        }
        $quantities = $this->quantities($order);
        $existing = $order->reservations()->get()->keyBy('product_id');
        $ids = array_unique([...array_keys($quantities), ...$existing->keys()->all()]);
        $products = Product::query()->whereIn('id', $ids)->orderBy('id')->lockForUpdate()->get()->keyBy('id');
        foreach ($ids as $id) {
            $row = $existing[$id] ?? null;
            $product = $products[$id] ?? null;
            if (! $product) {
                $this->fail('Один из товаров удалён. Проверьте состав заказа.');
            }
            $own = $row && ($row->state === 'paid' || ($row->state === 'active' && $row->expires_at->isFuture())) ? $row->quantity : 0;
            $quantity = min(max(0, ($quantities[$id] ?? 0) - ($row?->fulfilled_quantity ?? 0)), max(0, $product->stock - $this->reservedQuantity($product)) + $own);
            if ($quantity === 0) {
                if ($own > 0) {
                    $row->update(['state' => 'released', 'released_at' => now()]);
                    $this->log($order, 'Освобождён резерв товара №'.$id.': '.$own.' шт.');
                }

                continue;
            }
            $state = $order->payment_status === 'paid' ? 'paid' : 'active';
            $attributes = ['quantity' => $quantity, 'state' => $state, 'expires_at' => $state === 'paid' ? null : $order->reservation_expires_at, 'released_at' => null];
            if ($row && $own === $quantity && $row->state === $state) {
                continue;
            }
            $order->reservations()->updateOrCreate(['product_id' => $id], $attributes);
            $this->log($order, 'Резерв товара №'.$id.': '.$quantity.' шт.'.($state === 'paid' ? ', сохранён после оплаты.' : ', до '.$order->reservation_expires_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i:s').'.'));
        }
        $order->unsetRelation('reservations');
    }

    public function reserveArrived(Order $order, User $actor): void
    {
        DB::transaction(function () use ($order, $actor) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            if ($locked->payment_status !== 'paid' || $locked->isClosed() || $locked->status === Order::STATUS_SHIPPED) {
                $this->fail('Поступившие товары можно резервировать только для открытого оплаченного заказа.');
            }
            $this->allocate($locked);
            $this->log($locked, 'Менеджер проверил резерв поступивших товаров.', $actor);
        });
    }

    public function canCollect(Order $order): bool
    {
        if (! $order->reservation_started_at || $order->payment_status !== 'paid' || $order->isClosed() || $order->status === Order::STATUS_SHIPPED) {
            return false;
        }
        $latest = $order->latestTermsVersion;
        if ($latest && ! $latest->accepted_at) {
            return false;
        }
        $quantities = $this->quantities($order);
        $reserved = $order->reservations->where('state', 'paid')->keyBy('product_id');
        foreach ($quantities as $id => $quantity) {
            $fulfilled = $order->reservations->firstWhere('product_id', $id)?->fulfilled_quantity ?? 0;
            if (($reserved->get($id)?->quantity ?? 0) < $quantity - $fulfilled) {
                return false;
            }
        }

        return $quantities !== [] && collect($quantities)->sum() > $order->reservations->sum('fulfilled_quantity');
    }

    public function assertPhysicalStock(Product $product, int $quantity): void
    {
        // All stock writers take this same product lock, including checkout and XLSX import.
        Product::query()->whereKey($product->id)->lockForUpdate()->firstOrFail();
        $reserved = $this->reservedQuantity($product);
        if ($quantity < $reserved) {
            throw ValidationException::withMessages(['stock' => 'Товар №'.$product->id.': физический остаток не может быть меньше действующего резерва ('.$reserved.' шт.).']);
        }
    }

    public function release(Order $order, string $reason): void
    {
        foreach ($order->reservations()->whereIn('state', ['active', 'paid'])->get() as $row) {
            $row->update(['state' => 'released', 'released_at' => now()]);
            $this->log($order, 'Освобождён резерв товара №'.$row->product_id.': '.$row->quantity.' шт. Причина: '.$reason);
        }
        $order->unsetRelation('reservations');
    }

    public function canFulfillPart(Order $order): bool
    {
        if (! $order->reservation_started_at || $order->payment_status !== 'paid' || $order->isClosed() || $order->status === Order::STATUS_SHIPPED) {
            return false;
        }
        if ($order->latestTermsVersion && ! $order->latestTermsVersion->accepted_at) {
            return false;
        }

        return $order->reservations->contains(fn ($row) => $row->state === 'paid' && $row->quantity > 0);
    }

    /** Caller holds the order lock; completion after shipment does not debit twice. */
    public function consume(Order $order): void
    {
        if (! $order->reservation_started_at || $order->status === Order::STATUS_SHIPPED) {
            return;
        }
        if (collect($this->quantities($order))->sum() > 0 && $order->reservations->sum('fulfilled_quantity') >= collect($this->quantities($order))->sum()) {
            return; // Reopening a fulfilled order must not debit it again.
        }
        if (! $this->canCollect($order)) {
            $this->fail('Для выдачи или отправки нужна подтверждённая оплата и резерв всего оставшегося состава заказа.');
        }
        $quantities = [];
        foreach ($this->quantities($order) as $id => $quantity) {
            $remaining = $quantity - ($order->reservations->firstWhere('product_id', $id)?->fulfilled_quantity ?? 0);
            if ($remaining > 0) {
                $quantities[$id] = $remaining;
            }
        }
        $this->consumeQuantities($order, $quantities);
    }

    public function fulfillPart(Order $order, User $actor, array $data): void
    {
        DB::transaction(function () use ($order, $actor, $data) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            if ($locked->status !== $data['expected_status'] || $locked->fulfillment_version !== (int) $data['expected_fulfillment_version']
                || ($locked->latestTermsVersion?->version ?? 0) !== (int) $data['expected_terms_version']) {
                $this->fail('Заказ, условия или выданное количество уже изменены. Обновите страницу.');
            }
            if (! $this->canFulfillPart($locked) || ! ($data['fulfilled'] ?? false)) {
                $this->fail('Передача доступна только для открытого оплаченного заказа с резервом и согласованными условиями. Подтвердите фактическую передачу.');
            }
            $quantities = [];
            foreach ($data['quantities'] as $id => $quantity) {
                if (! ctype_digit((string) $id) || (int) $id < 1 || (string) (int) $id !== (string) $id || filter_var($quantity, FILTER_VALIDATE_INT) === false || $quantity < 0) {
                    $this->fail('Некорректный товар или количество.');
                }
                if ($quantity > 0) {
                    $quantities[(int) $id] = (int) $quantity;
                }
            }
            if ($quantities === []) {
                $this->fail('Укажите хотя бы один товар для передачи.');
            }
            $previousStatus = $locked->status;
            $this->consumeQuantities($locked, $quantities, $actor);
            $allIssued = true;
            foreach ($this->quantities($locked) as $id => $quantity) {
                if (($locked->reservations->firstWhere('product_id', $id)?->fulfilled_quantity ?? 0) < $quantity) {
                    $allIssued = false;
                }
            }
            $target = $allIssued
                ? ($locked->effectiveDeliveryMethod() === 'delivery' ? Order::STATUS_SHIPPED : Order::STATUS_COMPLETED)
                : (in_array($previousStatus, [Order::STATUS_NEW, Order::STATUS_READY], true) ? Order::STATUS_IN_PROGRESS : $previousStatus);
            $locked->status = $target;
            if (! $locked->assignee_id) {
                $locked->assignee_id = $actor->id;
            }
            if (! $locked->first_response_at) {
                $locked->response_stopped_at = $locked->isClosed() ? now() : null;
            }
            $locked->save();
            $this->log($locked, 'Передача части №'.$locked->fulfillment_version.': '.($locked->effectiveDeliveryMethod() === 'delivery' ? 'передано перевозчику' : 'получено покупателем / установка завершена').'. Получение по частям согласовано с покупателем. Этап: «'.$locked->statusLabel().'».', $actor);
            if (app(OrderNotifications::class)->recordStatusChange($locked, $previousStatus)) {
                DB::afterCommit(fn () => app(OrderNotifications::class)->dispatchPending(orderId: $locked->id));
            }
        }, 3);
    }

    private function consumeQuantities(Order $order, array $quantities, ?User $actor = null): void
    {
        $rows = $order->reservations()->get()->keyBy('product_id');
        $ordered = $this->quantities($order);
        $products = Product::query()->whereIn('id', array_keys($quantities))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
        foreach ($quantities as $id => $quantity) {
            $row = $rows->get($id);
            if (! $row || $row->state !== 'paid' || $quantity < 1 || $quantity > $row->quantity || $quantity > ($ordered[$id] ?? 0) - $row->fulfilled_quantity) {
                $this->fail('Количество передачи превышает оплаченный резерв или оставшееся количество заказа.');
            }
            if (! $products->has($id) || Product::query()->whereKey($id)->where('stock', '>=', $quantity)->decrement('stock', $quantity) !== 1) {
                $this->fail('Недостаточно физического остатка для выдачи. Проверьте склад.');
            }
            $remaining = $row->quantity - $quantity;
            $row->update(['quantity' => $remaining, 'fulfilled_quantity' => $row->fulfilled_quantity + $quantity,
                'state' => $remaining > 0 ? 'paid' : 'consumed', 'released_at' => $remaining > 0 ? null : now()]);
            $this->log($order, 'Передача №'.($order->fulfillment_version + 1).': товар №'.$id.' — '.$quantity.' шт. Списано со склада; остаток резерва: '.$remaining.' шт.', $actor);
        }
        $order->forceFill(['fulfillment_version' => $order->fulfillment_version + 1])->save();
        $order->unsetRelation('reservations');
    }

    public function receiveReturn(Order $order, User $actor, int $productId, int $quantity, string $reason, int $expectedReturned): void
    {
        DB::transaction(function () use ($order, $actor, $productId, $quantity, $reason, $expectedReturned) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            $row = $locked->reservations()->where('product_id', $productId)->first();
            if (! $row || $row->returned_quantity !== $expectedReturned || $quantity < 1 || $quantity > $row->fulfilled_quantity - $row->returned_quantity) {
                $this->fail('Количество возврата превышает выданное количество за вычетом уже принятых возвратов.');
            }
            $product = Product::query()->lockForUpdate()->findOrFail($productId);
            if ($product->stock + $quantity > 4294967295) {
                $this->fail('Остаток превышает допустимое значение.');
            }
            Product::query()->whereKey($productId)->increment('stock', $quantity);
            $returned = $row->returned_quantity + $quantity;
            $attributes = ['returned_quantity' => $returned];
            if (in_array($row->state, ['consumed', 'returned'], true)) {
                $attributes['state'] = $returned === $row->fulfilled_quantity ? 'returned' : 'consumed';
            }
            $row->update($attributes);
            $this->log($locked, 'Фактически принят возврат товара №'.$productId.': '.$quantity.' шт. Причина: '.$reason.'. Возврат денег учитывается отдельно.', $actor);
        });
    }

    public function expireDue(): int
    {
        $count = 0;
        Order::query()->whereHas('reservations', fn ($q) => $q->where('state', 'active')->where('expires_at', '<=', now()))
            ->select('orders.id')->chunkById(100, function ($orders) use (&$count) {
                foreach ($orders as $order) {
                    $count += DB::transaction(function () use ($order) {
                        $locked = Order::query()->lockForUpdate()->findOrFail($order->id);

                        return $this->expireLocked($locked);
                    });
                }
            });

        return $count;
    }

    public function expireLocked(Order $order): int
    {
        $rows = $order->reservations()->where('state', 'active')->where('expires_at', '<=', now())->get();
        foreach ($rows as $row) {
            $row->update(['state' => 'expired', 'released_at' => $row->expires_at]);
            $this->log($order, 'Истёк резерв товара №'.$row->product_id.': освобождено '.$row->quantity.' шт. Продление недоступно.');
        }
        $order->unsetRelation('reservations');

        return $rows->count();
    }

    public function log(Order $order, string $message, ?User $actor = null): void
    {
        AdminActivityLog::query()->create([
            'user_id' => $actor?->id, 'user_name' => $actor?->name ?? 'Система', 'action' => AdminActivityLog::ACTION_UPDATED,
            'subject_type' => 'order', 'subject_id' => $order->id, 'subject_name' => $order->number, 'description' => $message,
        ]);
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['reservation' => $message]);
    }

    private function reservedQuantity(Product $product): int
    {
        // A locking read is essential under MySQL REPEATABLE READ: SUM via a snapshot may predate the product lock.
        return (int) $product->reservations()->live()->lockForUpdate()->get(['quantity'])->sum('quantity');
    }
}
