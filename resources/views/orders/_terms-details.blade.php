@if ($terms->change_reason)<p><strong>Причина предложения:</strong> {{ $terms->change_reason }}</p>@endif
@unless ($hideItems ?? false)
<div class="order-terms-table-wrap"><table class="admin-table order-terms-table">
    <thead><tr><th>Позиция</th><th>Цена</th><th>Количество</th><th>Сумма</th><th>Срок поставки</th></tr></thead>
    <tbody>@foreach ($terms->items as $item)
        <tr><td>{{ $item['product_name'] }}</td><td>{{ number_format((float) $item['unit_price'], 2, ',', ' ') }} ₽</td><td>{{ $item['quantity'] }}</td><td>{{ number_format((float) $item['total'], 2, ',', ' ') }} ₽</td><td>{{ $item['quantity'] === 0 ? 'Не включена в предложение' : $item['supply_terms'] }}</td></tr>
    @endforeach</tbody>
</table></div>
@endunless
<dl>
    <dt>Получение</dt><dd>{{ $terms->delivery_method === 'delivery' ? 'Доставка' : 'Самовывоз' }}@if($terms->delivery_address) · {{ $terms->delivery_address }}@endif</dd>
    <dt>Сроки и порядок получения</dt><dd>{{ $terms->delivery_terms }}</dd>
    <dt>Стоимость доставки</dt><dd>{{ $terms->delivery_cost === null ? 'Пока не рассчитана' : number_format((float) $terms->delivery_cost, 2, ',', ' ').' ₽' }}</dd>
    <dt>Способ оплаты</dt><dd>{{ \App\Models\OrderTermsVersion::paymentMethods()[$terms->payment_method] }}</dd>
    <dt>Порядок оплаты</dt><dd>{{ $terms->payment_terms }}</dd>
    <dt>Товары и услуги</dt><dd>{{ number_format((float) $terms->goods_total, 2, ',', ' ') }} ₽</dd>
    <dt>Итог с доставкой</dt><dd>{{ $terms->total === null ? 'Будет определён после расчёта доставки' : number_format((float) $terms->total, 2, ',', ' ').' ₽' }}</dd>
</dl>
@if ($terms->baseline_version !== null && ! ($hideComparison ?? false))
    <p>Изменение стоимости относительно {{ $terms->baseline_version === 0 ? (($customerView ?? false) ? 'первоначального заказа' : 'исходной заявки') : 'согласованной версии № '.$terms->baseline_version }}:</p>
    <dl>
        @foreach (['goods_difference' => 'Товары и услуги', 'delivery_difference' => 'Доставка', 'total_difference' => 'Общий итог'] as $field => $label)
            <dt>{{ $label }}</dt><dd>@if($terms->$field === null)Разница пока не определена@else{{ (float) $terms->$field > 0 ? '+' : '' }}{{ number_format((float) $terms->$field, 2, ',', ' ') }} ₽@endif</dd>
        @endforeach
    </dl>
    <p class="order-note">Положительная разница увеличивает стоимость, отрицательная — уменьшает. Если вы уже внесли оплату, менеджер отдельно согласует доплату или возврат. Эти суммы не подтверждают движение денег.</p>
@endif
