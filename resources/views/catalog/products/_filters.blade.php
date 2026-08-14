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

    @if ($filterOptions['load_capacities']->isNotEmpty())
        <fieldset class="catalog-filter">
            <legend>Нагрузка, кг</legend>
            @foreach ($filterOptions['load_capacities'] as $loadCapacity)
                <label><input type="checkbox" name="load_capacity[]" value="{{ $loadCapacity }}" @checked(in_array((string) $loadCapacity, $filters['load_capacities'], true))> {{ number_format((float) $loadCapacity, 1, ',', ' ') }}</label>
            @endforeach
        </fieldset>
    @endif

    @if ($filterOptions['bar_types']->isNotEmpty())
        <fieldset class="catalog-filter">
            <legend>Тип дуги</legend>
            @foreach ($filterOptions['bar_types'] as $barType)
                <label><input type="checkbox" name="bar_type[]" value="{{ $barType }}" @checked(in_array($barType, $filters['bar_types'], true))> {{ $barType }}</label>
            @endforeach
        </fieldset>
    @endif

    @if ($filterOptions['bar_lengths']->isNotEmpty())
        <fieldset class="catalog-filter">
            <legend>Длина дуги, см</legend>
            @foreach ($filterOptions['bar_lengths'] as $barLength)
                <label><input type="checkbox" name="bar_length[]" value="{{ $barLength }}" @checked(in_array((string) $barLength, $filters['bar_lengths'], true))> {{ number_format((float) $barLength, 1, ',', ' ') }}</label>
            @endforeach
        </fieldset>
    @endif

    <button class="catalog-filters__submit" type="submit">Показать</button>
</form>
