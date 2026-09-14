@extends('layouts.catalog')

@section('title', $section->meta_title ?: $section->name)
@section('meta_description', $section->meta_description ?: $section->description)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594; <span class="breadcrumbs__text">{{ $section->name }}</span></nav>
    <h1 class="title title-h1">{{ $section->name }}</h1>
    @if ($selectedVehicle)<section class="vehicle-filter-notice">Велокрепления универсальны и подходят для {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}. <a href="{{ route('catalog.vehicle-fitment.index') }}">Изменить автомобиль</a></section>@endif
    @if ($unfilteredProductCount > 0)<div class="catalog-products-results--section">@include('catalog.bike-racks._filters', ['horizontal' => true])<div class="catalog-products-results"><p class="catalog-products-results__count">Найдено товаров: {{ $products->total() }}</p>@if ($products->isNotEmpty())@include('catalog.products._grid', ['products' => $products])@include('catalog.products._pagination', ['paginator' => $products])@else<div class="records-placeholder records-placeholder--list"><p>По выбранным параметрам товаров не найдено.</p></div>@endif</div></div>@else<div class="records-placeholder records-placeholder--list"><p>В этом разделе пока нет товаров.</p></div>@endif
    <section class="auto-boxes-description" aria-label="О велокреплениях">
        <h2 class="title title-h3">Сколько велосипедов влезает в ваш автомобиль?</h2>
        <p class="text">Велосипед, как средство передвижения, дает своему владельцу ни с чем не сравнимое чувство свободы – свободы от пробок, заправок, даже от дорог. Ведь любая тропинка в лесу, в парке, а иногда и бездорожье – для велосипедиста подчас лучше пыльной, забитой машинами, трассы. Тем не менее, любой велосипедист рано или поздно сталкивается с необходимостью перевозки двухколесного друга, в том числе, и на автомобиле. Ведь самый чистый воздух, самые интересные маршруты находятся вдали от города.</p>
        <p class="text">Сразу оговоримся, что перевозка велосипеда в багажном отсеке, пусть даже большом – далеко не лучшее решение этой проблемы. Неудобно это, высока вероятность повредить, испачкать салон. Гораздо лучше воспользоваться специальными приспособлениями для транспортировки велосипеда – автомобильными велобагажниками, или, правильнее, автомобильными велокреплениями.</p>
        <p class="text">Условно, все велокрепления можно разделить на несколько типов по способу их установки на автомобиль.</p>
    </section>
@endsection
