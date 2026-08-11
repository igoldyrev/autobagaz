@extends('layouts.catalog')

@section('title', $rootCategory->meta_title ?: $rootCategory->name)
@section('meta_description', $rootCategory->meta_description ?: $rootCategory->description)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">{{ $rootCategory->name }}</span>
    </nav>

    <h1 class="title title-h1">Автобагажники по маркам автомобилей</h1>
    <p class="text catalog-categories__intro">
        Выберите марку автомобиля или отдельную категорию. Модели автомобилей и товары будут добавлены позже.
    </p>

    <div class="catalog-categories">
        @foreach ($categories as $category)
            <a
                class="catalog-category"
                href="{{ route('catalog.autobagazhniki.show', $category->slug) }}"
                data-category-card
            >
                <img
                    class="catalog-category__image"
                    src="{{ asset($category->image_path) }}"
                    alt="{{ $category->image_alt ?: $category->name }}"
                    width="720"
                    height="480"
                    loading="lazy"
                >
                <span class="catalog-category__overlay" aria-hidden="true"></span>
                <span class="catalog-category__kind">
                    {{ $category->kind === 'vehicle_make' ? 'Марка автомобиля' : 'Категория' }}
                </span>
                <span class="catalog-category__name">{{ $category->name }}</span>
            </a>
        @endforeach
    </div>
@endsection
