<h1>Заказ {{ $order->number }} принят</h1>
<p>Здравствуйте, {{ $order->customer_name }}!</p>
<p>Мы получили ваш заказ и свяжемся с вами по телефону для подтверждения.</p>
@include('checkout._request_notice')
<h2>Состав заказа</h2>
<ul>
@foreach ($order->items as $item)
    <li>{{ $item->product_name }} × {{ $item->quantity }} — {{ number_format((float) $item->total, 0, ',', ' ') }} ₽</li>
@endforeach
</ul>
<p><strong>Итого: {{ number_format((float) $order->total, 0, ',', ' ') }} ₽</strong></p>

<p><a href="{{ $order->customerUrl() }}">Открыть заказ</a></p>
<p>Сохраните эту ссылку и не передавайте её другим людям: она открывает доступ к заказу.</p>
