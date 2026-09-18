@extends('layouts.catalog')

@section('title', 'Гарантия')
@section('meta_description', 'Информация о гарантии на товары магазина Автобагаж в Перми.')

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">Гарантия</span>
    </nav>

    <article class="information-page">
        <header class="information-page__header">
            <h1 class="title title-h1">Гарантия</h1>
            <p class="information-page__lead">На товары действует гарантия производителя в соответствии с условиями гарантийного талона и законодательством Российской Федерации.</p>
        </header>

        <section class="information-page__section information-page__section--accent">
            <h2>Гарантийное обслуживание</h2>
            <p>Срок гарантии и порядок обслуживания зависят от производителя и указаны в документах, передаваемых вместе с товаром. Сохраняйте кассовый или товарный чек, гарантийный талон и комплектность товара.</p>
        </section>

        <section class="information-page__section">
            <h2>Если обнаружен недостаток</h2>
            <p>Свяжитесь с нами по телефону <a href="tel:+73422889929">+7 (342) 288-99-29</a> или обратитесь в магазин по адресу: г. Пермь, ул. Дзержинского, 15. Мы подскажем дальнейший порядок действий и при необходимости примем товар на проверку качества.</p>
        </section>

        <section class="information-page__section">
            <h2>Важно</h2>
            <ul>
                <li>Гарантия распространяется на недостатки, возникшие не по вине покупателя.</li>
                <li>Соблюдайте инструкцию производителя по установке и эксплуатации товара.</li>
                <li>Условия обмена, возврата и гарантийного обслуживания определяются законодательством Российской Федерации и документами производителя.</li>
            </ul>
        </section>
    </article>
@endsection
