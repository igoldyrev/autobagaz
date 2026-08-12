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
        Выберите марку автомобиля или отдельную категорию, чтобы перейти к моделям автомобилей.
    </p>

    <div class="catalog-categories">
        @foreach ($categories as $category)
            @php
                $usesPlaceholder = str_ends_with($category->image_path, 'category-background.webp');
            @endphp
            <a
                class="catalog-category {{ $usesPlaceholder ? 'catalog-category--placeholder' : 'catalog-category--image' }}"
                href="{{ route('catalog.autobagazhniki.show', $category->slug) }}"
                data-category-card
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
@endsection
