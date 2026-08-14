@extends('layouts.admin')

@section('title', 'Редактирование '.$manufacturer->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Производитель автобагажников</p>
            <h1>{{ $manufacturer->name }}</h1>
            <p class="admin-content__lead">Товаров с этим производителем: {{ $manufacturer->roof_rack_products_count }}.</p>
            <form class="admin-form" method="POST" action="{{ route('admin.products.roof-racks.manufacturers.update', $manufacturer) }}">
                @include('admin.roof-rack-manufacturers._form')
            </form>
        </main>
    </div>
@endsection
