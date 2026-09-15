@extends('layouts.catalog')

@section('title', 'Заказ принят')

@section('content')
    <section class="checkout-success">
        <h1 class="title title-h1">Заказ принят</h1>
        <p>Заказ № {{ $order->number }} сохранён. Мы свяжемся с вами для подтверждения.</p>
        <a class="button button__buy" href="{{ route('home') }}">Вернуться в каталог</a>
    </section>
@endsection
