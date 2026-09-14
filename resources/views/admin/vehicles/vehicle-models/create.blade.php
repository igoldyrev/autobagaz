@extends('layouts.admin')

@section('title', 'Новая модель '.$vehicleMake->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">{{ $vehicleMake->name }}</p>
            <h1>Добавить модель</h1>

            <form class="admin-form" method="POST" action="{{ route('admin.vehicles.vehicle-models.store', $vehicleMake) }}" enctype="multipart/form-data">
                @include('admin.vehicles.vehicle-models._form')
            </form>
        </main>
    </div>
@endsection
