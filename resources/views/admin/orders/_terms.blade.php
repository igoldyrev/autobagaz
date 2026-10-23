<section class="admin-card order-details">
    <h2>Предложения и согласованные условия</h2>
    <p><a href="{{ $order->customerUrl() }}">Открыть страницу покупателя</a>. Эту секретную ссылку можно передать покупателю для согласования условий.</p>
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
            @include('orders._terms-details', ['terms' => $terms])
        </details>
    @endforeach
    {{ $termsVersions->links() }}
</section>

@unless ($order->isClosed())
<section class="admin-card">
    <h2>Предложить условия покупателю</h2>
    <p>Сохраняется новая версия предложения. Исходная заявка и ранее согласованные условия сохраняются. Сохранение предложения не фиксирует согласие покупателя.</p>
    <p>Чтобы исключить позицию, укажите количество 0. Цены и количество можно изменить; покупатель должен подтвердить новую версию.</p>
    <form method="GET" action="{{ route('admin.orders.show', $order) }}" class="processing-assignee">
        <label class="field"><span>Найти товар для добавления или замены</span><input name="product_search" maxlength="120" value="{{ $productSearch }}"></label>
        <button class="button button--secondary" type="submit">Найти</button>
    </form>
    <p>Сначала найдите товары для добавления или замены, затем заполните предложение. Поиск показывает до 20 товаров. Для замены исключите исходную позицию и укажите количество у нового товара.</p>
    @php
        $latestItems = collect($latestTerms?->items ?? [])->keyBy('order_item_id');
    @endphp
    <form method="POST" action="{{ route('admin.orders.terms.store', $order) }}">
        @csrf
        <input type="hidden" name="expected_version" value="{{ old('expected_version', $latestTerms?->version ?? 0) }}">
        <input type="hidden" name="expected_status" value="{{ old('expected_status', $order->status) }}">
        @foreach ($order->items as $item)
            <fieldset>
                <legend>{{ $item->product_name }} — исходная цена {{ number_format((float) $item->unit_price, 2, ',', ' ') }} ₽ за единицу</legend>
                <div class="form-grid">
                    <label class="field"><span>Предлагаемое количество (в заявке {{ $item->quantity }})</span><input type="number" name="items[{{ $item->id }}][quantity]" min="0" max="100" step="1" required value="{{ old('items.'.$item->id.'.quantity', $latestItems->get($item->id)['quantity'] ?? $item->quantity) }}"></label>
                    <label class="field"><span>Цена за единицу, ₽</span><input type="number" name="items[{{ $item->id }}][unit_price]" min="0" max="9999999999.99" step="0.01" required value="{{ old('items.'.$item->id.'.unit_price', $latestItems->get($item->id)['unit_price'] ?? $item->unit_price) }}"></label>
                    <label class="field"><span>Срок поставки / наличие</span><input type="text" name="items[{{ $item->id }}][supply_terms]" maxlength="1000" value="{{ old('items.'.$item->id.'.supply_terms', $latestItems->get($item->id)['supply_terms'] ?? '') }}" placeholder="Например: в наличии или до 30.10.2026"></label>
                </div>
            </fieldset>
        @endforeach
        @php
            $additionalRows = collect($latestTerms?->items ?? [])->filter(fn ($item) => $item['order_item_id'] === null)->keyBy('product_id');
            foreach ($additionalProducts as $product) {
                if (! $order->items->contains('product_id', $product->id) && ! $additionalRows->has($product->id)) {
                    $additionalRows->put($product->id, ['product_name' => $product->name, 'unit_price' => $product->price, 'quantity' => 0, 'supply_terms' => '']);
                }
            }
        @endphp
        @foreach ($additionalRows->take(100) as $productId => $row)
            <fieldset>
                <legend>Дополнительная позиция: {{ $row['product_name'] }}</legend>
                <div class="form-grid">
                    <label class="field"><span>Количество (0 — не включать)</span><input type="number" name="additional_items[{{ $productId }}][quantity]" min="0" max="100" step="1" required value="{{ old('additional_items.'.$productId.'.quantity', $row['quantity']) }}"></label>
                    <label class="field"><span>Цена за единицу, ₽</span><input type="number" name="additional_items[{{ $productId }}][unit_price]" min="0" max="9999999999.99" step="0.01" required value="{{ old('additional_items.'.$productId.'.unit_price', $row['unit_price']) }}"></label>
                    <label class="field"><span>Срок поставки / наличие</span><input name="additional_items[{{ $productId }}][supply_terms]" maxlength="1000" value="{{ old('additional_items.'.$productId.'.supply_terms', $row['supply_terms']) }}"></label>
                </div>
            </fieldset>
        @endforeach
        <label class="field"><span>Причина предложения или изменения (видна покупателю)</span><textarea name="change_reason" maxlength="2000" required>{{ old('change_reason', $latestTerms ? '' : 'Первичное предложение условий') }}</textarea></label>
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
