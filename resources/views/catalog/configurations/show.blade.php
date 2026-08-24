@php
    $generationTitle = $currentGeneration->display_name === $currentGeneration->year_label
        ? $currentGeneration->display_name
        : trim($currentGeneration->display_name.' '.$currentGeneration->year_label);
    $pageTitle = "Багажники для {$currentCategory->name} {$currentModel->name} {$currentConfiguration->display_name}";
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
        <a class="breadcrumbs__link" href="{{ route('catalog.autobagazhniki.generation.show', [$currentCategory->slug, $currentModel->slug, $currentGeneration->slug]) }}">{{ $generationTitle }}</a>&#8594;
        <span class="breadcrumbs__text">{{ $currentConfiguration->display_name }}</span>
    </nav>

    <h1 class="title title-h1">{{ $pageTitle }}</h1>

    <section class="body-type-summary" aria-label="Выбранная конфигурация">
        @if ($currentGeneration->image_path)
            <img
                src="{{ asset($currentGeneration->image_path) }}"
                alt="{{ $currentGeneration->image_alt ?: $currentCategory->name.' '.$currentModel->name.' — '.$generationTitle }}"
                width="220"
                height="150"
            >
        @endif
        <div>
            <h2>{{ $currentConfiguration->display_name }}</h2>
            <dl>
                <div><dt>Поколение</dt><dd>{{ $generationTitle }}</dd></div>
                @if ($currentConfiguration->bodyStyle)
                    <div><dt>Кузов</dt><dd>{{ $currentConfiguration->bodyStyle->name }}</dd></div>
                @endif
                <div><dt>Годы выпуска</dt><dd>{{ $currentConfiguration->year_label }}</dd></div>
                @if ($currentConfiguration->roofType)
                    <div><dt>Крепление</dt><dd>{{ $currentConfiguration->roofType->name }}</dd></div>
                @endif
            </dl>
            <a class="link-green" href="{{ route('catalog.autobagazhniki.generation.show', [$currentCategory->slug, $currentModel->slug, $currentGeneration->slug]) }}">Выбрать другую конфигурацию</a>
        </div>
    </section>

    @if ($unfilteredProductCount > 0)
        @include('catalog.products._filters', ['horizontal' => true])
        @include('catalog.products._filtered_results')
    @else
        <div class="records-placeholder records-placeholder--list body-type-products-empty">
            <p>Для выбранной конфигурации товары пока не добавлены</p>
        </div>
    @endif
@endsection
