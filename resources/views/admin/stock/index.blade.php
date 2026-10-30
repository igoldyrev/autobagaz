@extends('layouts.admin')

@section('title', 'Остатки')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Каталог</p>
                    <h1>Остатки</h1>
                    <p class="admin-content__lead">Выгрузка товаров и обновление цен и физических остатков через XLSX.</p>
                </div>
                <form method="POST" action="{{ route('admin.stock.export') }}">
                    @csrf
                    <button class="button button--primary" type="submit">Выгрузить товары ({{ $count }})</button>
                </form>
            </div>

            @include('admin.partials.help', ['title' => 'Как обновить данные', 'text' => 'Выгрузите файл, измените жёлтые колонки «Физический остаток, шт.» и «Цена» и загрузите его обратно. Товары разделены по типам на отдельные листы.', 'items' => ['Физический остаток включает зарезервированные, но ещё не выданные товары.', 'Пустая ячейка не меняет значение. Ноль устанавливает нулевой остаток или цену.', 'Товары, которых нет в файле, не изменяются и не удаляются. Новые товары через этот файл не создаются.', 'Сохраните номера товаров, заголовки колонок и лист «Сведения». Другие данные из файла не обновляются.', 'Перед применением проверьте предпросмотр. Если значение менялось на сайте после выгрузки, выберите решение для конфликта.']])

            <form class="toolbar" method="POST" enctype="multipart/form-data" action="{{ route('admin.stock.preview') }}">
                @csrf
                <label for="stock-file">Файл цен и остатков (XLSX, до 5 МБ)</label>
                <input id="stock-file" type="file" name="file" accept=".xlsx" required>
                <button class="button button--secondary" type="submit">Проверить файл</button>
            </form>

            <h2>История загрузок</h2>
            <div class="table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Применено</th><th>Файл</th><th>Менеджер</th><th>Товаров в предпросмотре</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($imports as $import)
                            <tr>
                                <td>{{ $import->applied_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i:s') }}</td>
                                <td>{{ $import->filename }}</td>
                                <td>{{ $import->user?->name ?? 'Пользователь удалён' }}</td>
                                <td>{{ count($import->changes) }}</td>
                                <td><a class="text-link" href="{{ route('admin.stock.show', $import) }}">Изменения</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-state">Загрузок пока нет.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @include('admin.partials.pagination', ['paginator' => $imports])
        </main>
    </div>
@endsection
