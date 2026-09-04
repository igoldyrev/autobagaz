@csrf
@if (isset($vehicleMake))
    @method('PUT')
@endif

@include('admin.partials.help', ['title' => 'Заполнение марки', 'text' => 'Создайте марку один раз для всего автомобильного справочника. После сохранения перейдите к её моделям, затем добавьте поколения и конечные конфигурации.', 'items' => ['Адрес можно оставить пустым для автоматического формирования.', 'Разделы каталога определяют, в каких подборах доступна марка.', 'Отключение публикации не удаляет модели и связи совместимости.']])

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

    <fieldset class="field field--wide directory-sections">
        <legend>Разделы каталога</legend>
        <p class="field__hint">Отметьте типы товаров, для которых доступна эта марка. Справочник марки и её модели сохранятся, даже если не выбран ни один раздел.</p>
        @php
            $selectedCatalogSections = array_map(
                'strval',
                old('catalog_category_ids', isset($vehicleMake) ? $vehicleMake->catalogCategories->pluck('id')->all() : []),
            );
        @endphp
        <div class="checkbox-list">
            @forelse ($catalogSections as $catalogSection)
                <label class="checkbox">
                    <input type="checkbox" name="catalog_category_ids[]" value="{{ $catalogSection->id }}" @checked(in_array((string) $catalogSection->id, $selectedCatalogSections, true))>
                    <span>{{ $catalogSection->name }}</span>
                </label>
            @empty
                <p class="field__hint">Сначала создайте корневой раздел в справочнике «Разделы и категории».</p>
            @endforelse
        </div>
        @error('catalog_category_ids') <p class="field__error">{{ $message }}</p> @enderror
        @error('catalog_category_ids.*') <p class="field__error">{{ $message }}</p> @enderror
    </fieldset>
</div>

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.vehicles.vehicle-makes.index') }}">Отмена</a>
</div>
