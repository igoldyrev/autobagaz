@extends('layouts.catalog')

@section('title', 'Оформление заказа')

@section('content')
    <section class="checkout-page">
        <h1 class="title title-h1">Оформление заказа</h1>
        <form method="POST" action="{{ route('checkout.store') }}" class="checkout-form ym-hide-content">
            @csrf
            <input type="hidden" name="checkout_token" value="{{ $checkoutToken }}">
            <input type="hidden" name="checkout_snapshot" value="{{ $checkoutSnapshot }}">
            <div class="checkout-form__summary">
                @if ($changes)
                    <div role="alert" tabindex="-1" data-checkout-changes>
                        <h2>Условия заказа изменились</h2>
                        <ul>@foreach ($changes as $change)<li>{{ $change }}</li>@endforeach</ul>
                        <p>Проверьте новый состав и сумму. Заказ ещё не создан.</p>
                    </div>
                @endif
                @if ($snapshot === [])
                    <p role="alert">В заказе не осталось доступных товаров. <a href="{{ route('cart.index') }}">Вернуться в корзину</a></p>
                @endif
                <h2>Ваш заказ</h2>
                <p class="order-note">После оформления доступные товары резервируются на 15 минут без продления. После подтверждения оплаты действующий резерв сохраняется до выдачи.</p>
                @foreach ($snapshot as $item)
                    <p><span>{{ $item['name'] }} × {{ $item['quantity'] }} ({{ number_format($item['price'] / 100, 2, ',', ' ') }} ₽ за единицу)@if ($item['product_id'] !== null) — @include('checkout._availability', ['quantity' => $item['quantity'], 'stock' => $item['stock']])@endif</span><strong>{{ number_format($item['price'] * $item['quantity'] / 100, 2, ',', ' ') }} ₽</strong></p>
                @endforeach
                <p class="checkout-form__total"><span>{{ $changes ? 'Новая сумма товаров и услуг' : 'Товары и услуги' }}</span><strong>{{ number_format($total / 100, 2, ',', ' ') }} ₽</strong></p>
                <div aria-live="polite">
                    <p class="order-note" data-delivery-info="delivery" @if (old('delivery_method', 'pickup') !== 'delivery') hidden @endif>Стоимость доставки пока не рассчитана и в указанную сумму не включена. Менеджер согласует её при подтверждении заказа.</p>
                    <p class="order-note" data-delivery-info="pickup" @if (old('delivery_method', 'pickup') === 'delivery') hidden @endif>Самовывоз из магазина — без платы за доставку.</p>
                </div>
            </div>
            <div class="checkout-form__fields">
                @error('checkout_snapshot')<p class="field__error" role="alert">{{ $message }}</p>@enderror
                @error('checkout_token')<p class="field__error" role="alert">{{ $message }}</p>@enderror
                <div class="field">
                    <label for="customer_name">Имя</label>
                    <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}" autocomplete="name" required>
                    @error('customer_name')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="phone">Телефон</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" placeholder="+7 900 000-00-00" required>
                    @error('phone')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="name@example.com" required>
                    @error('email')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <fieldset class="checkout-form__delivery">
                    <legend>Способ получения</legend>
                    <label><input name="delivery_method" type="radio" value="pickup" @checked(old('delivery_method', 'pickup') === 'pickup')><span>Самовывоз</span></label>
                    <label><input name="delivery_method" type="radio" value="delivery" @checked(old('delivery_method') === 'delivery')><span>Доставка</span></label>
                    @error('delivery_method')<p class="field__error">{{ $message }}</p>@enderror
                </fieldset>
                <div class="field" data-delivery-address>
                    <label for="delivery_address">Адрес доставки</label>
                    <input id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" autocomplete="street-address">
                    @error('delivery_address')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                @if ($installationService)
                    <div class="checkout-form__installation-note" aria-live="polite">
                        @include('checkout._installation_notice')
                        <p class="order-note" data-delivery-info="delivery" @if (old('delivery_method', 'pickup') !== 'delivery') hidden @endif>При доставке и установке в магазине потребуется отдельный визит — менеджер согласует порядок получения товара и время записи.</p>
                    </div>
                @endif
                <div class="field">
                    <label for="comment">Комментарий к заказу</label>
                    <textarea id="comment" name="comment" rows="4">{{ old('comment') }}</textarea>
                    @error('comment')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="checkout-form__honeypot" aria-hidden="true">
                    <label for="website">Сайт</label>
                    <input id="website" name="website" tabindex="-1" autocomplete="off">
                </div>
                <x-personal-data-consent id="checkout-consent" />
                <button class="button button__buy" type="submit" @disabled($snapshot === [])>{{ $changes ? 'Подтвердить изменения и оформить заказ' : 'Оформить заказ' }}</button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/checkout.js') }}" defer></script>
@endpush
