@extends('layouts.admin')

@section('title', 'Конфигурации без применяемости')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Качество применяемости</p><h1>Конфигурации без применяемости</h1><p class="admin-content__lead">Для этих автомобилей нет ни одной активной группы применяемости.</p></div><a class="button button--secondary button--inline" href="{{ route('admin.compatibility.quality') }}">К отчёту</a></div>
            <div class="table-wrap"><table class="admin-table"><thead><tr><th>Автомобиль</th><th>Конфигурация</th><th></th></tr></thead><tbody>@forelse ($configurations as $configuration)<tr><td>{{ $configuration->generation->vehicleModel->make->name }} {{ $configuration->generation->vehicleModel->name }} · {{ $configuration->generation->name }}</td><td>{{ $configuration->display_name }}</td><td><a class="text-link" href="{{ route('admin.vehicles.vehicle-configurations.edit', [$configuration->generation->vehicleModel->make, $configuration->generation->vehicleModel, $configuration->generation, $configuration]) }}">Изменить</a></td></tr>@empty<tr><td colspan="3" class="empty-state">Конфигураций без применяемости нет.</td></tr>@endforelse</tbody></table></div>
            @include('admin.partials.pagination', ['paginator' => $configurations])
        </main>
    </div>
@endsection
