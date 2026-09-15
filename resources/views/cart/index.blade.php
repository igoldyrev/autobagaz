@extends('layouts.catalog')

@section('title', 'Корзина')

@section('content')
    <section class="cart-page">
        <h1 class="title title-h1">Корзина</h1>

        @if (session('success'))
            <p class="order-flash order-flash--success" role="status">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p class="order-flash order-flash--error" role="alert">{{ session('error') }}</p>
        @endif

        @forelse ($items as $item)
            <article class="cart-item" data-cart-item data-unit-price="{{ $item['product']->price }}">
                <a href="{{ route('products.show', $item['product']) }}">{{ $item['product']->name }}</a>
                <span>{{ number_format((float) $item['product']->price, 2, ',', ' ') }} ₽</span>
                <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="cart-item__quantity" data-cart-quantity-form>
                    @csrf
                    @method('PATCH')
                    <label for="quantity-{{ $item['product']->id }}">Количество</label>
                    <input id="quantity-{{ $item['product']->id }}" name="quantity" type="number" min="1" max="100" value="{{ $item['quantity'] }}" data-cart-quantity>
                </form>
                <strong data-cart-line-total>{{ number_format($item['total'], 2, ',', ' ') }} ₽</strong>
                <form method="POST" action="{{ route('cart.destroy', $item['product']) }}">
                    @csrf
                    @method('DELETE')
                    <button class="cart-item__remove" type="submit">Удалить</button>
                </form>
            </article>
        @empty
            <p class="cart-page__empty">В корзине пока нет товаров.</p>
        @endforelse

        @if ($items->isNotEmpty())
            <div class="cart-page__total">
                <strong>Итого: <span data-cart-total>{{ number_format($total, 2, ',', ' ') }} ₽</span></strong>
                <a class="button button__buy" href="{{ route('checkout.create') }}">Оформить заказ</a>
            </div>
        @endif

        @if ($recentProducts->isNotEmpty())
            <section class="cart-recently-viewed" aria-labelledby="recently-viewed-title">
                <h2 class="title title-h2" id="recently-viewed-title">Товары, просмотренные ранее</h2>
                @include('catalog.products._grid', ['products' => $recentProducts, 'selectedVehicle' => null])
            </section>
        @endif
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/cart.js') }}" defer></script>
@endpush
