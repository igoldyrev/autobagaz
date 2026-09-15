@extends('layouts.admin')

@section('title', 'Заявка на обратный звонок')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Продажи · Обратные звонки</p>
            <h1>Заявка от {{ $callbackRequest->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</h1>
            @include('admin.partials.help', ['title' => 'Обработка заявки', 'text' => 'Позвоните клиенту по указанному номеру, затем обновите статус, чтобы другие менеджеры видели результат обработки.', 'items' => []])
            <dl class="profile-details">
                <div><dt>Клиент</dt><dd>{{ $callbackRequest->name }}</dd></div>
                <div><dt>Телефон</dt><dd><a href="tel:{{ $callbackRequest->phone }}">{{ $callbackRequest->phone }}</a></dd></div>
            </dl>
            <form method="POST" action="{{ route('admin.callback-requests.update', $callbackRequest) }}" class="admin-form">
                @csrf
                @method('PUT')
                <div class="field">
                    <span>Статус</span>
                    <details class="order-status-picker">
                        <summary>{{ $callbackRequest->statusLabel() }}</summary>
                        <div class="order-status-picker__menu">
                        @foreach (App\Models\CallbackRequest::statusLabels() as $value => $label)
                                <button name="status" type="submit" value="{{ $value }}" @if ($callbackRequest->status === $value) aria-current="true" @endif>{{ $label }}</button>
                        @endforeach
                        </div>
                    </details>
                    @error('status')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="form-actions"><a class="button button--secondary" href="{{ route('admin.callback-requests.index') }}">К списку заявок</a></div>
            </form>
        </main>
    </div>
@endsection
