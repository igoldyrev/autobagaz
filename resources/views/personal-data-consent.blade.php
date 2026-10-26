@extends('layouts.catalog')

@section('title', 'Согласие на обработку персональных данных')
@section('meta_description', 'Согласие пользователя сайта Автобагаж на обработку персональных данных.')

@section('content')
    <x-breadcrumbs :items="[
        ['name' => 'Главная страница', 'url' => route('home')],
        ['name' => 'Согласие на обработку персональных данных'],
    ]" />

    @include(App\Support\PersonalDataConsent::view(), ['showRevision' => false])
@endsection
