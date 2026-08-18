@extends('layouts.admin')

@section('title', 'Редактирование '.$manufacturer->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Производитель автомобильных боксов</p>
            <h1>{{ $manufacturer->name }}</h1>
            <p class="admin-content__lead">Товаров с этим производителем: {{ $manufacturer->auto_box_products_count }}.</p>
            <form class="admin-form" method="POST" action="{{ route('admin.products.auto-boxes.manufacturers.update', $manufacturer) }}">
                @include('admin.auto-box-manufacturers._form')
            </form>
        </main>
    </div>
@endsection
