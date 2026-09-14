@extends('layouts.admin')
@section('title', $item->name)
@section('body')
<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--form">@include('admin.partials.flash')
<p class="eyebrow">{{ $eyebrow }}</p><h1>{{ $item->name }}</h1>
<form class="admin-form" method="POST" action="{{ route($routePrefix.'.update', [$routeParameter => $item]) }}">@include('admin.vehicles.lookups._form')</form>
<section class="danger-zone"><div><h2>Удалить запись</h2><p>Удаление возможно, только если запись не используется конфигурациями.</p></div><form method="POST" action="{{ route($routePrefix.'.destroy', [$routeParameter => $item]) }}">@csrf @method('DELETE')<button class="button button--danger">Удалить</button></form></section>
</main></div>
@endsection
