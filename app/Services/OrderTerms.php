<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\Order;
use App\Models\OrderTermsVersion;
use App\Models\Product;
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
            if (! $locked->canEditTerms()) {
                throw ValidationException::withMessages(['terms' => 'Условия недоступны для изменения на этом этапе. До отправки заказ можно вернуть к согласованию.']);
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
                $snapshot = $this->snapshotItem([
                    'order_item_id' => $item->id, 'product_id' => $item->product_id,
                    'product_name' => $item->product_name, 'unit_price' => $item->unit_price,
                ], $data['items'][$item->id], 'items.'.$item->id);
                $goodsTotal += $this->cents($snapshot['total']);
                $quantityTotal += $snapshot['quantity'];
                $items[] = $snapshot;
            }
            $additional = $data['additional_items'] ?? [];
            foreach (array_keys($additional) as $id) {
                if (! ctype_digit((string) $id) || (int) $id < 1 || (string) (int) $id !== (string) $id) {
                    throw ValidationException::withMessages(['additional_items' => 'Некорректный идентификатор товара.']);
                }
            }
            $products = Product::query()->whereIn('id', array_keys($additional))->get()->keyBy('id');
            foreach ($additional as $id => $input) {
                if ((int) $input['quantity'] === 0) {
                    continue;
                }
                $product = $products->get($id);
                if (! $product || ! $product->is_active || (string) $product->id !== (string) $id) {
                    throw ValidationException::withMessages(['additional_items' => 'Выберите доступный товар из каталога.']);
                }
                if ($originalItems->contains('product_id', $product->id)) {
                    throw ValidationException::withMessages(['additional_items' => 'Этот товар уже есть в исходной заявке. Измените его количество в соответствующей строке.']);
                }
                $snapshot = $this->snapshotItem([
                    'order_item_id' => null, 'product_id' => $product->id,
                    'product_name' => $product->name, 'unit_price' => $product->price,
                ], $input, 'additional_items.'.$id);
                $goodsTotal += $this->cents($snapshot['total']);
                $quantityTotal += $snapshot['quantity'];
                $items[] = $snapshot;
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

            $baseline = $locked->termsVersions()->whereNotNull('accepted_at')->first();
            $baseGoods = $this->cents($baseline?->goods_total ?? $locked->total);
            $baseDelivery = $baseline ? $baseline->delivery_cost : ($locked->delivery_method === 'pickup' ? '0.00' : null);
            $baseTotal = $baseline ? $baseline->total : ($baseDelivery === null ? null : $locked->total);

            $version = $locked->termsVersions()->create([
                'change_reason' => $data['change_reason'], 'baseline_version' => $baseline?->version ?? 0,
                'goods_difference' => $this->money($goodsTotal - $baseGoods),
                'delivery_difference' => $deliveryCost === null || $baseDelivery === null ? null : $this->money($deliveryCost - $this->cents($baseDelivery)),
                'total_difference' => $total === null || $baseTotal === null ? null : $this->money($total - $this->cents($baseTotal)),
                'version' => $latest + 1, 'created_by' => $actor->id, 'created_by_name' => $actor->name,
                'items' => $items, 'goods_total' => $this->money($goodsTotal),
                'delivery_method' => $data['delivery_method'],
                'delivery_address' => $data['delivery_method'] === 'delivery' ? $data['delivery_address'] : null,
                'delivery_terms' => $data['delivery_terms'], 'delivery_cost' => $deliveryCost === null ? null : $this->money($deliveryCost),
                'payment_method' => $data['payment_method'], 'payment_terms' => $data['payment_terms'],
                'total' => $total === null ? null : $this->money($total),
            ]);
            app(AdminActivityLogger::class)->record($actor, AdminActivityLog::ACTION_UPDATED,
                'Сохранено предложение условий №'.$version->version.'. Согласие покупателя ещё не получено. Причина: '.$version->change_reason,
                'order', $locked->id, $locked->number);

            return $version;
        });
    }

    public function accept(Order $order, int $version): void
    {
        DB::transaction(function () use ($order, $version) {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            $latest = $locked->termsVersions()->first();
            if (! $locked->canEditTerms() || ! $latest || $latest->version !== $version) {
                throw ValidationException::withMessages(['version' => 'Условия изменились или согласование недоступно. Проверьте актуальные условия заказа.'])
                    ->redirectTo($locked->customerUrl());
            }
            if ($latest->accepted_at) {
                return;
            }
            $latest->forceFill(['accepted_at' => now(), 'accepted_via' => 'customer_link'])->save();
            AdminActivityLog::query()->create([
                'user_id' => null, 'user_name' => 'Покупатель', 'action' => AdminActivityLog::ACTION_UPDATED,
                'subject_type' => 'order', 'subject_id' => $locked->id, 'subject_name' => $locked->number,
                'description' => 'Покупатель подтвердил условия №'.$latest->version.' по защищённой ссылке.',
            ]);
        });
    }

    private function snapshotItem(array $source, array $input, string $field): array
    {
        $quantity = (int) $input['quantity'];
        $supplyTerms = trim($input['supply_terms'] ?? '');
        if ($quantity > 0 && $supplyTerms === '') {
            throw ValidationException::withMessages([$field.'.supply_terms' => 'Укажите срок поставки этой позиции.']);
        }
        $unitPrice = $this->cents($input['unit_price'] ?? $source['unit_price']);
        if ($quantity > 0 && $unitPrice > intdiv(999999999999, $quantity)) {
            throw ValidationException::withMessages([$field.'.unit_price' => 'Сумма позиции превышает допустимое значение.']);
        }

        return [
            ...$source, 'unit_price' => $this->money($unitPrice), 'quantity' => $quantity,
            'total' => $this->money($unitPrice * $quantity), 'supply_terms' => $supplyTerms,
        ];
    }

    private function cents(string $amount): int
    {
        [$rubles, $kopecks] = explode('.', $amount.'.00');

        return (int) $rubles * 100 + (int) str_pad($kopecks, 2, '0');
    }

    private function money(int $amount): string
    {
        $sign = $amount < 0 ? '-' : '';
        $absolute = abs($amount);

        return $sign.intdiv($absolute, 100).'.'.str_pad((string) ($absolute % 100), 2, '0', STR_PAD_LEFT);
    }
}
