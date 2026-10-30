@extends('layouts.admin')

@section('title', $import->applied_at ? 'Результат импорта' : 'Проверка импорта')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <h1>{{ $import->applied_at ? 'Результат импорта' : 'Проверка импорта' }}</h1>
            <p class="admin-content__lead">{{ $import->filename }} · выгрузка от {{ $export->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i:s') }}</p>
            @if ($import->applied_at)
                <p>Применено {{ $import->applied_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i:s') }}. Менеджер: {{ $import->user?->name ?? 'Пользователь удалён' }}.</p>
            @else
                <p>Данные ещё не изменены. Для каждого конфликта выберите значение из файла или сохраните значение сайта. Изменения применяются вместе после повторной проверки.</p>
            @endif
            <form method="POST" action="{{ route('admin.stock.apply', $import) }}">
                @csrf
                <div class="table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Номер</th><th>Товар</th><th>Поле</th><th>При выгрузке</th><th>На сайте при проверке</th><th>В файле</th><th>Решение</th></tr></thead>
                        <tbody>
                            @foreach ($import->changes as $change)
                                @foreach ($change['fields'] as $field => $values)
                                    <tr>
                                        <td>{{ $change['id'] }}</td>
                                        <td>{{ $change['name'] }}</td>
                                        <td>{{ $field === 'stock' ? 'Физический остаток, шт.' : 'Цена, ₽' }}</td>
                                        <td>{{ $values['original'] }}</td>
                                        <td>{{ $values['current'] }}</td>
                                        <td>{{ $values['value'] }}</td>
                                        <td>
                                            @if ($import->applied_at)
                                                {{ $values['applied'] ? 'Применено из файла' : 'Сохранено значение сайта' }}
                                            @elseif ($values['conflict'])
                                                <label>
                                                    <span class="status status--inactive">Конфликт</span>
                                                    <select name="decisions[{{ $change['id'] }}][{{ $field }}]" required aria-label="Решение для товара {{ $change['id'] }}, {{ $field === 'stock' ? 'остаток' : 'цена' }}">
                                                        <option value="">Выберите решение</option>
                                                        <option value="site" @selected(old("decisions.{$change['id']}.{$field}") === 'site')>Оставить {{ $values['current'] }} на сайте</option>
                                                        <option value="file" @selected(old("decisions.{$change['id']}.{$field}") === 'file')>Установить {{ $values['value'] }} из файла</option>
                                                    </select>
                                                </label>
                                            @else
                                                Будет установлено из файла
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="heading-actions">
                    @unless ($import->applied_at)
                        <button class="button button--primary" type="submit">Применить изменения</button>
                    @endunless
                    <a class="button button--secondary" href="{{ route('admin.stock.index') }}">Вернуться к остаткам</a>
                </div>
            </form>
        </main>
    </div>
@endsection
