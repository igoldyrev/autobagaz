@extends('layouts.admin')

@section('title', 'Модели '.$vehicleMake->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.vehicles.vehicle-makes.index') }}">Марки</a><span>/</span><span>{{ $vehicleMake->name }}</span>
            </nav>

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Модели автомобилей</p>
                    <h1>{{ $vehicleMake->name }}</h1>
                    <p class="admin-content__lead">Модели относятся к общему справочнику марки и могут использоваться во всех разделах сайта.</p>
                </div>
                <a class="button button--primary button--inline" href="{{ route('admin.vehicles.vehicle-models.create', $vehicleMake) }}">Добавить модель</a>
            </div>

            <form class="toolbar" method="GET">
                <label class="visually-hidden" for="search">Поиск модели</label>
                <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Поиск по названию или URL">
                <button class="button button--secondary" type="submit">Найти</button>
                @if (request()->filled('search'))
                    <a class="text-link" href="{{ route('admin.vehicles.vehicle-models.index', $vehicleMake) }}">Сбросить</a>
                @endif
            </form>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Модель</th>
                            <th>URL</th>
                            <th>Порядок</th>
                            <th>Варианты</th>
                            <th>Статус</th>
                            <th><span class="visually-hidden">Действия</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicleModels as $vehicleModel)
                            <tr>
                                <td>
                                    <div class="entity-title">
                                        @if ($vehicleModel->image_path)
                                            <img src="{{ asset($vehicleModel->image_path) }}" alt="" width="48" height="48">
                                        @else
                                            <span class="entity-title__placeholder" aria-hidden="true">{{ mb_substr($vehicleModel->name, 0, 1) }}</span>
                                        @endif
                                        <strong>{{ $vehicleModel->name }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $vehicleModel->slug }}</code></td>
                                <td>{{ $vehicleModel->sort_order }}</td>
                                <td>{{ $vehicleModel->body_types_count }}</td>
                                <td><span class="status {{ $vehicleModel->is_active ? 'status--active' : 'status--inactive' }}">{{ $vehicleModel->is_active ? 'Опубликована' : 'Скрыта' }}</span></td>
                                <td><a class="text-link" href="{{ route('admin.vehicles.vehicle-models.edit', [$vehicleMake, $vehicleModel]) }}">Изменить</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="empty-state">Модели не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $vehicleModels])
        </main>
    </div>
@endsection
