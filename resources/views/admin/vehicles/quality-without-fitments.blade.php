@extends('layouts.admin')

@section('title', 'Конфигурации без применяемости')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--wide">
            @include('admin.partials.flash')
            <div class="page-heading"><div><p class="eyebrow">Качество применяемости</p><h1>Конфигурации без применяемости</h1><p class="admin-content__lead">Для этих автомобилей нет ни одной активной группы применяемости.</p></div><a class="button button--secondary button--inline" href="{{ route('admin.compatibility.quality') }}">К отчёту</a></div>
            <form class="toolbar" method="GET">
                <select name="make_id" aria-label="Марка" onchange="this.form.elements.model_id.value = ''; this.form.requestSubmit()">
                    <option value="">Все марки</option>
                    @foreach ($vehicleMakes as $make)
                        <option value="{{ $make->id }}" @selected($makeId === $make->id)>{{ $make->name }}</option>
                    @endforeach
                </select>
                <select name="model_id" aria-label="Модель">
                    <option value="">Все модели</option>
                    @foreach ($vehicleModels as $model)
                        <option value="{{ $model->id }}" @selected($modelId === $model->id)>{{ $makeId ? $model->name : $model->make->name.' '.$model->name }}</option>
                    @endforeach
                </select>
                <button class="button button--secondary">Применить</button>
                @if ($makeId || $modelId)
                    <a class="text-link" href="{{ route('admin.vehicles.configurations.quality') }}">Сбросить</a>
                @endif
            </form>
            <div class="table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Автомобиль</th><th>Конфигурация</th><th>Действия</th></tr></thead>
                    <tbody>
                    @forelse ($configurations as $configuration)
                        @php($model = $configuration->generation->vehicleModel)
                        <tr>
                            <td>{{ $model->make->name }} {{ $model->name }} · {{ $configuration->generation->name }}</td>
                            <td>{{ $configuration->display_name }}</td>
                            <td>
                                <a class="text-link" href="{{ route('admin.fitments.index', ['vehicle_configuration_id' => $configuration->id]) }}">Открыть группы применяемости</a><br>
                                <a class="text-link" href="{{ route('admin.vehicles.vehicle-configurations.edit', [$model->make, $model, $configuration->generation, $configuration]) }}">Изменить</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="empty-state">{{ $makeId || $modelId ? 'По выбранным фильтрам конфигураций без применяемости нет.' : 'Конфигураций без применяемости нет.' }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @include('admin.partials.pagination', ['paginator' => $configurations])
        </main>
    </div>
@endsection
