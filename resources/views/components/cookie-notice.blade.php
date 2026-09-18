@if (! request()->cookie('autobagaz_cookie_notice'))
    <aside class="cookie-notice" data-cookie-notice aria-label="Использование cookie">
        <div class="cookie-notice__content">
            <p>Мы используем cookie, чтобы сайт работал корректно и становился удобнее. Подробнее — в <a href="{{ route('privacy-policy') }}">политике конфиденциальности</a>.</p>
            <button class="cookie-notice__button" type="button" data-cookie-notice-close>Принять</button>
        </div>
    </aside>
@endif
