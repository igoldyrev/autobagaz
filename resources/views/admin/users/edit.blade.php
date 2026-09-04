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

            @unless (auth()->user()->is($user))
                <section class="danger-zone" aria-labelledby="terminate-user-sessions-title">
                    <div>
                        <h2 id="terminate-user-sessions-title">Завершить все сеансы</h2>
                        <p>Пользователь выйдет из админки на всех устройствах. Для следующего входа потребуется пароль.</p>
                    </div>
                    <form method="POST" action="{{ route('admin.users.sessions.destroy', $user) }}" onsubmit="return confirm('Завершить все сеансы этого пользователя?')">
                        @csrf
                        @method('DELETE')
                        <button class="button button--danger" type="submit">Завершить сеансы</button>
                    </form>
                </section>
            @endunless
        </main>
    </div>
@endsection
