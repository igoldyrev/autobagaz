@extends('layouts.catalog')

@section('title', $section->meta_title ?: $section->name)
@section('meta_description', $section->meta_description ?: $section->description)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">{{ $section->name }}</span>
    </nav>

    <h1 class="title title-h1">{{ $section->name }}</h1>

    @if ($selectedVehicle)
        <section class="vehicle-filter-notice">
            Автобоксы универсальны и подходят для {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}.
            <a href="{{ route('catalog.vehicle-fitment.index') }}">Изменить автомобиль</a>
        </section>
    @endif

    @if ($unfilteredProductCount > 0)
        <div class="catalog-products-results--section">
            @include('catalog.auto-boxes._filters', ['horizontal' => true])
            <div class="catalog-products-results">
                <p class="catalog-products-results__count">Найдено товаров: {{ $products->total() }}</p>
                @if ($products->isNotEmpty())
                    @include('catalog.products._grid', ['products' => $products])
                    @include('catalog.products._pagination', ['paginator' => $products])
                @else
                    <div class="records-placeholder records-placeholder--list">
                        <p>По выбранным параметрам товаров не найдено.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="catalog-products-results catalog-products-results--section">
            <div class="records-placeholder records-placeholder--list">
                <p>В этом разделе пока нет товаров.</p>
            </div>
        </div>
    @endif

    <section class="auto-boxes-description" aria-label="Об автомобильных боксах">
        <p class="text">Каким бы просторным ни был автомобиль, порой места в нем начинает не хватать. Поездка за город или возвращение из похода по магазинам превращается в акробатический номер с грузом на коленях и плотно упакованными пассажирами на задних сиденьях. А перевозка лыж или сноубордов вообще является ночным кошмаром автомобилиста. Добавить столь необходимый рабочий объем вашей машине могут автомобильные боксы.</p>
        <p class="text">Автобоксы являются простым и надежным средством увеличения вместительности автомобиля, и абсолютно незаменимы при возникновении необходимости перевозки грузов, требующих бережного обращения и надежной защиты от влаги, пыли и прочих негативных факторов окружающей среды. Изготовленные из современных высококачественных материалов, автомобильные боксы сочетают в себе высокую надежность крепления, оптимальные условия фиксации груза и необычайную легкость базовой конструкции, а система центрального замка с двухсторонним открыванием и многоточечным запиранием гарантирует безопасную эксплуатацию и высокую защиту от несанкционированного проникновения в бокс.</p>
    </section>
@endsection
