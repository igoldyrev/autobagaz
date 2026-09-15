@extends('layouts.admin')

@section('title', 'Заказы')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Продажи</p><h1>Заказы</h1><p class="admin-content__lead">Новые заказы требуют подтверждения менеджером.</p></div></div>
            @include('admin.partials.help', ['id' => 'orders-help-title', 'title' => 'Как обрабатывать заказы', 'text' => 'Каждая запись создаётся покупателем после оформления корзины. Состав товаров и цены сохраняются на момент заказа, поэтому они не изменятся, если карточки каталога будут отредактированы позже.', 'items' => ['Начинайте с фильтра «Новый»: такие заказы ещё не подтверждены менеджером.', 'Откройте номер заказа, проверьте состав, способ получения, адрес доставки и контакты покупателя.', 'Свяжитесь с покупателем, уточните наличие, срок и условия получения, затем переведите заказ в статус «В работе» или «Подтверждён».', 'После выдачи установите статус «Завершён». Если заказ не состоялся, выберите «Отменён» — запись и история товаров останутся в админке.']])
            <div class="toolbar order-status-toolbar">
                <span>Статус</span>
                <details class="order-status-picker">
                    <summary>{{ App\Models\Order::statusLabels()[request('status')] ?? 'Все статусы' }}</summary>
                    <div class="order-status-picker__menu">
                        <a href="{{ route('admin.orders.index') }}" @if (! request('status')) aria-current="true" @endif>Все статусы</a>
                        @foreach (App\Models\Order::statusLabels() as $value => $label)
                            <a href="{{ route('admin.orders.index', ['status' => $value]) }}" @if (request('status') === $value) aria-current="true" @endif>{{ $label }}</a>
                        @endforeach
                    </div>
                </details>
            </div>
            <div class="table-wrap"><table class="admin-table"><thead><tr><th>Номер</th><th>Дата</th><th>Клиент</th><th>Получение</th><th>Сумма</th><th>Статус</th></tr></thead><tbody>
                @forelse ($orders as $order)
                    <tr><td><a class="text-link" href="{{ route('admin.orders.show', $order) }}">{{ $order->number }}</a></td><td>{{ $order->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</td><td><strong>{{ $order->customer_name }}</strong><br><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a><br><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td><td>{{ $order->deliveryMethodLabel() }}</td><td>{{ number_format((float) $order->total, 2, ',', ' ') }} ₽</td><td><span class="status">{{ $order->statusLabel() }}</span></td></tr>
                @empty
                    <tr><td colspan="6" class="empty-state">Заказов пока нет.</td></tr>
                @endforelse
            </tbody></table></div>
            @include('admin.partials.pagination', ['paginator' => $orders])
        </main>
    </div>
@endsection
