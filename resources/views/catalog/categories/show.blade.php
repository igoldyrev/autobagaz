@php
    $pageTitle = $isVehicleMake
        ? "Багажники для автомобилей {$currentCategory->name}"
        : $currentCategory->name;
@endphp

@extends('layouts.catalog')

@section('title', $currentCategory->meta_title ?: $pageTitle)
@section('meta_description', $currentCategory->meta_description ?: $pageTitle)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="{{ route('catalog.autobagazhniki.index') }}">{{ $rootCategory->name }}</a>&#8594;
        <span class="breadcrumbs__text">{{ $currentCategory->name }}</span>
    </nav>

    <h1 class="title title-h1">{{ $pageTitle }}</h1>

    @if ($models->isNotEmpty())
        <p class="text catalog-categories__intro">Выберите модель автомобиля {{ $currentCategory->name }}.</p>

        <div class="catalog-categories">
            @foreach ($models as $model)
                <a
                    class="catalog-category catalog-category--image"
                    href="{{ route('catalog.autobagazhniki.model.show', [$currentCategory->slug, $model->slug]) }}"
                    data-model-card
                >
                    <img
                        class="catalog-category__image catalog-category__image--provided"
                        src="{{ asset($model->image_path) }}"
                        alt="{{ $model->image_alt ?: $currentCategory->name.' '.$model->name }}"
                        width="100"
                        height="100"
                        loading="lazy"
                    >
                    <span class="catalog-category__name">{{ $model->name }}</span>
                </a>
            @endforeach
        </div>
    @elseif ($products->isNotEmpty())
        @include('catalog.products._grid', ['products' => $products])
    @else
        <div class="catalog-category-hero">
            <img
                class="catalog-category-hero__image {{ str_ends_with($currentCategory->image_path, 'category-background.webp') ? '' : 'catalog-category-hero__image--provided' }}"
                src="{{ asset($currentCategory->image_path) }}"
                alt="{{ $currentCategory->image_alt ?: $currentCategory->name }}"
                width="720"
                height="480"
            >
            <div>
                <p class="text">
                    Раздел подготовлен для каталога. Модели автомобилей и товары будут добавлены на следующем этапе.
                </p>
                <div class="records-placeholder records-placeholder--list"><p>Нет записей</p></div>
                <a class="link-green" href="{{ route('catalog.autobagazhniki.index') }}">Вернуться ко всем категориям</a>
            </div>
        </div>
    @endif
@endsection
