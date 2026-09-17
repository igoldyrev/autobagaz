@php
    $counterId = (int) config('services.yandex_metrika.counter_id');
    $goal = session('metrika_goal');
    $goalName = is_array($goal) ? ($goal['name'] ?? null) : $goal;
    $goalParams = is_array($goal) ? ($goal['params'] ?? null) : null;
@endphp

@if ($counterId > 0)
    <script>
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () { (m[i].a = m[i].a || []).push(arguments); };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0];
            k.async = 1;
            k.src = r;
            a.parentNode.insertBefore(k, a);
        })(window, document, 'script', 'https://mc.yandex.ru/metrika/tag.js?id={{ $counterId }}', 'ym');

        window.metrikaCounterId = {{ $counterId }};
        ym({{ $counterId }}, 'init', {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true,
        });
    </script>
    @if (is_string($goalName) && $goalName !== '')
        <script>
            ym({{ $counterId }}, 'reachGoal', @json($goalName), @json($goalParams));
        </script>
    @endif
@endif
