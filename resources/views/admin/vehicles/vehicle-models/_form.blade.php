@csrf
@if (isset($vehicleModel))
    @method('PUT')
@endif

<div class="form-grid">
    <div class="field field--wide">
        <label for="name">Название модели</label>
        <input id="name" name="name" type="text" value="{{ old('name', $vehicleModel->name ?? '') }}" maxlength="255" required>
        @error('name') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="slug">Адрес страницы</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $vehicleModel->slug ?? '') }}" placeholder="Заполнится автоматически">
        <p class="field__hint">Должен быть уникальным внутри марки {{ $vehicleMake->name }}.</p>
        @error('slug') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="sort_order">Порядок</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $vehicleModel->sort_order ?? $nextSortOrder ?? 0) }}" required>
        @error('sort_order') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field field--wide">
        <label for="description">Описание</label>
        <textarea id="description" name="description" rows="4">{{ old('description', $vehicleModel->description ?? '') }}</textarea>
        @error('description') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="image">Изображение модели</label>
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp,image/gif">
        <p class="field__hint">JPG, PNG, WebP или GIF, до 4 МБ.</p>
        @error('image') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="image_alt">Описание изображения</label>
        <input id="image_alt" name="image_alt" type="text" value="{{ old('image_alt', $vehicleModel->image_alt ?? '') }}" maxlength="255">
        @error('image_alt') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    @if (isset($vehicleModel) && $vehicleModel->image_path)
        <div class="field field--wide">
            <span class="field__label">Текущее изображение</span>
            <img class="image-preview" src="{{ asset($vehicleModel->image_path) }}" alt="{{ $vehicleModel->image_alt ?: $vehicleModel->name }}">
        </div>
    @endif

    @if (isset($vehicleModel) && $vehicleModel->bodyTypes->isNotEmpty())
        <div class="field field--wide">
            <span class="field__label">Варианты кузова и крепления</span>
            <div class="vehicle-body-types-admin">
                @foreach ($vehicleModel->bodyTypes as $bodyType)
                    <div class="entity-title">
                        @if ($bodyType->image_path)
                            <img src="{{ asset($bodyType->image_path) }}" alt="" width="64" height="64">
                        @endif
                        <span>
                            <strong>{{ $bodyType->source_name ?: $bodyType->name }}</strong>
                            @if ($bodyType->year_label || $bodyType->mounting_type)
                                <small>{{ collect([$bodyType->year_label, $bodyType->mounting_type])->filter()->implode(' · ') }}</small>
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
            <p class="field__hint">Варианты с годами выпуска и типами креплений импортированы из справочника применимости автобагажников.</p>
        </div>
    @endif

    <div class="field">
        <label for="meta_title">SEO-заголовок</label>
        <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title', $vehicleModel->meta_title ?? '') }}" maxlength="255">
        @error('meta_title') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="meta_description">SEO-описание</label>
        <textarea id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $vehicleModel->meta_description ?? '') }}</textarea>
        @error('meta_description') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <label class="checkbox field--wide">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $vehicleModel->is_active ?? true))>
        <span>Показывать модель на сайте</span>
    </label>
</div>

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.vehicles.vehicle-models.index', $vehicleMake) }}">Отмена</a>
</div>
