@php
    $siteNavigation = ['Прокат', 'Галерея', 'Спецпредложения', 'Новости и статьи', 'Отзывы о нас', 'Контакты'];
    $siteCategories = [
        'Автомобильные боксы',
        'Велокрепления',
        'Крепления для лыж и сноубордов',
        'Рейлинги',
        'Браслеты противоскольжения',
        'Фаркопы',
        'Багажные системы Inno',
        'Такелажная продукция',
        'Экспедиционные багажники',
        'Авточехлы',
        'Автомобильные пороги',
    ];
@endphp

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
        <meta name="robots" content="index,follow">
        <meta name="description" content="@yield('meta_description', 'Каталог автомобильных багажников по маркам автомобилей.')">

        <title>@yield('title', 'Автобагажники') | autobagaz.ru</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('css/autobagaz.css') }}">
        <link rel="stylesheet" href="{{ asset('src/fa/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
        <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
    </head>
    <body>
        <nav class="navigation-mobile" aria-label="Мобильная навигация">
            <ul class="navigation__list" id="mobile-menu">
                <li class="navigation__list-item"><a class="navigation__link" href="{{ route('home') }}">Каталог</a></li>
                @foreach ($siteNavigation as $item)
                    <li class="navigation__list-item"><a class="navigation__link" href="#" data-placeholder aria-disabled="true">{{ $item }}</a></li>
                @endforeach
            </ul>
            <div class="navigation-mobile__link-wrap">
                <a class="navigation-mobile__link" id="pull" href="#mobile-menu" aria-expanded="false">Меню сайта</a>
            </div>
        </nav>

        <div class="top-header">
            <div class="top-header__inner">
                <span class="top-header__address">Наши адреса:</span>
                <div class="top-header__shop top-header__shop-last top-header__shop-last-child">
                    <a class="top-header__shop-address" href="#" data-placeholder aria-disabled="true">г. Пермь, ул. Дзержинского, 15</a>
                    <a class="top-header__shop-phone" href="tel:+73422889929">+7 342 288 99 29</a>
                </div>
            </div>
        </div>

        <header class="header">
            <div class="header__wrap">
                <div class="header__logo">
                    <a href="{{ route('home') }}" aria-label="Автобагаж — главная">
                        <img src="{{ asset('src/common.blocks/header/img/logo.jpg') }}" class="header__img" alt="Автобагаж">
                    </a>
                </div>
                <div class="header__inner">
                    <div class="header__info">
                        <ul class="list header__list">
                            <li>Пн — Пт с 10:00 до 19:00</li>
                            <li>Сб — Вс с 10:00 до 18:00</li>
                        </ul>
                        <ul class="list header__list">
                            <li><a class="link header__link" href="mailto:autobagaz@yandex.ru">autobagaz@yandex.ru</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <nav class="navigation" aria-label="Основная навигация">
            <ul class="navigation__list">
                <li class="navigation__list-item"><a class="navigation__link" href="{{ route('home') }}">Каталог</a></li>
                @foreach ($siteNavigation as $item)
                    <li class="navigation__list-item"><a class="navigation__link" href="#" data-placeholder aria-disabled="true">{{ $item }}</a></li>
                @endforeach
            </ul>
        </nav>

        <div class="wrapper">
            <aside class="left-nav">
                <a href="{{ route('catalog.autobagazhniki.index') }}" class="left-nav__link left-nav__link--active" aria-current="page">Автобагажники</a>
                @foreach ($siteCategories as $category)
                    <a href="#" class="left-nav__link" data-placeholder aria-disabled="true">{{ $category }}</a>
                @endforeach
                <a href="https://vk.com/autobagaz" class="left-nav__link" target="_blank" rel="noopener noreferrer">Мы ВКонтакте</a>
            </aside>

            <main class="wrapper__content">
                @yield('content')
            </main>
        </div>

        <footer class="footer">
            <div class="footer__copyright">
                <ul class="footer__list">
                    <li class="footer__list-item"><a class="footer__link" href="{{ route('home') }}">© 2016–{{ now()->year }} AutoBagaz</a></li>
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Карта сайта</a></li>
                </ul>
            </div>
            <div class="footer__links">
                <ul class="footer__list">
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Контактная информация</a></li>
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Новости</a></li>
                </ul>
            </div>
            <div class="footer__social">
                <ul class="footer__list">
                    <li class="footer__list-item"><i class="fa fa-vk fa-1x" aria-hidden="true"></i><a class="footer__link" href="https://vk.com/autobagaz" target="_blank" rel="noopener noreferrer">Мы ВКонтакте</a></li>
                </ul>
            </div>
        </footer>

        <script src="{{ asset('js/home.js') }}" defer></script>
        @stack('scripts')
    </body>
</html>
