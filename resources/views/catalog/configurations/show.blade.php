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
    <x-breadcrumbs :items="[
        ['name' => 'Главная страница', 'url' => route('home')],
        ['name' => $rootCategory->name, 'url' => route('catalog.autobagazhniki.index')],
        ['name' => $currentCategory->name, 'url' => route('catalog.autobagazhniki.show', $currentCategory->slug)],
        ['name' => $currentModel->name, 'url' => route('catalog.autobagazhniki.model.show', [$currentCategory->slug, $currentModel->slug])],
        ['name' => $generationTitle, 'url' => route('catalog.autobagazhniki.generation.show', [$currentCategory->slug, $currentModel->slug, $currentGeneration->slug])],
        ['name' => $currentConfiguration->display_name],
    ]" />

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
