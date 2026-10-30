@php
    $itemKey = fn ($item) => isset($item['order_item_id']) ? 'item:'.$item['order_item_id'] : 'product:'.$item['product_id'];
    $currentItems = collect($acceptedTerms?->items ?? $order->items->map(fn ($item) => [
        ...$item->only(['product_id', 'product_name', 'quantity', 'unit_price', 'total']), 'order_item_id' => $item->id,
    ])->all())->keyBy($itemKey);
    $proposal = $latestTerms && ! $latestTerms->accepted_at ? $latestTerms : null;
    $proposedItems = collect($proposal?->items ?? [])->keyBy($itemKey);
    $displayItems = $currentItems->union($proposedItems);
    $reservationRows = $order->reservations->keyBy('product_id');
    $hasSupply = false;
@endphp
@if ($proposal)
    <p class="order-note">{{ ($adminView ?? false) ? 'Предложенные изменения отмечены в таблице и вступят в силу после подтверждения покупателем.' : 'Менеджер предложил изменения. Они отмечены в таблице и вступят в силу только после вашего подтверждения.' }}</p>
@endif
<div class="order-terms-table-wrap">
    <table class="order-terms-table order-customer-items @if ($adminView ?? false) admin-table @endif">
        <thead><tr><th>Товар или услуга</th><th>Цена</th><th>Количество</th><th>Сумма</th><th>Наличие и сроки</th></tr></thead>
        <tbody>
        @foreach ($displayItems as $key => $displayItem)
            @php
                $current = $currentItems->get($key);
                $proposed = $proposedItems->get($key);
                if ($proposal && $current && ! $proposed) {
                    $proposed = [...$current, 'quantity' => 0, 'total' => '0.00', 'supply_terms' => ''];
                }
                $currentQuantity = (int) ($current['quantity'] ?? 0);
                $proposedQuantity = (int) ($proposed['quantity'] ?? 0);
                $reservation = $reservationRows->get($displayItem['product_id']);
                $liveQuantity = $reservation && ($reservation->state === 'paid' || ($reservation->state === 'active' && $reservation->expires_at->isFuture())) ? $reservation->quantity : 0;
                $hasSupply = $hasSupply || ($displayItem['product_id'] !== null && $currentQuantity > $liveQuantity && ! in_array($reservation?->state, ['consumed', 'returned'], true));
            @endphp
            @continue($currentQuantity === 0 && $proposedQuantity === 0)
            <tr>
                <td><strong>{{ $displayItem['product_name'] }}</strong>
                    @if ($proposal && $currentQuantity === 0)<small class="order-item-change">Предлагается добавить</small>
                    @elseif ($proposal && $proposed && $proposedQuantity === 0)<small class="order-item-change">Предлагается убрать</small>@endif
                </td>
                @foreach (['unit_price', 'quantity', 'total'] as $field)
                    <td>
                        {{ $currentQuantity === 0 ? '—' : ($field === 'quantity' ? $currentQuantity : number_format((float) $current[$field], 2, ',', ' ').' ₽') }}
                        @if ($proposed && ($currentQuantity === 0 || (string) $proposed[$field] !== (string) ($current[$field] ?? '')))
                            <small class="order-item-change">Предлагается: {{ $field === 'quantity' ? $proposedQuantity : number_format((float) $proposed[$field], 2, ',', ' ').' ₽' }}</small>
                        @endif
                    </td>
                @endforeach
                <td>
                    @if ($currentQuantity > 0)
                        @if ($displayItem['product_id'] === null)
                            Услуга
                        @elseif ($order->reservation_started_at)
                            {{ $reservation?->stateLabel() ?? 'Под заказ' }}
                            @if ($liveQuantity > 0)<small>В резерве: {{ $liveQuantity }} шт.</small>@endif
                            @if ($liveQuantity > 0 && $liveQuantity < $currentQuantity)<small>Остальные {{ $currentQuantity - $liveQuantity }} шт. — под заказ, сроки согласует менеджер.</small>@endif
                            @if ($reservation?->returned_quantity)<small>Возвращено: {{ $reservation->returned_quantity }} шт.</small>@endif
                        @else
                            {{ $current['supply_terms'] ?? 'Наличие уточнит менеджер' }}
                        @endif
                        @if ($order->reservation_started_at && ! empty($current['supply_terms']))<small>{{ $current['supply_terms'] }}</small>@endif
                    @endif
                    @if ($proposed && $proposedQuantity > 0 && ($proposed['supply_terms'] ?? '') !== ($current['supply_terms'] ?? ''))
                        <small class="order-item-change">Предлагается: {{ $proposed['supply_terms'] }}</small>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<p class="order-customer-total">Товары и услуги: <strong>{{ number_format((float) ($acceptedTerms?->goods_total ?? $order->total), 2, ',', ' ') }} ₽</strong></p>
@if ($hasSupply)
    <p class="order-note">Для товаров под заказ наличие у поставщика и сроки не гарантируются нулевым остатком. Условия поставки согласуются отдельно с менеджером.</p>
@endif
