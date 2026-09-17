@php($counterId = (int) config('services.yandex_metrika.counter_id'))

@if ($counterId > 0)
    <noscript><div><img src="https://mc.yandex.ru/watch/{{ $counterId }}" style="position:absolute;left:-9999px" alt=""></div></noscript>
@endif
