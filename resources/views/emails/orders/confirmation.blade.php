<h1>Заказ {{ $order->number }} принят</h1>
<p>Здравствуйте, {{ $order->customer_name }}!</p>
<p>Мы получили ваш заказ и свяжемся с вами по телефону для подтверждения.</p>
<h2>Состав заказа</h2>
<ul>
@foreach ($order->items as $item)
    <li>{{ $item->product_name }} × {{ $item->quantity }} — {{ number_format((float) $item->total, 2, ',', ' ') }} ₽</li>
@endforeach
</ul>
<p><strong>Итого: {{ number_format((float) $order->total, 2, ',', ' ') }} ₽</strong></p>
