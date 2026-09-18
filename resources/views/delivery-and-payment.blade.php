@extends('layouts.catalog')

@section('title', 'Доставка и оплата')
@section('meta_description', 'Условия доставки, самовывоза и оплаты заказов в магазине Автобагаж в Перми.')

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">Доставка и оплата</span>
    </nav>

    <article class="information-page">
        <header class="information-page__header">
            <h1 class="title title-h1">Доставка и оплата</h1>
            <p class="information-page__lead">Поможем выбрать удобный способ получения заказа и согласуем все детали до отправки.</p>
        </header>

        <section class="information-page__section information-page__section--accent">
            <h2>Самовывоз</h2>
            <p>Заказ можно забрать в магазине «Автобагаж» по адресу: г. Пермь, ул. Дзержинского, 15. Перед визитом рекомендуем уточнить наличие товара и резерв по телефону <a href="tel:+73422889929">+7 (342) 288-99-29</a>.</p>
            <p>Режим работы: Пн–Пт — 10:00–19:00, Сб–Вс — 10:00–18:00.</p>
        </section>

        <section class="information-page__section">
            <h2>Доставка</h2>
            <p>Доставляем заказы по Перми и отправляем товары в другие регионы России. После оформления заказа менеджер свяжется с вами, чтобы согласовать наличие, адрес, способ доставки, её стоимость и срок.</p>
            <p>Стоимость и срок зависят от габаритов и веса товара, адреса получения и выбранной транспортной компании.</p>
        </section>

        <section class="information-page__section">
            <h2>Оплата</h2>
            <p>Условия и способ оплаты согласуются с менеджером при подтверждении заказа. Для уточнения деталей по конкретному товару, доставке или оплате позвоните нам или оставьте заказ на сайте.</p>
        </section>
    </article>
@endsection
