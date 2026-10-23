@extends('layouts.admin')

@section('title', 'Заказы')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide processing-table-page">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Продажи</p><h1>Заказы</h1><p class="admin-content__lead">Новые заказы требуют подтверждения менеджером.</p></div></div>
            @include('admin.partials.processing-filters', ['statusLabels' => App\Models\Order::statusLabels(), 'indexUrl' => route('admin.orders.index'), 'showOrderSearch' => true])
            <div class="table-wrap processing-table-wrap"><table class="admin-table processing-table processing-table--orders">
                <colgroup><col class="processing-table__number"><col class="processing-table__date"><col class="processing-table__status"><col class="processing-table__assignee"><col class="processing-table__customer"><col class="processing-table__vehicle"><col class="processing-table__delivery"><col class="processing-table__amount"></colgroup>
                <thead><tr><th>Номер</th><th>Дата</th><th>Статус</th><th>Ответственный</th><th>Клиент</th><th>Автомобиль</th><th>Получение</th><th>Сумма</th></tr></thead>
                <tbody>
                @forelse ($orders as $order)
                    <tr class="admin-table__linked-row">
                        <td data-label="Номер"><a class="admin-table__row-link" href="{{ route('admin.orders.show', $order) }}" aria-label="Открыть заказ {{ $order->number }}"></a><strong>{{ $order->number }}</strong></td>
                        <td data-label="Дата"><time datetime="{{ $order->created_at->toIso8601String() }}">{{ $order->created_at->timezone(config('app.display_timezone'))->format('d.m.Y') }}<small>{{ $order->created_at->timezone(config('app.display_timezone'))->format('H:i') }}</small></time></td>
                        <td data-label="Статус"><span class="status processing-status processing-status--{{ $order->status }}">{{ $order->statusLabel() }}</span><small>@include('admin.partials.response-status', ['responseRecord' => $order, 'compact' => true])</small></td>
                        <td data-label="Ответственный">{{ $order->assignee?->name ?? 'Не назначен' }}</td>
                        <td data-label="Клиент"><strong>{{ $order->customer_name }}</strong><br><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a><br><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                        <td data-label="Автомобиль">{{ $order->vehicle_snapshot['label'] ?? 'Не указан' }}</td>
                        <td data-label="Получение">{{ $order->effectiveDeliveryMethodLabel() }}</td>
                        <td data-label="Сумма"><strong>{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</strong></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="empty-state">{{ request()->filled('search') || request()->filled('status') || request()->filled('assignee_id') || request()->boolean('mine') || request()->filled('response') ? 'По выбранным условиям заказы не найдены.' : 'Заказов пока нет.' }}</td></tr>
                @endforelse
                </tbody>
            </table></div>
            @include('admin.partials.pagination', ['paginator' => $orders])
        </main>
    </div>
@endsection
