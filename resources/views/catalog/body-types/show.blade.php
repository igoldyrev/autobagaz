@php
    $fitmentTitle = $currentBodyType->source_name ?: $currentModel->name.' '.$currentBodyType->name;
    $pageTitle = "Багажники для {$currentCategory->name} {$fitmentTitle}";
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
        <span class="breadcrumbs__text">{{ $currentBodyType->name }}</span>
    </nav>

    <h1 class="title title-h1">{{ $pageTitle }}</h1>

    <section class="body-type-summary" aria-label="Выбранный кузов">
        @if ($currentBodyType->image_path)
            <img
                src="{{ asset($currentBodyType->image_path) }}"
                alt="{{ $currentBodyType->image_alt ?: $currentCategory->name.' '.$fitmentTitle }}"
                width="220"
                height="150"
            >
        @endif
        <div>
            <h2>{{ $fitmentTitle }}</h2>
            <dl>
                <div><dt>Кузов</dt><dd>{{ $currentBodyType->name }}</dd></div>
                @if ($currentBodyType->year_label)
                    <div><dt>Годы выпуска</dt><dd>{{ $currentBodyType->year_label }}</dd></div>
                @endif
                @if ($currentBodyType->mounting_type)
                    <div><dt>Крепление</dt><dd>{{ $currentBodyType->mounting_type }}</dd></div>
                @endif
            </dl>
            <a class="link-green" href="{{ route('catalog.autobagazhniki.model.show', [$currentCategory->slug, $currentModel->slug]) }}">Выбрать другой кузов</a>
        </div>
    </section>

    @if ($unfilteredProductCount > 0)
        @include('catalog.products._filters', ['horizontal' => true])
        @include('catalog.products._filtered_results')
    @else
        <div class="records-placeholder records-placeholder--list body-type-products-empty">
            <p>Для выбранного кузова товары пока не добавлены</p>
        </div>
    @endif
@endsection
