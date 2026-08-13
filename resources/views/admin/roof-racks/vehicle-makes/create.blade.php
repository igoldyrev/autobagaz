@extends('layouts.admin')

@section('title', 'Новая марка')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.roof-racks.vehicle-makes.index') }}">Марки</a><span>/</span><span>Новая марка</span>
            </nav>
            <p class="eyebrow">Автобагажники</p>
            <h1>Добавить марку</h1>
            <p class="admin-content__lead">Новая марка появится в общем справочнике и будет привязана к разделу «Автобагажники».</p>

            <form class="admin-form" method="POST" action="{{ route('admin.roof-racks.vehicle-makes.store') }}" enctype="multipart/form-data">
                @include('admin.roof-racks.vehicle-makes._form')
            </form>
        </main>
    </div>
@endsection
