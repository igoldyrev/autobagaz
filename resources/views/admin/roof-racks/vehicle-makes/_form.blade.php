@csrf
@if (isset($vehicleMake))
    @method('PUT')
@endif

<div class="form-grid">
    <div class="field field--wide">
        <label for="name">Название марки</label>
        <input id="name" name="name" type="text" value="{{ old('name', $vehicleMake->name ?? '') }}" maxlength="255" required>
        @error('name') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="slug">Адрес страницы</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $vehicleMake->slug ?? '') }}" placeholder="Заполнится автоматически">
        <p class="field__hint">Например: <code>lada-vaz</code></p>
        @error('slug') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="sort_order">Порядок в разделе</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $sortOrder ?? $nextSortOrder ?? 0) }}" required>
        @error('sort_order') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field field--wide">
        <label for="description">Описание</label>
        <textarea id="description" name="description" rows="4">{{ old('description', $vehicleMake->description ?? '') }}</textarea>
        @error('description') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="image">Изображение марки</label>
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
        <p class="field__hint">JPG, PNG, WebP или GIF, до 4 МБ.</p>
        @error('image') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="image_alt">Описание изображения</label>
        <input id="image_alt" name="image_alt" type="text" value="{{ old('image_alt', $vehicleMake->image_alt ?? '') }}" maxlength="255">
        @error('image_alt') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    @if (isset($vehicleMake) && $vehicleMake->image_path)
        <div class="field field--wide">
            <span class="field__label">Текущее изображение</span>
            <img class="image-preview" src="{{ asset($vehicleMake->image_path) }}" alt="{{ $vehicleMake->image_alt ?: $vehicleMake->name }}">
        </div>
    @endif

    <div class="field">
        <label for="meta_title">SEO-заголовок</label>
        <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title', $vehicleMake->meta_title ?? '') }}" maxlength="255">
        @error('meta_title') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="meta_description">SEO-описание</label>
        <textarea id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $vehicleMake->meta_description ?? '') }}</textarea>
        @error('meta_description') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <label class="checkbox field--wide">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $vehicleMake->is_active ?? true))>
        <span>Показывать марку на сайте</span>
    </label>
</div>

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.roof-racks.vehicle-makes.index') }}">Отмена</a>
</div>
