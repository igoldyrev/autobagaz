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
            <div class="admin-card order-details">
                <h2>Клиент</h2><p>{{ $order->customer_name }} · <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a> · <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                <h2>Автомобиль</h2>
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
                <h2>Исходная заявка: получение</h2><p>{{ $order->deliveryMethodLabel() }}@if($order->delivery_address) · {{ $order->delivery_address }}@endif</p>
                @if($order->comment)<h2>Комментарий</h2><p>{{ $order->comment }}</p>@endif
                <h2>Исходная заявка: товары</h2>
                <div class="table-wrap"><table class="admin-table"><thead><tr><th>Товар</th><th>Цена</th><th>Количество</th><th>Сумма</th></tr></thead><tbody>
                    @foreach ($order->items as $item)
                        <tr><td>{{ $item->product_name }}</td><td>{{ number_format((float) $item->unit_price, 2, ',', ' ') }} ₽</td><td>{{ $item->quantity }}</td><td>{{ number_format((float) $item->total, 2, ',', ' ') }} ₽</td></tr>
                    @endforeach
                </tbody></table></div>
                <p class="processing-total"><strong>Сумма исходной заявки: {{ number_format((float) $order->total, 2, ',', ' ') }} ₽</strong></p>
                <p class="order-customer-link"><a href="{{ $order->customerUrl() }}">Открыть страницу покупателя</a><br><span>Передайте эту ссылку покупателю, если нужно согласовать замену или новые условия.</span></p>
            </div>
            @include('admin.orders._terms')
            @include('admin.partials.processing-history')
        </main>
    </div>
@endsection
