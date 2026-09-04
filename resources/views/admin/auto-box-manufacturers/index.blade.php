@extends('layouts.admin')

@section('title', 'Производители автомобильных боксов')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.products.index') }}">Товары</a><span>→</span>
                <a href="{{ route('admin.products.auto-boxes.index') }}">Автомобильные боксы</a><span>→</span>
                <span>Производители</span>
            </nav>

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Справочник автомобильных боксов</p>
                    <h1>Производители</h1>
                    <p class="admin-content__lead">Справочник используется только товарами раздела «Автомобильные боксы».</p>
                </div>
                <a class="button button--primary button--inline" href="{{ route('admin.products.auto-boxes.manufacturers.create') }}">Добавить производителя</a>
            </div>

            @include('admin.partials.help', ['title' => 'Как работает справочник', 'text' => 'Здесь хранятся производители только автомобильных боксов. Запись выбирается в карточке товара и используется в каталоге и фильтрах.', 'items' => ['Поиск проверяет название производителя.', 'Скрытого производителя нельзя выбрать для нового товара, но существующие связи сохраняются.', 'Перед добавлением проверьте, нет ли производителя с другим написанием.']])

            <form class="toolbar" method="GET">
                <label class="visually-hidden" for="search">Поиск производителя</label>
                <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Название производителя">
                <button class="button button--secondary" type="submit">Найти</button>
                @if (request()->filled('search'))
                    <a class="text-link" href="{{ route('admin.products.auto-boxes.manufacturers.index') }}">Сбросить</a>
                @endif
            </form>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Название</th><th>Товаров</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($manufacturers as $manufacturer)
                            <tr>
                                <td><strong>{{ $manufacturer->name }}</strong></td>
                                <td>{{ $manufacturer->auto_box_products_count }}</td>
                                <td><span class="status {{ $manufacturer->is_active ? 'status--active' : 'status--inactive' }}">{{ $manufacturer->is_active ? 'Активен' : 'Скрыт' }}</span></td>
                                <td><a class="text-link" href="{{ route('admin.products.auto-boxes.manufacturers.edit', $manufacturer) }}">Изменить</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">Производители не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $manufacturers])
        </main>
    </div>
@endsection
