<h1>Новый заказ {{ $order->number }}</h1>
<p><strong>Клиент:</strong> {{ $order->customer_name }}</p>
<p><strong>Телефон:</strong> <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></p>
<p><strong>Email:</strong> <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
<p><strong>Получение:</strong> {{ $order->deliveryMethodLabel() }}</p>
@if ($order->delivery_address)<p><strong>Адрес:</strong> {{ $order->delivery_address }}</p>@endif
@if ($order->comment)<p><strong>Комментарий:</strong> {{ $order->comment }}</p>@endif
<h2>Товары</h2>
<ul>
@foreach ($order->items as $item)
    <li>{{ $item->product_name }} × {{ $item->quantity }} — {{ number_format((float) $item->total, 2, ',', ' ') }} ₽</li>
@endforeach
</ul>
<p><strong>Итого: {{ number_format((float) $order->total, 2, ',', ' ') }} ₽</strong></p>
