@extends('layouts.admin')

@section('title', 'Редактирование '.$vehicleMake->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Глобальный справочник</p>
                    <h1>{{ $vehicleMake->name }}</h1>
                </div>
                <a class="button button--secondary" href="{{ route('admin.vehicles.vehicle-models.index', $vehicleMake) }}">Модели ({{ $vehicleMake->models()->count() }})</a>
            </div>

            <form class="admin-form" method="POST" action="{{ route('admin.vehicles.vehicle-makes.update', $vehicleMake) }}" enctype="multipart/form-data">
                @include('admin.vehicles.vehicle-makes._form')
            </form>

        </main>
    </div>
@endsection
