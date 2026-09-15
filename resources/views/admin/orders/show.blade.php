@extends('layouts.admin')

@section('title', 'Заказ '.$order->number)

@section('body')
    <div class="admin-shell"><div>@include('admin.partials.header')</div>
        <main class="admin-content">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Заказ</p><h1>{{ $order->number }}</h1><p class="admin-content__lead">{{ $order->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p></div></div>
            @include('admin.partials.help', ['title' => 'Работа с заказом', 'text' => 'Сначала свяжитесь с покупателем по телефону или email, чтобы подтвердить заказ. Затем выберите актуальный статус и сохраните его — это изменит состояние заказа в общем списке.', 'items' => ['«Новый» — заказ ещё не взят в работу.', '«В работе» — менеджер уточняет детали или проверяет наличие.', '«Подтверждён» — покупатель согласовал заказ и условия получения.', '«Завершён» и «Отменён» — финальные статусы для закрытия работы с заказом.']])
            <div class="admin-card order-details">
                <h2>Клиент</h2><p>{{ $order->customer_name }} · <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a> · <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                <h2>Получение</h2><p>{{ $order->deliveryMethodLabel() }}@if($order->delivery_address) · {{ $order->delivery_address }}@endif</p>
                @if($order->comment)<h2>Комментарий</h2><p>{{ $order->comment }}</p>@endif
                <h2>Товары</h2><ul>@foreach($order->items as $item)<li>{{ $item->product_name }} × {{ $item->quantity }} — {{ number_format((float) $item->total, 2, ',', ' ') }} ₽</li>@endforeach</ul><p><strong>Итого: {{ number_format((float) $order->total, 2, ',', ' ') }} ₽</strong></p>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="toolbar order-status-toolbar">
                    @csrf
                    @method('PUT')
                    <span>Статус</span>
                    <details class="order-status-picker">
                        <summary>{{ $order->statusLabel() }}</summary>
                        <div class="order-status-picker__menu">
                            @foreach(App\Models\Order::statusLabels() as $value => $label)
                                <button type="submit" name="status" value="{{ $value }}" @if ($order->status === $value) aria-current="true" @endif>{{ $label }}</button>
                            @endforeach
                        </div>
                    </details>
                </form>
            </div>
        </main>
    </div>
@endsection
