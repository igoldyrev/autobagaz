<div class="field">
    <label for="catalog_priority">Приоритет в каталоге</label>
    <input id="catalog_priority" name="catalog_priority" type="number" min="0" max="1000000" value="{{ old('catalog_priority', $product->catalog_priority ?? 0) }}">
    <p class="field__hint">Больший приоритет выше в сортировке «Популярные».</p>
    @error('catalog_priority')<p class="field__error">{{ $message }}</p>@enderror
</div>
