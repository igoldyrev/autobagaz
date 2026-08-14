@extends('layouts.admin')

@section('title', 'Новый производитель автобагажников')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Справочник автобагажников</p>
            <h1>Добавить производителя</h1>
            <form class="admin-form" method="POST" action="{{ route('admin.products.roof-racks.manufacturers.store') }}">
                @include('admin.roof-rack-manufacturers._form')
            </form>
        </main>
    </div>
@endsection
