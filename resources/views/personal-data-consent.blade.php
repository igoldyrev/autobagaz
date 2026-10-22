@extends('layouts.catalog')

@section('title', 'Согласие на обработку персональных данных')
@section('meta_description', 'Согласие пользователя сайта Автобагаж на обработку персональных данных.')

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">Согласие на обработку персональных данных</span>
    </nav>

    @include(App\Support\PersonalDataConsent::view())
@endsection
