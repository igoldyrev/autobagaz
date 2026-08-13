@extends('layouts.admin')
@section('title', 'Редактирование '.$catalogCategory->name)
@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Раздел или категория</p>
            <h1>{{ $catalogCategory->name }}</h1>
            <p class="admin-content__lead">Чтобы убрать категорию с сайта, отключите публикацию. Данные и привязки товаров сохранятся.</p>
            <form class="admin-form" method="POST" action="{{ route('admin.catalog-categories.update', $catalogCategory) }}" enctype="multipart/form-data">
                @include('admin.catalog-categories._form')
            </form>
        </main>
    </div>
@endsection
