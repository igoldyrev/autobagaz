@extends('layouts.catalog')

@section('title', 'Оформление заказа')

@section('content')
    <section class="checkout-page">
        <h1 class="title title-h1">Оформление заказа</h1>
        <form method="POST" action="{{ route('checkout.store') }}" class="checkout-form">
            @csrf
            <input type="hidden" name="checkout_token" value="{{ $checkoutToken }}">
            <div class="checkout-form__summary">
                <h2>Ваш заказ</h2>
                @foreach ($items as $item)
                    <p><span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span><strong>{{ number_format($item['total'], 0, ',', ' ') }} ₽</strong></p>
                @endforeach
                <p><span>Товары</span><strong>{{ number_format($items->sum('total'), 0, ',', ' ') }} ₽</strong></p>
                @if ($installationService)
                    <p><span>{{ $installationService->name }}</span><strong>{{ number_format((float) $installationService->price, 0, ',', ' ') }} ₽</strong></p>
                @endif
                <p class="checkout-form__total"><span>Товары и услуги</span><strong>{{ number_format($total, 0, ',', ' ') }} ₽</strong></p>
                <div aria-live="polite">
                    <p class="order-note" data-delivery-info="delivery" @if (old('delivery_method', 'pickup') !== 'delivery') hidden @endif>Стоимость доставки пока не рассчитана и в указанную сумму не включена. Менеджер согласует её при подтверждении заказа.</p>
                    <p class="order-note" data-delivery-info="pickup" @if (old('delivery_method', 'pickup') === 'delivery') hidden @endif>Самовывоз из магазина — без платы за доставку.</p>
                </div>
            </div>
            <div class="checkout-form__fields">
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
                <div class="field" data-delivery-address @if (old('delivery_method', 'pickup') !== 'delivery') hidden @endif>
                    <label for="delivery_address">Адрес доставки</label>
                    <input id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" autocomplete="street-address">
                    @error('delivery_address')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                @if ($installationService)
                    <div class="checkout-form__installation-note" aria-live="polite">
                        @include('checkout._installation_notice')
                        <p class="order-note" data-delivery-info="delivery" @if (old('delivery_method', 'pickup') !== 'delivery') hidden @endif>Вы выбрали доставку и установку в магазине. Для установки потребуется отдельный визит — менеджер согласует порядок получения товара и время записи.</p>
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
                <p class="order-note">После отправки заказа менеджер свяжется с вами для подтверждения наличия, стоимости и способа получения. Порядок оплаты согласуем при подтверждении заказа.</p>
                <button class="button button__buy" type="submit">Оформить заказ</button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/checkout.js') }}" defer></script>
@endpush
