<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\Order;
use App\Models\OrderTermsVersion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderTerms
{
    public function propose(Order $order, User $actor, array $data): OrderTermsVersion
    {
        return DB::transaction(function () use ($order, $actor, $data) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            $latest = (int) $locked->termsVersions()->max('version');
            if ($locked->status !== $data['expected_status'] || $latest !== (int) $data['expected_version']) {
                throw ValidationException::withMessages(['terms' => 'Заказ или условия уже изменены. Обновите страницу.']);
            }
            if ($locked->isClosed()) {
                throw ValidationException::withMessages(['terms' => 'Нельзя изменять условия закрытого заказа.']);
            }

            $originalItems = $locked->items()->orderBy('id')->get();
            $ids = array_map('strval', array_keys($data['items']));
            $originalIds = $originalItems->pluck('id')->map(fn ($id) => (string) $id)->all();
            sort($ids);
            sort($originalIds);
            if ($ids !== $originalIds) {
                throw ValidationException::withMessages(['items' => 'Укажите количество для каждой позиции исходной заявки.']);
            }

            $items = [];
            $goodsTotal = 0;
            $quantityTotal = 0;
            foreach ($originalItems as $item) {
                $input = $data['items'][$item->id];
                $quantity = (int) $input['quantity'];
                if ($quantity > $item->quantity) {
                    throw ValidationException::withMessages(['items.'.$item->id.'.quantity' => 'Количество не может превышать количество в заявке.']);
                }
                $supplyTerms = trim($input['supply_terms'] ?? '');
                if ($quantity > 0 && $supplyTerms === '') {
                    throw ValidationException::withMessages(['items.'.$item->id.'.supply_terms' => 'Укажите срок поставки этой позиции.']);
                }
                $unitPrice = $this->cents($item->unit_price);
                if ($quantity > 0 && $unitPrice > intdiv(999999999999, $quantity)) {
                    throw ValidationException::withMessages(['items' => 'Сумма позиции превышает допустимое значение.']);
                }
                $total = $unitPrice * $quantity;
                $goodsTotal += $total;
                $quantityTotal += $quantity;
                $items[] = [
                    'order_item_id' => $item->id, 'product_id' => $item->product_id, 'product_name' => $item->product_name,
                    'unit_price' => $item->unit_price, 'quantity' => $quantity,
                    'total' => $this->money($total), 'supply_terms' => $supplyTerms,
                ];
            }
            if ($quantityTotal === 0) {
                throw ValidationException::withMessages(['items' => 'В предложении должна остаться хотя бы одна позиция. Для отказа отмените заказ.']);
            }

            $deliveryCost = isset($data['delivery_cost']) ? $this->cents($data['delivery_cost']) : null;
            if ($data['delivery_method'] === 'pickup') {
                if ($deliveryCost !== null && $deliveryCost !== 0) {
                    throw ValidationException::withMessages(['delivery_cost' => 'Для самовывоза стоимость доставки должна быть нулевой.']);
                }
                $deliveryCost = 0;
            }
            $total = $deliveryCost === null ? null : $goodsTotal + $deliveryCost;
            if ($goodsTotal > 999999999999 || ($total !== null && $total > 999999999999)) {
                throw ValidationException::withMessages(['delivery_cost' => 'Итоговая сумма превышает допустимое значение.']);
            }

            $version = $locked->termsVersions()->create([
                'version' => $latest + 1, 'created_by' => $actor->id, 'created_by_name' => $actor->name,
                'items' => $items, 'goods_total' => $this->money($goodsTotal),
                'delivery_method' => $data['delivery_method'],
                'delivery_address' => $data['delivery_method'] === 'delivery' ? $data['delivery_address'] : null,
                'delivery_terms' => $data['delivery_terms'], 'delivery_cost' => $deliveryCost === null ? null : $this->money($deliveryCost),
                'payment_method' => $data['payment_method'], 'payment_terms' => $data['payment_terms'],
                'total' => $total === null ? null : $this->money($total),
            ]);
            app(AdminActivityLogger::class)->record($actor, AdminActivityLog::ACTION_UPDATED,
                'Сохранено предложение условий №'.$version->version.'. Согласие покупателя ещё не получено.',
                'order', $locked->id, $locked->number);

            return $version;
        });
    }

    private function cents(string $amount): int
    {
        [$rubles, $kopecks] = explode('.', $amount.'.00');

        return (int) $rubles * 100 + (int) str_pad($kopecks, 2, '0');
    }

    private function money(int $amount): string
    {
        return intdiv($amount, 100).'.'.str_pad((string) ($amount % 100), 2, '0', STR_PAD_LEFT);
    }
}
