@extends('layouts.admin')

@section('title', 'Обратные звонки')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide processing-table-page">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Продажи</p><h1>Обратные звонки</h1><p class="admin-content__lead">Заявки из формы обратного звонка на сайте.</p></div></div>
            @include('admin.callback-requests._help')
            @include('admin.partials.processing-filters', ['statusLabels' => App\Models\CallbackRequest::statusLabels(), 'indexUrl' => route('admin.callback-requests.index'), 'showArchiveFilter' => true])
            <div class="table-wrap processing-table-wrap"><table class="admin-table processing-table processing-table--callbacks">
                <colgroup><col class="processing-table__date"><col class="processing-table__status"><col class="processing-table__assignee"><col class="processing-table__customer"></colgroup>
                <thead><tr><th>Дата</th><th>Статус</th><th>Ответственный</th><th>Клиент</th></tr></thead>
                <tbody>
                @forelse ($callbackRequests as $callbackRequest)
                    <tr class="admin-table__linked-row">
                        <td data-label="Дата"><a class="admin-table__row-link" href="{{ route('admin.callback-requests.show', $callbackRequest) }}" aria-label="Открыть заявку №{{ $callbackRequest->id }}: {{ $callbackRequest->name }}"></a><time datetime="{{ $callbackRequest->created_at->toIso8601String() }}">{{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y') }}<small>{{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('H:i') }}</small></time></td>
                        <td data-label="Статус"><span class="status processing-status processing-status--{{ $callbackRequest->status }}">{{ $callbackRequest->statusLabel() }}</span><small>@include('admin.partials.response-status', ['responseRecord' => $callbackRequest, 'compact' => true])</small></td>
                        <td data-label="Ответственный">{{ $callbackRequest->assignee?->name ?? 'Не назначен' }}</td>
                        <td data-label="Клиент"><strong>{{ $callbackRequest->name }}</strong>@if ($callbackRequest->phone)<br><a href="tel:{{ $callbackRequest->phone }}">{{ $callbackRequest->phone }}</a>@endif</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">{{ request()->filled('response') ? 'По выбранным условиям заявки не найдены.' : 'Заявок пока нет.' }}</td></tr>
                @endforelse
                </tbody>
            </table></div>
            @include('admin.partials.pagination', ['paginator' => $callbackRequests])
        </main>
    </div>
@endsection
