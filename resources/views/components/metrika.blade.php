@php
    $counterId = (int) config('services.yandex_metrika.counter_id');
    $goal = session('metrika_goal');
    $goalName = is_array($goal) ? ($goal['name'] ?? null) : $goal;
    $goalParams = is_array($goal) ? ($goal['params'] ?? null) : null;
@endphp

@if ($counterId > 0)
    <script type="application/json" id="metrika-config">@json(['counterId' => $counterId, 'goal' => $goalName, 'params' => $goalParams])</script>
    <script src="{{ asset('js/analytics.js') }}?v={{ filemtime(public_path('js/analytics.js')) }}" defer></script>
@endif
