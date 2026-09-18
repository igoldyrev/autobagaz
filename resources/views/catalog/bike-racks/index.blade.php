@extends('layouts.catalog')

@section('title', $section->meta_title ?: $section->name)
@section('meta_description', $section->meta_description ?: $section->description)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594; <span class="breadcrumbs__text">{{ $section->name }}</span></nav>
    <h1 class="title title-h1">{{ $section->name }}</h1>
    @if ($selectedVehicle)<section class="vehicle-filter-notice">Велокрепления универсальны и подходят для {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}. <a href="{{ route('catalog.vehicle-fitment.index') }}">Изменить автомобиль</a></section>@endif
    @if ($unfilteredProductCount > 0)<div class="catalog-products-results--section">@include('catalog.bike-racks._filters', ['horizontal' => true])<div class="catalog-products-results">@include('catalog.products._toolbar')@if ($products->isNotEmpty())@include('catalog.products._grid', ['products' => $products])@include('catalog.products._pagination', ['paginator' => $products])@else<div class="records-placeholder records-placeholder--list"><p>По выбранным параметрам товаров не найдено.</p></div>@endif</div></div>@else<div class="records-placeholder records-placeholder--list"><p>В этом разделе пока нет товаров.</p></div>@endif
    <section class="catalog-selection-guide" aria-labelledby="bike-racks-selection-guide-title">
        <h2 class="title title-h3" id="bike-racks-selection-guide-title">Как выбрать велокрепление</h2>
        <dl class="catalog-selection-guide__options">
            <div><dt>На крышу</dt><dd>подходит для одного–трёх велосипедов, если уже установлены поперечины.</dd></div>
            <div><dt>На фаркоп</dt><dd>удобно для нескольких велосипедов и тяжёлых моделей.</dd></div>
            <div><dt>На заднюю дверь</dt><dd>вариант для автомобилей, конструкция которых допускает такое крепление.</dd></div>
        </dl>
        <p class="text">Учитывайте число и вес велосипедов, особенно электровелосипедов, а также возможность открыть багажник после установки крепления.</p>
        <a class="link-green catalog-selection-guide__action" href="{{ route('contacts') }}">Помочь с выбором</a>
    </section>
@endsection
