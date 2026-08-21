@csrf
@if (isset($product)) @method('PUT') @endif

@php
    $selectedCategories = array_map('intval', old('category_ids', isset($product) ? $product->categories->pluck('id')->all() : []));
    $defaultModels = isset($product)
        ? $product->vehicleModels->pluck('id')->all()
        : (isset($fitmentCopySource) ? $fitmentCopySource->vehicleModels->pluck('id')->all() : []);
    $defaultBodyTypes = isset($product)
        ? $product->vehicleBodyTypes->pluck('id')->all()
        : (isset($fitmentCopySource) ? $fitmentCopySource->vehicleBodyTypes->pluck('id')->all() : []);
    $selectedModels = array_map('intval', old('vehicle_model_ids', $defaultModels));
    $selectedBodyTypes = array_map('intval', old('vehicle_body_type_ids', $defaultBodyTypes));
    $roofRack = isset($product) ? $product->roofRack : null;
    $selectedManufacturerId = (string) old('manufacturer_id', $roofRack?->manufacturer_id ?? '');
@endphp

<div class="form-grid">
    <div class="field field--wide">
        <label for="name">Название товара</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field field--wide">
        <label for="slug">Адрес страницы</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug ?? '') }}" placeholder="Заполнится автоматически">
        @error('slug') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="price">Цена, ₽</label>
        <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price ?? '0.00') }}" required>
        @error('price') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="stock">Остаток, шт.</label>
        <input id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock ?? 0) }}" required>
        @error('stock') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="manufacturer_id">Производитель</label>
        <select id="manufacturer_id" name="manufacturer_id">
            <option value="">Не выбран</option>
            @foreach ($roofRackManufacturers as $manufacturer)
                <option
                    value="{{ $manufacturer->id }}"
                    @selected($selectedManufacturerId === (string) $manufacturer->id)
                    @disabled(! $manufacturer->is_active && $selectedManufacturerId !== (string) $manufacturer->id)
                >{{ $manufacturer->name }}{{ $manufacturer->is_active ? '' : ' (скрыт)' }}</option>
            @endforeach
        </select>
        <p class="field__hint"><a class="text-link" href="{{ route('admin.products.roof-racks.manufacturers.index') }}">Открыть справочник производителей</a></p>
        @error('manufacturer_id') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field">
        <label for="country_of_origin">Страна производства</label>
        <input id="country_of_origin" name="country_of_origin" type="text" value="{{ old('country_of_origin', $product->country_of_origin ?? '') }}" maxlength="255">
        @error('country_of_origin') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <div class="field field--wide">
        <label for="product_model">Модель товара</label>
        <input id="product_model" name="product_model" type="text" value="{{ old('product_model', $product->product_model ?? '') }}" maxlength="255">
        <p class="field__hint">Например: 5517+1002. Не связано со списком моделей автомобилей ниже.</p>
        @error('product_model') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <fieldset class="field field--wide product-specific-fields">
        <legend>Характеристики для раздела «Автобагажники»</legend>
        <p class="field__hint">На сайте этот блок показывается только у товаров, привязанных к разделу «Автобагажники» или его дочерним категориям.</p>
        <div class="form-grid product-specific-fields__grid">
            <div class="field">
                <label for="bar_length_cm">Длина дуги, см</label>
                <input id="bar_length_cm" name="bar_length_cm" type="number" min="0" step="0.1" value="{{ old('bar_length_cm', $roofRack?->bar_length_cm ?? '') }}">
                @error('bar_length_cm') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="load_capacity_kg">Нагрузка, кг</label>
                <input id="load_capacity_kg" name="load_capacity_kg" type="number" min="0" step="0.1" value="{{ old('load_capacity_kg', $roofRack?->load_capacity_kg ?? '') }}">
                @error('load_capacity_kg') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field field--wide">
                <label for="installation_method">Способ установки</label>
                <input id="installation_method" name="installation_method" type="text" value="{{ old('installation_method', $roofRack?->installation_method ?? '') }}" maxlength="255">
                @error('installation_method') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="bar_type">Тип дуги</label>
                <input id="bar_type" name="bar_type" type="text" value="{{ old('bar_type', $roofRack?->bar_type ?? '') }}" maxlength="255">
                @error('bar_type') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="rack_color">Цвет багажника</label>
                <input id="rack_color" name="rack_color" type="text" value="{{ old('rack_color', $roofRack?->rack_color ?? '') }}" maxlength="255">
                @error('rack_color') <p class="field__error">{{ $message }}</p> @enderror
            </div>
        </div>
    </fieldset>
    <div class="field field--wide">
        <label for="description">Описание</label>
        <textarea id="description" name="description" rows="8">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="category_ids">Категории автобагажников</label>
        <div class="select-search">
            <label class="visually-hidden" for="category-search">Поиск по категориям автобагажников</label>
            <input
                id="category-search"
                type="search"
                placeholder="Найти категорию"
                autocomplete="off"
                data-select-search="category_ids"
            >
            <span class="select-search__result" data-select-search-result="category_ids" aria-live="polite"></span>
        </div>
        <input type="hidden" name="category_ids[]" value="{{ $rootCategory->id }}">
        <select id="category_ids" name="category_ids[]" multiple size="10" data-searchable-select>
            @foreach ($categories as $category)
                @continue($category->id === $rootCategory->id)
                <option value="{{ $category->id }}" @selected(in_array($category->id, $selectedCategories, true))>
                    {{ $category->parent ? $category->parent->name.' → ' : '' }}{{ $category->name }}{{ $category->is_active ? '' : ' (скрыта)' }}
                </option>
            @endforeach
        </select>
        <p class="field__hint">Можно выбрать несколько значений с Ctrl/Cmd или Shift.</p>
        @error('category_ids.*') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field field--wide">
        <span class="field__label">Модели автомобилей и типы кузова</span>
        <div class="vehicle-fitment-picker" data-vehicle-fitment-picker>
            <div class="vehicle-fitment-picker__toolbar">
                <label class="visually-hidden" for="vehicle-fitment-search">Поиск по маркам, моделям, кузовам, годам и креплениям</label>
                <input id="vehicle-fitment-search" type="search" placeholder="Марка, модель, кузов, год или крепление" autocomplete="off" data-fitment-search>
                <span class="vehicle-fitment-picker__count" data-fitment-count aria-live="polite"></span>
            </div>
            <div class="vehicle-fitment-picker__tree" data-fitment-tree>
                @foreach ($vehicleMakes as $vehicleMake)
                    @php
                        $makeSelected = $vehicleMake->models->contains(fn ($model) => in_array($model->id, $selectedModels, true)
                            || $model->bodyTypes->contains(fn ($bodyType) => in_array($bodyType->id, $selectedBodyTypes, true)));
                    @endphp
                    <details class="fitment-make" data-fitment-make data-make-search="{{ $vehicleMake->name }}" @if ($makeSelected) open @endif>
                        <summary>{{ $vehicleMake->name }}{{ $vehicleMake->is_active ? '' : ' (скрыта)' }}</summary>
                        <div class="fitment-make__models">
                            @foreach ($vehicleMake->models as $vehicleModel)
                                @php
                                    $modelSelected = in_array($vehicleModel->id, $selectedModels, true);
                                    $bodySelected = $vehicleModel->bodyTypes->contains(fn ($bodyType) => in_array($bodyType->id, $selectedBodyTypes, true));
                                @endphp
                                <details class="fitment-model" data-fitment-model data-model-search="{{ $vehicleMake->name }} {{ $vehicleModel->name }}" @if ($modelSelected || $bodySelected) open @endif>
                                    <summary>{{ $vehicleModel->name }}{{ $vehicleModel->is_active ? '' : ' (скрыта)' }}</summary>
                                    <div class="fitment-model__options">
                                        <label class="fitment-option fitment-option--whole" data-fitment-option data-search-text="{{ $vehicleMake->name }} {{ $vehicleModel->name }} вся модель">
                                            <input type="checkbox" name="vehicle_model_ids[]" value="{{ $vehicleModel->id }}" @checked($modelSelected)>
                                            <span>
                                                <strong>Вся модель {{ $vehicleModel->name }}</strong>
                                                <small>Для всех кузовов, годов и способов крепления</small>
                                            </span>
                                        </label>
                                        @foreach ($vehicleModel->bodyTypes as $bodyType)
                                            <label class="fitment-option" data-fitment-option data-search-text="{{ $vehicleMake->name }} {{ $vehicleModel->name }} {{ $bodyType->source_name }} {{ $bodyType->name }} {{ $bodyType->year_label }} {{ $bodyType->mounting_type }}">
                                                <input type="checkbox" name="vehicle_body_type_ids[]" value="{{ $bodyType->id }}" @checked(in_array($bodyType->id, $selectedBodyTypes, true))>
                                                <span>
                                                    <strong>{{ $bodyType->source_name ?: $bodyType->name }}</strong>
                                                    @if ($bodyType->year_label || $bodyType->mounting_type)
                                                        <small>{{ collect([$bodyType->year_label, $bodyType->mounting_type])->filter()->join(' · ') }}</small>
                                                    @endif
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </details>
                @endforeach
                <p class="vehicle-fitment-picker__empty" data-fitment-empty hidden>Ничего не найдено.</p>
            </div>
        </div>
        <p class="field__hint">Выберите «Вся модель», если багажник подходит ко всем вариантам. Иначе отметьте только точные кузовы с нужными годами и креплениями.</p>
        @error('vehicle_model_ids.*') <p class="field__error">{{ $message }}</p> @enderror
        @error('vehicle_body_type_ids.*') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <div class="field field--wide">
        <label for="images">Фотографии</label>
        <input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp,image/gif" multiple>
        <p class="field__hint">До 10 файлов за один раз, каждый до 6 МБ.</p>
        @error('images.*') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    @if (isset($product) && $product->images->isNotEmpty())
        <fieldset class="field field--wide image-manager">
            <legend>Загруженные фотографии</legend>
            <div class="image-manager__grid">
                @foreach ($product->images as $image)
                    <label class="image-manager__item">
                        <img src="{{ asset($image->path) }}" alt="{{ $image->alt }}">
                        <span><input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}"> Удалить при сохранении</span>
                    </label>
                @endforeach
            </div>
        </fieldset>
    @endif

    <label class="checkbox field--wide">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? false))>
        <span>Опубликовать товар на сайте</span>
    </label>
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/searchable-select.js') }}" defer></script>
        <script src="{{ asset('js/vehicle-fitment-picker.js') }}" defer></script>
    @endpush
@endonce

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.products.roof-racks.index') }}">Отмена</a>
    @if (isset($product) && $product->is_active)
        <a class="text-link form-actions__preview" href="{{ route('products.show', $product) }}" target="_blank" rel="noopener">Открыть на сайте ↗</a>
    @endif
</div>
