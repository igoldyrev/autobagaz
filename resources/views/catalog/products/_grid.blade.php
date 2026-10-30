@php
    $installationRecommendations = app(\App\Services\RoofRackRecommendationService::class);
    $cardProducts = new \Illuminate\Database\Eloquent\Collection($products->all());
    $cardProducts->loadMissing(['autoBox', 'bikeRack', 'skiRack', 'productType']);
    $hasOwnCrossbars = $installationRecommendations->ownsCrossbars();
@endphp
<div class="product-grid">
    @foreach ($products as $product)
        @php
            $cardBadges = array_slice(array_values(array_intersect(
                ['hit', 'budget', 'optimal', 'premium', 'new', 'recommended'],
                $product->badges ?? [],
            )), 0, 2);
            $box = $product->autoBox;
            $needsTowbar = $installationRecommendations->requiresTowbar($product);
            $usesOwnCrossbars = $hasOwnCrossbars && $installationRecommendations->requiresRoofRack($product);
            $matchingRoofRack = $box && $selectedVehicle && ! $usesOwnCrossbars
                ? $installationRecommendations->recommend($product, $selectedVehicle)
                : null;
            $boxSummary = [];
            $boxMounting = [];
            $formatNumber = fn ($value) => rtrim(rtrim(number_format((float) $value, 1, ',', ' '), '0'), ',');
            if ($box) {
                if ($box->volume_l > 0) {
                    $boxSummary[] = $formatNumber($box->volume_l).' л';
                }
                if ($box->length_cm > 0 && $box->width_cm > 0 && $box->height_cm > 0) {
                    $boxSummary[] = implode(' × ', array_map($formatNumber, [$box->length_cm, $box->width_cm, $box->height_cm])).' см';
                }
                if (filled($box->opening_type)) {
                    $boxMounting[] = 'Открывание: '.$box->opening_type;
                }
                if (filled($box->mounting_type)) {
                    $boxMounting[] = 'Крепление: '.$box->mounting_type;
                }
            }
        @endphp
        <article class="product-card">
            <a class="product-card__image-link" href="{{ route('products.show', $product) }}">
                @if ($cardBadges)
                    <span class="product-card__badges" aria-label="Особенности товара">
                        @foreach ($cardBadges as $badge)
                            <span class="product-card__badge product-card__badge--{{ $badge }}">{{ \App\Models\Product::BADGES[$badge] ?? $badge }}</span>
                        @endforeach
                    </span>
                @endif
                @if ($product->images->first())
                    <img class="product-card__image" src="{{ asset($product->images->first()->path) }}" alt="{{ $product->images->first()->alt ?: $product->name }}" loading="lazy">
                @else
                    <span class="product-card__no-image">Нет фото</span>
                @endif
            </a>
            <div class="product-card__body">
                <a class="product-card__name" href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                @if ($boxSummary || $boxMounting)
                    <div class="product-card__characteristics">
                        @if ($boxSummary)<span>{{ implode(' · ', $boxSummary) }}</span>@endif
                        @if ($boxMounting)<span>{{ implode(' · ', $boxMounting) }}</span>@endif
                    </div>
                @endif
                @if ($needsTowbar)
                    <span class="product-card__compatibility product-card__compatibility--conditional">Для установки необходим совместимый фаркоп</span>
                @elseif ($usesOwnCrossbars)
                    <span class="product-card__compatibility product-card__compatibility--conditional">Совместимость с вашими поперечинами пока не подтверждена</span>
                @elseif ($selectedVehicle)
                    <span class="product-card__compatibility">
                        <span aria-hidden="true">✓</span>
                        <span>
                            Подходит для вашей {{ $selectedVehicle->labelForYear($selectedVehicleYear) }}
                            @if ($matchingRoofRack) с указанным багажником @endif
                        </span>
                    </span>
                    @if ($matchingRoofRack)
                        <div class="product-card__installation">
                            <span class="product-card__stock">Подходящий багажник</span>
                            <a class="product-card__rack-link" href="{{ route('products.show', $matchingRoofRack) }}">{{ $matchingRoofRack->name }}</a>
                            <span class="product-card__stock">Для установки необходимы поперечины указанного багажника.</span>
                        </div>
                    @endif
                @endif
                <strong class="product-card__price">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</strong>
                @if ($product->hasActivePromotion())
                    @if ($product->promotion_label)
                        <span class="product-card__promotion-label">{{ $product->promotion_label }}</span>
                    @endif
                    <span class="product-card__old-price">{{ number_format((float) $product->old_price, 0, ',', ' ') }} ₽</span>
                @endif
                <span class="product-card__stock">{{ $product->available_stock > 0 ? 'В наличии: '.$product->available_stock.' шт.' : 'Под заказ' }}</span>
                <form method="POST" action="{{ route('cart.store', $product) }}" class="product-card__cart-form">
                    @csrf
                    <button class="button button__buy product-card__buy" type="submit">В корзину</button>
                </form>
            </div>
        </article>
    @endforeach
</div>
