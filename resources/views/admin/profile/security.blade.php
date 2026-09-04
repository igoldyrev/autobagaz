@extends('layouts.admin')

@section('title', 'Безопасность профиля')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--form">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Профиль</p>
                    <h1>Безопасность</h1>
                    <p class="admin-content__lead">Управляйте паролем и активными сеансами вашей учётной записи.</p>
                </div>
            </div>

            @include('admin.profile._tabs')
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.profile.security.password.update') }}" class="admin-form" aria-labelledby="change-password-heading">
                @csrf
                @method('PUT')

                <h2 id="change-password-heading">Смена пароля</h2>
                <p class="form-description">Используйте уникальный пароль длиной не менее 12 символов.</p>

                @include('admin.partials.help', ['title' => 'Безопасность учётной записи', 'text' => 'Для смены пароля потребуется текущий пароль. Используйте пароль, которого нет на других сайтах. Если вы работали на чужом устройстве или заметили подозрительный вход, завершите остальные сеансы в блоке ниже.', 'items' => []])

                <div class="form-grid">
                    <div class="field field--wide">
                        <label for="current_password">Текущий пароль</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" required>
                    </div>
                    <div class="field">
                        <label for="password">Новый пароль</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required>
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Повторите новый пароль</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="button button--primary button--inline" type="submit">Сохранить пароль</button>
                </div>
            </form>

            <section class="danger-zone" aria-labelledby="sessions-heading">
                <div>
                    <h2 id="sessions-heading">Завершить другие сеансы</h2>
                    <p>Вы останетесь в текущем сеансе. На остальных устройствах потребуется войти снова.</p>
                </div>
                <form method="POST" action="{{ route('admin.profile.security.sessions.destroy') }}" class="inline-password-form">
                    @csrf
                    @method('DELETE')
                    <label class="visually-hidden" for="sessions_current_password">Текущий пароль</label>
                    <input id="sessions_current_password" name="current_password" type="password" autocomplete="current-password" placeholder="Текущий пароль" required>
                    <button class="button button--danger" type="submit">Завершить сеансы</button>
                </form>
            </section>
        </main>
    </div>
@endsection
