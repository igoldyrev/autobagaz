@php
    $catalog = [
        ['title' => 'Автобагажники', 'image' => '/content/index/img/catalog/1_autobagazniki.jpg', 'alt' => 'Автобагажники', 'url' => route('catalog.autobagazhniki.index')],
        ['title' => 'Автомобильные боксы', 'image' => '/content/index/img/catalog/2_autobox.jpg', 'alt' => 'Автомобильные боксы', 'url' => route('catalog.auto-boxes.index')],
        ['title' => 'Велокрепления', 'image' => '/content/index/img/catalog/3_velokreplenya.jpg', 'alt' => 'Велокрепления', 'url' => route('catalog.bike-racks.index')],
        ['title' => 'Крепления для лыж и сноубордов', 'image' => '/content/index/img/catalog/4_lyzh_kreplenya.jpg', 'alt' => 'Крепления для лыж и сноубордов', 'url' => route('catalog.ski-racks.index')],
    ];

    $brands = [
        ['mont-blanc', 'Mont Blanc'],
        ['lux', 'Lux'],
        ['atlant', 'Атлант'],
        ['amos', 'Amos'],
        ['yuago', 'Yuago'],
        ['vetlan', 'Vetlan'],
        ['pt-group', 'PT GROUP'],
        ['koffer', 'Koffer'],
        ['menabo', 'Menabo'],
        ['terra-drive', 'Terra Drive'],
        ['muravey', 'Муравей'],
        ['inno', 'Inno'],
        ['whispbar', 'Whispbar'],
        ['yakima', 'Yakima'],
        ['atera', 'Atera'],
    ];

    $navigation = [
        ['title' => 'Прокат', 'url' => route('rental')],
        ['title' => 'Установка', 'url' => route('installation')],
        ['title' => 'Акции', 'url' => route('promotions.index')],
        ['title' => 'Контакты', 'url' => route('contacts')],
    ];
