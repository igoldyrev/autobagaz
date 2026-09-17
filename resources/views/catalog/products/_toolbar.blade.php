@php
    $filterDefinitions = [
        ['filter' => 'manufacturers', 'query' => 'manufacturer', 'prefix' => '', 'suffix' => '', 'option' => 'manufacturers'],
        ['filter' => 'availability', 'query' => 'availability', 'prefix' => '', 'suffix' => ''],
        ['filter' => 'bar_types', 'query' => 'bar_type', 'prefix' => '', 'suffix' => ''],
        ['filter' => 'bar_lengths', 'query' => 'bar_length', 'prefix' => 'Длина дуги: ', 'suffix' => ' см'],
        ['filter' => 'load_capacities', 'query' => 'load_capacity', 'prefix' => 'Нагрузка: ', 'suffix' => ' кг'],
        ['filter' => 'lengths', 'query' => 'length', 'prefix' => 'Длина: ', 'suffix' => ' см'],
        ['filter' => 'widths', 'query' => 'width', 'prefix' => 'Ширина: ', 'suffix' => ' см'],
        ['filter' => 'heights', 'query' => 'height', 'prefix' => 'Высота: ', 'suffix' => ' см'],
        ['filter' => 'volumes', 'query' => 'volume', 'prefix' => 'Объём: ', 'suffix' => ' л'],
        ['filter' => 'opening_types', 'query' => 'opening_type', 'prefix' => '', 'suffix' => ''],
        ['filter' => 'mounting_types', 'query' => 'mounting_type', 'prefix' => '', 'suffix' => ''],
        ['filter' => 'colors', 'query' => 'box_color', 'prefix' => '', 'suffix' => ''],
        ['filter' => 'bike_capacities', 'query' => 'bike_capacity', 'prefix' => 'Вместимость: ', 'suffix' => ' вел.'],
        ['filter' => 'ski_pairs', 'query' => 'ski_pairs', 'prefix' => 'Вместимость: ', 'suffix' => ' пар лыж'],
        ['filter' => 'snowboards', 'query' => 'snowboard', 'prefix' => 'Вместимость: ', 'suffix' => ' сноубордов'],
    ];
    $chips = [];
    foreach ($filterDefinitions as $definition) {
        foreach ($filters[$definition['filter']] ?? [] as $value) {
            $label = $value;
            if ($definition['filter'] === 'manufacturers') {
                $label = $filterOptions['manufacturers']->firstWhere('id', (int) $value)?->name ?? $value;
            } elseif ($definition['filter'] === 'availability') {
                $label = $value === 'in_stock' ? 'В наличии' : 'Под заказ';
            } elseif (is_numeric($value) && $definition['suffix'] !== '') {
                $label = rtrim(rtrim(number_format((float) $value, 1, ',', ' '), '0'), ',');
            }
            $query = request()->query();
            unset($query['page']);
            $query[$definition['query']] = array_values(array_filter((array) ($query[$definition['query']] ?? []), fn ($item) => (string) $item !== (string) $value));
            if ($query[$definition['query']] === []) unset($query[$definition['query']]);
            $chips[] = ['label' => $definition['prefix'].$label.$definition['suffix'], 'url' => url()->current().($query ? '?'.http_build_query($query) : '')];
        }
    }
    foreach (['price_from' => 'от ', 'price_to' => 'до '] as $parameter => $prefix) {
        if (($filters[$parameter] ?? null) !== null) {
            $query = request()->query(); unset($query['page'], $query[$parameter]);
            $chips[] = ['label' => $prefix.number_format((float) $filters[$parameter], 0, ',', ' ').' ₽', 'url' => url()->current().($query ? '?'.http_build_query($query) : '')];
        }
    }
    $resetQuery = array_intersect_key(request()->query(), array_flip(['vehicle_configuration_id', 'vehicle_year']));
    $resetUrl = url()->current().($resetQuery ? '?'.http_build_query($resetQuery) : '');
    $count = method_exists($products, 'total') ? $products->total() : $products->count();
@endphp

<div class="catalog-toolbar">
    <p class="catalog-products-results__count" aria-label="Найдено товаров: {{ $count }}">Найдено: {{ $count }} товаров</p>
    <form class="catalog-toolbar__sort" method="get" action="{{ url()->current() }}">
        @foreach (request()->except(['sort', 'page']) as $name => $value)
            @foreach (is_array($value) ? $value : [$value] as $item)
                <input type="hidden" name="{{ $name }}{{ is_array($value) ? '[]' : '' }}" value="{{ $item }}">
            @endforeach
        @endforeach
        <label for="catalog-sort">Сортировать:</label>
        <select id="catalog-sort" name="sort" onchange="this.form.submit()">
            <option value="popular" @selected($filters['sort'] === 'popular')>Популярные</option>
            <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Сначала дешевле</option>
            <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Сначала дороже</option>
            <option value="in_stock" @selected($filters['sort'] === 'in_stock')>Сначала в наличии</option>
        </select>
        <button type="submit">Применить</button>
    </form>
</div>

@if ($chips)
    <div class="catalog-active-filters" aria-label="Активные фильтры">
        @foreach ($chips as $chip)<a href="{{ $chip['url'] }}">{{ $chip['label'] }} <span aria-label="Убрать фильтр">×</span></a>@endforeach
        <a class="catalog-active-filters__reset" href="{{ $resetUrl }}">Сбросить всё</a>
    </div>
@endif
