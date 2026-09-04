@csrf
@if (isset($catalogCategory)) @method('PUT') @endif

@include('admin.partials.help', ['title' => 'Заполнение категории', 'text' => 'Выберите тип и родителя в соответствии со структурой каталога. Корневой раздел создаётся без родителя; вложенной категории нужен родительский раздел или категория.', 'items' => ['Адрес страницы можно оставить пустым для автоматического формирования.', 'Описание и изображение используются в содержимом страницы, SEO-поля — в поисковой выдаче.', 'Снятие флага публикации не удаляет товары и дочерние связи.']])

<div class="form-grid">
    <div class="field field--wide">
        <label for="name">Название</label>
        <input id="name" name="name" type="text" value="{{ old('name', $catalogCategory->name ?? '') }}" required>
        @error('name') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="kind">Тип</label>
        <select id="kind" name="kind" required>
            <option value="section" @selected(old('kind', $catalogCategory->kind ?? 'category') === 'section')>Раздел</option>
            <option value="category" @selected(old('kind', $catalogCategory->kind ?? 'category') === 'category')>Категория</option>
            <option value="special" @selected(old('kind', $catalogCategory->kind ?? 'category') === 'special')>Спецкатегория</option>
        </select>
    </div>
    <div class="field">
        <label for="parent_id">Родительская категория</label>
        <select id="parent_id" name="parent_id">
            <option value="">Нет — корневой раздел</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected((string) old('parent_id', $catalogCategory->parent_id ?? '') === (string) $parent->id)>{{ $parent->name }}</option>
            @endforeach
        </select>
        @error('parent_id') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="slug">Адрес страницы</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $catalogCategory->slug ?? '') }}" placeholder="Заполнится автоматически">
        @error('slug') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="sort_order">Порядок</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $catalogCategory->sort_order ?? $nextSortOrder ?? 0) }}" required>
    </div>
    <div class="field field--wide">
        <label for="description">Описание</label>
        <textarea id="description" name="description" rows="5">{{ old('description', $catalogCategory->description ?? '') }}</textarea>
    </div>
    <div class="field">
        <label for="image">Изображение</label>
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
        <p class="field__hint">До 4 МБ.</p>
        @error('image') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="image_alt">Описание изображения</label>
        <input id="image_alt" name="image_alt" type="text" value="{{ old('image_alt', $catalogCategory->image_alt ?? '') }}">
    </div>
    @if (isset($catalogCategory) && $catalogCategory->image_path)
        <div class="field field--wide">
            <span class="field__label">Текущее изображение</span>
            <img class="image-preview" src="{{ asset($catalogCategory->image_path) }}" alt="">
        </div>
    @endif
    <div class="field">
        <label for="meta_title">SEO-заголовок</label>
        <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title', $catalogCategory->meta_title ?? '') }}">
    </div>
    <div class="field">
        <label for="meta_description">SEO-описание</label>
        <textarea id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $catalogCategory->meta_description ?? '') }}</textarea>
    </div>
    <label class="checkbox field--wide">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $catalogCategory->is_active ?? true))>
        <span>Показывать категорию на сайте</span>
    </label>
</div>

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.catalog-categories.index') }}">Отмена</a>
</div>
