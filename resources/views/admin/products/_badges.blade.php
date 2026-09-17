@php
    $selectedBadges = old('badges', $product->badges ?? []);
@endphp

<fieldset class="field field--wide product-badges-editor">
    <legend>Бейджи в каталоге</legend>
    <p class="field__hint">Можно выбрать до трёх. «Бюджетный», «Оптимальный» и «Премиум» — альтернативные позиции товара.</p>
    <div class="checkbox-list">
        @foreach (\App\Models\Product::BADGES as $code => $label)
            <label class="checkbox">
                <input type="checkbox" name="badges[]" value="{{ $code }}" @checked(in_array($code, $selectedBadges, true))>
                <span>{{ $label }}</span>
            </label>
        @endforeach
    </div>
    @error('badges') <p class="field__error">{{ $message }}</p> @enderror
    @error('badges.*') <p class="field__error">{{ $message }}</p> @enderror
</fieldset>
