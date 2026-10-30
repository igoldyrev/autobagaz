@extends('layouts.admin')
@section('title', 'Прокат №'.$rental->id)
@section('body')
<div class="admin-shell">
    @include('admin.partials.header')
    <main class="admin-content admin-order-page rental-order-page">
        @include('admin.partials.flash')
        <div class="page-heading"><div><p class="eyebrow">Заявка на прокат</p><h1>№{{ $rental->id }}</h1></div></div>
        <div class="order-page-meta">
            <p class="admin-content__lead">{{ $rental->created_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p>
            <a class="button button--secondary button--inline" href="{{ route('admin.rental-requests.index') }}">← К списку заявок</a>
        </div>
        @include('admin.rental-requests._help')
        @include('admin.rental-requests._processing-panel')
        <section class="admin-card order-details">
            <h2>Клиент</h2><p>{{ $rental->name }} · <a href="tel:{{ $rental->phone }}">{{ $rental->phone }}</a></p>
            <p>Автомобиль: {{ $rental->vehicle ?: 'Не указан' }}</p>
            @if($rental->comment)<h3>Комментарий покупателя</h3><p>{{ $rental->comment }}</p>@endif
            <h2>Условия проката</h2>
            <p>{{ $rental->equipment }} × {{ $rental->quantity }}</p>
            <p>{{ $rental->starts_on->format('d.m.Y') }} — {{ $rental->ends_on->format('d.m.Y') }} (включительно)</p>
            <p>Тариф: {{ $rental->daily_price }} ₽/день за единицу. Аренда: {{ $rental->rental_total }} ₽. Оплачено: {{ $rental->rental_paid }} ₽.</p>
            <p>Стоимость выкупа всего оборудования: {{ $rental->buyout_price }} ₽. Аренда в выкуп не засчитывается.</p>
            @foreach(['issued_at' => 'Выдано', 'returned_at' => 'Возвращено', 'purchased_at' => 'Выкуплено'] as $key => $label)@if($rental->$key)<p>{{ $label }}: {{ $rental->$key->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p>@endif @endforeach
            <details><summary>Исходная заявка</summary><p>{{ $rental->original_request['equipment'] }} × {{ $rental->original_request['quantity'] }}; {{ $rental->original_request['starts_on'] }} — {{ $rental->original_request['ends_on'] }}; тариф {{ $rental->original_request['daily_price'] }} ₽/день.</p></details>
        </section>
        @if(in_array($rental->status, ['new', 'in_progress'], true) && !$rental->deposit_received_at && (float) $rental->rental_paid === 0.0)
            <details id="rental-terms" class="admin-card order-change-editor" @if(!$rental->deposit_type || ($errors->any() && in_array(old('action'), ['terms', 'confirm'], true))) open @endif>
                <summary>Условия проката и залога</summary>
                <p>Выберите тип залога: для денег укажите сумму, для документа — его вид и описание. Согласуйте остальные условия с покупателем, нажмите «Сохранить условия», затем «Подтвердить» в верхней панели.</p>
                @include('admin.rental-requests._form-start', ['action' => 'terms'])
                    <label class="field field--wide">Оборудование<input name="equipment" value="{{ old('equipment', $rental->equipment) }}" maxlength="255" required></label>
                    <label class="field">Количество<input name="quantity" type="number" min="1" max="100" value="{{ old('quantity', $rental->quantity) }}" required></label>
                    <label class="field">Тариф, ₽/день за единицу<input name="daily_price" type="number" min="0" max="1000000000" step="0.01" value="{{ old('daily_price', $rental->daily_price) }}" required></label>
                    <label class="field">Получение<input name="starts_on" type="date" value="{{ old('starts_on', $rental->starts_on->toDateString()) }}" required></label>
                    <label class="field">Возврат<input name="ends_on" type="date" value="{{ old('ends_on', $rental->ends_on->toDateString()) }}" required></label>
                    <label class="field">Стоимость выкупа всего оборудования, ₽<input name="buyout_price" type="number" min="0" max="1000000000" step="0.01" value="{{ old('buyout_price', $rental->buyout_price) }}" required></label>
                    <label class="field">Тип залога<select name="deposit_type" data-rental-deposit-type required><option value="" @selected(!old('deposit_type', $rental->deposit_type))>Выберите тип залога</option><option value="money" @selected(old('deposit_type', $rental->deposit_type) === 'money')>Деньги</option><option value="document" @selected(old('deposit_type', $rental->deposit_type) === 'document')>Документ</option></select></label>
                    <label class="field" data-rental-deposit-field="money">Денежный залог, ₽<input name="deposit_required" type="number" min="0.01" max="1000000000" step="0.01" value="{{ old('deposit_required', $rental->deposit_required) }}" @required(old('deposit_type', $rental->deposit_type) === 'money')></label>
                    <label class="field field--wide" data-rental-deposit-field="document">Вид и описание документа<input name="deposit_document" maxlength="255" value="{{ old('deposit_document', $rental->deposit_document) }}" @required(old('deposit_type', $rental->deposit_type) === 'document')><span class="field__hint">Для залога документом денежную сумму указывать не нужно.</span></label>
                    <div class="form-actions field--wide"><button class="button button--primary button--inline" type="submit">Сохранить условия</button></div>
                </form>
            </details>
        @endif
        <section class="admin-card order-details"><h2>Залог и расчёты</h2>
            <p>{{ $rental->depositLabel() }}</p>
            <p>Тип: {{ ['money' => 'Деньги', 'document' => 'Документ'][$rental->deposit_type] ?? 'Не согласован' }}. {{ $rental->deposit_document }}</p>
            <p>Требуется: {{ $rental->deposit_required }} ₽; получено: {{ $rental->deposit_received }} ₽; возвращено: {{ $rental->deposit_returned }} ₽; удержано: {{ $rental->deposit_withheld }} ₽; зачтено в выкуп: {{ $rental->deposit_applied }} ₽.</p>
            @foreach(['deposit_received_at' => 'Залог получен', 'deposit_returned_at' => 'Залог возвращён / расчёт при выкупе'] as $key => $label)@if($rental->$key)<p>{{ $label }}: {{ $rental->$key->timezone(config('app.display_timezone'))->format('d.m.Y H:i') }}</p>@endif @endforeach
            @unless($rental->isClosed())
                @php
                    $moneyActions = [];
                    if ($rental->status === 'confirmed' && (float) $rental->rental_paid > 0) $moneyActions['rental_refund'] = 'Вернуть оплату аренды';
                    if ($rental->status === 'confirmed' && !$rental->deposit_received_at) $moneyActions['receive_deposit'] = 'Получить залог';
                    if (in_array($rental->status, ['confirmed', 'returned'], true) && $rental->deposit_received_at && !$rental->depositSettled()) $moneyActions['return_deposit'] = 'Вернуть залог';
                    if ($rental->status === 'returned' && $rental->deposit_type === 'money' && $rental->depositBalance() > 0) $moneyActions['withhold_deposit'] = 'Удержать из залога';
                    if (in_array($rental->status, ['confirmed', 'rented', 'returned'], true) && (float) $rental->rental_paid < (float) $rental->rental_total) $moneyActions['rental_payment'] = 'Получить оплату аренды';
                @endphp
                @if($moneyActions)
                <div class="form-actions processing-actions">
                @foreach($moneyActions as $action => $label)
                    <details class="rental-processing-action" @if($errors->any() && old('action') === $action) open @endif><summary class="button button--secondary button--inline">{{ $label }}</summary>
                        @include('admin.rental-requests._form-start')
                            @if($rental->deposit_type === 'document' && in_array($action, ['receive_deposit', 'return_deposit'], true))<input type="hidden" name="amount" value="0">@else<label class="field">Сумма, ₽<input name="amount" type="number" min="0.01" max="1000000000" step="0.01" value="{{ $action === 'receive_deposit' ? $rental->deposit_required : ($action === 'rental_refund' ? $rental->rental_paid : ($action === 'rental_payment' ? number_format((float) $rental->rental_total - (float) $rental->rental_paid, 2, '.', '') : number_format($rental->depositBalance() / 100, 2, '.', ''))) }}" required></label>@endif
                            <label class="field field--wide">{{ $action === 'withhold_deposit' ? 'Причина удержания' : 'Комментарий' }}<textarea name="note" maxlength="2000" @required($action === 'withhold_deposit')></textarea></label>
                            <label class="checkbox field--wide"><input type="checkbox" name="confirmed" value="1" required> Подтверждаю фактическое выполнение операции</label>
                            <div class="form-actions field--wide"><button class="button button--primary button--inline" type="submit">{{ $label }}</button></div>
                        </form>
                    </details>
                @endforeach
                </div>
                @endif
            @endunless
        </section>
        @if($rental->status === 'rented')
            <details class="admin-card order-change-editor" @if($errors->any() && old('action') === 'extend') open @endif><summary>Продлить прокат</summary>
                <p>Продление рассчитывается по сохранённому тарифу. Доплата за просрочку автоматически не начисляется.</p>
                @include('admin.rental-requests._form-start', ['action' => 'extend'])
                    <label class="field">Новая дата возврата<input name="ends_on" type="date" min="{{ $rental->ends_on->copy()->addDay()->toDateString() }}" required></label>
                    <label class="field field--wide">Согласование продления<textarea name="note" maxlength="2000" required></textarea></label>
                    <div class="form-actions field--wide"><button class="button button--secondary button--inline" type="submit">Продлить</button></div>
                </form>
            </details>
        @endif
        @include('admin.partials.processing-history')
    </main>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin-rental.js') }}?v={{ filemtime(public_path('js/admin-rental.js')) }}" defer></script>
@endpush
