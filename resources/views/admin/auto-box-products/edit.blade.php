@extends('layouts.admin')
@section('title', 'Редактирование '.$product->name)
@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Товары · Автомобильные боксы</p>
            <h1>{{ $product->name }}</h1>
            <p class="admin-content__lead">Отключение публикации скрывает товар с сайта без удаления данных.</p>
            <form class="admin-form" method="POST" action="{{ route('admin.products.auto-boxes.update', $product) }}" enctype="multipart/form-data">
                @include('admin.auto-box-products._form')
            </form>
        </main>
    </div>
@endsection
