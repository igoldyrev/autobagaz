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
        <link rel="stylesheet" href="{{ asset('css/admin-toolbar.css') }}">
    </head>
    <body>
        @include('admin.partials.site-toolbar')

        <div class="modal-call__overlay">
            <div class="modal-call" role="dialog" aria-modal="true" aria-labelledby="callback-title">
                <button class="modal-call__close" type="button" aria-label="Закрыть">X</button>
                <div class="modal-call__header">
                    <h3 class="title title-h3" id="callback-title">Введите имя и телефон, и мы вам перезвоним!</h3>
                </div>
                <div class="modal-call__body">
                    <form action="#" class="form js-modal-call-form">
                        <span class="form__label">Ваше имя:</span>
                        <div class="form__input-wrap">
                            <input type="text" name="name" class="form__input form__input--call" placeholder="Введите ваше имя">
                        </div>
                        <span class="form__label">Ваш телефон:</span>
                        <div class="form__input-wrap">
                            <input type="tel" name="phone" class="form__input form__input--call" placeholder="Введите номер телефона">
                        </div>
                        <button class="button button__zakaz button__zakaz--call" type="submit">Перезвоните мне!</button>
                        <p class="form-placeholder" hidden>Форма пока не подключена</p>
                    </form>
                </div>
            </div>
        </div>
        <button class="modal-call__button" type="button" aria-label="Заказать обратный звонок">
            <i class="fa fa-phone fa-4x" aria-hidden="true"></i>
        </button>

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
                <x-selected-vehicle />
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
                @include('catalog.vehicle-fitment._picker', ['make' => null, 'model' => null, 'bodyType' => null])
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

                <h2 class="title title-h2">Специальные предложения</h2>
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

                <h2 class="title title-h2">Новости</h2>
                <div class="records-placeholder records-placeholder--list"><p>Нет записей</p></div>
                <a class="link-green" href="#" data-placeholder aria-disabled="true">Все новости</a>

                <h2 class="title title-h2">Мы работаем со следующими брендами:</h2>
                <div class="brands__wrap">
                    @foreach ($brands as $row)
                        <div class="brands">
                            @foreach ($row as [$image, $alt])
                                <img src="{{ asset(ltrim($image, '/')) }}" alt="{{ $alt }}" width="150">
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <h2 class="title title-h2">Последние отзывы о нас</h2>
                <div class="records-placeholder records-placeholder--list"><p>Нет записей</p></div>
                <a href="#" class="link-green" data-placeholder aria-disabled="true">Смотреть все отзывы</a>

                <h1 class="title title-h1">Купить багажник в Перми теперь не проблема</h1>
                <p class="text">Для многих современных людей автомобиль является не только свидетельством жизненного успеха, но и
                    незаменимым помощником для перевозки грузов. Имея личное авто можно без проблем осуществить перевозку вещей в
                    загородный дом или дачу или же снаряжения при занятии активным отдыхом. Так, для осуществления грузоперевозок
                    на легковом автомобиле существует багажник, устанавливаемый на крышу авто. Это может быть как простая и
                    эстетичная конструкция, состоящая из двух дуг, так и более сложная, к примеру, автобокс или багажник для лодки.
                    Наш магазин предлагает вашему вниманию автобагажники от известных мировых брендов. Если вам необходимо перевезти
                    вещи или вы занимаетесь активным отдыхом — то вы попали по назначению. У нас вы сможете подобрать именно то, что
                    вам нужно: автомобильные багажники, автомобильные боксы, которые станут незаменимыми помощниками при перевозке
                    вещей и спортивного снаряжения. А для того, чтобы обеспечить вам комфорт и безопасность передвижения по зимней
                    трассе, мы предлагаем вашему вниманию цепи противоскольжения от мировых производителей.</p>

                <h3 class="title title-h3">Универсальные багажники</h3>
                <p class="text">В наиболее простом варианте такой автобагажник представляет собой две параллельные дуги. Благодаря
                    простоте и функциональности, данная конструкция предназначена для перевозки любых грузов, позволяя надежно
                    закрепить предметы. Кроме стандартных вариантов, существует также корзина для авто. Универсальные модели
                    автобагажников в основном предназначаются для иномарок и современных российских авто. Потому, если вам нужно
                    подобрать багажник для отечественного автомобиля, то придется буквально «примерять» различные модели, дабы
                    подобрать наиболее удобную и подходящую.</p>

                <h3 class="title title-h3">Автобоксы</h3>
                <p class="text">Такие багажники представляют собой конструкции в виде кейсов, которые изготавливаются из прочного
                    толстого пластика. Такая конструкция позволяет полностью обезопасить ваш груз от атмосферных осадков, уличной
                    грязи и злоумышленников, поскольку устройство оснащается надежным замком.</p>

                <h3 class="title title-h3">Специальные приспособления</h3>
                <p class="text">К ним относится велокрепление, багажник для лодки и прочие всевозможные приспособления,
                    специализированные под перевозку определённого вида грузов. Такие конструкции отлично подходят для тех, кто
                    любит активный отдых или занимается определённым видом спорта. В данном случае, универсальный багажник окажется
                    не очень удобным, а потому современные производители разработали ряд специальных приспособлений и насадок к
                    ним, обеспечивающих комфортную и безопасную перевозку конкретного вида снаряжения. Всё большее количество людей
                    в наши дни открывают для себя удобство и функциональность автобагажников. Современные конструкции совершенно не
                    портят внешний вид вашего авто и выглядят эстетично, позволяя значительно расширить его функциональные
                    возможности. К тому же у нас существует такая услуга, как прокат багажников и автобоксов, что будет отличным
                    вариантом в том случае, если автобагажник нужен вам единоразово и вы не видите прямой необходимости в его
                    покупке.</p>
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
