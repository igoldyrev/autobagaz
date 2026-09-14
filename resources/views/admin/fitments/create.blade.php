@extends('layouts.admin')
@section('title', 'Новая группа применяемости')
@section('body')<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--form">@include('admin.partials.flash')<p class="eyebrow">Совместимость</p><h1>Добавить группу применяемости</h1><form class="admin-form" method="POST" action="{{ route('admin.fitments.store') }}">@include('admin.fitments._form')</form></main></div>@endsection
