@extends('layouts.admin')
@section('title', 'Новое поколение')
@section('body')<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--form">@include('admin.partials.flash')<p class="eyebrow">{{ $vehicleMake->name }} {{ $vehicleModel->name }}</p><h1>Добавить поколение</h1><form class="admin-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.vehicles.vehicle-generations.store', [$vehicleMake, $vehicleModel]) }}">@include('admin.vehicles.vehicle-generations._form')</form></main></div>@endsection
