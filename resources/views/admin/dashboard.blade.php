@extends('layouts.admin')

@section('title', 'Панель управления')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content">
            <p class="eyebrow">Панель управления</p>
            <h1>Добро пожаловать, {{ auth()->user()->name }}</h1>
            <p class="admin-content__lead">Авторизация настроена. Здесь появятся инструменты управления товарами и категориями.</p>

            @include('admin.partials.help', ['title' => 'Как организована админка', 'text' => 'Рабочие разделы доступны по вашим правам. Обычно контент заполняется в последовательности: справочники и категории → товары → автомобили → совместимость.', 'items' => ['Начинайте со справочников, чтобы не создавать дубли прямо во время заполнения товара.', 'Скрытие записи обычно убирает её с сайта без удаления данных и связей.', 'Перед публикацией проверяйте карточку товара и результат совместимости.']])

            <div class="admin-grid">
                @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_PRODUCTS))
                <section class="admin-card">
                    <h2>Товары</h2>
                    <p>Добавление товаров, цены, остатки, фотографии и привязки к каталогу.</p>
                    <a class="button button--primary button--inline" href="{{ route('admin.products.index') }}">Управлять товарами</a>
                </section>
                @endif
                @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_CATEGORIES))
                <section class="admin-card">
                    <h2>Разделы и категории</h2>
                    <p>Общее дерево каталога, порядок и статус публикации.</p>
                    <a class="button button--primary button--inline" href="{{ route('admin.catalog-categories.index') }}">Открыть дерево</a>
                </section>
                @endif
                @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_VEHICLES))
                <section class="admin-card">
                    <h2>Марки и модели</h2>
                    <p>Глобальный справочник марок и моделей для всех типов автомобильных товаров.</p>
                    <a class="button button--primary button--inline" href="{{ route('admin.vehicles.vehicle-makes.index') }}">Перейти к справочнику</a>
                </section>
                @endif
                @if (auth()->user()->isSuperAdmin())
                <section class="admin-card">
                    <h2>Пользователи</h2>
                    <p>Учётные записи сотрудников, роли и индивидуальные права доступа.</p>
                    <a class="button button--primary button--inline" href="{{ route('admin.users.index') }}">Управлять доступом</a>
                </section>
                @endif
            </div>

            <a class="admin-content__site-link" href="{{ route('home') }}" target="_blank" rel="noopener">Открыть сайт ↗</a>
        </main>
    </div>
@endsection
