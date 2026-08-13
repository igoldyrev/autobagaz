@extends('layouts.admin')

@section('title', 'Редактирование '.$vehicleMake->name)

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <nav class="admin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('admin.roof-racks.vehicle-makes.index') }}">Марки</a><span>/</span><span>{{ $vehicleMake->name }}</span>
            </nav>
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Автобагажники</p>
                    <h1>{{ $vehicleMake->name }}</h1>
                </div>
                <a class="button button--secondary" href="{{ route('admin.roof-racks.vehicle-models.index', $vehicleMake) }}">Модели ({{ $vehicleMake->models()->count() }})</a>
            </div>

            <form class="admin-form" method="POST" action="{{ route('admin.roof-racks.vehicle-makes.update', $vehicleMake) }}" enctype="multipart/form-data">
                @include('admin.roof-racks.vehicle-makes._form')
            </form>

            <section class="danger-zone">
                <div>
                    <h2>Убрать марку из раздела</h2>
                    <p>Марка и её модели останутся в общем справочнике для использования в других разделах.</p>
                </div>
                <form method="POST" action="{{ route('admin.roof-racks.vehicle-makes.destroy', $vehicleMake) }}" onsubmit="return confirm('Убрать марку из раздела «Автобагажники»?')">
                    @csrf
                    @method('DELETE')
                    <button class="button button--danger" type="submit">Убрать из раздела</button>
                </form>
            </section>
        </main>
    </div>
@endsection
