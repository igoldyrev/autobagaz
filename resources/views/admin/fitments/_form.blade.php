@csrf @if(isset($fitment)) @method('PUT') @endif
@php($selectedProducts = array_map('intval', old('product_ids', isset($fitment) ? $fitment->products->pluck('id')->all() : [])))
<div class="form-grid">
<div class="field field--wide"><label for="name">Название</label><input id="name" name="name" value="{{ old('name', $fitment->name ?? '') }}" required>@error('name')<p class="field__error">{{ $message }}</p>@enderror</div>
<div class="field"><label for="code">Стабильный код</label><input id="code" name="code" value="{{ old('code', $fitment->code ?? '') }}" placeholder="LUX-RAILS-120"><p class="field__hint">Латиница, цифры и дефис. После использования код лучше не менять.</p>@error('code')<p class="field__error">{{ $message }}</p>@enderror</div>
<div class="field"><label for="roof_rack_manufacturer_id">Производитель системы</label><select id="roof_rack_manufacturer_id" name="roof_rack_manufacturer_id"><option value="">Не указан</option>@foreach($manufacturers as $manufacturer)<option value="{{ $manufacturer->id }}" @selected((string)old('roof_rack_manufacturer_id', $fitment->roof_rack_manufacturer_id ?? '') === (string)$manufacturer->id)>{{ $manufacturer->name }}</option>@endforeach</select></div>
<div class="field"><label for="verification_status">Статус проверки</label><select id="verification_status" name="verification_status">@foreach(App\Models\Fitment::VERIFICATION_STATUSES as $status)<option value="{{ $status }}" @selected(old('verification_status', $fitment->verification_status ?? 'draft') === $status)>{{ App\Models\Fitment::verificationStatusLabel($status) }}</option>@endforeach</select></div>
<div class="field field--wide"><label for="product_ids">Багажники в группе применяемости</label><select id="product_ids" name="product_ids[]" multiple size="10" data-searchable-select>@foreach($roofRackProducts as $product)<option value="{{ $product->id }}" @selected(in_array($product->id, $selectedProducts, true))>{{ $product->name }}{{ $product->roofRack?->manufacturer?->name ? ' · '.$product->roofRack->manufacturer->name : '' }}{{ $product->is_active ? '' : ' (скрыт)' }}</option>@endforeach</select><p class="field__hint">Автомобили настраиваются отдельно, поэтому карточка группы остаётся компактной.</p>@error('product_ids.*')<p class="field__error">{{ $message }}</p>@enderror</div>
<div class="field field--wide"><label for="notes">Примечание</label><textarea id="notes" name="notes" rows="5">{{ old('notes', $fitment->notes ?? '') }}</textarea></div>
<label class="checkbox field--wide"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $fitment->is_active ?? true))><span>Группа применяемости активна</span></label>
</div>
<div class="form-actions form-actions--fitment">
<div class="form-actions__primary"><button class="button button--primary button--inline">Сохранить</button><a class="button button--secondary button--inline" href="{{ route('admin.fitments.index') }}">Отмена</a></div>
@if(isset($fitment))
<nav class="fitment-form-actions" aria-label="Работа с применяемостью">
<a class="fitment-form-action fitment-form-action--vehicles" href="{{ route('admin.fitments.configurations', $fitment) }}">
<span class="fitment-form-action__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 17h14M6.5 17l-1-5.2a2 2 0 0 1 .4-1.6l1.4-1.8A2 2 0 0 1 8.9 7h6.2a2 2 0 0 1 1.6.8l1.4 1.8a2 2 0 0 1 .4 1.6l-1 5.8M7 12h10M8 17v2M16 17v2M8.5 14.5h.01M15.5 14.5h.01"/></svg></span>
<span><strong>Настроить автомобили</strong><small>Добавлено конфигураций: {{ $fitment->configurations_count }}</small></span>
</a>
<a class="fitment-form-action fitment-form-action--preview" href="{{ route('admin.fitments.preview', $fitment) }}">
<span class="fitment-form-action__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.75"/></svg></span>
<span><strong>Открыть предпросмотр</strong><small>Проверить итоговую применяемость</small></span>
</a>
</nav>
@endif
</div>
@once @push('scripts')<script src="{{ asset('js/searchable-select.js') }}" defer></script>@endpush @endonce
