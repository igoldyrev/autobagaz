@extends('layouts.admin')

@section('title', 'Марки автомобилей')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.dashboard') }}">Главная</a><span>/</span><span>Автобагажники</span>
            </nav>

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Раздел каталога</p>
                    <h1>Марки автомобилей</h1>
                    <p class="admin-content__lead">Марки являются общим справочником сайта. Здесь настраивается их отображение в разделе «{{ $rootCategory->name }}».</p>
                </div>
                <div class="heading-actions">
                    <a class="button button--secondary" href="{{ route('admin.roof-racks.vehicle-makes.attach-form') }}">Привязать существующую</a>
                    <a class="button button--primary button--inline" href="{{ route('admin.roof-racks.vehicle-makes.create') }}">Добавить марку</a>
                </div>
            </div>

            <form class="toolbar" method="GET">
                <label class="visually-hidden" for="search">Поиск марки</label>
                <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Поиск по названию или URL">
                <button class="button button--secondary" type="submit">Найти</button>
                @if (request()->filled('search'))
                    <a class="text-link" href="{{ route('admin.roof-racks.vehicle-makes.index') }}">Сбросить</a>
                @endif
            </form>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Марка</th>
                            <th>URL</th>
                            <th>Моделей</th>
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
                                    <a class="text-link" href="{{ route('admin.roof-racks.vehicle-models.index', $vehicleMake) }}">
                                        {{ $vehicleMake->models_count }}
                                    </a>
                                </td>
                                <td><span class="status {{ $vehicleMake->is_active ? 'status--active' : 'status--inactive' }}">{{ $vehicleMake->is_active ? 'Опубликована' : 'Скрыта' }}</span></td>
                                <td>
                                    <div class="row-actions">
                                        <a class="text-link" href="{{ route('admin.roof-racks.vehicle-models.index', $vehicleMake) }}">Модели</a>
                                        <a class="text-link" href="{{ route('admin.roof-racks.vehicle-makes.edit', $vehicleMake) }}">Изменить</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-state">Марки не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $vehicleMakes])
        </main>
    </div>
@endsection
