<div class="form-grid">
    <label class="checkbox field--wide">
        <input type="checkbox" name="is_on_sale" value="1" @checked(old('is_on_sale', $product->is_on_sale ?? false))>
        <span>Показывать товар в разделе «Акции»</span>
        <span class="field__hint">Акция отображается, если указана старая цена и период ещё не закончился.</span>
    </label>
    <div class="field">
        <label for="old_price">Старая цена, ₽</label>
        <input id="old_price" name="old_price" type="number" min="0" step="0.01" value="{{ old('old_price', $product->old_price ?? '') }}">
        <p class="field__hint">Должна быть выше текущей цены из вкладки «Основное».</p>
        @error('old_price')<p class="field__error">{{ $message }}</p>@enderror
    </div>
    <div class="field">
        <label for="promotion_label">Подпись акции</label>
        <input id="promotion_label" name="promotion_label" type="text" maxlength="100" value="{{ old('promotion_label', $product->promotion_label ?? '') }}" placeholder="Например: Осенняя скидка">
        @error('promotion_label')<p class="field__error">{{ $message }}</p>@enderror
    </div>
    <div class="field">
        <label for="promotion_starts_at">Начало акции</label>
        <input id="promotion_starts_at" name="promotion_starts_at" type="datetime-local" value="{{ old('promotion_starts_at', isset($product) && $product->promotion_starts_at ? $product->promotion_starts_at->format('Y-m-d\\TH:i') : '') }}">
        @error('promotion_starts_at')<p class="field__error">{{ $message }}</p>@enderror
    </div>
    <div class="field">
        <label for="promotion_ends_at">Окончание акции</label>
        <input id="promotion_ends_at" name="promotion_ends_at" type="datetime-local" value="{{ old('promotion_ends_at', isset($product) && $product->promotion_ends_at ? $product->promotion_ends_at->format('Y-m-d\\TH:i') : '') }}">
        <p class="field__hint">Оставьте пустым, если акция действует без даты окончания.</p>
        @error('promotion_ends_at')<p class="field__error">{{ $message }}</p>@enderror
    </div>
</div>
