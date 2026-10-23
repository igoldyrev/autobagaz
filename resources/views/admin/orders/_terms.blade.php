<section class="admin-card order-details">
    <h2>Предложения и согласованные условия</h2>
    @if ($acceptedTerms)
        <p>Действующие согласованные условия: версия № {{ $acceptedTerms->version }}.</p>
    @else
        <p>Согласие покупателя на условия пока не зафиксировано. Подтверждение заказа менеджером не означает согласия покупателя.</p>
    @endif
    @foreach ($termsVersions as $terms)
        <details @if($loop->first) open @endif>
            <summary>Версия № {{ $terms->version }} — {{ $terms->accepted_at ? 'Подтверждена покупателем' : 'Предложение менеджера' }}</summary>
            <p>{{ $terms->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }} · {{ $terms->created_by_name }}</p>
            @if ($terms->accepted_at)<p>Подтверждена: {{ $terms->accepted_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p>@endif
            <div class="table-wrap"><table class="admin-table">
                <thead><tr><th>Позиция</th><th>Цена</th><th>Количество</th><th>Сумма</th><th>Срок поставки</th></tr></thead>
                <tbody>@foreach ($terms->items as $item)
                    <tr><td>{{ $item['product_name'] }}</td><td>{{ number_format((float) $item['unit_price'], 2, ',', ' ') }} ₽</td><td>{{ $item['quantity'] }}</td><td>{{ number_format((float) $item['total'], 2, ',', ' ') }} ₽</td><td>{{ $item['supply_terms'] ?: 'Не включена в предложение' }}</td></tr>
                @endforeach</tbody>
            </table></div>
            <dl>
                <dt>Получение</dt><dd>{{ $terms->delivery_method === 'delivery' ? 'Доставка' : 'Самовывоз' }}@if($terms->delivery_address) · {{ $terms->delivery_address }}@endif</dd>
                <dt>Сроки и порядок получения</dt><dd>{{ $terms->delivery_terms }}</dd>
                <dt>Стоимость доставки</dt><dd>{{ $terms->delivery_cost === null ? 'Пока не рассчитана' : number_format((float) $terms->delivery_cost, 2, ',', ' ').' ₽' }}</dd>
                <dt>Способ оплаты</dt><dd>{{ \App\Models\OrderTermsVersion::paymentMethods()[$terms->payment_method] }}</dd>
                <dt>Порядок оплаты</dt><dd>{{ $terms->payment_terms }}</dd>
                <dt>Товары и услуги</dt><dd>{{ number_format((float) $terms->goods_total, 2, ',', ' ') }} ₽</dd>
                <dt>Итог с доставкой</dt><dd>{{ $terms->total === null ? 'Будет определён после расчёта доставки' : number_format((float) $terms->total, 2, ',', ' ').' ₽' }}</dd>
            </dl>
        </details>
    @endforeach
    {{ $termsVersions->links() }}
</section>

@unless ($order->isClosed())
<section class="admin-card">
    <h2>Предложить условия покупателю</h2>
    <p>Сохраняется новая версия предложения. Исходная заявка и ранее согласованные условия сохраняются. Сохранение предложения не фиксирует согласие покупателя.</p>
    <p>Цены взяты из исходной заявки. Чтобы исключить позицию из предложения, укажите количество 0.</p>
    @php($latestItems = collect($latestTerms?->items ?? [])->keyBy('order_item_id'))
    <form method="POST" action="{{ route('admin.orders.terms.store', $order) }}">
        @csrf
        <input type="hidden" name="expected_version" value="{{ old('expected_version', $latestTerms?->version ?? 0) }}">
        <input type="hidden" name="expected_status" value="{{ old('expected_status', $order->status) }}">
        @foreach ($order->items as $item)
            <fieldset>
                <legend>{{ $item->product_name }} — {{ number_format((float) $item->unit_price, 2, ',', ' ') }} ₽ за единицу</legend>
                <div class="form-grid">
                    <label class="field"><span>Предлагаемое количество (в заявке {{ $item->quantity }})</span><input type="number" name="items[{{ $item->id }}][quantity]" min="0" max="{{ $item->quantity }}" step="1" required value="{{ old('items.'.$item->id.'.quantity', $latestItems->get($item->id)['quantity'] ?? $item->quantity) }}"></label>
                    <label class="field"><span>Срок поставки / наличие</span><input type="text" name="items[{{ $item->id }}][supply_terms]" maxlength="1000" value="{{ old('items.'.$item->id.'.supply_terms', $latestItems->get($item->id)['supply_terms'] ?? '') }}" placeholder="Например: в наличии или до 30.10.2026"></label>
                </div>
            </fieldset>
        @endforeach
        <div class="form-grid">
            <label class="field"><span>Способ получения</span><select name="delivery_method" required>
                @foreach (['pickup' => 'Самовывоз', 'delivery' => 'Доставка'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('delivery_method', $latestTerms?->delivery_method ?? $order->delivery_method) === $value)>{{ $label }}</option>
                @endforeach
            </select></label>
            <label class="field"><span>Адрес доставки</span><input name="delivery_address" maxlength="500" value="{{ old('delivery_address', $latestTerms?->delivery_address ?? $order->delivery_address) }}"></label>
            <label class="field"><span>Стоимость доставки, ₽ (пусто — ещё не рассчитана)</span><input type="number" name="delivery_cost" min="0" max="9999999999.99" step="0.01" value="{{ old('delivery_cost', $latestTerms?->delivery_cost ?? '') }}"></label>
            <label class="field"><span>Сроки и порядок получения</span><textarea name="delivery_terms" required maxlength="2000">{{ old('delivery_terms', $latestTerms?->delivery_terms ?? '') }}</textarea></label>
            <label class="field"><span>Способ оплаты</span><select name="payment_method" required>
                <option value="">Выберите способ</option>
                @foreach (\App\Models\OrderTermsVersion::paymentMethods() as $value => $label)
                    <option value="{{ $value }}" @selected(old('payment_method', $latestTerms?->payment_method) === $value)>{{ $label }}</option>
                @endforeach
            </select></label>
            <label class="field"><span>Порядок оплаты</span><textarea name="payment_terms" required maxlength="2000" placeholder="Размер предоплаты, срок и порядок оплаты доставки">{{ old('payment_terms', $latestTerms?->payment_terms ?? '') }}</textarea></label>
        </div>
        <button type="submit" class="button button--primary">Сохранить предложение</button>
    </form>
</section>
@endunless
