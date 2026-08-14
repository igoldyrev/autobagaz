@php
    $pageTitle = "Багажники для {$currentCategory->name} {$currentModel->name}";
@endphp

@extends('layouts.catalog')

@section('title', $currentModel->meta_title ?: $pageTitle)
@section('meta_description', $currentModel->meta_description ?: $pageTitle)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="{{ route('catalog.autobagazhniki.index') }}">{{ $rootCategory->name }}</a>&#8594;
        <a class="breadcrumbs__link" href="{{ route('catalog.autobagazhniki.show', $currentCategory->slug) }}">{{ $currentCategory->name }}</a>&#8594;
        <span class="breadcrumbs__text">{{ $currentModel->name }}</span>
    </nav>

    <h1 class="title title-h1">{{ $pageTitle }}</h1>

    @if ($unfilteredProductCount > 0)
        @include('catalog.products._filters', ['horizontal' => true])
        @include('catalog.products._filtered_results')
    @else
    <div class="catalog-category-hero">
        <img
            class="catalog-category-hero__image catalog-category-hero__image--provided"
            src="{{ asset($currentModel->image_path) }}"
            alt="{{ $currentModel->image_alt ?: $currentCategory->name.' '.$currentModel->name }}"
            width="100"
            height="100"
        >
        <div>
            <p class="text">Товары для этой модели автомобиля будут добавлены на следующем этапе.</p>
            <div class="records-placeholder records-placeholder--list"><p>Нет записей</p></div>
            <a class="link-green" href="{{ route('catalog.autobagazhniki.show', $currentCategory->slug) }}">Вернуться к моделям {{ $currentCategory->name }}</a>
        </div>
    </div>
    @endif
@endsection
