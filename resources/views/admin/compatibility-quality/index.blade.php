@extends('layouts.admin')

@section('title', 'Качество применяемости')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Совместимость</p>
                    <h1>Качество применяемости</h1>
                    <p class="admin-content__lead">Очередь записей, из-за которых подбор может быть неполным или противоречивым.</p>
                </div>
                <a class="button button--secondary button--inline" href="{{ route('admin.compatibility.preview') }}">Проверить совместимость</a>
            </div>

            @include('admin.partials.help', ['title' => 'Как работать с отчётом', 'text' => 'Начинайте с критичных пунктов: они влияют на результат подбора для покупателей. Каждый счётчик открывает уже отфильтрованный список записей для исправления.', 'items' => ['Автобагажник без применяемости не показывается как подходящий автомобилю.', 'Группа без товаров или автомобилей не влияет на подбор и обычно требует заполнения или отключения.', 'Конфликт исключений означает, что для одного контекста есть противоположные активные правила одинакового приоритета.']])

            <section class="quality-metrics" aria-label="Показатели качества применяемости">
                @foreach ($metrics as $metric)
                    <a class="quality-metric quality-metric--{{ $metric['level'] }}" href="{{ $metric['url'] }}">
                        <strong>{{ $metric['count'] }}</strong>
                        <span>{{ $metric['label'] }}</span>
                        <small>{{ $metric['description'] }}</small>
                        <span class="quality-metric__action">Открыть список →</span>
                    </a>
                @endforeach
            </section>
        </main>
    </div>
@endsection
