<div class="product-grid">
    @foreach ($products as $product)
        <article class="product-card">
            <a class="product-card__image-link" href="{{ route('products.show', $product) }}">
                @if ($product->images->first())
                    <img class="product-card__image" src="{{ asset($product->images->first()->path) }}" alt="{{ $product->images->first()->alt ?: $product->name }}" loading="lazy">
                @else
                    <span class="product-card__no-image">Нет фото</span>
                @endif
            </a>
            <div class="product-card__body">
                <a class="product-card__name" href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                @if ($selectedVehicle)
                    <span class="product-card__compatibility">
                        <span aria-hidden="true">✓</span>
                        Подходит для вашей {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}
                    </span>
                @endif
                <strong class="product-card__price">{{ number_format((float) $product->price, 2, ',', ' ') }} ₽</strong>
                <span class="product-card__stock">{{ $product->stock > 0 ? 'В наличии: '.$product->stock.' шт.' : 'Под заказ' }}</span>
                <form method="POST" action="{{ route('cart.store', $product) }}" class="product-card__cart-form">
                    @csrf
                    <button class="button button__buy product-card__buy" type="submit">В корзину</button>
                </form>
            </div>
        </article>
    @endforeach
</div>
