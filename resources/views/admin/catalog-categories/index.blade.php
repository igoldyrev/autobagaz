@extends('layouts.admin')

@section('title', 'Разделы и категории')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Структура каталога</p>
                    <h1>Разделы и категории</h1>
                    <p class="admin-content__lead">Категории скрываются флагом публикации и остаются в базе вместе с привязками товаров.</p>
                </div>
                <a class="button button--primary button--inline" href="{{ route('admin.catalog-categories.create') }}">Добавить категорию</a>
            </div>

            <form class="toolbar" method="GET">
                <label class="visually-hidden" for="search">Поиск</label>
                <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Название или URL">
                <button class="button button--secondary" type="submit">Найти</button>
                @if (request()->filled('search'))
                    <a class="text-link" href="{{ route('admin.catalog-categories.index') }}">Сбросить</a>
                @endif
            </form>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr><th>Название</th><th>Тип</th><th>Родитель</th><th>Товаров</th><th>Статус</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td><strong>{{ $category->name }}</strong><br><code>{{ $category->slug }}</code></td>
                                <td>{{ ['section' => 'Раздел', 'category' => 'Категория', 'special' => 'Спецкатегория'][$category->kind] ?? $category->kind }}</td>
                                <td>{{ $category->parent?->name ?? '—' }}</td>
                                <td>{{ $category->products_count }}</td>
                                <td><span class="status {{ $category->is_active ? 'status--active' : 'status--inactive' }}">{{ $category->is_active ? 'Опубликована' : 'Скрыта' }}</span></td>
                                <td><a class="text-link" href="{{ route('admin.catalog-categories.edit', $category) }}">Изменить</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="empty-state">Категории не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $categories])
        </main>
    </div>
@endsection
