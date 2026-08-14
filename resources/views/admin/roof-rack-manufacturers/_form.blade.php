@csrf
@if (isset($manufacturer)) @method('PUT') @endif

<div class="form-grid">
    <div class="field field--wide">
        <label for="name">Название</label>
        <input id="name" name="name" type="text" value="{{ old('name', $manufacturer->name ?? '') }}" maxlength="255" required>
        @error('name') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <label class="checkbox field--wide">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $manufacturer->is_active ?? true))>
        <span>Производитель активен — доступен в формах товаров и фильтрах</span>
    </label>
</div>

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.products.roof-racks.manufacturers.index') }}">Отмена</a>
</div>
