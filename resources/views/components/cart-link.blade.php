@php($cartCount = array_sum(session('cart.items', [])))
<a class="header__cart" href="{{ route('cart.index') }}" aria-label="Корзина, товаров: {{ $cartCount }}">
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    <span class="header__cart-label">Корзина</span>
    <span class="header__cart-count">{{ $cartCount }}</span>
</a>
