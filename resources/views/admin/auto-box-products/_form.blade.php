@csrf
@if (isset($product)) @method('PUT') @endif

@php
    $autoBox = isset($product) ? $product->autoBox : null;
    $selectedManufacturerId = (string) old('manufacturer_id', $autoBox?->manufacturer_id ?? '');
@endphp

@include('admin.partials.help', ['title' => 'Заполнение автомобильного бокса', 'text' => 'Сначала заполните общие данные и характеристики бокса, затем ограничения его крепления. Они используются для автоматической проверки совместимости с багажниками. Публикуйте товар после проверки карточки.', 'items' => ['Адрес страницы можно оставить пустым — он сформируется автоматически.', 'Габариты самого бокса указываются в сантиметрах, монтажные ограничения — в миллиметрах.', 'Если технический параметр неизвестен, оставьте его пустым, а не указывайте приблизительное значение.']])

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
            @foreach ($autoBoxManufacturers as $manufacturer)
                <option
                    value="{{ $manufacturer->id }}"
                    @selected($selectedManufacturerId === (string) $manufacturer->id)
                    @disabled(! $manufacturer->is_active && $selectedManufacturerId !== (string) $manufacturer->id)
                >{{ $manufacturer->name }}{{ $manufacturer->is_active ? '' : ' (скрыт)' }}</option>
            @endforeach
        </select>
        <p class="field__hint"><a class="text-link" href="{{ route('admin.products.auto-boxes.manufacturers.index') }}">Открыть справочник производителей</a></p>
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
        @error('product_model') <p class="field__error">{{ $message }}</p> @enderror
    </div>

    <fieldset class="field field--wide product-specific-fields">
        <legend>Характеристики автомобильного бокса</legend>
        <div class="form-grid product-specific-fields__grid">
            <div class="field">
                <label for="length_cm">Длина, см</label>
                <input id="length_cm" name="length_cm" type="number" min="0" step="0.1" value="{{ old('length_cm', $autoBox?->length_cm ?? '') }}">
                @error('length_cm') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="width_cm">Ширина, см</label>
                <input id="width_cm" name="width_cm" type="number" min="0" step="0.1" value="{{ old('width_cm', $autoBox?->width_cm ?? '') }}">
                @error('width_cm') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="height_cm">Высота, см</label>
                <input id="height_cm" name="height_cm" type="number" min="0" step="0.1" value="{{ old('height_cm', $autoBox?->height_cm ?? '') }}">
                @error('height_cm') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="volume_l">Объём, л</label>
                <input id="volume_l" name="volume_l" type="number" min="0" step="0.1" value="{{ old('volume_l', $autoBox?->volume_l ?? '') }}">
                @error('volume_l') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="load_capacity_kg">Грузоподъёмность, кг</label>
                <input id="load_capacity_kg" name="load_capacity_kg" type="number" min="0" step="0.1" value="{{ old('load_capacity_kg', $autoBox?->load_capacity_kg ?? '') }}">
                @error('load_capacity_kg') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="opening_type">Тип открывания</label>
                <select id="opening_type" name="opening_type">
                    <option value="">Не выбран</option>
                    <option value="Одностороннее" @selected(old('opening_type', $autoBox?->opening_type ?? '') === 'Одностороннее')>Одностороннее</option>
                    <option value="Двухстороннее" @selected(old('opening_type', $autoBox?->opening_type ?? '') === 'Двухстороннее')>Двухстороннее</option>
                </select>
                @error('opening_type') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="mounting_type">Тип крепления</label>
                <select id="mounting_type" name="mounting_type">
                    <option value="">Не выбран</option>
                    <option value="U-скоба" @selected(old('mounting_type', $autoBox?->mounting_type ?? '') === 'U-скоба')>U-скоба</option>
                    <option value="Быстросъем" @selected(old('mounting_type', $autoBox?->mounting_type ?? '') === 'Быстросъем')>Быстросъем</option>
                    <option value="Лапа быстросъем" @selected(old('mounting_type', $autoBox?->mounting_type ?? '') === 'Лапа быстросъем')>Лапа быстросъем</option>
                </select>
                @error('mounting_type') <p class="field__error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="box_color">Цвет</label>
                @php
                    $selectedBoxColor = old('box_color', $autoBox?->box_color ?? '');
                    $boxColors = [
                        'Белый глянец',
                        'Белый карбон',
                        'Белый матовый',
                        'Серый глянец',
                        'Серый карбон',
                        'Серый матовый',
                        'Черный глянец',
                        'Черный карбон',
                        'Черный матовый',
                    ];
                @endphp
                <select id="box_color" name="box_color">
                    <option value="">Не выбран</option>
                    @foreach ($boxColors as $boxColor)
                        <option value="{{ $boxColor }}" @selected($selectedBoxColor === $boxColor)>{{ $boxColor }}</option>
                    @endforeach
                </select>
                @error('box_color') <p class="field__error">{{ $message }}</p> @enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="field field--wide product-specific-fields">
        <legend>Ограничения крепления для автоматической совместимости</legend>
        <p class="field__hint">Это допустимые параметры багажника, на который можно установить автобокс, а не размеры самого бокса. Возьмите значения из инструкции или схемы крепления производителя. Все размеры указываются в миллиметрах; если параметр неизвестен, оставьте поле пустым — проверка покажет «Недостаточно данных».</p>
        <div class="form-grid product-specific-fields__grid">
            <div class="field">
                <label for="clamp_width_min_mm">Ширина дуги от, мм</label>
                <input id="clamp_width_min_mm" name="clamp_width_min_mm" type="number" min="1" value="{{ old('clamp_width_min_mm', $autoBox?->clamp_width_min_mm ?? '') }}">
                <p class="field__hint">Минимальная внешняя ширина дуги, которую может обхватить крепление.</p>
                @error('clamp_width_min_mm')<p class="field__error">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label for="clamp_width_max_mm">Ширина дуги до, мм</label>
                <input id="clamp_width_max_mm" name="clamp_width_max_mm" type="number" min="1" value="{{ old('clamp_width_max_mm', $autoBox?->clamp_width_max_mm ?? '') }}">
                <p class="field__hint">Максимальная внешняя ширина дуги, которую может обхватить крепление.</p>
                @error('clamp_width_max_mm')<p class="field__error">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label for="clamp_height_max_mm">Высота дуги до, мм</label>
                <input id="clamp_height_max_mm" name="clamp_height_max_mm" type="number" min="1" value="{{ old('clamp_height_max_mm', $autoBox?->clamp_height_max_mm ?? '') }}">
                <p class="field__hint">Максимальная внешняя высота дуги, допустимая для крепления.</p>
                @error('clamp_height_max_mm')<p class="field__error">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label for="crossbar_spacing_min_mm">Расстояние между дугами от, мм</label>
                <input id="crossbar_spacing_min_mm" name="crossbar_spacing_min_mm" type="number" min="1" value="{{ old('crossbar_spacing_min_mm', $autoBox?->crossbar_spacing_min_mm ?? '') }}">
                <p class="field__hint">Минимальное расстояние между центрами передней и задней дуг.</p>
                @error('crossbar_spacing_min_mm')<p class="field__error">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label for="crossbar_spacing_max_mm">Расстояние между дугами до, мм</label>
                <input id="crossbar_spacing_max_mm" name="crossbar_spacing_max_mm" type="number" min="1" value="{{ old('crossbar_spacing_max_mm', $autoBox?->crossbar_spacing_max_mm ?? '') }}">
                <p class="field__hint">Максимальное расстояние между центрами передней и задней дуг.</p>
                @error('crossbar_spacing_max_mm')<p class="field__error">{{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label for="required_t_slot_width_mm">Необходимый T-паз, мм</label>
                <input id="required_t_slot_width_mm" name="required_t_slot_width_mm" type="number" min="1" value="{{ old('required_t_slot_width_mm', $autoBox?->required_t_slot_width_mm ?? '') }}">
                <p class="field__hint">Минимальная ширина T-паза, если бокс крепится через него. Для крепления без T-паза оставьте поле пустым.</p>
                @error('required_t_slot_width_mm')<p class="field__error">{{ $message }}</p>@enderror
            </div>
        </div>
    </fieldset>

    <div class="field field--wide">
        <label for="description">Описание</label>
        <textarea id="description" name="description" rows="8">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <p class="field__error">{{ $message }}</p> @enderror
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

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.products.auto-boxes.index') }}">Отмена</a>
    @if (isset($product) && $product->is_active)
        <a class="text-link form-actions__preview" href="{{ route('products.show', $product) }}" target="_blank" rel="noopener">Открыть на сайте ↗</a>
    @endif
</div>
