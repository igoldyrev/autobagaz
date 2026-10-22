@extends('layouts.admin')

@section('title', 'Заявка на обратный звонок')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Обратный звонок №{{ $callbackRequest->id }}</p><h1>{{ $callbackRequest->name }}</h1><p class="admin-content__lead">{{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p></div></div>
            <a class="text-link" href="{{ route('admin.callback-requests.index') }}">← К списку заявок</a>
            @include('admin.partials.processing-panel', ['record' => $callbackRequest, 'updateUrl' => route('admin.callback-requests.update', $callbackRequest)])
            <section class="admin-card order-details">
                <h2>Клиент</h2>
                <p>{{ $callbackRequest->name }}</p>
                <p><a class="text-link" href="tel:{{ $callbackRequest->phone }}">{{ $callbackRequest->phone }}</a></p>
            </section>
            @include('admin.partials.processing-history')
        </main>
    </div>
@endsection
