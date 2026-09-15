@php
    $catalog = [
        ['title' => 'Автобагажники', 'image' => '/content/index/img/catalog/1_autobagazniki.jpg', 'alt' => 'Автобагажники', 'url' => route('catalog.autobagazhniki.index')],
        ['title' => 'Автомобильные боксы', 'image' => '/content/index/img/catalog/2_autobox.jpg', 'alt' => 'Автомобильные боксы', 'url' => route('catalog.auto-boxes.index')],
        ['title' => 'Велокрепления', 'image' => '/content/index/img/catalog/3_velokreplenya.jpg', 'alt' => 'Велокрепления', 'url' => route('catalog.bike-racks.index')],
        ['title' => 'Крепления для лыж и сноубордов', 'image' => '/content/index/img/catalog/4_lyzh_kreplenya.jpg', 'alt' => 'Крепления для лыж и сноубордов', 'url' => route('catalog.ski-racks.index')],
        ['title' => 'Рейлинги', 'image' => '/content/index/img/catalog/6_reelings.jpg', 'alt' => 'Рейлинги'],
        ['title' => 'Браслеты противоскольжения', 'image' => '/content/index/img/catalog/7_braslet.jpg', 'alt' => 'Браслеты противоскольжения'],
        ['title' => 'Фаркопы', 'image' => '/content/index/img/catalog/8_farkops.jpg', 'alt' => 'Фаркопы'],
        ['title' => 'Багажные системы Inno', 'image' => '/content/index/img/catalog/9_inno.jpg', 'alt' => 'Багажные системы Inno'],
        ['title' => 'Такелажная продукция', 'image' => '/content/index/img/catalog/10_textil.JPG', 'alt' => 'Такелажная продукция'],
        ['title' => 'Экспедиционные багажники', 'image' => '/content/index/img/catalog/11_expidition.JPG', 'alt' => 'Экспедиционные багажники'],
        ['title' => 'Авточехлы', 'image' => '/content/covers/img/Cayman_Black_Red_Face.jpg', 'alt' => 'Авточехлы'],
        ['title' => 'Автомобильные пороги', 'image' => '/content/index/img/catalog/12_porogi.jpg', 'alt' => 'Автомобильные пороги'],
    ];

    $sales = [
        [
            'name' => 'Носовая сумка TERRA DRIVE для автобоксов',
            'image' => '/src/common.blocks/sales/img/terra_bug_nose.jpg',
            'price' => '2 200 рублей',
            'oldPrice' => '3 000 рублей',
        ],
        [
            'name' => 'Основная сумка TERRA DRIVE для автобоксов',
            'image' => '/src/common.blocks/sales/img/terra_bug.jpg',
            'price' => '2 200 рублей',
            'oldPrice' => '3 000 рублей',
        ],
        [
            'name' => 'Лыжное крепление Amos для 3-4-х пар лыж/2 сноуборда',
            'image' => '/content/lyzhnye-kreplenya/img/amos.jpg',
            'price' => '2 500 рублей',
            'oldPrice' => '3 000 рублей',
        ],
    ];

    $brands = [
        [
            ['/content/index/img/logos/mont_blanc.jpg', 'Mont Blanc'],
            ['/content/index/img/logos/lux.png', 'Lux'],
            ['/content/index/img/logos/atlant.png', 'Атлант'],
            ['/content/index/img/logos/amos.jpg', 'Amos'],
            ['/content/index/img/logos/yuago.png', 'Yuago'],
        ],
        [
            ['/content/index/img/logos/vetlan.png', 'Vetlan'],
            ['/content/index/img/logos/turino.jpg', 'Turino'],
            ['/content/autobox/img/logo/koffer.jpg', 'Koffer'],
            ['/content/index/img/logos/menabo.jpg', 'Menabo'],
            ['/content/autobox/img/logo/terradrive.png', 'Terra Drive'],
        ],
        [
            ['/content/index/img/logos/myravei.png', 'Муравей'],
            ['/content/index/img/logos/inno.jpg', 'Inno'],
            ['/content/index/img/logos/whispbar.png', 'Whispbar'],
            ['/content/index/img/logos/yakima.png', 'Yakima'],
            ['/content/index/img/logos/atera.png', 'Atera'],
        ],
    ];

    $navigation = [
        ['title' => 'Прокат', 'url' => route('rental')],
        ['title' => 'Галерея'],
        ['title' => 'Спецпредложения'],
        ['title' => 'Новости и статьи'],
        ['title' => 'Отзывы о нас'],
        ['title' => 'Контакты'],
    ];
    $categories = array_column($catalog, 'title');
