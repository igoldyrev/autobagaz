@extends('layouts.admin')

@section('title', 'Новый производитель автомобильных боксов')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Справочник автомобильных боксов</p>
            <h1>Добавить производителя</h1>
            <form class="admin-form" method="POST" action="{{ route('admin.products.auto-boxes.manufacturers.store') }}">
                @include('admin.auto-box-manufacturers._form')
            </form>
        </main>
    </div>
@endsection
