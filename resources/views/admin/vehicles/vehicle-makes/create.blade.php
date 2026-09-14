@extends('layouts.admin')

@section('title', 'Новая марка')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Глобальный справочник</p>
            <h1>Добавить марку</h1>
            <p class="admin-content__lead">Создайте марку один раз, добавьте её модели и выберите разделы каталога, где она должна использоваться.</p>

            <form class="admin-form" method="POST" action="{{ route('admin.vehicles.vehicle-makes.store') }}" enctype="multipart/form-data">
                @include('admin.vehicles.vehicle-makes._form')
            </form>
        </main>
    </div>
@endsection