@endphp

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
        <meta name="robots" content="index,follow">
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
                @foreach ($navigation as $item)
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
                @foreach ($navigation as $item)
                    <li class="navigation__list-item">
                        <a class="navigation__link" href="{{ $item['url'] ?? '#' }}" @if (! isset($item['url'])) data-placeholder aria-disabled="true" @endif>{{ $item['title'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="wrapper">
            <aside class="left-nav">
                @foreach ($categories as $category)
                    <a
                        href="{{ $category === 'Автобагажники' ? route('catalog.autobagazhniki.index') : ($category === 'Автомобильные боксы' ? route('catalog.auto-boxes.index') : ($category === 'Велокрепления' ? route('catalog.bike-racks.index') : ($category === 'Крепления для лыж и сноубордов' ? route('catalog.ski-racks.index') : '#'))) }}"
                        class="left-nav__link"
                        @if (! in_array($category, ['Автобагажники', 'Автомобильные боксы', 'Велокрепления', 'Крепления для лыж и сноубордов'], true)) data-placeholder aria-disabled="true" @endif
                    >{{ $category }}</a>
                @endforeach
                <a href="https://vk.com/autobagaz" class="left-nav__link" target="_blank" rel="noopener noreferrer">Мы ВКонтакте</a>
                <a href="#" class="left-nav__link" data-placeholder aria-disabled="true">Оставить отзыв о нашей работе</a>
                <a href="#" class="left-nav__link" data-placeholder aria-disabled="true">Наши партнёры</a>
                <a href="#" class="left-nav__link" data-placeholder aria-disabled="true">Сертификаты и лицензии</a>
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

                <section class="home-section" aria-labelledby="sales-title">
                <h2 class="title title-h2" id="sales-title">Акции</h2>
                <div class="sales">
                    @foreach ($sales as $sale)
                        <div class="sales__item">
                            <img class="sales__img" src="{{ asset(ltrim($sale['image'], '/')) }}" alt="{{ $sale['name'] }}">
                            <div class="sales__description">
                                <h4 class="title title-h4">{{ $sale['name'] }}</h4>
                                <div class="sales__item-price">
                                    <p><span class="text">Новая цена: </span><span class="sales__price">{{ $sale['price'] }}</span></p>
                                    <p><span class="text">Старая цена: </span><span class="sales__price sales__price--strike">{{ $sale['oldPrice'] }}</span></p>
                                </div>
                                <div class="sales__item-button">
                                    <a href="#" class="button button__buy" data-placeholder aria-disabled="true">Заказать</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="#" class="link-green" data-placeholder aria-disabled="true">Все предложения</a>
                </section>

                <section class="home-section" aria-labelledby="brands-title">
                <h2 class="title title-h2" id="brands-title">Бренды</h2>
                <div class="brands__wrap">
                    @foreach ($brands as $row)
                        <div class="brands">
                            @foreach ($row as [$image, $alt])
                                <img src="{{ asset(ltrim($image, '/')) }}" alt="{{ $alt }}" width="150">
                            @endforeach
                        </div>
                    @endforeach
                </div>
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

        <footer class="footer">
            <div class="footer__copyright">
                <ul class="footer__list">
                    <li class="footer__list-item"><a class="footer__link" href="{{ route('home') }}">© 2016–{{ now()->year }} AutoBagaz</a></li>
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Карта сайта</a></li>
                </ul>
            </div>
            <div class="footer__links">
                <ul class="footer__list">
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Оставить отзыв о нас</a></li>
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Контактная информация</a></li>
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Новости</a></li>
                    <li class="footer__list-item"><a class="footer__link" href="#" data-placeholder aria-disabled="true">Галерея работ</a></li>
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
