@extends('layouts.admin')

@section('title', 'Автобагажники')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Товары · отдельный тип</p>
                    <h1>Автобагажники</h1>
                    <p class="admin-content__lead">Список содержит только автобагажники. Их особенные характеристики хранятся отдельно от остальных типов товаров.</p>
                </div>
                <div class="heading-actions">
                    <a class="button button--secondary" href="{{ route('admin.products.roof-racks.manufacturers.index') }}">Производители</a>
                    <a class="button button--primary button--inline" href="{{ route('admin.products.roof-racks.create') }}">Добавить автобагажник</a>
                </div>
            </div>

            <form class="toolbar" method="GET">
                <label class="visually-hidden" for="search">Поиск товара</label>
                <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Название товара">
                <select name="status" aria-label="Статус публикации">
                    <option value="">Все статусы</option>
                    <option value="active" @selected(request('status') === 'active')>Опубликованные</option>
                    <option value="hidden" @selected(request('status') === 'hidden')>Скрытые</option>
                </select>
                <button class="button button--secondary" type="submit">Применить</button>
            </form>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Товар</th><th>Цена</th><th>Остаток</th><th>Привязки</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <div class="entity-title">
                                        @if ($product->images->first())
                                            <img src="{{ asset($product->images->first()->path) }}" alt="" width="48" height="48">
                                        @else
                                            <span class="entity-title__placeholder" aria-hidden="true">{{ mb_substr($product->name, 0, 1) }}</span>
                                        @endif
                                        <strong>{{ $product->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ number_format((float) $product->price, 2, ',', ' ') }} ₽</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->categories_count }} кат. / {{ $product->vehicle_models_count }} мод. / {{ $product->vehicle_body_types_count }} куз.</td>
                                <td><span class="status {{ $product->is_active ? 'status--active' : 'status--inactive' }}">{{ $product->is_active ? 'Опубликован' : 'Скрыт' }}</span></td>
                                <td>
                                    <div class="row-actions">
                                        <a class="text-link" href="{{ route('admin.products.roof-racks.create', ['copy_fitment_from' => $product->id]) }}">Повторить применимость</a>
                                        <a class="text-link" href="{{ route('admin.products.roof-racks.edit', $product) }}">Изменить</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="empty-state">Товары не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $products])
        </main>
    </div>
@endsection
