@extends('layouts.catalog')

@section('title', $rootCategory->meta_title ?: $rootCategory->name)
@section('meta_description', $rootCategory->meta_description ?: $rootCategory->description)

@section('content')
    <x-breadcrumbs :items="[
        ['name' => 'Главная страница', 'url' => route('home')],
        ['name' => $rootCategory->name],
    ]" />

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
            <div class="catalog-products-results--section" id="roof-rack-products">
                @include('catalog.products._filters', ['horizontal' => true])
                @include('catalog.products._filtered_results')
                @include('catalog.products._pagination', ['paginator' => $products])
            </div>
        @else
            <div class="records-placeholder records-placeholder--list">
                <p>Для выбранного автомобиля подтверждённо совместимые багажники пока не добавлены.</p>
            </div>
        @endif

    @else
        <p class="text catalog-intro">Багажник подбирается под модель, год выпуска и тип крыши автомобиля. Выберите марку или воспользуйтесь <a href="{{ route('catalog.vehicle-fitment.index') }}">подбором по автомобилю</a>.</p>
    @endif

    <section class="brand-picker" data-brand-picker aria-label="Поиск марки автомобиля">
        <h2 class="title title-h2">Подбор по марке автомобиля</h2>
        <label class="model-picker__search" for="brand-search">
            <span class="sr-only">Поиск марки автомобиля</span>
            <i class="fa fa-search" aria-hidden="true"></i>
            <input id="brand-search" type="search" placeholder="Начните вводить название марки" autocomplete="off" data-brand-search>
        </label>
        <p class="model-picker__empty" data-brand-empty hidden aria-live="polite">Марки по вашему запросу не найдены.</p>

        <div class="catalog-categories brand-picker__grid" id="roof-rack-brands">
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
        <button class="brand-picker__toggle" type="button" data-brand-toggle aria-expanded="false" aria-controls="roof-rack-brands" hidden>Показать все марки</button>
    </section>

    @unless ($selectedVehicle)
        <section id="roof-rack-products" aria-labelledby="roof-rack-products-title">
            <h2 class="title title-h2" id="roof-rack-products-title">Каталог автобагажников</h2>
            <p class="text catalog-intro">Ниже представлен общий ассортимент. <a href="{{ route('catalog.vehicle-fitment.index') }}">Выберите автомобиль</a>, чтобы проверить совместимость.</p>
            @if ($unfilteredProductCount > 0)
                <div class="catalog-products-results--section">
                    @include('catalog.products._filters', ['horizontal' => true])
                    @include('catalog.products._filtered_results')
                    @include('catalog.products._pagination', ['paginator' => $products])
                </div>
            @else
                <div class="records-placeholder records-placeholder--list"><p>В этом разделе пока нет товаров.</p></div>
            @endif
        </section>
    @endunless

    <section class="catalog-selection-guide" aria-labelledby="roof-racks-selection-guide-title">
        <h2 class="title title-h3" id="roof-racks-selection-guide-title">Как выбрать багажник на крышу</h2>
        <dl class="catalog-selection-guide__options">
            <div><dt>Тип крыши</dt><dd>гладкая крыша, штатные места, открытые или интегрированные рейлинги требуют разных креплений. Учитывайте модель и год выпуска автомобиля.</dd></div>
            <div><dt>Тип дуг</dt><dd>прямоугольные дуги — базовый вариант. Аэродинамические и крыловидные профили обычно создают меньше шума. Проверьте совместимость профиля с креплением бокса или другого оборудования.</dd></div>
            <div><dt>Комплектность</dt><dd>уточните, входят ли в комплект поперечины, опоры и установочный комплект для вашего автомобиля.</dd></div>
        </dl>
        <p class="text">Перед установкой проверьте допустимую нагрузку на крышу по инструкции автомобиля и ограничения багажной системы. В общий вес входят сам багажник, установленное оборудование и груз; ориентируйтесь на наименьший из допустимых пределов.</p>
        <a class="link-green catalog-selection-guide__action" href="{{ route('contacts') }}">Помочь с подбором</a>
    </section>
@endsection
