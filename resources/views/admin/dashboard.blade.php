@extends('layouts.admin')

@section('title', 'Панель управления')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content">
            <p class="eyebrow">Панель управления</p>
            <h1>Добро пожаловать, {{ auth()->user()->name }}</h1>
            <p class="admin-content__lead">Авторизация настроена. Здесь появятся инструменты управления товарами и категориями.</p>

            <div class="admin-grid">
                <section class="admin-card">
                    <h2>Товары</h2>
                    <p>Добавление и редактирование товаров будет доступно на следующем этапе.</p>
                    <span class="status">Скоро</span>
                </section>
                <section class="admin-card">
                    <h2>Категории</h2>
                    <p>Управление марками и моделями автомобилей в разделе «Автобагажники».</p>
                    <a class="button button--primary button--inline" href="{{ route('admin.roof-racks.vehicle-makes.index') }}">Перейти к разделу</a>
                </section>
            </div>

            <a class="admin-content__site-link" href="{{ route('home') }}" target="_blank" rel="noopener">Открыть сайт ↗</a>
        </main>
    </div>
@endsection
