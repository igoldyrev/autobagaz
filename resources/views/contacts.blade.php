@extends('layouts.catalog')

@section('title', 'Контакты')
@section('meta_description', 'Контакты магазина Автобагаж в Перми: адрес, режим работы, телефоны, электронная почта и реквизиты.')

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">Контакты</span>
    </nav>

    <section class="contacts-page">
        <header class="contacts-page__header">
            <h1 class="title title-h1">Контакты</h1>
            <p class="contacts-page__lead">Свяжитесь с нами или приезжайте в магазин — поможем подобрать багажную систему для вашего автомобиля.</p>
        </header>

        <div class="contacts-page__summary">
            <section class="contacts-card">
                <h2 class="contacts-card__title">Магазин «Автобагаж»</h2>
                <address class="contacts-card__address">г. Пермь, ул. Дзержинского, 15</address>
                <p class="contacts-card__hours">Пн–Пт: 10:00–19:00<br>Сб–Вс: 10:00–18:00</p>
                <div class="contacts-card__actions">
                    <a class="contacts-card__action contacts-card__action--primary" href="tel:+73422889929"><i class="fa fa-phone" aria-hidden="true"></i> Позвонить</a>
                    <a class="contacts-card__action" href="mailto:autobagaz@yandex.ru"><i class="fa fa-envelope" aria-hidden="true"></i> Написать</a>
                    <a class="contacts-card__action" href="https://yandex.ru/maps/?text=%D0%9F%D0%B5%D1%80%D0%BC%D1%8C%2C%20%D1%83%D0%BB%D0%B8%D1%86%D0%B0%20%D0%94%D0%B7%D0%B5%D1%80%D0%B6%D0%B8%D0%BD%D1%81%D0%BA%D0%BE%D0%B3%D0%BE%2C%2015" target="_blank" rel="noopener noreferrer"><i class="fa fa-map-marker" aria-hidden="true"></i> Построить маршрут</a>
                </div>
            </section>

            <section class="contacts-card contacts-card--details" aria-label="Телефоны и электронная почта">
                <h2 class="contacts-card__title">Связаться с нами</h2>
                <dl class="contacts-details">
                    <div><dt>Магазин</dt><dd><a href="tel:+73422889929">+7 (342) 288-99-29</a></dd></div>
                    <div><dt>Денис Зарубин</dt><dd><a href="tel:+79091004006">+7 909 100-40-06</a></dd></div>
                    <div><dt>Максим Некрасов</dt><dd><a href="tel:+79194519402">+7 919 451-94-02</a></dd></div>
                    <div><dt>Интернет-магазин</dt><dd><a href="tel:+79082410193">+7 908 241-01-93</a></dd></div>
                    <div><dt>Email</dt><dd><a href="mailto:autobagaz@yandex.ru">autobagaz@yandex.ru</a></dd></div>
                </dl>
            </section>
        </div>

        <section class="contacts-location" aria-labelledby="contacts-location-title">
            <h2 class="title title-h2" id="contacts-location-title">Как нас найти</h2>
            <div class="contacts-location__map">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A9ce0f3ba2e36cfbb902238d75ab5fe2b20a6bc5e5c1d4eee55d146ebfa34dfc5&amp;source=constructor" title="Карта проезда к магазину Автобагаж" loading="lazy"></iframe>
            </div>
            <div class="contacts-location__photos">
                <img src="{{ asset('content/contacts/shop_autobagaz_dzerzhinskogo-5.jpg') }}" alt="Магазин Автобагаж на улице Дзержинского">
                <img src="{{ asset('content/contacts/shop_autobagaz_dzerzhinskogo-4.jpg') }}" alt="Вход в магазин Автобагаж">
            </div>
        </section>

        <details class="contacts-requisites">
            <summary>Реквизиты индивидуального предпринимателя</summary>
            <div>
                <p>Индивидуальный предприниматель: Зарубин Денис Юрьевич</p>
                <p>ИНН 590850700022 · ОГРНИП 316595800158377</p>
                <p>р/с 40802810149770015620 в Волго-Вятском банке ПАО Сбербанк, г. Нижний Новгород</p>
                <p>БИК 042202603 · к/с № 30101810900000000603</p>
                <p>Свидетельство о регистрации 59 004723382 от 17.11.2016</p>
            </div>
        </details>
    </section>
@endsection
