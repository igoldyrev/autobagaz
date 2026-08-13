@extends('layouts.admin')

@section('title', 'Новая модель '.$vehicleMake->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.vehicles.vehicle-makes.index') }}">Марки</a><span>/</span>
                <a href="{{ route('admin.vehicles.vehicle-models.index', $vehicleMake) }}">{{ $vehicleMake->name }}</a><span>/</span><span>Новая модель</span>
            </nav>
            <p class="eyebrow">{{ $vehicleMake->name }}</p>
            <h1>Добавить модель</h1>

            <form class="admin-form" method="POST" action="{{ route('admin.vehicles.vehicle-models.store', $vehicleMake) }}" enctype="multipart/form-data">
                @include('admin.vehicles.vehicle-models._form')
            </form>
        </main>
    </div>
@endsection
