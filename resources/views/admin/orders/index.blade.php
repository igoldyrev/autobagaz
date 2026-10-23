@extends('layouts.admin')

@section('title', 'Заказы')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Продажи</p><h1>Заказы</h1><p class="admin-content__lead">Новые заказы требуют подтверждения менеджером.</p></div></div>
            @include('admin.partials.processing-filters', ['statusLabels' => App\Models\Order::statusLabels(), 'indexUrl' => route('admin.orders.index')])
            <div class="table-wrap"><table class="admin-table"><thead><tr><th>Номер</th><th>Дата</th><th>Статус</th><th>Ответственный</th><th>Клиент</th><th>Автомобиль</th><th>Получение</th><th>Сумма</th></tr></thead><tbody>
                @forelse ($orders as $order)
                    <tr class="admin-table__linked-row"><td><a class="admin-table__row-link" href="{{ route('admin.orders.show', $order) }}" aria-label="Открыть заказ {{ $order->number }}"></a>{{ $order->number }}</td><td>{{ $order->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</td><td><span class="status processing-status processing-status--{{ $order->status }}">{{ $order->statusLabel() }}</span></td><td>{{ $order->assignee?->name ?? 'Не назначен' }}</td><td><strong>{{ $order->customer_name }}</strong><br><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a><br><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td><td>{{ $order->vehicle_snapshot['label'] ?? 'Не указан' }}</td><td>{{ $order->deliveryMethodLabel() }}</td><td>{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</td></tr>
                @empty
                    <tr><td colspan="8" class="empty-state">Заказов пока нет.</td></tr>
                @endforelse
            </tbody></table></div>
            @include('admin.partials.pagination', ['paginator' => $orders])
        </main>
    </div>
@endsection
