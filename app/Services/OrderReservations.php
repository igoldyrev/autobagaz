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
            if ($row && in_array($row->state, ['consumed', 'returned'], true)) {
                continue;
            }
            $product = $products[$id] ?? null;
            if (! $product) {
                $this->fail('Один из товаров удалён. Проверьте состав заказа.');
            }
            $own = $row && ($row->state === 'paid' || ($row->state === 'active' && $row->expires_at->isFuture())) ? $row->quantity : 0;
            $quantity = min($quantities[$id] ?? 0, max(0, $product->stock - $this->reservedQuantity($product)) + $own);
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
            if (($reserved->get($id)?->quantity ?? 0) < $quantity) {
                return false;
            }
        }

        return $quantities !== [];
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

    /** Whole-order fulfillment follows the existing workflow; repeated shipment/completion does not debit twice. */
    public function consume(Order $order): void
    {
        if (! $order->reservation_started_at) {
            return; // Historical orders were never reserved and must not be debited retroactively.
        }
        if ($order->status === Order::STATUS_SHIPPED) {
            return;
        }
        $rows = $order->reservations()->get();
        if ($rows->isNotEmpty() && $rows->every(fn ($r) => in_array($r->state, ['consumed', 'returned'], true))) {
            return;
        }
        if (! $this->canCollect($order)) {
            $this->fail('Для выдачи или отправки нужна подтверждённая оплата и резерв всего состава заказа.');
        }
        $products = Product::query()->whereIn('id', $rows->pluck('product_id'))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
        foreach ($rows->where('state', 'paid') as $row) {
            $product = $products[$row->product_id];
            if (Product::query()->whereKey($product->id)->where('stock', '>=', $row->quantity)->decrement('stock', $row->quantity) !== 1) {
                $this->fail('Недостаточно физического остатка для выдачи. Проверьте склад.');
            }
            $row->update(['state' => 'consumed', 'released_at' => now()]);
            $this->log($order, 'Выдан / отправлен товар №'.$product->id.': списано '.$row->quantity.' шт., резерв закрыт.');
        }
        $order->unsetRelation('reservations');
    }

    public function receiveReturn(Order $order, User $actor, int $productId, int $quantity, string $reason, int $expectedReturned): void
    {
        DB::transaction(function () use ($order, $actor, $productId, $quantity, $reason, $expectedReturned) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            $row = $locked->reservations()->where('product_id', $productId)->first();
            if (! $row || $row->returned_quantity !== $expectedReturned || ! in_array($row->state, ['consumed', 'returned'], true) || $quantity < 1 || $quantity > $row->quantity - $row->returned_quantity) {
                $this->fail('Количество возврата превышает выданное количество за вычетом уже принятых возвратов.');
            }
            $product = Product::query()->lockForUpdate()->findOrFail($productId);
            if ($product->stock + $quantity > 4294967295) {
                $this->fail('Остаток превышает допустимое значение.');
            }
            Product::query()->whereKey($productId)->increment('stock', $quantity);
            $returned = $row->returned_quantity + $quantity;
            $row->update(['returned_quantity' => $returned, 'state' => $returned === $row->quantity ? 'returned' : 'consumed']);
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
