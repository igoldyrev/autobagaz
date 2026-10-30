@extends('layouts.admin')

@section('title', 'Заказ '.$order->number)

@section('body')
    <div class="admin-shell"><div>@include('admin.partials.header')</div>
        <main class="admin-content admin-order-page">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Заказ</p><h1>{{ $order->number }}</h1></div></div>
            <div class="order-page-meta">
                <p class="admin-content__lead">{{ $order->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p>
                <a class="button button--secondary button--inline" href="{{ route('admin.orders.index') }}">← К списку заказов</a>
            </div>
            @include('admin.partials.processing-panel', ['record' => $order, 'updateUrl' => route('admin.orders.update', $order)])
            <div class="admin-card order-details order-overview">
                <div class="order-overview__meta">
                <div>
                <h2>Клиент</h2><p>{{ $order->customer_name }} · <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a> · <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                </div>
                <div>
                <h3>Автомобиль</h3>
                @if ($order->vehicle_snapshot)
                    <p><strong>{{ $order->vehicle_snapshot['label'] }}</strong></p>
                    <dl>
                        @foreach (['generation' => 'Поколение', 'configuration' => 'Конфигурация', 'body_style' => 'Кузов', 'roof_type' => 'Крыша'] as $key => $label)
                            @if (! empty($order->vehicle_snapshot[$key]))
                                <dt>{{ $label }}</dt><dd>{{ $order->vehicle_snapshot[$key] }}</dd>
                            @endif
                        @endforeach
                    </dl>
                @else
                    <p>Не указан</p>
                @endif
                </div>
                <div>
                <h3>Получение</h3><p>{{ $order->effectiveDeliveryMethodLabel() }}@if($order->effectiveDeliveryMethod() === 'delivery' && ($acceptedTerms?->delivery_address ?? $order->delivery_address)) · {{ $acceptedTerms?->delivery_address ?? $order->delivery_address }}@endif</p>
                @if ($acceptedTerms)
                    <p>{{ $acceptedTerms->delivery_terms }}</p>
                    <p>Доставка: {{ $acceptedTerms->delivery_cost === null ? 'стоимость пока не рассчитана' : number_format((float) $acceptedTerms->delivery_cost, 2, ',', ' ').' ₽' }}.</p>
                @endif
                </div>
                </div>
                @if($order->comment)<h3>Комментарий покупателя</h3><p>{{ $order->comment }}</p>@endif
                @include('orders._reservation', ['unifiedItems' => true, 'hideHeading' => true, 'adminView' => true])
                @if ($order->reservation_started_at && $order->payment_status === 'paid' && ! $order->isClosed() && $order->status !== \App\Models\Order::STATUS_SHIPPED && ! $order->canCollect())
                    <form method="POST" action="{{ route('admin.orders.reserve', $order) }}">
                        @csrf
                        <p>После поступления сначала обновите физические остатки, затем зарезервируйте доступные товары для этого оплаченного заказа.</p>
                        <button class="button button--secondary" type="submit">Зарезервировать поступившие товары</button>
                    </form>
                @endif
                @foreach ($order->reservations as $reservation)
                    @if (in_array($reservation->state, ['consumed', 'returned'], true) && $reservation->returned_quantity < $reservation->quantity)
                        <details>
                            <summary>Принять возврат: {{ $reservation->product?->name }} (до {{ $reservation->quantity - $reservation->returned_quantity }} шт.)</summary>
                            <form method="POST" action="{{ route('admin.orders.returns', $order) }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $reservation->product_id }}">
                                <input type="hidden" name="expected_returned" value="{{ $reservation->returned_quantity }}">
                                <label class="field">Количество<input type="number" name="quantity" min="1" max="{{ $reservation->quantity - $reservation->returned_quantity }}" value="1" required></label>
                                <label class="field">Причина<textarea name="reason" maxlength="1000" required></textarea></label>
                                <label><input type="checkbox" name="received" value="1" required> Товар фактически принят в магазин и пригоден к продаже</label>
                                <p>Увеличит физический остаток. Возврат денег учитывается отдельно.</p>
                                <button class="button button--secondary" type="submit">Принять возврат на склад</button>
                            </form>
                        </details>
                    @endif
                @endforeach
                <p class="order-customer-link"><a href="{{ $order->customerUrl() }}">Открыть страницу покупателя</a><br><span>Передайте эту ссылку покупателю, если нужно согласовать замену или новые условия.</span></p>
            </div>
            @include('admin.orders._terms')
            @include('admin.partials.processing-history')
        </main>
    </div>
@endsection
