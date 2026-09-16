@extends('layouts.catalog')

@section('title', $rootCategory->meta_title ?: $rootCategory->name)
@section('meta_description', $rootCategory->meta_description ?: $rootCategory->description)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">{{ $rootCategory->name }}</span>
    </nav>

    <h1 class="title title-h1">
        {{ $selectedVehicle
            ? 'Багажники для '.$selectedVehicle->labelForYear($selectedVehicleYear)
            : 'Багажники на крышу автомобиля' }}
    </h1>

    @if ($selectedVehicle)
        <section class="vehicle-filter-notice">
            Показаны товары, совместимость которых подтверждена для выбранной конфигурации.
            <a href="{{ route('catalog.vehicle-fitment.index') }}">Изменить автомобиль</a>
        </section>

        @if ($unfilteredProductCount > 0)
            <div class="catalog-products-results--section">
                @include('catalog.products._filters', ['horizontal' => true])
                @include('catalog.products._filtered_results')
            </div>
        @else
            <div class="records-placeholder records-placeholder--list">
                <p>Для выбранного автомобиля подтверждённо совместимые багажники пока не добавлены.</p>
            </div>
        @endif

        <h2 class="title title-h2">Подбор по марке автомобиля</h2>
    @endif

    <section class="brand-picker" data-brand-picker aria-label="Поиск марки автомобиля">
        <label class="model-picker__search" for="brand-search">
            <span class="sr-only">Поиск марки автомобиля</span>
            <i class="fa fa-search" aria-hidden="true"></i>
            <input id="brand-search" type="search" placeholder="Начните вводить название марки" autocomplete="off" data-brand-search>
        </label>
        <p class="model-picker__empty" data-brand-empty hidden aria-live="polite">Марки по вашему запросу не найдены.</p>

        <div class="catalog-categories brand-picker__grid">
            @foreach ($categories as $category)
                @php
                    $usesPlaceholder = str_ends_with($category->image_path, 'category-background.webp');
                @endphp
                <a
                    class="catalog-category {{ $usesPlaceholder ? 'catalog-category--placeholder' : 'catalog-category--image' }}"
                    href="{{ route('catalog.autobagazhniki.show', $category->slug) }}"
                    data-category-card
                    data-brand-name="{{ mb_strtolower($category->name) }}"
                >
                    <img
                        class="catalog-category__image {{ $usesPlaceholder ? '' : 'catalog-category__image--provided' }}"
                        src="{{ asset($category->image_path) }}"
                        alt="{{ $category->image_alt ?: $category->name }}"
                        width="720"
                        height="480"
                        loading="lazy"
                    >
                    @if ($usesPlaceholder)
                        <span class="catalog-category__overlay" aria-hidden="true"></span>
                    @endif
                    <span class="catalog-category__name">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>
@endsection
