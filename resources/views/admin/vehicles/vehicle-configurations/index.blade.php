@extends('layouts.admin')
@section('title', 'Конфигурации '.$vehicleGeneration->name)
@section('body')
<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--wide">@include('admin.partials.flash')
<nav class="admin-breadcrumbs"><a href="{{ route('admin.vehicles.vehicle-generations.index', [$vehicleMake, $vehicleModel]) }}">Поколения</a><span>/</span><span>{{ $vehicleGeneration->name }}</span></nav>
<div class="page-heading"><div><p class="eyebrow">Конфигурации</p><h1>{{ $vehicleMake->name }} {{ $vehicleModel->name }} · {{ $vehicleGeneration->name }}</h1><p class="admin-content__lead">Конечные варианты кузова и крыши, которые позднее будут выбираться в подборе.</p></div><a class="button button--primary button--inline" href="{{ route('admin.vehicles.vehicle-configurations.create', [$vehicleMake, $vehicleModel, $vehicleGeneration]) }}">Добавить конфигурацию</a></div>
@include('admin.partials.help', ['title' => 'Что такое конфигурация', 'text' => 'Конфигурация — конечный вариант автомобиля, для которого настраивается совместимость: сочетание поколения, кузова, типа крыши и при необходимости уточнённых годов.', 'items' => ['Создавайте отдельные конфигурации, если применяемость багажника отличается.', 'Поиск проверяет отображаемое название конфигурации.', 'Статус проверки помогает отделить черновые данные от подтверждённых.']])
<form class="toolbar"><input name="search" value="{{ request('search') }}" placeholder="Поиск конфигурации"><button class="button button--secondary">Найти</button></form>
<div class="table-wrap"><table class="admin-table"><thead><tr><th>Конфигурация</th><th>Кузов</th><th>Крыша</th><th>Годы</th><th>Проверка</th><th></th></tr></thead><tbody>
@forelse($vehicleConfigurations as $configuration)<tr><td><strong>{{ $configuration->display_name }}</strong></td><td>{{ $configuration->bodyStyle?->name ?? 'Не указан' }}</td><td>{{ $configuration->roofType?->name ?? 'Не указан' }}</td><td>{{ $configuration->year_from ?: '—' }}–{{ $configuration->year_to ?: 'н.в.' }}</td><td>{{ $configuration->verification_status }}</td><td><a class="text-link" href="{{ route('admin.vehicles.vehicle-configurations.edit', [$vehicleMake, $vehicleModel, $vehicleGeneration, $configuration]) }}">Изменить</a></td></tr>@empty<tr><td colspan="6" class="empty-state">Конфигурации не найдены.</td></tr>@endforelse
</tbody></table></div>@include('admin.partials.pagination', ['paginator' => $vehicleConfigurations])
</main></div>
@endsection
