@extends('layouts.admin')
@section('title', 'Группы применяемости')
@section('body')
<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--wide">@include('admin.partials.flash')
<div class="page-heading"><div><p class="eyebrow">Совместимость</p><h1>Группы применяемости</h1><p class="admin-content__lead">Группы применяемости монтажных систем к конфигурациям автомобилей.</p></div><a class="button button--primary button--inline" href="{{ route('admin.fitments.create') }}">Добавить группу</a></div>
<nav class="admin-shortcuts" aria-label="Инструменты совместимости"><a class="admin-shortcuts__link" href="{{ route('admin.compatibility.preview') }}">Проверить совместимость</a><a class="admin-shortcuts__link" href="{{ route('admin.compatibility-overrides.index') }}">Ручные исключения</a></nav>
<form class="toolbar" method="GET"><input name="search" value="{{ request('search') }}" placeholder="Код или название"><button class="button button--secondary">Найти</button></form>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Группа</th><th>Производитель</th><th>Автомобили</th><th>Товары</th><th>Статус</th><th></th></tr></thead><tbody>
@forelse($fitments as $fitment)<tr><td><strong>{{ $fitment->name }}</strong><br><code>{{ $fitment->code }}</code></td><td>{{ $fitment->manufacturer?->name ?? '—' }}</td><td><a class="text-link" href="{{ route('admin.fitments.configurations', $fitment) }}">{{ $fitment->configurations_count }}</a></td><td>{{ $fitment->products_count }}</td><td>{{ $fitment->is_active ? 'Активна' : 'Скрыта' }}</td><td><a class="text-link" href="{{ route('admin.fitments.edit', $fitment) }}">Изменить</a></td></tr>@empty<tr><td colspan="6" class="empty-state">Группы применяемости не найдены.</td></tr>@endforelse
</tbody></table></div>@include('admin.partials.pagination', ['paginator' => $fitments])
</main></div>
@endsection
