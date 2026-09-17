@extends('layouts.catalog')

@section('title', 'Установка багажных систем в Перми')
@section('meta_description', 'Профессиональная установка автомобильных багажников, автобоксов и креплений в Перми.')

@section('content')
    <section class="installation-page">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
            <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
            <span class="breadcrumbs__text">Установка</span>
        </nav>

        <header class="installation-page__header">
            <p class="installation-page__eyebrow">Автобагаж · Пермь</p>
            <h1 class="title title-h1">Установка багажных систем</h1>
            <p>Установим багажник на крышу, автобокс, велокрепление или другое совместимое оборудование. Поможем проверить комплект и объясним, как им пользоваться.</p>
        </header>

        <div class="installation-page__grid">
            <section class="installation-page__card" aria-labelledby="installation-steps-title">
                <h2 id="installation-steps-title">Как проходит установка</h2>
                <ol>
                    <li>Подберём оборудование для вашего автомобиля.</li>
                    <li>Согласуем удобное время визита.</li>
                    <li>Установим и проверим надёжность креплений.</li>
                    <li>Покажем, как снять и установить оборудование самостоятельно.</li>
                </ol>
            </section>

            <aside class="installation-page__order" aria-labelledby="installation-order-title">
                <h2 id="installation-order-title">Заказать установку</h2>
                @if ($installationService)
                    <p class="installation-page__price">{{ $installationService->name }} — {{ number_format((float) $installationService->price, 0, ',', ' ') }} ₽</p>
                    @if ($installationService->description)
                        <p class="installation-page__note">{{ $installationService->description }}</p>
                    @endif
                    <button class="installation-page__button" type="button" data-callback-open data-metrika-goal="installation_booking_opened">Записаться на установку</button>
                @else
                    <p>Уточните возможность установки и свободное время по телефону.</p>
                    <a class="installation-page__button" href="tel:+73422889929">Позвонить: +7 (342) 288-99-29</a>
                @endif
            </aside>
        </div>

        <section class="installation-page__help" aria-labelledby="installation-help-title">
            <h2 id="installation-help-title">Что подготовить</h2>
            <p>Если оборудование ещё не выбрано, сначала воспользуйтесь <a href="{{ route('catalog.vehicle-fitment.index') }}">подбором по автомобилю</a>. При записи сообщите марку, модель и год выпуска автомобиля — это поможет подготовиться к визиту.</p>
        </section>
    </section>
@endsection
