@if ((int) config('services.yandex_metrika.counter_id') > 0)
    <aside class="cookie-notice" data-cookie-notice aria-label="Настройки аналитики" hidden>
        <div class="cookie-notice__content">
            <div>
                <p>Мы используем cookie, чтобы сайт работал корректно и становился удобнее. Подробнее — в <a href="{{ route('privacy-policy') }}#analytics">политике обработки персональных данных</a>.</p>
                <p data-analytics-status role="status"></p>
            </div>
            <div class="cookie-notice__actions">
                <button class="cookie-notice__button" type="button" data-analytics-accept>Принять</button>
                <button class="cookie-notice__button cookie-notice__button--secondary" type="button" data-analytics-reject>Отказаться</button>
                <button class="cookie-notice__button cookie-notice__button--secondary" type="button" data-analytics-close hidden>Закрыть</button>
            </div>
        </div>
    </aside>
@endif
