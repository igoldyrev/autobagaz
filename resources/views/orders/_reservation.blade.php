@if ($order->reservation_started_at || ($customerView ?? false) || ($unifiedItems ?? false))
    <section class="order-reservation" aria-label="Состояние оплаты и резерва" data-payment-status="{{ $order->payment_status }}">
        @unless (($customerView ?? false) || ($hideHeading ?? false))
            <h2>Оплата и резерв</h2>
        @endunless
        @if ($order->reservation_started_at)
        <div class="order-reservation__summary">
            <p><span class="order-reservation__label">Оплата</span> <strong class="order-reservation__payment">{{ $order->paymentLabel() }}</strong></p>
            <p><span class="order-reservation__label">Резерв</span> <strong class="order-reservation__state">{{ $order->reservationLabel() }}</strong></p>
        </div>
        @if ($order->payment_status === 'unpaid')
            <p class="order-reservation__deadline">Срок неоплаченного резерва: до <time datetime="{{ $order->reservation_expires_at->toIso8601String() }}">{{ $order->reservation_expires_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i:s') }}</time>.</p>
        @endif
        @if ($order->canCollect())
            <p>{{ $order->effectiveDeliveryMethod() === 'pickup' ? 'Заказ оплачен, все оставшиеся товары зарезервированы. Можно приезжать за заказом в магазин.' : 'Заказ оплачен, все оставшиеся товары зарезервированы. Передачу в доставку оформляет менеджер.' }}</p>
        @elseif ($order->canFulfillPart())
            <p>Часть товаров доступна для получения. Выдачу или отправку по частям согласуйте с менеджером.</p>
        @elseif ($order->payment_status === 'paid' && ! $order->isClosed() && $order->status !== \App\Models\Order::STATUS_SHIPPED)
            <p>Оплата получена. Полный складской резерв пока не подтверждён либо новые условия ожидают согласования. Перед получением свяжитесь с менеджером.</p>
        @endif
        @endif
        @if (($customerView ?? false) || ($unifiedItems ?? false))
            @include('orders._customer-items')
        @else
        @php
            $reservationRows = $order->reservations->keyBy('product_id');
            $hasSupply = false;
        @endphp
        <div class="order-terms-table-wrap table-wrap">
            <table class="order-terms-table admin-table">
                <thead><tr><th>Товар</th><th>Заказано, шт.</th><th>В резерве, шт.</th><th>Выдано / отправлено, шт.</th><th>Осталось передать, шт.</th><th>Состояние</th><th>Возвращено, шт.</th></tr></thead>
                <tbody>
                @foreach (app(\App\Services\OrderReservations::class)->items($order) as $reservedItem)
                    @continue($reservedItem['product_id'] === null || $reservedItem['quantity'] === 0)
                    @php
                        $reservation = $reservationRows->get($reservedItem['product_id']);
                        $liveQuantity = $reservation && ($reservation->state === 'paid' || ($reservation->state === 'active' && $reservation->expires_at->isFuture())) ? $reservation->quantity : 0;
                        $fulfilledQuantity = $reservation?->fulfilled_quantity ?? 0;
                        $remainingQuantity = max(0, $reservedItem['quantity'] - $fulfilledQuantity);
                        $hasSupply = $hasSupply || ($liveQuantity < $remainingQuantity);
                    @endphp
                    <tr>
                        <td>{{ $reservedItem['product_name'] }}</td>
                        <td>{{ $reservedItem['quantity'] }}</td>
                        <td>{{ $liveQuantity }}</td>
                        <td>{{ $fulfilledQuantity }}</td>
                        <td>{{ $remainingQuantity }}</td>
                        <td>{{ $reservation?->stateLabel() ?? 'Под заказ, без складского резерва' }}
                            @if ($liveQuantity > 0 && $liveQuantity < $remainingQuantity)
                                <br>Остальные {{ $remainingQuantity - $liveQuantity }} шт. — под заказ, сроки согласует менеджер.
                            @endif
                        </td>
                        <td>{{ $reservation?->returned_quantity ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($hasSupply)
            <p>Для товаров под заказ наличие у поставщика и сроки не гарантируются нулевым остатком. Условия поставки согласуются отдельно с менеджером.</p>
        @endif
        @endif
    </section>
@endif
