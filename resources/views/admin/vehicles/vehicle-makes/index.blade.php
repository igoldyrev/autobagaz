@extends('layouts.admin')

@section('title', 'Марки автомобилей')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.dashboard') }}">Главная</a><span>/</span><span>Справочник автомобилей</span>
            </nav>

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Глобальный справочник</p>
                    <h1>Марки автомобилей</h1>
                    <p class="admin-content__lead">Единый список марок и моделей для автобагажников, фаркопов, рейлингов и будущих типов товаров.</p>
                </div>
                <div class="heading-actions">
                    <a class="button button--primary button--inline" href="{{ route('admin.vehicles.vehicle-makes.create') }}">Добавить марку</a>
                </div>
            </div>

            <nav class="admin-shortcuts" aria-label="Справочники автомобилей">
                <a class="admin-shortcuts__link" href="{{ route('admin.vehicles.vehicle-body-styles.index') }}">Типы кузова</a>
                <a class="admin-shortcuts__link" href="{{ route('admin.vehicles.vehicle-roof-types.index') }}">Типы крыши</a>
            </nav>

            @include('admin.partials.help', ['title' => 'Как устроен справочник автомобилей', 'text' => 'Данные заполняются по порядку: марка → модель → поколение → конфигурация. Именно конечная конфигурация с кузовом и типом крыши выбирается в подборе и группах применяемости.', 'items' => ['Поиск на этой странице проверяет название и адрес марки.', 'Привязка к разделам каталога определяет, где марка доступна пользователю.', 'Скрытие марки сохраняет всю вложенную структуру, но убирает её с сайта.']])

            <form class="toolbar" method="GET">
                <label class="visually-hidden" for="search">Поиск марки</label>
                <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Поиск по названию или URL">
                <button class="button button--secondary" type="submit">Найти</button>
                @if (request()->filled('search'))
                    <a class="text-link" href="{{ route('admin.vehicles.vehicle-makes.index') }}">Сбросить</a>
                @endif
            </form>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Марка</th>
                            <th>URL</th>
                            <th>Моделей</th>
                            <th>Разделы каталога</th>
                            <th>Статус</th>
                            <th><span class="visually-hidden">Действия</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicleMakes as $vehicleMake)
                            <tr>
                                <td>
                                    <div class="entity-title">
                                        @if ($vehicleMake->image_path)
                                            <img src="{{ asset($vehicleMake->image_path) }}" alt="" width="48" height="48">
                                        @else
                                            <span class="entity-title__placeholder" aria-hidden="true">{{ mb_substr($vehicleMake->name, 0, 1) }}</span>
                                        @endif
                                        <strong>{{ $vehicleMake->name }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $vehicleMake->slug }}</code></td>
                                <td>
                                    <a class="text-link" href="{{ route('admin.vehicles.vehicle-models.index', $vehicleMake) }}">
                                        {{ $vehicleMake->models_count }}
                                    </a>
                                </td>
                                <td>
                                    <div class="entity-tags">
                                        @forelse ($vehicleMake->catalogCategories as $catalogSection)
                                            <span class="status status--active">{{ $catalogSection->name }}</span>
                                        @empty
                                            <span class="status status--inactive">Не привязана</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td><span class="status {{ $vehicleMake->is_active ? 'status--active' : 'status--inactive' }}">{{ $vehicleMake->is_active ? 'Опубликована' : 'Скрыта' }}</span></td>
                                <td>
                                    <div class="row-actions">
                                        <a class="text-link" href="{{ route('admin.vehicles.vehicle-models.index', $vehicleMake) }}">Модели</a>
                                        <a class="text-link" href="{{ route('admin.vehicles.vehicle-makes.edit', $vehicleMake) }}">Изменить</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="empty-state">Марки не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $vehicleMakes])
        </main>
    </div>
@endsection
