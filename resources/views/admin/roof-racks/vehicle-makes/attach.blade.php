@extends('layouts.admin')

@section('title', 'Привязать существующую марку')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.roof-racks.vehicle-makes.index') }}">Марки</a><span>/</span><span>Привязать существующую</span>
            </nav>
            <p class="eyebrow">Общий справочник</p>
            <h1>Привязать марку</h1>
            <p class="admin-content__lead">Выберите марку, которая уже существует в справочнике, но пока не показывается в разделе «Автобагажники».</p>

            @if ($vehicleMakes->isEmpty())
                <div class="empty-panel">
                    <p>Все существующие марки уже привязаны к разделу.</p>
                    <a class="button button--primary button--inline" href="{{ route('admin.roof-racks.vehicle-makes.create') }}">Создать новую марку</a>
                </div>
            @else
                <form class="admin-form" method="POST" action="{{ route('admin.roof-racks.vehicle-makes.attach') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="field field--wide">
                            <label for="vehicle_make_id">Марка</label>
                            <select id="vehicle_make_id" name="vehicle_make_id" required>
                                <option value="">Выберите марку</option>
                                @foreach ($vehicleMakes as $vehicleMake)
                                    <option value="{{ $vehicleMake->id }}" @selected(old('vehicle_make_id') == $vehicleMake->id)>{{ $vehicleMake->name }} ({{ $vehicleMake->models_count }} моделей)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label for="sort_order">Порядок в разделе</label>
                            <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $nextSortOrder) }}" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="button button--primary button--inline" type="submit">Привязать</button>
                        <a class="button button--secondary" href="{{ route('admin.roof-racks.vehicle-makes.index') }}">Отмена</a>
                    </div>
                </form>
            @endif
        </main>
    </div>
@endsection
