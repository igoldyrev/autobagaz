@php
    $generationTitle = $currentGeneration->display_name === $currentGeneration->year_label
        ? $currentGeneration->display_name
        : trim($currentGeneration->display_name.' '.$currentGeneration->year_label);
    $pageTitle = "Багажники для {$currentCategory->name} {$currentModel->name} {$generationTitle}";
@endphp

@extends('layouts.catalog')

@section('title', $pageTitle)
@section('meta_description', $pageTitle)

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="{{ route('catalog.autobagazhniki.index') }}">{{ $rootCategory->name }}</a>&#8594;
        <a class="breadcrumbs__link" href="{{ route('catalog.autobagazhniki.show', $currentCategory->slug) }}">{{ $currentCategory->name }}</a>&#8594;
        <a class="breadcrumbs__link" href="{{ route('catalog.autobagazhniki.model.show', [$currentCategory->slug, $currentModel->slug]) }}">{{ $currentModel->name }}</a>&#8594;
        <span class="breadcrumbs__text">{{ $generationTitle }}</span>
    </nav>

    <h1 class="title title-h1">{{ $pageTitle }}</h1>

    @if ($configurations->isNotEmpty())
        <section aria-label="Конфигурации {{ $currentModel->name }} {{ $generationTitle }}">
            <div class="catalog-categories vehicle-body-types-grid">
                @foreach ($configurations as $configuration)
                    <a
                        class="catalog-category catalog-category--image vehicle-body-card {{ $currentGeneration->image_path ? '' : 'vehicle-body-card--without-image' }}"
                        href="{{ route('catalog.autobagazhniki.configuration.show', [$currentCategory->slug, $currentModel->slug, $currentGeneration->slug, $configuration->slug]) }}"
                        data-configuration-card
                    >
                        @if ($currentGeneration->image_path)
                            <img
                                class="catalog-category__image catalog-category__image--provided"
                                src="{{ asset($currentGeneration->image_path) }}"
                                alt="{{ $currentGeneration->image_alt ?: $currentCategory->name.' '.$currentModel->name.' — '.$generationTitle }}"
                                width="100"
                                height="100"
                                loading="lazy"
                            >
                        @endif
                        <span class="catalog-category__name">{{ $configuration->display_name }}</span>
                        <span>{{ $configuration->year_label }}@if($configuration->roofType) · {{ $configuration->roofType->name }}@endif</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if ($unfilteredProductCount > 0)
        @include('catalog.products._filters', ['horizontal' => true])
        @include('catalog.products._filtered_results')
    @else
        <div class="records-placeholder records-placeholder--list body-type-products-empty">
            <p>Для этого поколения товары пока не добавлены</p>
        </div>
    @endif
@endsection
