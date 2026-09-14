@extends('layouts.admin')
@section('title', 'Новое велокрепление')
@section('body')<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--form">@include('admin.partials.flash')<p class="eyebrow">Товары · Велокрепления</p><h1>Добавить велокрепление</h1><form class="admin-form" method="POST" action="{{ route('admin.products.bike-racks.store') }}" enctype="multipart/form-data">@include('admin.bike-rack-products._form')</form></main></div>@endsection
