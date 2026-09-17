<div class="catalog-products-results">
    @include('catalog.products._toolbar')
    @if ($products->isNotEmpty())
        @include('catalog.products._grid', ['products' => $products])
    @else
        <div class="records-placeholder records-placeholder--list">
            <p>По выбранным параметрам товаров не найдено</p>
        </div>
    @endif
</div>
