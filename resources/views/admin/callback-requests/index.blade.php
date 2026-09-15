@extends('layouts.admin')

@section('title', 'Обратные звонки')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Продажи</p><h1>Обратные звонки</h1><p class="admin-content__lead">Заявки из формы обратного звонка на сайте.</p></div></div>
            @include('admin.partials.help', ['title' => 'Как обрабатывать заявки', 'text' => 'Новая заявка появляется сразу после отправки формы на сайте. Позвоните клиенту по указанному номеру и измените статус заявки.', 'items' => ['Начинайте с фильтра «Новая», чтобы не пропустить обращение.', 'После первого звонка переведите заявку в статус «В работе».', 'После общения с клиентом установите статус «Завершена» — заявка останется в истории.']])
            <div class="toolbar order-status-toolbar">
                <span>Статус</span>
                <details class="order-status-picker">
                    <summary>{{ App\Models\CallbackRequest::statusLabels()[request('status')] ?? 'Все статусы' }}</summary>
                    <div class="order-status-picker__menu">
                        <a href="{{ route('admin.callback-requests.index') }}" @if (! request('status')) aria-current="true" @endif>Все статусы</a>
                        @foreach (App\Models\CallbackRequest::statusLabels() as $value => $label)
                            <a href="{{ route('admin.callback-requests.index', ['status' => $value]) }}" @if (request('status') === $value) aria-current="true" @endif>{{ $label }}</a>
                        @endforeach
                    </div>
                </details>
            </div>
            <div class="table-wrap"><table class="admin-table"><thead><tr><th>Дата</th><th>Клиент</th><th>Статус</th><th></th></tr></thead><tbody>
                @forelse ($callbackRequests as $callbackRequest)
                    <tr><td>{{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</td><td><strong>{{ $callbackRequest->name }}</strong><br><a href="tel:{{ $callbackRequest->phone }}">{{ $callbackRequest->phone }}</a></td><td><span class="status">{{ $callbackRequest->statusLabel() }}</span></td><td><a class="text-link" href="{{ route('admin.callback-requests.show', $callbackRequest) }}">Открыть</a></td></tr>
                @empty
                    <tr><td colspan="4" class="empty-state">Заявок пока нет.</td></tr>
                @endforelse
            </tbody></table></div>
            @include('admin.partials.pagination', ['paginator' => $callbackRequests])
        </main>
    </div>
@endsection
