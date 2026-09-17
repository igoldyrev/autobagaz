@extends('layouts.catalog')

@section('title', $product->meta_title ?: $product->name)
@section('meta_description', $product->meta_description ?: str($product->description)->stripTags()->limit(155))

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">{{ $product->name }}</span>
    </nav>

    <h1 class="title title-h1 product-page__title">{{ $product->name }}</h1>

    <div class="product-page">
        <section class="product-gallery" aria-label="Фотографии товара">
            @if ($product->images->isNotEmpty())
                @php($mainImage = $product->images->first())
                <div class="product-gallery__main">
                    <img
                        id="product-main-image"
                        src="{{ asset($mainImage->path) }}"
                        alt="{{ $mainImage->alt ?: $product->name }}"
                    >
                </div>

                @if ($product->images->count() > 1)
                    <div class="product-gallery__thumbnails" aria-label="Выбор фотографии">
                        @foreach ($product->images as $image)
                            <button
                                class="product-gallery__thumbnail {{ $loop->first ? 'product-gallery__thumbnail--active' : '' }}"
                                type="button"
                                data-product-thumbnail
                                data-image-src="{{ asset($image->path) }}"
                                data-image-alt="{{ $image->alt ?: $product->name }}"
                                aria-label="Показать фотографию {{ $loop->iteration }}"
                                aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                            >
                                <img src="{{ asset($image->path) }}" alt="" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="product-gallery__empty">Нет фотографий</div>
            @endif

            @if ($product->roofRack?->hasCharacteristics())
                <table class="roof-rack-characteristics">
                    <caption>Характеристики автобагажника</caption>
                    <tbody>
                        @if (filled($product->roofRack->bar_length_cm))
                            <tr>
                                <th scope="row">Длина дуги, см</th>
                                <td>{{ rtrim(rtrim(number_format((float) $product->roofRack->bar_length_cm, 1, ',', ''), '0'), ',') }}</td>
                            </tr>
                        @endif
                        @if (filled($product->roofRack->load_capacity_kg))
                            <tr>
                                <th scope="row">Нагрузка, кг</th>
                                <td>{{ rtrim(rtrim(number_format((float) $product->roofRack->load_capacity_kg, 1, ',', ''), '0'), ',') }}</td>
                            </tr>
                        @endif
                        @if (filled($product->roofRack->installation_method))
                            <tr>
                                <th scope="row">Способ установки</th>
                                <td>{{ $product->roofRack->installation_method }}</td>
                            </tr>
                        @endif
                        @if (filled($product->roofRack->bar_type))
                            <tr>
                                <th scope="row">Тип дуги</th>
                                <td>{{ $product->roofRack->bar_type }}</td>
                            </tr>
                        @endif
                        @if (filled($product->roofRack->rack_color))
                            <tr>
                                <th scope="row">Цвет багажника</th>
                                <td>{{ $product->roofRack->rack_color }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @endif

            @if ($product->autoBox?->hasCharacteristics())
                <table class="roof-rack-characteristics">
                    <caption>Характеристики автомобильного бокса</caption>
                    <tbody>
                        @if (filled($product->autoBox->length_cm))
                            <tr><th scope="row">Длина, см</th><td>{{ rtrim(rtrim(number_format((float) $product->autoBox->length_cm, 1, ',', ''), '0'), ',') }}</td></tr>
                        @endif
                        @if (filled($product->autoBox->width_cm))
                            <tr><th scope="row">Ширина, см</th><td>{{ rtrim(rtrim(number_format((float) $product->autoBox->width_cm, 1, ',', ''), '0'), ',') }}</td></tr>
                        @endif
                        @if (filled($product->autoBox->height_cm))
                            <tr><th scope="row">Высота, см</th><td>{{ rtrim(rtrim(number_format((float) $product->autoBox->height_cm, 1, ',', ''), '0'), ',') }}</td></tr>
                        @endif
                        @if (filled($product->autoBox->volume_l))
                            <tr><th scope="row">Объём, л</th><td>{{ rtrim(rtrim(number_format((float) $product->autoBox->volume_l, 1, ',', ''), '0'), ',') }}</td></tr>
                        @endif
                        @if (filled($product->autoBox->load_capacity_kg))
                            <tr><th scope="row">Грузоподъёмность, кг</th><td>{{ rtrim(rtrim(number_format((float) $product->autoBox->load_capacity_kg, 1, ',', ''), '0'), ',') }}</td></tr>
                        @endif
                        @if (filled($product->autoBox->opening_type))
                            <tr><th scope="row">Тип открывания</th><td>{{ $product->autoBox->opening_type }}</td></tr>
                        @endif
                        @if (filled($product->autoBox->mounting_type))
                            <tr><th scope="row">Тип крепления</th><td>{{ $product->autoBox->mounting_type }}</td></tr>
                        @endif
                        @if (filled($product->autoBox->box_color))
                            <tr><th scope="row">Цвет</th><td>{{ $product->autoBox->box_color }}</td></tr>
                        @endif
                    </tbody>
                </table>
            @endif

            @if ($product->bikeRack?->hasCharacteristics())
                <table class="roof-rack-characteristics">
                    <caption>Характеристики велокрепления</caption>
                    <tbody>
                        @if (filled($product->bikeRack->mounting_type))
                            <tr><th scope="row">Тип крепления</th><td>{{ $product->bikeRack->mounting_type }}</td></tr>
                        @endif
                        @if (filled($product->bikeRack->bike_capacity))
                            <tr><th scope="row">Вместимость, велосипедов</th><td>{{ $product->bikeRack->bike_capacity }}</td></tr>
                        @endif
                        @if (filled($product->bikeRack->load_capacity_kg))
                            <tr><th scope="row">Грузоподъёмность, кг</th><td>{{ rtrim(rtrim(number_format((float) $product->bikeRack->load_capacity_kg, 1, ',', ''), '0'), ',') }}</td></tr>
                        @endif
                    </tbody>
                </table>
            @endif
            @if ($product->skiRack?->hasCharacteristics())
                <table class="roof-rack-characteristics"><caption>Характеристики крепления для лыж и сноубордов</caption><tbody>@if(filled($product->skiRack->ski_pairs_capacity))<tr><th scope="row">Вместимость, пар лыж</th><td>{{ $product->skiRack->ski_pairs_capacity }}</td></tr>@endif @if(filled($product->skiRack->snowboard_capacity))<tr><th scope="row">Вместимость, сноубордов</th><td>{{ $product->skiRack->snowboard_capacity }}</td></tr>@endif</tbody></table>
            @endif
        </section>

        <section class="product-page__summary" aria-label="Характеристики товара">
            <dl class="product-characteristics">
                <div>
                    <dt>Производитель</dt>
                    <dd>{{ $product->roofRack?->manufacturer?->name ?: ($product->autoBox?->manufacturer?->name ?: ($product->bikeRack?->manufacturer?->name ?: ($product->skiRack?->manufacturer?->name ?: ($product->manufacturer ?: 'Не указан')))) }}</dd>
                </div>
                <div>
                    <dt>Страна производства</dt>
                    <dd>{{ $product->country_of_origin ?: 'Не указана' }}</dd>
                </div>
                <div>
                    <dt>Модель</dt>
                    <dd>{{ $product->product_model ?: 'Не указана' }}</dd>
                </div>
                <div>
                    <dt>Наличие</dt>
                    <dd class="{{ $product->stock > 0 ? 'product-characteristics__available' : 'product-characteristics__to-order' }}">
                        {{ $product->stock > 0 ? $product->stock.' шт.' : 'Под заказ' }}
                    </dd>
                </div>
            </dl>

            <p class="product-page__price">{{ number_format((float) $product->price, 2, ',', ' ') }} ₽</p>
            <form method="POST" action="{{ route('cart.store', $product) }}" class="product-page__buy">
                @csrf
                <button class="button button__buy" type="submit">В корзину</button>
            </form>

            <section class="product-vehicle-compatibility {{ $compatibilityResult ? 'product-vehicle-compatibility--'.$compatibilityResult->status : 'product-vehicle-compatibility--empty' }}" aria-labelledby="product-vehicle-compatibility-title">
                <h2 id="product-vehicle-compatibility-title">Совместимость</h2>
                @if ($selectedVehicle && $compatibilityResult)
                    <p class="product-vehicle-compatibility__label">Ваш автомобиль:</p>
                    <strong class="product-vehicle-compatibility__vehicle">{{ $selectedVehicleLabel }}</strong>
                    <p class="product-vehicle-compatibility__status">
                        <span aria-hidden="true">●</span>
                        @if ($compatibilityResult->status === App\Compatibility\CompatibilityResult::COMPATIBLE)
                            Подходит для вашей {{ $selectedVehicleLabel }}
                        @elseif ($compatibilityResult->status === App\Compatibility\CompatibilityResult::INCOMPATIBLE)
                            Не подходит для выбранного автомобиля
                        @else
                            Совместимость пока не подтверждена
                        @endif
                    </p>
                    @if ($compatibilityResult->status !== App\Compatibility\CompatibilityResult::COMPATIBLE)
                        <a class="button button--secondary product-vehicle-compatibility__button" href="{{ $alternativesUrl }}">Показать подходящие аналоги</a>
                    @endif
                @else
                    <p class="product-vehicle-compatibility__prompt">Выберите автомобиль, чтобы проверить совместимость товара.</p>
                    <a class="button button--secondary product-vehicle-compatibility__button" href="{{ route('catalog.vehicle-fitment.index') }}">Выбрать автомобиль</a>
                @endif
            </section>

            @if ($requiresRoofRack)
                <section class="product-roof-rack-cross-sell" aria-labelledby="product-roof-rack-cross-sell-title">
                    @if ($selectedVehicle && $recommendedRoofRack)
                        <h2 id="product-roof-rack-cross-sell-title">Всё необходимое для установки</h2>
                        <p class="product-roof-rack-cross-sell__vehicle">{{ $selectedVehicleLabel }}</p>
                        <dl class="product-roof-rack-cross-sell__kit">
                            <div><dt><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></dt><dd>{{ number_format((float) $product->price, 2, ',', ' ') }} ₽ ✓</dd></div>
                            <div><dt><a href="{{ route('products.show', $recommendedRoofRack) }}">{{ $recommendedRoofRack->name }}</a></dt><dd>{{ number_format((float) $recommendedRoofRack->price, 2, ',', ' ') }} ₽</dd></div>
                        </dl>
                        <form method="POST" action="{{ route('cart.store-kit', ['product' => $product, 'roofRack' => $recommendedRoofRack]) }}">
                            @csrf
                            <button class="button button__buy product-roof-rack-cross-sell__button" type="submit">Добавить комплект</button>
                        </form>
                        <p class="product-roof-rack-cross-sell__total">Итого: {{ number_format((float) $product->price + (float) $recommendedRoofRack->price, 2, ',', ' ') }} ₽</p>
                    @else
                        <h2 id="product-roof-rack-cross-sell-title">Требуется багажник на крышу</h2>
                        <p>Этот товар устанавливается на поперечины багажника.</p>
                        @if ($product->autoBox?->mounting_type)
                            <p class="product-roof-rack-cross-sell__mounting">Тип крепления: {{ $product->autoBox->mounting_type }}</p>
                        @endif
                        <p class="product-roof-rack-cross-sell__lead">Нет поперечин? Подберите багажник для вашего автомобиля.</p>
                        <a class="button button--secondary product-roof-rack-cross-sell__button" href="{{ route('catalog.vehicle-fitment.index', ['redirect_to' => 'roof-racks']) }}">Подобрать багажник →</a>
                    @endif
                </section>
            @endif

            @if ($compatibleVehicles->isNotEmpty())
                <details class="product-compatible-vehicles">
                    <summary>
                        <span>Подходит для {{ $compatibleVehicles->count() }} {{ $compatibleVehiclesCountLabel }}</span>
                        <span class="product-compatible-vehicles__action">Показать список</span>
                    </summary>
                    <p class="product-compatible-vehicles__lead">Подтверждённые конфигурации автомобилей для этого багажника:</p>
                    <ul class="product-compatible-vehicles__list">
                        @foreach ($compatibleVehicles as $vehicle)
                            <li>
                                <strong>{{ $vehicle->generation->vehicleModel->make->name }} {{ $vehicle->generation->vehicleModel->name }}</strong>
                                <span>{{ $vehicle->generation->display_name }} · {{ $vehicle->year_label }} · {{ $vehicle->bodyStyle?->name ?: 'кузов не указан' }} · {{ $vehicle->roofType?->name ?: 'крыша не указана' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </details>
            @endif
        </section>
    </div>

    @if ($product->description)
        <section class="product-description" aria-labelledby="product-description-title">
            <h2 id="product-description-title">Описание</h2>
            <div class="text product-description__content">{!! nl2br(e($product->description)) !!}</div>
        </section>
    @endif

    <section class="product-information-tabs" data-product-information-tabs aria-label="Условия покупки">
        <div class="product-information-tabs__controls" role="tablist" aria-label="Условия покупки">
            <button id="product-delivery-tab" class="product-information-tabs__control" type="button" role="tab" aria-selected="true" aria-controls="product-delivery-panel">Доставка</button>
            <button id="product-payment-tab" class="product-information-tabs__control" type="button" role="tab" aria-selected="false" aria-controls="product-payment-panel" tabindex="-1">Оплата</button>
            <button id="product-warranty-tab" class="product-information-tabs__control" type="button" role="tab" aria-selected="false" aria-controls="product-warranty-panel" tabindex="-1">Гарантия</button>
        </div>
        <div id="product-delivery-panel" class="product-information-tabs__panel" role="tabpanel" aria-labelledby="product-delivery-tab">
            {!! nl2br(e($productPageInformation->delivery_content)) !!}
        </div>
        <div id="product-payment-panel" class="product-information-tabs__panel" role="tabpanel" aria-labelledby="product-payment-tab" hidden>
            {!! nl2br(e($productPageInformation->payment_content)) !!}
        </div>
        <div id="product-warranty-panel" class="product-information-tabs__panel" role="tabpanel" aria-labelledby="product-warranty-tab" hidden>
            {!! nl2br(e($productPageInformation->warranty_content)) !!}
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('js/product-gallery.js') }}" defer></script>
    <script src="{{ asset('js/product-information-tabs.js') }}" defer></script>
@endpush
