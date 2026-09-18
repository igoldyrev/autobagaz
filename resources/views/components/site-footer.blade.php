<footer class="footer" aria-label="Навигация в подвале сайта">
    <div class="footer__content">
        <section class="footer__column" aria-labelledby="footer-catalog-title">
            <h2 class="footer__title" id="footer-catalog-title">Каталог</h2>
            <ul class="footer__list">
                <li><a class="footer__link" href="{{ route('catalog.autobagazhniki.index') }}">Автобагажники</a></li>
                <li><a class="footer__link" href="{{ route('catalog.auto-boxes.index') }}">Автобоксы</a></li>
                <li><a class="footer__link" href="{{ route('catalog.bike-racks.index') }}">Велокрепления</a></li>
                <li><a class="footer__link" href="{{ route('catalog.ski-racks.index') }}">Лыжи и сноуборды</a></li>
                <li><a class="footer__link" href="{{ route('home') }}#popular-categories-title">Все категории</a></li>
            </ul>
        </section>

        <section class="footer__column" aria-labelledby="footer-customers-title">
            <h2 class="footer__title" id="footer-customers-title">Покупателям</h2>
            <ul class="footer__list">
                <li><a class="footer__link" href="{{ route('catalog.vehicle-fitment.index') }}">🚗 Подбор по автомобилю</a></li>
                <li><a class="footer__link" href="{{ route('delivery-payment') }}">Доставка и оплата</a></li>
                <li><a class="footer__link" href="{{ route('installation') }}">Установка</a></li>
                <li><a class="footer__link" href="{{ route('rental') }}">Прокат</a></li>
                <li><a class="footer__link" href="{{ route('warranty') }}">Гарантия</a></li>
            </ul>
        </section>

        <section class="footer__column" aria-labelledby="footer-company-title">
            <h2 class="footer__title" id="footer-company-title">AutoBagaz</h2>
            <ul class="footer__list">
                <li><a class="footer__link" href="{{ route('contacts') }}">Контакты</a></li>
                <li><a class="footer__link" href="{{ route('promotions.index') }}">Акции</a></li>
            </ul>
        </section>

        <section class="footer__column footer__column--contacts" aria-labelledby="footer-contacts-title">
            <h2 class="footer__title" id="footer-contacts-title">Контакты</h2>
            <address class="footer__contacts">
                <a class="footer__link footer__address" href="{{ route('contacts') }}">г. Пермь, ул. Дзержинского, 15</a>
                <a class="footer__phone" href="tel:+73422889929">+7 342 288-99-29</a>
                <span>Пн–Пт: 10:00–19:00<br>Сб–Вс: 10:00–18:00</span>
                <a class="footer__social-link" href="https://vk.com/autobagaz" target="_blank" rel="noopener noreferrer"><i class="fa fa-vk" aria-hidden="true"></i>ВКонтакте</a>
            </address>
        </section>
    </div>

    <div class="footer__bottom">
        <span>© 2016–{{ now()->year }} AutoBagaz</span>
        <div class="footer__legal">
            <a class="footer__link" href="{{ route('privacy-policy') }}">Политика конфиденциальности</a>
            <a class="footer__link" href="{{ route('personal-data-consent') }}">Согласие на обработку персональных данных</a>
        </div>
    </div>
</footer>
