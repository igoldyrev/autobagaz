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
            @if ($installationService)
                <article class="cart-item cart-item--service">
                    <span>{{ $installationService->name }}@if ($installationService->description)<small>{{ $installationService->description }}</small>@endif</span>
                    <span>{{ number_format((float) $installationService->price, 2, ',', ' ') }} ₽</span>
                    <span>Услуга</span>
                    <strong>{{ number_format((float) $installationService->price, 2, ',', ' ') }} ₽</strong>
                    <form method="POST" action="{{ route('cart.installation-service.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button class="cart-item__remove" type="submit">Удалить</button>
                    </form>
                </article>
            @endif
            @if ($hasInstallationKit)
                <section class="cart-installation-kit-confirmation" aria-labelledby="cart-installation-kit-confirmation-title">
                    <h2 id="cart-installation-kit-confirmation-title">Полный комплект для установки собран</h2>
                    <p>В корзине есть товар «<a href="{{ route('products.show', $roofRackAccessory) }}">{{ $roofRackAccessory->name }}</a>» и багажник на крышу.</p>
                </section>
            @elseif ($recommendedRoofRack)
                <section class="cart-roof-rack-cross-sell" aria-labelledby="cart-roof-rack-cross-sell-title">
                    <h2 id="cart-roof-rack-cross-sell-title">Всё необходимое для установки</h2>
                    <p class="cart-roof-rack-cross-sell__vehicle">Для вашего автомобиля — совместимый багажник:</p>
                    <p><strong><a href="{{ route('products.show', $recommendedRoofRack) }}">{{ $recommendedRoofRack->name }}</a></strong> · {{ number_format((float) $recommendedRoofRack->price, 2, ',', ' ') }} ₽</p>
                    <form method="POST" action="{{ route('cart.store', $recommendedRoofRack) }}">
                        @csrf
                        <button class="button button__buy" type="submit">Добавить багажник</button>
                    </form>
                    <p class="cart-roof-rack-cross-sell__total">Итого с багажником: {{ number_format((float) $total + (float) $recommendedRoofRack->price, 2, ',', ' ') }} ₽</p>
                </section>
            @elseif ($roofRackAccessory)
                <section class="cart-roof-rack-cross-sell" aria-labelledby="cart-roof-rack-cross-sell-title">
                    <h2 id="cart-roof-rack-cross-sell-title">Для установки требуется багажник на крышу</h2>
                    <p>«<a href="{{ route('products.show', $roofRackAccessory) }}">{{ $roofRackAccessory->name }}</a>» устанавливается на поперечины.</p>
                    <a class="button button--secondary" href="{{ route('catalog.vehicle-fitment.index', ['redirect_to' => 'roof-racks']) }}">Подобрать совместимый багажник</a>
                </section>
            @endif
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
