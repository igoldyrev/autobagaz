@if ((int) config('services.yandex_metrika.counter_id') > 0)
    <aside class="cookie-notice" data-cookie-notice aria-label="Настройки аналитики" hidden>
        <div class="cookie-notice__content">
            <div>
                <p>Разрешить Яндекс Метрику и Webvisor? Они используют cookie для статистики и записи действий на сайте. Содержимое полей форм скрывается. Без вашего согласия аналитика не запускается. <a href="{{ route('privacy-policy') }}#analytics">Подробнее в политике</a>.</p>
                <p data-analytics-status role="status"></p>
            </div>
            <div class="cookie-notice__actions">
                <button class="cookie-notice__button" type="button" data-analytics-accept>Разрешить аналитику</button>
                <button class="cookie-notice__button cookie-notice__button--secondary" type="button" data-analytics-reject>Отказаться</button>
                <button class="cookie-notice__button cookie-notice__button--secondary" type="button" data-analytics-close hidden>Закрыть</button>
            </div>
        </div>
    </aside>
@endif
