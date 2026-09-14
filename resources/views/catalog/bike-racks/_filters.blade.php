<form class="catalog-filters {{ ($horizontal ?? false) ? 'catalog-filters--horizontal' : '' }}" method="get" action="{{ url()->current() }}">
    <div class="catalog-filters__header">
        <h2>Фильтры товаров</h2>
        @if (request()->query())
            <a href="{{ url()->current() }}">Сбросить</a>
        @endif
    </div>

    @if ($filterOptions['manufacturers']->isNotEmpty())
        <fieldset class="catalog-filter">
            <legend>Производитель</legend>
            @foreach ($filterOptions['manufacturers'] as $manufacturer)
                <label><input type="checkbox" name="manufacturer[]" value="{{ $manufacturer->id }}" @checked(in_array((string) $manufacturer->id, $filters['manufacturers'], true))> {{ $manufacturer->name }}</label>
            @endforeach
        </fieldset>
    @endif

    <fieldset class="catalog-filter catalog-filter--price">
        <legend>Цена, ₽</legend>
        <label><span>от</span><input type="number" name="price_from" min="0" step="0.01" value="{{ $filters['price_from'] }}" placeholder="{{ $filterOptions['price_min'] !== null ? number_format((float) $filterOptions['price_min'], 0, '.', '') : '' }}"></label>
        <label><span>до</span><input type="number" name="price_to" min="0" step="0.01" value="{{ $filters['price_to'] }}" placeholder="{{ $filterOptions['price_max'] !== null ? number_format((float) $filterOptions['price_max'], 0, '.', '') : '' }}"></label>
    </fieldset>

    <fieldset class="catalog-filter">
        <legend>Товар</legend>
        <label><input type="checkbox" name="availability[]" value="in_stock" @checked(in_array('in_stock', $filters['availability'], true))> В наличии</label>
        <label><input type="checkbox" name="availability[]" value="to_order" @checked(in_array('to_order', $filters['availability'], true))> Под заказ</label>
    </fieldset>

    @php
        $filterDefinitions = [
            ['option' => 'mounting_types', 'filter' => 'mounting_types', 'name' => 'mounting_type', 'label' => 'Тип крепления', 'numeric' => false],
            ['option' => 'bike_capacities', 'filter' => 'bike_capacities', 'name' => 'bike_capacity', 'label' => 'Вместимость, велосипедов', 'numeric' => true],
            ['option' => 'load_capacities', 'filter' => 'load_capacities', 'name' => 'load_capacity', 'label' => 'Грузоподъёмность, кг', 'numeric' => true],
        ];
    @endphp

    @foreach ($filterDefinitions as $filter)
        @if ($filterOptions[$filter['option']]->isNotEmpty())
            <fieldset class="catalog-filter">
                <legend>{{ $filter['label'] }}</legend>
                @foreach ($filterOptions[$filter['option']] as $value)
                    <label><input type="checkbox" name="{{ $filter['name'] }}[]" value="{{ $value }}" @checked(in_array((string) $value, $filters[$filter['filter']], true))> {{ $filter['numeric'] ? rtrim(rtrim(number_format((float) $value, 1, ',', ' '), '0'), ',') : $value }}</label>
                @endforeach
            </fieldset>
        @endif
    @endforeach

    <button class="catalog-filters__submit" type="submit">Показать</button>
</form>
