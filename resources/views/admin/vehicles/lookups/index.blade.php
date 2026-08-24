@extends('layouts.admin')

@section('title', $title)

@section('body')
<div class="admin-shell">
    @include('admin.partials.header')
    <main class="admin-content admin-content--wide">
        @include('admin.partials.flash')
        <nav class="admin-breadcrumbs"><a href="{{ route('admin.vehicles.vehicle-makes.index') }}">Автомобили</a><span>/</span><span>{{ $title }}</span></nav>
        <div class="page-heading">
            <div><p class="eyebrow">{{ $eyebrow }}</p><h1>{{ $title }}</h1><p class="admin-content__lead">Нормализованный справочник для конфигураций автомобилей.</p></div>
            <a class="button button--primary button--inline" href="{{ route($routePrefix.'.create') }}">Добавить {{ $singular }}</a>
        </div>
        <form class="toolbar" method="GET">
            <input name="search" type="search" value="{{ request('search') }}" placeholder="Поиск по названию">
            <button class="button button--secondary" type="submit">Найти</button>
        </form>
        <div class="table-wrap"><table class="admin-table">
            <thead><tr><th>Название</th><th>URL</th><th>Порядок</th><th>Конфигурации</th><th>Статус</th><th></th></tr></thead>
            <tbody>
            @forelse($items as $item)
                <tr><td><strong>{{ $item->name }}</strong></td><td><code>{{ $item->slug }}</code></td><td>{{ $item->sort_order }}</td><td>{{ $item->configurations_count }}</td><td><span class="status {{ $item->is_active ? 'status--active' : 'status--inactive' }}">{{ $item->is_active ? 'Активен' : 'Скрыт' }}</span></td><td><a class="text-link" href="{{ route($routePrefix.'.edit', [$routeParameter => $item]) }}">Изменить</a></td></tr>
            @empty
                <tr><td colspan="6" class="empty-state">Записи не найдены.</td></tr>
            @endforelse
            </tbody>
        </table></div>
        @include('admin.partials.pagination', ['paginator' => $items])
    </main>
</div>
@endsection
