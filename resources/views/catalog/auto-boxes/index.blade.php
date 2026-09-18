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
                @include('catalog.products._toolbar')
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

    <section class="catalog-selection-guide" aria-labelledby="auto-boxes-selection-guide-title">
        <h2 class="title title-h3" id="auto-boxes-selection-guide-title">Как выбрать автобокс</h2>
        <dl class="catalog-selection-guide__options">
            <div><dt>До 350 л</dt><dd>компактный вариант для повседневных вещей и коротких поездок.</dd></div>
            <div><dt>400–450 л</dt><dd>семейный объём для путешествий и отдыха за городом.</dd></div>
            <div><dt>Более 450 л</dt><dd>для большого багажа, колясок и длительных поездок.</dd></div>
        </dl>
        <p class="text">Для лыж и сноубордов учитывайте внутреннюю длину бокса. Перед покупкой также проверьте грузоподъёмность поперечин и крыши автомобиля.</p>
        <a class="link-green catalog-selection-guide__action" href="{{ route('contacts') }}">Помочь с выбором</a>
    </section>
@endsection
