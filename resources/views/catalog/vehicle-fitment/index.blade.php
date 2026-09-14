@extends('layouts.catalog')

@section('title', 'Подбор товаров по автомобилю')
@section('meta_description', 'Подберите автобагажники и аксессуары по марке, модели и кузову автомобиля.')

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">Подбор по автомобилю</span>
    </nav>

    @include('catalog.vehicle-fitment._picker')

    @if ($selectedVehicle)
        <section class="vehicle-fitment-results" aria-label="Результаты подбора">
            <h2>Подходит для {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}</h2>
            <p class="vehicle-fitment-results__configuration">
                {{ $selectedVehicle->generation->display_name }} · {{ $selectedVehicle->bodyStyle?->name ?: 'кузов не указан' }} · {{ $selectedVehicle->roofType?->name ?: 'крыша не указана' }}
            </p>

            <div class="vehicle-result-categories">
                @foreach ($categoryResults as $categoryResult)
                    <a class="vehicle-result-category" href="{{ $categoryResult['url'] }}">
                        <span>{{ $categoryResult['name'] }}</span>
                        <strong>{{ $categoryResult['count'] }}</strong>
                    </a>
                @endforeach
            </div>

            <h2 id="roof-racks">Автобагажники</h2>
            @if ($baseProducts->isNotEmpty())
                @include('catalog.products._grid', ['products' => $baseProducts])
            @else
                <div class="records-placeholder records-placeholder--list"><p>Для этой конфигурации пока нет подтверждённо совместимых автобагажников.</p></div>
            @endif

            <h2 id="auto-boxes">Автомобильные боксы</h2>
            @if ($dependentProducts->isNotEmpty())
                @include('catalog.products._grid', ['products' => $dependentProducts])
            @else
                <div class="records-placeholder records-placeholder--list"><p>В каталоге пока нет доступных автобоксов.</p></div>
            @endif
        </section>
    @endif
@endsection
