<h1>{{ $heading }}</h1>
<p>Здравствуйте, {{ $snapshot['customer_name'] }}!</p>
@switch($event)
    @case('order_manager_confirmed')
        <p>Менеджер подтвердил возможность выполнения вашего заказа.</p>
        @break
    @case('order_cancelled')
        <p>Выполнение заказа прекращено. Если вы уже внесли оплату, менеджер согласует порядок возврата.</p>
        @break
    @case('order_ready')
        @if ($snapshot['terms']['delivery_method'] === 'delivery')
            <p>Весь заказ собран и готов к передаче службе доставки. После передачи мы сообщим об отправке.</p>
        @else
            <p>Весь заказ собран и готов к выдаче в магазине. Если согласована установка, она выполняется по предварительной записи.</p>
            <p>Магазин: {{ $snapshot['pickup_address'] }}.</p>
        @endif
        @break
    @case('order_shipped')
        <p>Заказ передан службе доставки. Отправка ещё не означает получение заказа покупателем.</p>
        @break
@endswitch
<p>Событие от {{ \Illuminate\Support\Carbon::parse($snapshot['occurred_at'])->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}. Ниже приведены условия на этот момент; актуальный статус доступен по ссылке на заказ.</p>
<h2>{{ $snapshot['terms_version'] === null ? 'Исходная заявка' : 'Согласованные условия № '.$snapshot['terms_version'] }}</h2>
@if ($snapshot['pending_terms_version'] !== null)
    <p>Менеджер предложил изменения условий № {{ $snapshot['pending_terms_version'] }}. Они пока не подтверждены вами. Ниже указаны ранее принятые условия; актуальная информация доступна по ссылке на заказ.</p>
@endif
<ul>
    @foreach ($snapshot['terms']['items'] as $item)
        @continue((int) $item['quantity'] === 0)
        <li>{{ $item['product_name'] }} × {{ $item['quantity'] }} — {{ number_format((float) $item['unit_price'], 2, ',', ' ') }} ₽ за единицу, {{ number_format((float) $item['total'], 2, ',', ' ') }} ₽ за позицию.@if($item['supply_terms']) Срок поставки / наличие: {{ $item['supply_terms'] }}.@endif</li>
    @endforeach
</ul>
<p><strong>Товары и услуги: {{ number_format((float) $snapshot['terms']['goods_total'], 2, ',', ' ') }} ₽.</strong></p>
<h2>Получение и оплата</h2>
<p>{{ $snapshot['terms']['delivery_method'] === 'delivery' ? 'Доставка' : 'Самовывоз' }}@if($snapshot['terms']['delivery_address']) · {{ $snapshot['terms']['delivery_address'] }}@endif.</p>
@if ($snapshot['terms']['delivery_terms'])<p>Сроки и порядок получения: {{ $snapshot['terms']['delivery_terms'] }}</p>@endif
<p>Стоимость доставки: {{ $snapshot['terms']['delivery_cost'] === null ? 'ещё не рассчитана' : number_format((float) $snapshot['terms']['delivery_cost'], 2, ',', ' ').' ₽' }}.</p>
@if ($snapshot['terms']['total'] === null)
    <p>Итог с доставкой будет определён после расчёта её стоимости. Неизвестная стоимость доставки не означает бесплатную доставку.</p>
@else
    <p><strong>Итог с доставкой: {{ number_format((float) $snapshot['terms']['total'], 2, ',', ' ') }} ₽.</strong></p>
@endif
@if ($snapshot['terms']['payment_method_label'])<p>Способ оплаты: {{ $snapshot['terms']['payment_method_label'] }}.</p>@endif
@if ($snapshot['terms']['payment_terms'])<p>Порядок оплаты: {{ $snapshot['terms']['payment_terms'] }}</p>@endif
@foreach ($snapshot['checkout_notices'] as $notice)<p>{{ $notice }}</p>@endforeach
<p>Это уведомление об обработке заказа. Оно не подтверждает оплату или возврат.</p>
<p><a href="{{ $customerUrl }}">Открыть заказ и проверить актуальные условия</a></p>
<p>Не передавайте эту ссылку другим людям: она открывает доступ к заказу.</p>
