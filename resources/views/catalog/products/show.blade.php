@extends('layouts.catalog')

@section('title', $product->name)
@section('meta_description', str($product->description)->stripTags()->limit(155))

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
        </section>

        <section class="product-page__summary" aria-label="Характеристики товара">
            <dl class="product-characteristics">
                <div>
                    <dt>Производитель</dt>
                    <dd>{{ $product->roofRack?->manufacturer?->name ?: ($product->manufacturer ?: 'Не указан') }}</dd>
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
        </section>
    </div>

    @if ($product->description)
        <section class="product-description" aria-labelledby="product-description-title">
            <h2 id="product-description-title">Описание</h2>
            <div class="text product-description__content">{!! nl2br(e($product->description)) !!}</div>
        </section>
    @endif

    @if ($product->vehicleModels->isNotEmpty())
        <section class="product-compatibility" aria-labelledby="product-compatibility-title">
            <h2 id="product-compatibility-title">Подходит для моделей</h2>
            <ul>
                @foreach ($product->vehicleModels as $vehicleModel)
                    <li>{{ $vehicleModel->make->name }} {{ $vehicleModel->name }}</li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/product-gallery.js') }}" defer></script>
@endpush
