@extends('layouts.catalog')

@section('title', 'Подбор товаров по автомобилю')
@section('meta_description', 'Подберите автобагажники и аксессуары по марке, модели и кузову автомобиля.')

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">Подбор по автомобилю</span>
    </nav>

    @include('catalog.vehicle-fitment._picker')

    @if ($bodyType)
        <section class="vehicle-fitment-results" aria-label="Результаты подбора">
            <h2>Товары для: {{ $make->name }} {{ $model->name }} — {{ $bodyType->source_name ?: $bodyType->name }}</h2>

            <h2>Автобагажники</h2>
            @if ($baseProducts->isNotEmpty())
                @include('catalog.products._grid', ['products' => $baseProducts])
            @else
                <div class="records-placeholder records-placeholder--list"><p>Для этого автомобиля автобагажники пока не добавлены.</p></div>
            @endif

            @if ($dependentProducts->isNotEmpty())
                <h2>Автомобильные боксы</h2>
                @include('catalog.products._grid', ['products' => $dependentProducts])
            @endif
        </section>
    @endif
@endsection
