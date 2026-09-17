@php
    $siteNavigation = [
        ['title' => 'Прокат', 'url' => route('rental')],
        ['title' => 'Установка', 'url' => route('installation')],
        ['title' => 'Акции', 'url' => route('promotions.index')],
        ['title' => 'Контакты', 'url' => route('contacts')],
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
    $isCatalogPage = request()->routeIs(
        'catalog.autobagazhniki.*',
        'catalog.auto-boxes.*',
        'catalog.bike-racks.*',
        'catalog.ski-racks.*',
    );
    $hasCategoryMenu = $isCatalogPage || request()->routeIs(
        'rental',
        'installation',
        'promotions.index',
        'contacts',
    );
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
        <x-metrika />
    </head>
    <body>
        <x-metrika-noscript />
        @include('admin.partials.site-toolbar')
        <x-callback-widget />

        <div class="site-topbar">
            <div class="site-topbar__content">
                <span>📍 Пермь, ул. Дзержинского, 15</span>
                <span>Пн–Пт 10:00–19:00 · Сб–Вс 10:00–18:00</span>
                <a href="tel:+73422889929">☎ +7 342 288 99 29</a>
            </div>
        </div>

        <nav class="navigation-mobile" aria-label="Мобильная навигация">
            <button class="navigation-mobile__toggle" id="pull" type="button" aria-controls="mobile-menu" aria-expanded="false">
                <span>Меню</span>
                <span class="navigation-mobile__icon" aria-hidden="true"></span>
            </button>
            <ul class="navigation__list" id="mobile-menu" aria-hidden="true" inert>
                <li class="navigation__list-item"><a class="navigation__link {{ request()->routeIs('home') ? 'navigation__link--active' : '' }}" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Каталог</a></li>
                <li class="navigation__list-item"><a class="navigation__link {{ request()->routeIs('catalog.vehicle-fitment.*') ? 'navigation__link--active' : '' }}" href="{{ route('catalog.vehicle-fitment.index') }}">🚗 Подбор по авто</a></li>
                @foreach ($siteNavigation as $item)
                    <li class="navigation__list-item">
                        @php($isCurrent = isset($item['url']) && request()->url() === $item['url'])
                        <a class="navigation__link {{ $isCurrent ? 'navigation__link--active' : '' }} {{ ! isset($item['url']) ? 'navigation__link--placeholder' : '' }}" href="{{ $item['url'] ?? '#' }}" @if (! isset($item['url'])) data-placeholder aria-disabled="true" tabindex="-1" @elseif ($isCurrent) aria-current="page" @endif>{{ $item['title'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <button class="navigation-mobile__backdrop" type="button" data-mobile-menu-close aria-label="Закрыть меню"></button>

        <header class="header">
            <div class="header__wrap">
                <div class="header__logo">
                    <a href="{{ route('home') }}" aria-label="Автобагаж — главная">
                        <img src="{{ asset('src/common.blocks/header/img/logo.jpg') }}" class="header__img" alt="Автобагаж">
                    </a>
                </div>
                <nav class="header-navigation" aria-label="Основная навигация">
                    <a class="header-navigation__link {{ request()->routeIs('home') ? 'header-navigation__link--active' : '' }}" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Каталог</a>
                    <a class="header-navigation__link header-navigation__link--vehicle {{ request()->routeIs('catalog.vehicle-fitment.*') ? 'header-navigation__link--active' : '' }}" href="{{ route('catalog.vehicle-fitment.index') }}">🚗 Подбор по авто</a>
                    @foreach ($siteNavigation as $item)
                        @php($isCurrent = isset($item['url']) && request()->url() === $item['url'])
                        <a class="header-navigation__link {{ $isCurrent ? 'header-navigation__link--active' : '' }} {{ ! isset($item['url']) ? 'header-navigation__link--placeholder' : '' }}" href="{{ $item['url'] ?? '#' }}" @if (! isset($item['url'])) data-placeholder aria-disabled="true" tabindex="-1" @elseif ($isCurrent) aria-current="page" @endif>{{ $item['title'] }}</a>
                    @endforeach
                </nav>
                <div class="header__actions">
                    <x-selected-vehicle />
                    <x-cart-link />
                </div>
            </div>
        </header>

        <div class="wrapper {{ $hasCategoryMenu ? 'wrapper--with-categories' : 'wrapper--page' }}">
            @if ($hasCategoryMenu)
                <aside class="catalog-sidebar" aria-label="Навигация по каталогу">
                    <details class="catalog-sidebar__section" data-catalog-sidebar-section open>
                        <summary>☰ Категории</summary>
                        <nav class="catalog-sidebar__categories" aria-label="Категории каталога">
                            <a href="{{ route('catalog.autobagazhniki.index') }}" class="left-nav__link {{ request()->routeIs('catalog.autobagazhniki.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.autobagazhniki.*')) aria-current="page" @endif>Автобагажники</a>
                            <a href="{{ route('catalog.auto-boxes.index') }}" class="left-nav__link {{ request()->routeIs('catalog.auto-boxes.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.auto-boxes.*')) aria-current="page" @endif>Автомобильные боксы</a>
                            <a href="{{ route('catalog.bike-racks.index') }}" class="left-nav__link {{ request()->routeIs('catalog.bike-racks.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.bike-racks.*')) aria-current="page" @endif>Велокрепления</a>
                            <a href="{{ route('catalog.ski-racks.index') }}" class="left-nav__link {{ request()->routeIs('catalog.ski-racks.*') ? 'left-nav__link--active' : '' }}" @if (request()->routeIs('catalog.ski-racks.*')) aria-current="page" @endif>Крепления для лыж и сноубордов</a>
                            @foreach ($siteCategories as $category)
                                <a href="#" class="left-nav__link" data-placeholder aria-disabled="true">{{ $category }}</a>
                            @endforeach
                        </nav>
                    </details>
                </aside>
            @endif

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
                    <li class="footer__list-item"><a class="footer__link" href="{{ route('contacts') }}">Контактная информация</a></li>
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
