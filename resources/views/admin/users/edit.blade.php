@extends('layouts.admin')

@section('title', 'Настройка пользователя')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--form">
            <div class="admin-breadcrumbs">
                <a href="{{ route('admin.users.index') }}">Пользователи</a><span>→</span><span>{{ $user->name }}</span>
            </div>
            <h1>{{ $user->name }}</h1>
            <p class="admin-content__lead">Настройте роль, права доступа и при необходимости задайте новый пароль.</p>

            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="admin-form">
                @csrf
                @method('PUT')
                @include('admin.users._form', ['submitLabel' => 'Сохранить изменения'])
            </form>
        </main>
    </div>
@endsection
