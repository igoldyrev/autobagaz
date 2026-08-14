<div class="catalog-products-results">
    <p class="catalog-products-results__count">Найдено товаров: {{ $products->count() }}</p>
    @if ($products->isNotEmpty())
        @include('catalog.products._grid', ['products' => $products])
    @else
        <div class="records-placeholder records-placeholder--list">
            <p>По выбранным параметрам товаров не найдено</p>
        </div>
    @endif
</div>
