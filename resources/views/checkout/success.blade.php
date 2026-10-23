@extends('layouts.catalog')

@section('title', 'Заказ '.$order->number)
@section('robots', 'noindex,nofollow')

@section('content')
    <section class="checkout-success checkout-order ym-hide-content">
        <h1 class="title title-h1">Заказ № {{ $order->number }}</h1>
        <p>Этап обработки: <strong>{{ $order->statusLabel() }}</strong></p>
        <p>{{ $order->statusDescription() }}</p>
        @unless ($order->isClosed())
            <ol class="order-processing-steps" aria-label="Этапы заказа" role="list">
                @foreach ($order->processingSteps() as $value => $label)
                    <li @if($order->status === $value) aria-current="step" @endif>
                        @unless ($loop->first)<span class="order-processing-steps__arrow" aria-hidden="true">→</span>@endunless
                        <span class="order-processing-steps__label">{{ match ($value) {
                            \App\Models\Order::STATUS_NEW => 'Принят',
                            \App\Models\Order::STATUS_CONFIRMED => 'Подтверждён',
                            \App\Models\Order::STATUS_AWAITING_SUPPLY => 'Поставка',
                            \App\Models\Order::STATUS_READY => 'Готов',
                            default => $label,
                        } }}</span>
                    </li>
                @endforeach
            </ol>
        @endunless
        @if (session('success'))<p role="status">{{ session('success') }}</p>@endif
        @if ($errors->any())
            <div role="alert"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @if ($acceptedTerms)
            <h2>Согласованные условия № {{ $acceptedTerms->version }}</h2>
            <p>Вы подтвердили эту версию {{ $acceptedTerms->accepted_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}.</p>
            @include('orders._terms-details', ['terms' => $acceptedTerms])
        @endif
        @if ($latestTerms && ! $latestTerms->accepted_at)
            <h2>Предложение менеджера № {{ $latestTerms->version }}</h2>
            <p>Проверьте состав, стоимость, сроки, получение и порядок оплаты.</p>
            @if ($acceptedTerms)<p>До вашего подтверждения новых условий сохраняется согласованная версия № {{ $acceptedTerms->version }}.</p>@endif
            @include('orders._terms-details', ['terms' => $latestTerms])
            @if ($order->canEditTerms())
                @if ($latestTerms->delivery_cost === null)<p>Стоимость доставки ещё не рассчитана. Её согласуют отдельно; в этой версии вы подтверждаете стоимость товаров и остальные указанные условия.</p>@endif
                <form method="POST" action="{{ route('checkout.terms.accept', ['order' => $order->access_token]) }}">
                    @csrf
                    <input type="hidden" name="version" value="{{ $latestTerms->version }}">
                    <label><input type="checkbox" name="accept_terms" value="1" required> Я согласен с условиями версии № {{ $latestTerms->version }}, включая состав, цены, сроки, получение и порядок оплаты.</label>
                    <button type="submit" class="button button__buy">Подтвердить условия</button>
                </form>
            @endif
        @elseif (! $latestTerms)
            <p>Состав и условия заказа указаны в исходной заявке ниже.</p>
        @endif
        @if ($order->isClosed())<p>Согласование условий этого заказа завершено.</p>@endif
        <details @if(! $latestTerms) open @endif>
            <summary>Исходная заявка и условия оформления</summary>
            <div class="order-terms-table-wrap"><table class="order-terms-table">
                <thead><tr><th>Товар или услуга</th><th>Цена</th><th>Количество</th><th>Сумма</th></tr></thead>
                <tbody>@foreach ($order->items as $item)
                    <tr><td>{{ $item->product_name }}</td><td>{{ number_format((float) $item->unit_price, 2, ',', ' ') }} ₽</td><td>{{ $item->quantity }}</td><td>{{ number_format((float) $item->total, 2, ',', ' ') }} ₽</td></tr>
                @endforeach</tbody>
            </table></div>
            <p class="order-note">Товары и услуги в исходной заявке: <strong>{{ number_format((float) $order->total, 2, ',', ' ') }} ₽</strong>.</p>
            <p>{{ $order->deliveryMethodLabel() }}@if($order->delivery_address) · {{ $order->delivery_address }}@endif</p>
            @if ($order->delivery_method === 'delivery')
                <p class="order-note">При оформлении стоимость доставки не была рассчитана и в указанную сумму не включена. Если вы заказали установку в магазине, для неё потребуется отдельный визит — менеджер согласует порядок получения товара и время записи.</p>
            @else
                <p class="order-note">Самовывоз из магазина — без платы за доставку.</p>
            @endif
            @include('checkout._request_notice')
            @include('checkout._installation_notice', ['conditionalInstallationNotice' => true])
        </details>
        <a class="button button__buy" href="{{ route('home') }}">Вернуться в каталог</a>
    </section>
@endsection
