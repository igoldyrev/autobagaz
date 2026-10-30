@extends('layouts.admin')
@section('title', 'Заявки на прокат')
@section('body')
<div class="admin-shell">
    @include('admin.partials.header')
    <main class="admin-content admin-content--wide processing-table-page">
        @include('admin.partials.flash')
        <div class="page-heading"><div><p class="eyebrow">Продажи</p><h1>Заявки на прокат</h1></div></div>
        @include('admin.rental-requests._help')
        @include('admin.partials.processing-filters', [
            'statusLabels' => App\Models\RentalRequest::statusLabels(),
            'indexUrl' => route('admin.rental-requests.index'),
            'showOrderSearch' => true,
            'searchLabel' => 'Поиск заявки',
            'searchPlaceholder' => 'Номер, имя или телефон',
            'showOverdueReturnFilter' => true,
        ])
        <div class="table-wrap processing-table-wrap"><table class="admin-table processing-table"><thead><tr><th>Заявка</th><th>Клиент</th><th>Период</th><th>Статус</th><th>Залог</th><th>Ответственный</th></tr></thead><tbody>
            @forelse($records as $rental)<tr class="admin-table__linked-row">
                <td data-label="Заявка"><a class="admin-table__row-link" href="{{ route('admin.rental-requests.show', $rental) }}" aria-label="Открыть заявку на прокат №{{ $rental->id }}: {{ $rental->name }}"></a><strong>№{{ $rental->id }}</strong><br>{{ $rental->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</td>
                <td data-label="Клиент">{{ $rental->name }}<br><a href="tel:{{ $rental->phone }}">{{ $rental->phone }}</a></td>
                <td data-label="Период">{{ $rental->starts_on->format('d.m.Y') }} — {{ $rental->ends_on->format('d.m.Y') }}</td>
                <td data-label="Статус"><span class="status processing-status processing-status--{{ $rental->status }}">{{ $rental->statusLabel() }}</span>@if($rental->isOverdue())<p>Просрочен возврат</p>@endif @include('admin.partials.response-status', ['responseRecord' => $rental, 'compact' => true])</td>
                <td data-label="Залог">{{ $rental->depositLabel() }}</td><td data-label="Ответственный">{{ $rental->assignee?->name ?? 'Не назначен' }}</td>
            </tr>@empty<tr><td colspan="6" class="empty-state">Заявок не найдено.</td></tr>@endforelse
        </tbody></table></div>
        @include('admin.partials.pagination', ['paginator' => $records])
    </main>
</div>
@endsection
