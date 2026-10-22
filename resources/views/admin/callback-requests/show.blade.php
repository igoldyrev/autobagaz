@extends('layouts.admin')

@section('title', 'Заявка на обратный звонок')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Обратный звонок №{{ $callbackRequest->id }}</p><h1>{{ $callbackRequest->name }}</h1><p class="admin-content__lead">{{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p></div></div>
            <a class="text-link" href="{{ route('admin.callback-requests.index', $callbackRequest->archived_at ? ['archived' => 1] : []) }}">← К списку заявок</a>
            @if ($callbackRequest->archived_at)
                <p class="admin-content__lead">В архиве с {{ $callbackRequest->archived_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}. @if ($callbackRequest->anonymized_at) Контактные данные удалены {{ $callbackRequest->anonymized_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}. @else Контактные данные ожидают удаления. @endif</p>
            @endif
            @unless ($callbackRequest->anonymized_at)
                @include('admin.partials.processing-panel', ['record' => $callbackRequest, 'assigneeExpanded' => true, 'updateUrl' => route('admin.callback-requests.update', $callbackRequest)])
            @endunless
            <section class="admin-card order-details">
                <h2>Клиент</h2>
                <p>{{ $callbackRequest->name }}</p>
                @if ($callbackRequest->phone)<p><a class="text-link" href="tel:{{ $callbackRequest->phone }}">{{ $callbackRequest->phone }}</a></p>@endif
            </section>
            @unless ($callbackRequest->anonymized_at)
                @include('admin.partials.personal-data-consent', ['record' => $callbackRequest])
            @endunless
            @include('admin.partials.processing-history')
        </main>
    </div>
@endsection
