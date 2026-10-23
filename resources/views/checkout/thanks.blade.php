@extends('layouts.catalog')

@section('title', 'Заявка принята')
@section('robots', 'noindex,nofollow')

@section('content')
    <section class="checkout-success ym-hide-content">
        <h1 class="title title-h1">Заявка принята</h1>
        <p>Мы получили вашу заявку и свяжемся с вами для подтверждения.</p>
        @include('checkout._request_notice')
        <p><a class="button button__buy" href="{{ route('checkout.open-order') }}">Открыть заказ</a></p>
        <a class="button button__buy" href="{{ route('home') }}">Вернуться в каталог</a>
    </section>
@endsection
