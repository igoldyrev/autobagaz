@extends('layouts.admin')

@section('title', 'Журнал действий')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')

            <div class="page-heading">
                <div>
                    <p class="eyebrow">Контроль изменений</p>
                    <h1>Журнал действий</h1>
                    <p class="admin-content__lead">Последние успешные изменения в панели управления. Записи хранятся 180 дней.</p>
                </div>
                <a class="button button--secondary button--inline" href="{{ route('admin.users.index') }}">Пользователи</a>
            </div>

            @include('admin.partials.help', ['title' => 'Что попадает в журнал', 'text' => 'Журнал показывает, кто и когда добавлял, изменял или удалял данные, входил в админку и завершал сеансы. Просмотры страниц, пароли, содержимое полей, IP-адреса и сведения о браузере не записываются.', 'items' => ['Фильтры применяются одновременно.', 'Название пользователя сохраняется в записи даже при последующем изменении его профиля.', 'Журнал доступен только Главному администратору и не редактируется через админку.']])

            <form class="toolbar activity-filters" method="GET">
                <select name="user_id" aria-label="Пользователь">
                    <option value="">Все пользователи</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected((string) request('user_id') === (string) $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
                <select name="action" aria-label="Действие">
                    <option value="">Все действия</option>
                    @foreach ($actionLabels as $value => $label)
                        <option value="{{ $value }}" @selected(request('action') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="subject_type" aria-label="Раздел">
                    <option value="">Все разделы</option>
                    @foreach ($subjectLabels as $value => $label)
                        <option value="{{ $value }}" @selected(request('subject_type') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <label><span>С даты</span><input name="date_from" type="date" value="{{ request('date_from') }}"></label>
                <label><span>По дату</span><input name="date_to" type="date" value="{{ request('date_to') }}"></label>
                <button class="button button--secondary" type="submit">Применить</button>
                @if (request()->hasAny(['user_id', 'action', 'subject_type', 'date_from', 'date_to']))
                    <a class="text-link" href="{{ route('admin.activity.index') }}">Сбросить</a>
                @endif
            </form>

            <div class="table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Дата и время</th><th>Пользователь</th><th>Действие</th><th>Описание</th></tr></thead>
                    <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td class="table-secondary">{{ $activity->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</td>
                                <td><strong>{{ $activity->user_name }}</strong></td>
                                <td><span class="activity-action activity-action--{{ $activity->action }}">{{ $activity->actionLabel() }}</span></td>
                                <td>{{ $activity->description }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">Записи с выбранными условиями не найдены.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $activities])
        </main>
    </div>
@endsection
