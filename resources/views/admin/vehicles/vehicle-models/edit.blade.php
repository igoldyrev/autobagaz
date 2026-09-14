@extends('layouts.admin')

@section('title', 'Редактирование '.$vehicleModel->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">{{ $vehicleMake->name }}</p>
            <h1>{{ $vehicleModel->name }}</h1>

            <form class="admin-form" method="POST" action="{{ route('admin.vehicles.vehicle-models.update', [$vehicleMake, $vehicleModel]) }}" enctype="multipart/form-data">
                @include('admin.vehicles.vehicle-models._form')
            </form>

            <section class="danger-zone">
                <div>
                    <h2>Удалить модель</h2>
                    <p>Модель будет удалена из общего справочника марки {{ $vehicleMake->name }}.</p>
                </div>
                <form method="POST" action="{{ route('admin.vehicles.vehicle-models.destroy', [$vehicleMake, $vehicleModel]) }}" onsubmit="return confirm('Удалить модель «{{ $vehicleModel->name }}»?')">
                    @csrf
                    @method('DELETE')
                    <button class="button button--danger" type="submit">Удалить модель</button>
                </form>
            </section>
        </main>
    </div>
@endsection
