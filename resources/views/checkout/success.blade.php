@extends('layouts.catalog')

@section('title', 'Заказ принят')
@section('robots', 'noindex,nofollow')

@section('content')
    <section class="checkout-success ym-hide-content">
        <h1 class="title title-h1">Заказ принят</h1>
        <p>Заказ № {{ $order->number }} сохранён. Мы свяжемся с вами для подтверждения.</p>
        @include('checkout._request_notice')
        <p class="order-note">Товары и услуги: <strong>{{ number_format((float) $order->total, 2, ',', ' ') }} ₽</strong>.</p>
        @if ($order->delivery_method === 'delivery')
            <p class="order-note">Стоимость доставки пока не рассчитана и в указанную сумму не включена. Менеджер согласует её стоимость и срок. Если вы заказали установку в магазине, для неё потребуется отдельный визит — менеджер согласует порядок получения товара и время записи.</p>
        @else
            <p class="order-note">Самовывоз из магазина — без платы за доставку.</p>
        @endif
        @include('checkout._installation_notice', ['conditionalInstallationNotice' => true])
        <a class="button button__buy" href="{{ route('home') }}">Вернуться в каталог</a>
    </section>
@endsection
