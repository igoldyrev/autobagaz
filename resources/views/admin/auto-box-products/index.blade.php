@extends('layouts.admin')

@section('title', 'Автомобильные боксы')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Товары · отдельный тип</p>
                    <h1>Автомобильные боксы</h1>
                    <p class="admin-content__lead">Список содержит только автомобильные боксы и их профильные характеристики.</p>
                </div>
                <div class="heading-actions">
                    <a class="button button--secondary" href="{{ route('admin.products.auto-boxes.manufacturers.index') }}">Производители</a>
                    <a class="button button--primary button--inline" href="{{ route('admin.products.auto-boxes.create') }}">Добавить автомобильный бокс</a>
                </div>
            </div>

            @include('admin.partials.help', ['title' => 'Работа со списком', 'text' => 'Поиск проверяет название автомобильного бокса, а фильтр статуса отдельно показывает опубликованные или скрытые товары. Оба условия применяются одновременно.', 'items' => ['Производитель и объём в таблице помогают быстро проверить заполненность карточек.', 'Скрытый товар остаётся в базе со всеми характеристиками и фотографиями.', 'Автоматическая совместимость бокса зависит от заполненных ограничений крепления.']])

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
                    <thead><tr><th>Товар</th><th>Производитель</th><th>Цена</th><th>Остаток</th><th>Объём</th><th>Статус</th><th></th></tr></thead>
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
                                <td>{{ $product->autoBox->manufacturer?->name ?: '—' }}</td>
                                <td>{{ number_format((float) $product->price, 2, ',', ' ') }} ₽</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ filled($product->autoBox->volume_l) ? rtrim(rtrim(number_format((float) $product->autoBox->volume_l, 1, ',', ''), '0'), ',').' л' : '—' }}</td>
                                <td><span class="status {{ $product->is_active ? 'status--active' : 'status--inactive' }}">{{ $product->is_active ? 'Опубликован' : 'Скрыт' }}</span></td>
                                <td><a class="text-link" href="{{ route('admin.products.auto-boxes.edit', $product) }}">Изменить</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="empty-state">Товары не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $products])
        </main>
    </div>
@endsection
