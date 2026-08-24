@extends('layouts.admin')
@section('title', 'Поколения '.$vehicleModel->name)
@section('body')
<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--wide">@include('admin.partials.flash')
<nav class="admin-breadcrumbs"><a href="{{ route('admin.vehicles.vehicle-makes.index') }}">Марки</a><span>/</span><a href="{{ route('admin.vehicles.vehicle-models.index', $vehicleMake) }}">{{ $vehicleMake->name }}</a><span>/</span><span>{{ $vehicleModel->name }}</span></nav>
<div class="page-heading"><div><p class="eyebrow">Поколения</p><h1>{{ $vehicleMake->name }} {{ $vehicleModel->name }}</h1></div><a class="button button--primary button--inline" href="{{ route('admin.vehicles.vehicle-generations.create', [$vehicleMake, $vehicleModel]) }}">Добавить поколение</a></div>
<form class="toolbar"><input name="search" value="{{ request('search') }}" placeholder="Поиск поколения"><button class="button button--secondary">Найти</button></form>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Поколение</th><th>Годы</th><th>Конфигурации</th><th>Статус</th><th></th></tr></thead><tbody>
@forelse($vehicleGenerations as $generation)<tr><td><strong>{{ $generation->name }}</strong><br><code>{{ $generation->slug }}</code></td><td>{{ $generation->year_label }}</td><td><a class="text-link" href="{{ route('admin.vehicles.vehicle-configurations.index', [$vehicleMake, $vehicleModel, $generation]) }}">{{ $generation->configurations_count }}</a></td><td>{{ $generation->is_active ? 'Активно' : 'Скрыто' }}</td><td><a class="text-link" href="{{ route('admin.vehicles.vehicle-generations.edit', [$vehicleMake, $vehicleModel, $generation]) }}">Изменить</a></td></tr>@empty<tr><td colspan="5" class="empty-state">Поколения не найдены.</td></tr>@endforelse
</tbody></table></div>@include('admin.partials.pagination', ['paginator' => $vehicleGenerations])
</main></div>
@endsection
