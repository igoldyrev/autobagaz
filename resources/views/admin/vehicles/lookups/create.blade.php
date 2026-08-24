@extends('layouts.admin')
@section('title', 'Новый '.$singular)
@section('body')
<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--form">@include('admin.partials.flash')
<nav class="admin-breadcrumbs"><a href="{{ route($routePrefix.'.index') }}">{{ $title }}</a><span>/</span><span>Новая запись</span></nav><p class="eyebrow">{{ $eyebrow }}</p><h1>Добавить {{ $singular }}</h1>
<form class="admin-form" method="POST" action="{{ route($routePrefix.'.store') }}">@include('admin.vehicles.lookups._form')</form>
</main></div>
@endsection
