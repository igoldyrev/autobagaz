@extends('layouts.admin')

@section('title', 'Обратные звонки')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Продажи</p><h1>Обратные звонки</h1><p class="admin-content__lead">Заявки из формы обратного звонка на сайте.</p></div></div>
            @include('admin.partials.processing-filters', ['statusLabels' => App\Models\CallbackRequest::statusLabels(), 'indexUrl' => route('admin.callback-requests.index'), 'showArchiveFilter' => true])
            <div class="table-wrap"><table class="admin-table"><thead><tr><th>Дата</th><th>Статус</th><th>Ответственный</th><th>Клиент</th><th></th></tr></thead><tbody>
                @forelse ($callbackRequests as $callbackRequest)
                    <tr><td>{{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</td><td><span class="status processing-status processing-status--{{ $callbackRequest->status }}">{{ $callbackRequest->statusLabel() }}</span></td><td>{{ $callbackRequest->assignee?->name ?? 'Не назначен' }}</td><td><strong>{{ $callbackRequest->name }}</strong>@if ($callbackRequest->phone)<br><a href="tel:{{ $callbackRequest->phone }}">{{ $callbackRequest->phone }}</a>@endif</td><td><a class="text-link" href="{{ route('admin.callback-requests.show', $callbackRequest) }}">Открыть</a></td></tr>
                @empty
                    <tr><td colspan="5" class="empty-state">Заявок пока нет.</td></tr>
                @endforelse
            </tbody></table></div>
            @include('admin.partials.pagination', ['paginator' => $callbackRequests])
        </main>
    </div>
@endsection
