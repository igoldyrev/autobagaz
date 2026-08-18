@extends('layouts.admin')
@section('title', 'Новый автомобильный бокс')
@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Товары · Автомобильные боксы</p>
            <h1>Добавить автомобильный бокс</h1>
            <form class="admin-form" method="POST" action="{{ route('admin.products.auto-boxes.store') }}" enctype="multipart/form-data">
                @include('admin.auto-box-products._form')
            </form>
        </main>
    </div>
@endsection
