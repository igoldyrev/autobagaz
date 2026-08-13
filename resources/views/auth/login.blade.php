@extends('layouts.admin')

@section('title', 'Вход')

@section('body')
    <main class="auth-page">
        <section class="auth-card" aria-labelledby="login-title">
            <a class="auth-card__logo" href="{{ route('home') }}" aria-label="Вернуться на сайт">
                <img src="{{ asset('src/common.blocks/header/img/logo.jpg') }}" alt="Автобагаж">
            </a>

            <div class="auth-card__heading">
                <p class="eyebrow">Панель управления</p>
                <h1 id="login-title">Вход администратора</h1>
                <p>Введите данные учётной записи для продолжения.</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                @csrf

                <div class="field">
                    <label for="email">Электронная почта</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        required
                        autofocus
                        @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                    >
                    @error('email')
                        <p class="field__error" id="email-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Пароль</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        @error('password') aria-invalid="true" @enderror
                    >
                </div>

                <label class="checkbox">
                    <input type="checkbox" name="remember" value="1">
                    <span>Запомнить меня</span>
                </label>

                <button class="button button--primary" type="submit">Войти</button>
            </form>

            <a class="auth-card__back" href="{{ route('home') }}">← Вернуться на сайт</a>
        </section>
    </main>
@endsection
