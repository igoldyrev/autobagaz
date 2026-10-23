@props(['checkoutGoal' => null])

@php
    $counterId = (int) config('services.yandex_metrika.counter_id');
    $goal = $checkoutGoal ?? session('metrika_goal');
    $goalName = is_array($goal) ? ($goal['name'] ?? null) : $goal;
    $goalParams = is_array($goal) ? ($goal['params'] ?? null) : null;
@endphp

{{-- Секретная ссылка на заказ не должна передаваться в аналитику. --}}
@if ($counterId > 0 && ! request()->routeIs('checkout.success'))
    <script type="application/json" id="metrika-config">@json(['counterId' => $counterId, 'goal' => $goalName, 'params' => $goalParams])</script>
    <script src="{{ asset('js/analytics.js') }}?v={{ filemtime(public_path('js/analytics.js')) }}" defer></script>
@endif
