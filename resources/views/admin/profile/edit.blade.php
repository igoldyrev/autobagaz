@extends('layouts.admin')

@section('title', 'Личные данные')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--form">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Профиль</p>
                    <h1>Настройки профиля</h1>
                    <p class="admin-content__lead">Управляйте личными данными и безопасностью учётной записи.</p>
                </div>
            </div>

            @include('admin.profile._tabs')
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.profile.settings.update') }}" class="admin-form" aria-labelledby="personal-data-heading">
                @csrf
                @method('PUT')

                <h2 id="personal-data-heading">Личные данные</h2>
                <p class="form-description">Эти данные используются в панели управления.</p>

                <div class="form-grid">
                    <div class="field">
                        <label for="name">Имя</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name" required>
                    </div>
                    <div class="field">
                        <label for="email">Электронная почта</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                    </div>
                    <div class="field field--wide">
                        <label for="phone">Телефон</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" autocomplete="tel" placeholder="+7 900 000-00-00">
                        <p class="field__hint">Необязательное поле.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="button button--primary button--inline" type="submit">Сохранить изменения</button>
                </div>
            </form>
        </main>
    </div>
@endsection
