@extends('layouts.admin')

@section('title', 'Мой профиль')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--form">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Учётная запись</p>
                    <h1>Мой профиль</h1>
                    <p class="admin-content__lead">Основная информация вашей учётной записи.</p>
                </div>
                <a class="button button--secondary button--inline" href="{{ route('admin.profile.settings.edit') }}">Настроить профиль</a>
            </div>

            @include('admin.partials.help', ['title' => 'О профиле', 'text' => 'Здесь показаны ваши контактные данные, роль и последний вход. Имя, почту и телефон можно изменить в настройках, а пароль и другие активные сеансы — на вкладке безопасности.', 'items' => []])

            <section class="profile-card">
                <div class="profile-card__heading">
                    <span class="profile-card__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                    <div>
                        <h2>{{ $user->name }}</h2>
                        <span class="role-badge role-badge--{{ $user->role }}">{{ $user->roleLabel() }}</span>
                    </div>
                </div>

                <dl class="profile-details">
                    <div>
                        <dt>Электронная почта</dt>
                        <dd>{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt>Телефон</dt>
                        <dd>{{ $user->phone ?: 'Не указан' }}</dd>
                    </div>
                    <div>
                        <dt>Последний вход</dt>
                        <dd>
                            @if ($user->last_login_at)
                                {{ $user->last_login_at->timezone(config('app.display_timezone'))->translatedFormat('d F Y в H:i') }}
                            @else
                                Пока нет данных о входах
                            @endif
                        </dd>
                    </div>
                </dl>
            </section>
        </main>
    </div>
@endsection
