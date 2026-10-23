@php
    $availableQuantity = min($quantity, max(0, (int) $stock));
    $backorderQuantity = $quantity - $availableQuantity;
@endphp
<span data-cart-availability>По текущему остатку: <span data-cart-available>{{ $availableQuantity }}</span> шт.; Под заказ: <span data-cart-backorder>{{ $backorderQuantity }}</span> шт.</span>
<span class="order-availability-warning" data-cart-stock-warning @if ($backorderQuantity === 0) hidden @endif>Количество превышает текущий остаток. Срок поставки товаров под заказ подтвердит менеджер.</span>
