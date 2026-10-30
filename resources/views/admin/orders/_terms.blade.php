@if ($order->canEditTerms())
<details class="admin-card order-change-editor" @if ($productSearch !== '' || $errors->any()) open @endif>
    <summary>Замена товаров и изменение условий</summary>
    <p>Используйте этот блок, если товара нет в наличии и нужна замена, либо нужно изменить количество, цену, доставку или оплату. Если заказ выполняется на исходных условиях, заполнять этот блок не нужно.</p>
    <p>Сначала согласуйте изменения с покупателем. После сохранения отправьте ему ссылку на заказ для подтверждения. До подтверждения изменения не считаются согласованными.</p>
    <form method="GET" action="{{ route('admin.orders.show', $order) }}" class="processing-assignee">
        <label class="field"><span>Найти товар для добавления или замены</span><input name="product_search" maxlength="120" placeholder="Часть названия товара" value="{{ $productSearch }}"></label>
        <button class="button button--secondary" type="submit">Найти</button>
    </form>
    <p>Сначала найдите товары для добавления или замены, затем заполните изменения. Поиск показывает до 20 товаров. Для замены исключите исходную позицию и укажите количество у нового товара.</p>
    @php
        $latestItems = collect($latestTerms?->items ?? [])->keyBy('order_item_id');
    @endphp
    <form method="POST" action="{{ route('admin.orders.terms.store', $order) }}">
        @csrf
        <input type="hidden" name="expected_version" value="{{ old('expected_version', $latestTerms?->version ?? 0) }}">
        <input type="hidden" name="expected_status" value="{{ old('expected_status', $order->status) }}">
        <h3>Товары из заказа</h3>
        <p class="field__hint">В этих строках меняйте только то, что нужно скорректировать. Количество 0 исключает товар из нового варианта заказа.</p>
        @foreach ($order->items as $item)
            <fieldset class="order-change-item order-change-item--existing">
                <legend>В заказе: {{ $item->product_name }} — исходная цена {{ number_format((float) $item->unit_price, 2, ',', ' ') }} ₽ за единицу</legend>
                <div class="order-change-item__fields">
                    <label class="field"><span>Количество</span><input type="number" name="items[{{ $item->id }}][quantity]" min="0" max="100" step="1" required value="{{ old('items.'.$item->id.'.quantity', $latestItems->get($item->id)['quantity'] ?? $item->quantity) }}"><small class="field__hint">В заявке: {{ $item->quantity }} шт.</small></label>
                    <label class="field"><span>Цена, ₽</span><input type="number" name="items[{{ $item->id }}][unit_price]" min="0" max="9999999999.99" step="0.01" required value="{{ old('items.'.$item->id.'.unit_price', $latestItems->get($item->id)['unit_price'] ?? $item->unit_price) }}"></label>
                    <label class="field"><span>Наличие / срок поступления</span><input type="text" name="items[{{ $item->id }}][supply_terms]" maxlength="1000" value="{{ old('items.'.$item->id.'.supply_terms', $latestItems->get($item->id)['supply_terms'] ?? '') }}" placeholder="В наличии / до 30.10.2026"><small class="field__hint">Есть в магазине — напишите «В наличии». Если нужно заказать у поставщика — укажите, когда товар поступит.</small></label>
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
            <fieldset class="order-change-item order-change-item--additional">
                <legend>Добавление или замена: {{ $row['product_name'] }}</legend>
                <div class="order-change-item__fields">
                    <label class="field"><span>Количество</span><input type="number" name="additional_items[{{ $productId }}][quantity]" min="0" max="100" step="1" required value="{{ old('additional_items.'.$productId.'.quantity', $row['quantity']) }}"><small class="field__hint">0 — не включать</small></label>
                    <label class="field"><span>Цена, ₽</span><input type="number" name="additional_items[{{ $productId }}][unit_price]" min="0" max="9999999999.99" step="0.01" required value="{{ old('additional_items.'.$productId.'.unit_price', $row['unit_price']) }}"></label>
                    <label class="field"><span>Наличие / срок поступления</span><input name="additional_items[{{ $productId }}][supply_terms]" maxlength="1000" value="{{ old('additional_items.'.$productId.'.supply_terms', $row['supply_terms']) }}"></label>
                </div>
            </fieldset>
        @endforeach
        <label class="field"><span>Причина изменения</span><textarea name="change_reason" maxlength="2000" required>{{ old('change_reason', '') }}</textarea><small class="field__hint">Кратко объясните, что изменилось и почему. Этот текст увидит покупатель.</small></label>
        <h3>Получение</h3>
        <div class="form-grid">
            <label class="field"><span>Способ получения</span><select name="delivery_method" required>
                @foreach (['pickup' => 'Самовывоз', 'delivery' => 'Доставка'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('delivery_method', $latestTerms?->delivery_method ?? $order->delivery_method) === $value)>{{ $label }}</option>
                @endforeach
            </select></label>
            <label class="field"><span>Адрес доставки</span><input name="delivery_address" maxlength="500" value="{{ old('delivery_address', $latestTerms?->delivery_address ?? $order->delivery_address) }}"></label>
            <label class="field"><span>Стоимость доставки, ₽</span><input type="number" name="delivery_cost" min="0" max="9999999999.99" step="0.01" value="{{ old('delivery_cost', $latestTerms?->delivery_cost ?? '') }}"><small class="field__hint">Оставьте пустым, если стоимость ещё не рассчитана.</small></label>
            <label class="field"><span>Сроки и порядок получения</span><textarea name="delivery_terms" required maxlength="2000">{{ old('delivery_terms', $latestTerms?->delivery_terms ?? '') }}</textarea></label>
        </div>
        <h3>Оплата</h3>
        <div class="form-grid">
            <label class="field"><span>Способ оплаты</span><select name="payment_method" required>
                <option value="">Выберите способ</option>
                @foreach (\App\Models\OrderTermsVersion::paymentMethods() as $value => $label)
                    <option value="{{ $value }}" @selected(old('payment_method', $latestTerms?->payment_method) === $value)>{{ $label }}</option>
                @endforeach
            </select></label>
            <label class="field"><span>Порядок оплаты</span><textarea name="payment_terms" required maxlength="2000" placeholder="Размер предоплаты, срок и порядок оплаты доставки">{{ old('payment_terms', $latestTerms?->payment_terms ?? '') }}</textarea></label>
        </div>
        <button type="submit" class="button button--primary">Сохранить изменения для согласования</button>
    </form>
</details>
@endif
