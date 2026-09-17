@extends('layouts.admin')

@section('title', 'Панель управления')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content">
            <p class="eyebrow">Панель управления</p>
            <h1>Добро пожаловать, {{ auth()->user()->name }}</h1>

            @include('admin.partials.help', ['title' => 'Как организована админка', 'text' => 'Рабочие разделы доступны по вашим правам. Обычно контент заполняется в последовательности: справочники и категории → товары → автомобили → совместимость.', 'items' => ['Начинайте со справочников, чтобы не создавать дубли прямо во время заполнения товара.', 'Скрытие записи обычно убирает её с сайта без удаления данных и связей.', 'Перед публикацией проверяйте карточку товара и результат совместимости.']])

            @if ($productStatistics)
                <section class="dashboard-section" aria-labelledby="product-statistics-title">
                    <div class="dashboard-section__heading">
                        <h2 id="product-statistics-title">Статистика по товарам</h2>
                        <span>Все / опубликовано</span>
                    </div>
                    <div class="dashboard-statistics">
                        @foreach ($productStatistics as $statistic)
                            <a class="dashboard-statistic" href="{{ $statistic['url'] }}">
                                <span class="dashboard-statistic__label">{{ $statistic['label'] }}</span>
                                <strong>{{ $statistic['total'] }}</strong>
                                <span>Опубликовано: {{ $statistic['active'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($orderStatistics)
                <section class="dashboard-section" aria-labelledby="order-statistics-title">
                    <div class="dashboard-section__heading">
                        <h2 id="order-statistics-title">Статистика по заказам</h2>
                        <span>Количество / сумма</span>
                    </div>
                    <div class="dashboard-statistics">
                        @foreach ($orderStatistics as $statistic)
                            <a class="dashboard-statistic" href="{{ $statistic['url'] }}">
                                <span class="dashboard-statistic__label">{{ $statistic['label'] }}</span>
                                <strong>{{ $statistic['total'] }}</strong>
                                <span>На сумму: {{ number_format($statistic['amount'], 2, ',', ' ') }} ₽</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <div class="dashboard-workspace">
                <section class="dashboard-panel" aria-labelledby="attention-title">
                    <h2 id="attention-title">Требует внимания</h2>
                    @forelse ($attentionItems as $item)
                        <a class="dashboard-attention-item" href="{{ $item['url'] }}">
                            <strong>{{ $item['count'] }}</strong>
                            <span>{{ $item['label'] }}</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    @empty
                        <p class="dashboard-panel__empty">Сейчас нет задач, требующих внимания.</p>
                    @endforelse
                </section>

                <section class="dashboard-panel" aria-labelledby="quick-actions-title">
                    <h2 id="quick-actions-title">Быстрые действия</h2>
                    <div class="dashboard-actions">
                        @if ($canManageProducts)
                            <a class="button button--secondary button--inline" href="{{ route('admin.products.roof-racks.create') }}">Добавить багажник</a>
                            <a class="button button--secondary button--inline" href="{{ route('admin.products.auto-boxes.create') }}">Добавить автобокс</a>
                        @endif
                        @if ($canManageVehicles)
                            <a class="button button--secondary button--inline" href="{{ route('admin.compatibility.quality') }}">Качество применяемости</a>
                            <a class="button button--secondary button--inline" href="{{ route('admin.compatibility.preview') }}">Проверить совместимость</a>
                        @endif
                        @if ($canManageOrders)
                            <a class="button button--secondary button--inline" href="{{ route('admin.orders.index') }}">Открыть заказы</a>
                        @endif
                        <a class="button button--secondary button--inline" href="{{ route('home') }}" target="_blank" rel="noopener">Открыть сайт ↗</a>
                    </div>
                </section>

                <section class="dashboard-panel dashboard-panel--activity" aria-labelledby="recent-activity-title">
                    <div class="dashboard-panel__heading">
                        <h2 id="recent-activity-title">Последние изменения</h2>
                        <a class="text-link" href="{{ route('admin.activity.index') }}">Весь журнал</a>
                    </div>
                    @forelse ($recentActivities as $activity)
                        <div class="dashboard-activity-item">
                            <span>{{ $activity->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</span>
                            <div>
                                <strong>{{ $activity->user_name }}</strong>
                                <p>{{ $activity->description }}</p>
                            </div>
                            <span class="activity-action activity-action--{{ $activity->action }}">{{ $activity->actionLabel() }}</span>
                        </div>
                    @empty
                        <p class="dashboard-panel__empty">В журнале пока нет записей.</p>
                    @endforelse
                </section>
            </div>

        </main>
    </div>
@endsection
