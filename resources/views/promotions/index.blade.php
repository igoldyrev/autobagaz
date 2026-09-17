@extends('layouts.catalog')

@section('title', 'Акции на автобагажники и автобоксы')
@section('meta_description', 'Актуальные акции на багажники, автобоксы и крепления для автомобиля в Перми.')

@section('content')
    <section class="promotions-page">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
            <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
            <span class="breadcrumbs__text">Акции</span>
        </nav>

        <header class="promotions-page__header">
            <h1 class="title title-h1">Акции</h1>
            <p>Актуальные предложения на багажники, автобоксы и крепления. Цена в карточке уже указана с учётом скидки.</p>
        </header>

        @if ($products->isNotEmpty())
            @include('catalog.products._grid', ['selectedVehicle' => null, 'selectedVehicleYear' => null])
            @include('catalog.products._pagination', ['paginator' => $products])
        @else
            <div class="promotions-page__empty">
                <h2>Сейчас активных акций нет</h2>
                <p>Следите за обновлениями каталога или выберите оборудование для своего автомобиля.</p>
                <a class="link-green" href="{{ route('catalog.vehicle-fitment.index') }}">Подобрать по авто</a>
            </div>
        @endif
    </section>
@endsection
