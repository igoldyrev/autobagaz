@php
    $siteNavigation = [
        ['title' => 'Прокат', 'url' => route('rental')],
        ['title' => 'Галерея'],
        ['title' => 'Спецпредложения'],
        ['title' => 'Новости и статьи'],
        ['title' => 'Отзывы о нас'],
        ['title' => 'Контакты'],
    ];
    $siteCategories = [
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
        <link rel="stylesheet" href="{{ asset('css/admin-toolbar.css') }}">
    </head>
    <body>
        @include('admin.partials.site-toolbar')
        <x-callback-widget />

        <nav class="navigation-mobile" aria-label="Мобильная навигация">
            <ul class="navigation__list" id="mobile-menu">
                <li class="navigation__list-item"><a class="navigation__link" href="{{ route('home') }}">Каталог</a></li>
                @foreach ($siteNavigation as $item)
                    <li class="navigation__list-item">
                        <a class="navigation__link" href="{{ $item['url'] ?? '#' }}" @if (! isset($item['url'])) data-placeholder aria-disabled="true" @endif>{{ $item['title'] }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="navigation-mobile__link-wrap">
                <a class="navigation-mobile__link" id="pull" href="#mobile-menu" aria-expanded="false">Меню сайта</a>
            </div>
        </nav>

        <header class="header">
            <div class="header__wrap">
                <div class="header__logo">
                    <a href="{{ route('home') }}" aria-label="Автобагаж — главная">
                        <img src="{{ asset('src/common.blocks/header/img/logo.jpg') }}" class="header__img" alt="Автобагаж">
                    </a>
                </div>
                <div class="header__inner">
                    <address class="header__contacts">
                        <span class="header__column-title">Наш адрес</span>
                        <span class="header__column-text header__contacts-address">г. Пермь,<br>ул. Дзержинского, 15</span>
                        <a class="link header__link header__contacts-phone" href="tel:+73422889929">+7 342 288 99 29</a>
                    </address>
                    <div class="header__info">
                        <span class="header__column-title">Режим работы</span>
                        <span class="header__column-text">Пн — Пт: 10:00–19:00<br>Сб — Вс: 10:00–18:00</span>
                        <a class="link header__link" href="mailto:autobagaz@yandex.ru">autobagaz@yandex.ru</a>
                    </div>
                </div>
                <div class="header__actions">
                    <x-cart-link />
                    <x-selected-vehicle />
                </div>
            </div>
        </header>

        <nav class="navigation" aria-label="Основная навигация">
            <ul class="navigation__list">
                <li class="navigation__list-item"><a class="navigation__link" href="{{ route('home') }}">Каталог</a></li>
                @foreach ($siteNavigation as $item)
                    <li class="navigation__list-item">
                        <a class="navigation__link" href="{{ $item['url'] ?? '#' }}" @if (! isset($item['url'])) data-placeholder aria-disabled="true" @endif>{{ $item['title'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="wrapper">
            <aside class="left-nav">
                <a href="{{ route('catalog.autobagazhniki.index') }}" class="left-nav__link {{ request()->routeIs('catalog.autobagazhniki.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.autobagazhniki.*')) aria-current="page" @endif>Автобагажники</a>
                <a href="{{ route('catalog.auto-boxes.index') }}" class="left-nav__link {{ request()->routeIs('catalog.auto-boxes.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.auto-boxes.*')) aria-current="page" @endif>Автомобильные боксы</a>
                <a href="{{ route('catalog.bike-racks.index') }}" class="left-nav__link {{ request()->routeIs('catalog.bike-racks.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.bike-racks.*')) aria-current="page" @endif>Велокрепления</a>
                <a href="{{ route('catalog.ski-racks.index') }}" class="left-nav__link {{ request()->routeIs('catalog.ski-racks.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.ski-racks.*')) aria-current="page" @endif>Крепления для лыж и сноубордов</a>
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
