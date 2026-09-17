@extends('layouts.catalog')

@section('title', 'Оформление заказа')

@section('content')
    <section class="checkout-page">
        <h1 class="title title-h1">Оформление заказа</h1>
        <form method="POST" action="{{ route('checkout.store') }}" class="checkout-form">
            @csrf
            <div class="checkout-form__summary">
                <h2>Ваш заказ</h2>
                @foreach ($items as $item)
                    <p><span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span><strong>{{ number_format($item['total'], 2, ',', ' ') }} ₽</strong></p>
                @endforeach
                @if ($installationService)
                    <p><span>{{ $installationService->name }}</span><strong>{{ number_format((float) $installationService->price, 2, ',', ' ') }} ₽</strong></p>
                @endif
                <p class="checkout-form__total"><span>Итого</span><strong>{{ number_format($total, 2, ',', ' ') }} ₽</strong></p>
            </div>
            <div class="checkout-form__fields">
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
                <div class="field" data-delivery-address @if (old('delivery_method', 'pickup') !== 'delivery') hidden @endif>
                    <label for="delivery_address">Адрес доставки</label>
                    <input id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" autocomplete="street-address">
                    @error('delivery_address')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="comment">Комментарий к заказу</label>
                    <textarea id="comment" name="comment" rows="4">{{ old('comment') }}</textarea>
                    @error('comment')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="checkout-form__honeypot" aria-hidden="true">
                    <label for="website">Сайт</label>
                    <input id="website" name="website" tabindex="-1" autocomplete="off">
                </div>
                <button class="button button__buy" type="submit">Оформить заказ</button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/checkout.js') }}" defer></script>
@endpush
