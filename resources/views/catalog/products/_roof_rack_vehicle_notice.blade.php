@if ($selectedVehicle)
    @php
        $roofRackQuery = request()->except(['page', 'show_all']);
        $catalogUrl = route('catalog.autobagazhniki.index', $roofRackQuery);
        $allRoofRacksUrl = route('catalog.autobagazhniki.index', $roofRackQuery + ['show_all' => 1]);
    @endphp
    <section class="vehicle-filter-notice">
        @if ($showAllRoofRacks ?? false)
            <p>Показаны все багажники. Совместимость отмечена для {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}.</p>
            <a class="button button__buy" href="{{ $catalogUrl }}#roof-rack-products">Показать только подходящие</a>
        @else
            <p>Список отфильтрован по выбранному автомобилю. Если вы покупаете багажник для другой машины, откройте весь каталог.</p>
            <a class="button button__buy" href="{{ $allRoofRacksUrl }}#roof-rack-products">Показать все багажники</a>
        @endif
        <a href="{{ route('catalog.vehicle-fitment.index') }}">Изменить автомобиль</a>
    </section>
@endif