@endphp

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
        <x-seo />
        <x-structured-data />
        <meta name="description" content="Продажа и прокат багажников и автобоксов, креплений и багажных систем в Перми.">
        <meta name="keywords" content="автобагажники, автобоксы, багажник на крышу, велокрепления, рейлинги, Пермь">
        <meta property="place:location:latitude" content="58.03593904782619">
        <meta property="place:location:longitude" content="56.2000031453342">
        <meta property="business:contact_data:locality" content="Пермь">
        <meta property="business:contact_data:email" content="autobagaz@yandex.ru">
        <meta property="og:site_name" content="Автобагаж">

        <title>Купить багажники и автобоксы на крышу автомобиля в Перми | autobagaz.ru</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('css/autobagaz.css') }}">
        <link rel="stylesheet" href="{{ asset('src/fa/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ filemtime(public_path('css/home.css')) }}">
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
                @foreach ($navigation as $item)
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
                    @foreach ($navigation as $item)
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

        <div class="wrapper wrapper--with-categories">
            <aside class="catalog-sidebar" aria-label="Навигация по каталогу">
                <details class="catalog-sidebar__section" data-catalog-sidebar-section open>
                    <summary>☰ Категории</summary>
                    <nav class="catalog-sidebar__categories" aria-label="Категории каталога">
                        @foreach ($catalog as $category)
                            <a
                                href="{{ $category['url'] }}"
                                class="left-nav__link"
                            >{{ $category['title'] }}</a>
                        @endforeach
                    </nav>
                </details>
            </aside>

            <main class="wrapper__content">
                <section class="home-section home-section--hero" aria-label="Подбор оборудования">
                    @include('catalog.vehicle-fitment._picker', ['make' => null, 'model' => null, 'bodyType' => null, 'hero' => true])
                </section>
                <section class="home-section" aria-labelledby="popular-categories-title">
                <h2 class="title title-h2" id="popular-categories-title">Популярные категории</h2>
                <div class="catalog">
                    @foreach ($catalog as $item)
                        <div class="catalog__item">
                            <a
                                href="{{ $item['url'] ?? '#' }}"
                                class="catalog__item-link"
                                @unless (isset($item['url'])) data-placeholder aria-disabled="true" @endunless
                                aria-label="{{ $item['title'] }}"
                            ></a>
                            <div class="catalog__image-wrap">
                                <img class="catalog__image" src="{{ asset(ltrim($item['image'], '/')) }}" alt="{{ $item['alt'] }}">
                            </div>
                            <div class="catalog__text">
                                <p class="text">{{ $item['title'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                </section>

                <section class="home-section" aria-labelledby="vehicle-products-title">
                    <h2 class="title title-h2" id="vehicle-products-title">Популярные товары для вашего автомобиля</h2>
                    @if ($selectedVehicle && $homeProducts->isNotEmpty())
                        <p class="vehicle-products__lead">Подходит для {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}</p>
                        @include('catalog.products._grid', ['products' => $homeProducts])
                        <a class="link-green" href="{{ route('catalog.vehicle-fitment.index', array_filter(['vehicle_configuration_id' => $selectedVehicle->id, 'vehicle_year' => $selectedVehicleYear])) }}">Все подходящие товары</a>
                    @elseif ($selectedVehicle)
                        <div class="records-placeholder records-placeholder--list"><p>Для выбранного автомобиля пока нет подтверждённо совместимых товаров.</p></div>
                    @else
                        <div class="vehicle-products-empty">
                            <span class="vehicle-products-empty__icon" aria-hidden="true"><i class="fa fa-car"></i></span>
                            <div><p>Выберите автомобиль в форме выше — покажем багажники, боксы и крепления, которые точно подойдут.</p><a class="vehicle-products-empty__link" href="#vehicle-picker">Начать подбор</a></div>
                        </div>
                    @endif
                </section>

                <section class="home-section home-benefits" aria-labelledby="benefits-title">
                    <h2 class="title title-h2" id="benefits-title">Почему AutoBagaz</h2>
                    <ul class="home-benefits__list">
                        <li><i class="fa fa-car" aria-hidden="true"></i><span>Подбираем оборудование именно под ваш автомобиль</span></li>
                        <li><i class="fa fa-wrench" aria-hidden="true"></i><span>Устанавливаем оборудование в нашем сервисе</span></li>
                        <li><i class="fa fa-shield" aria-hidden="true"></i><span>Даём гарантию на товары и работы</span></li>
                        <li><i class="fa fa-check-circle" aria-hidden="true"></i><span>Подскажем, что есть в наличии</span></li>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i><span>Самовывоз в Перми, ул. Дзержинского, 15</span></li>
                    </ul>
                </section>

                @if ($sales->isNotEmpty())
                <section class="home-section" aria-labelledby="sales-title">
                <h2 class="title title-h2" id="sales-title">Акции</h2>
                <div class="sales">
                    @foreach ($sales as $sale)
                        <div class="sales__item">
                            <a href="{{ route('products.show', $sale) }}">
                                @if ($sale->images->first())
                                    <img class="sales__img" src="{{ asset($sale->images->first()->path) }}" alt="{{ $sale->images->first()->alt ?: $sale->name }}" loading="lazy">
                                @else
                                    <span class="sales__img sales__img--placeholder">Нет фото</span>
                                @endif
                            </a>
                            <div class="sales__description">
                                <h4 class="title title-h4"><a href="{{ route('products.show', $sale) }}">{{ $sale->name }}</a></h4>
                                @if ($sale->promotion_label)<p class="sales__label">{{ $sale->promotion_label }}</p>@endif
                                <div class="sales__item-price">
                                    <p><span class="text">Новая цена: </span><span class="sales__price">{{ number_format((float) $sale->price, 0, ',', ' ') }} ₽</span></p>
                                    <p><span class="text">Старая цена: </span><span class="sales__price sales__price--strike">{{ number_format((float) $sale->old_price, 0, ',', ' ') }} ₽</span></p>
                                </div>
                                <div class="sales__item-button">
                                    <a href="{{ route('products.show', $sale) }}" class="button button__buy">К товару</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('promotions.index') }}" class="link-green">Все предложения</a>
                </section>
                @endif

                <section class="home-section" aria-labelledby="brands-title">
                    <h2 class="title title-h2" id="brands-title">Мы работаем с такими брендами</h2>
                    <ul class="brand-grid" aria-label="Бренды производителей">
                        @foreach ($brands as [$logo, $name])
                            <li class="brand-grid__item">
                                <img src="{{ asset('content/brands/'.$logo.'.webp') }}" alt="{{ $name }}" width="320" height="120" loading="lazy" decoding="async">
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section class="home-section home-seo" aria-labelledby="about-title">
                    <h2 class="title title-h2" id="about-title">Багажники и автобоксы в Перми</h2>
                    <p class="text">Автомобильный багажник помогает взять в поездку больше: вещи для дачи, туристическое снаряжение, лыжи или велосипеды. В AutoBagaz можно подобрать оборудование по марке, модели, году выпуска и типу крыши автомобиля — без риска купить несовместимый комплект.</p>

                    <h3 class="title title-h3">Багажники на крышу и автобоксы</h3>
                    <p class="text">Базовый багажник состоит из опор и поперечин, на которые устанавливают автобокс, корзину или крепления для снаряжения. Автобокс защищает вещи от дождя и дорожной грязи, закрывается на ключ и освобождает место в салоне.</p>

                    <h3 class="title title-h3">Крепления для активного отдыха</h3>
                    <p class="text">Для велосипедов, лыж, сноубордов и другого снаряжения есть специализированные крепления. Поможем выбрать подходящий вариант, проверим совместимость с багажной системой и при необходимости установим оборудование в Перми. Также доступен прокат, если багажник или бокс нужен только на одну поездку.</p>
                </section>

            </main>
        </div>

        <x-site-footer />
        <x-cookie-notice />

        <script src="{{ asset('js/home.js') }}?v={{ filemtime(public_path('js/home.js')) }}" defer></script>
        @stack('scripts')
    </body>
</html>
