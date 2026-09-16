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
        @if ($unfilteredProductCount > 0)
            @include('catalog.products._filters', ['horizontal' => true])
        @endif

        <section class="model-picker" data-model-picker aria-label="Поиск модели {{ $currentCategory->name }}">
            <label class="model-picker__search" for="model-search">
                <span class="sr-only">Поиск модели {{ $currentCategory->name }}</span>
                <i class="fa fa-search" aria-hidden="true"></i>
                <input id="model-search" type="search" placeholder="Начните вводить название модели" autocomplete="off" data-model-search>
            </label>
            <p class="model-picker__empty" data-model-empty hidden aria-live="polite">Модели по вашему запросу не найдены.</p>

            @if ($popularModels->isNotEmpty())
                <div class="model-picker__popular" aria-label="Популярные модели">
                    <span>Популярные модели:</span>
                    @foreach ($popularModels as $model)
                        <a href="{{ route('catalog.autobagazhniki.model.show', [$currentCategory->slug, $model->slug]) }}">{{ $model->name }}</a>
                    @endforeach
                </div>
            @endif

            <details class="model-picker__all" data-model-list open>
                <summary>Все модели <span>({{ $models->count() }})</span></summary>
                <div class="catalog-categories model-picker__grid">
                    @foreach ($models as $model)
                        <a
                            class="catalog-category catalog-category--image"
                            href="{{ route('catalog.autobagazhniki.model.show', [$currentCategory->slug, $model->slug]) }}"
                            data-model-card
                            data-model-name="{{ mb_strtolower($model->name) }}"
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
            </details>
        </section>
        @if ($unfilteredProductCount > 0)
            @include('catalog.products._filtered_results')
        @endif
    @elseif ($unfilteredProductCount > 0)
        @include('catalog.products._filtered_list')
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
