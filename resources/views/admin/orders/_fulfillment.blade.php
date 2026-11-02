@if ($order->canFulfillPart())
    <details @if ($errors->has('quantities') || $errors->has('quantities.*') || $errors->has('fulfilled')) open @endif>
        <summary>{{ $order->effectiveDeliveryMethod() === 'delivery' ? 'Отправить часть заказа' : 'Выдать часть заказа' }}</summary>
        <form method="POST" action="{{ route('admin.orders.fulfill', $order) }}">
            @csrf
            <input type="hidden" name="expected_status" value="{{ $order->status }}">
            <input type="hidden" name="expected_terms_version" value="{{ $order->latestTermsVersion?->version ?? 0 }}">
            <input type="hidden" name="expected_fulfillment_version" value="{{ $order->fulfillment_version }}">
            <p>Укажите только фактически переданное количество. Остальные товары сохранят резерв. Для раздельных отправок согласуйте стоимость и сроки каждой доставки с покупателем.</p>
            @foreach ($order->reservations->where('state', 'paid')->where('quantity', '>', 0) as $row)
                <label class="field">{{ $row->product?->name }} · в резерве {{ $row->quantity }} шт.
                    <input type="number" name="quantities[{{ $row->product_id }}]" min="0" max="{{ $row->quantity }}" value="0" required>
                </label>
            @endforeach
            <label><input type="checkbox" name="fulfilled" value="1" required> Получение по частям согласовано с покупателем. Указанные товары фактически переданы {{ $order->effectiveDeliveryMethod() === 'delivery' ? 'перевозчику' : 'покупателю; согласованная установка выполнена' }}.</label>
            <button class="button button--secondary" type="submit">Учесть передачу товаров</button>
        </form>
    </details>
@endif
