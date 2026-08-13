@extends('layouts.admin')
@section('title', 'Новая категория')
@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Структура каталога</p>
            <h1>Добавить раздел или категорию</h1>
            <form class="admin-form" method="POST" action="{{ route('admin.catalog-categories.store') }}" enctype="multipart/form-data">
                @include('admin.catalog-categories._form')
            </form>
        </main>
    </div>
@endsection
