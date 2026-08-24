@extends('layouts.admin')
@section('title', 'Новый автобагажник')
@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Товары · Автобагажники</p>
            <h1>Добавить автобагажник</h1>

            <form class="admin-form" method="POST" action="{{ route('admin.products.roof-racks.store') }}" enctype="multipart/form-data">
                @include('admin.products._form')
            </form>
        </main>
    </div>
@endsection
