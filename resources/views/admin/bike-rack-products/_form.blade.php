@csrf
@if (isset($product)) @method('PUT') @endif
@php
    $bikeRack = isset($product) ? $product->bikeRack : null;
    $selectedManufacturerId = (string) old('manufacturer_id', $bikeRack?->manufacturer_id ?? '');
@endphp

@include('admin.partials.help', ['title' => 'Как заполнять карточку велокрепления', 'text' => 'Велокрепления универсальны: их не нужно связывать с автомобилями. Вкладки помогают отделить продающие данные от технических параметров.', 'items' => ['«Основное» — название, адрес страницы, цена, остаток, описание и публикация. Остаток 0 означает «Под заказ».', '«Характеристики» — производитель, страна, модель, способ крепления, вместимость и грузоподъёмность. Используйте подтверждённые данные производителя; не указывайте вместимость или нагрузку выше заявленной.', '«Фото» — изображения для галереи. Добавляйте до 10 файлов размером до 6 МБ за одну загрузку.', '«SEO» — заголовок и описание для поисковой выдачи. Пустые поля автоматически заменяются названием и описанием товара; заполняйте их уникальным, понятным покупателю текстом без обещаний, которые нельзя подтвердить.']])

<div class="product-editor" data-product-editor-tabs>
    <div class="product-editor__tabs" role="tablist" aria-label="Разделы карточки товара">
        <button id="bike-main-tab" class="product-editor__tab" type="button" role="tab" aria-selected="true" aria-controls="bike-main-panel">Основное</button>
        <button id="bike-specifications-tab" class="product-editor__tab" type="button" role="tab" aria-selected="false" aria-controls="bike-specifications-panel" tabindex="-1">Характеристики</button>
        <button id="bike-photos-tab" class="product-editor__tab" type="button" role="tab" aria-selected="false" aria-controls="bike-photos-panel" tabindex="-1">Фото</button>
        <button id="bike-seo-tab" class="product-editor__tab" type="button" role="tab" aria-selected="false" aria-controls="bike-seo-panel" tabindex="-1">SEO</button>
    </div>

    <section id="bike-main-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="bike-main-tab">
        <div class="product-editor__panel-heading"><h2>Основное</h2><p>Название, адрес страницы, цена, наличие и публикация.</p></div>
        <div class="form-grid">
            <div class="field field--wide"><label for="name">Название товара</label><input id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required><p class="field__hint">Показывается в заголовке карточки и каталоге.</p>@error('name')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field field--wide"><label for="slug">Адрес страницы</label><input id="slug" name="slug" value="{{ old('slug', $product->slug ?? '') }}" placeholder="Заполнится автоматически">@error('slug')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="price">Цена, ₽</label><input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price ?? '0.00') }}" required>@error('price')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="stock">Остаток, шт.</label><input id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock ?? 0) }}" required><p class="field__hint">0 означает «Под заказ».</p>@error('stock')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field field--wide"><label for="description">Описание</label><textarea id="description" name="description" rows="8">{{ old('description', $product->description ?? '') }}</textarea>@error('description')<p class="field__error">{{ $message }}</p>@enderror</div>
            <label class="checkbox field--wide"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? false))><span>Опубликовать товар на сайте</span><span class="field__hint">Скрытый товар остаётся в админке, но не показывается покупателям.</span></label>
            @include('admin.products._badges')
        </div>
    </section>

    <section id="bike-specifications-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="bike-specifications-tab" hidden>
        <div class="product-editor__panel-heading"><h2>Характеристики</h2><p>Данные для таблицы характеристик на карточке товара.</p></div>
        <div class="form-grid">
            <div class="field"><label for="manufacturer_id">Производитель</label><select id="manufacturer_id" name="manufacturer_id"><option value="">Не выбран</option>@foreach ($bikeRackManufacturers as $manufacturer)<option value="{{ $manufacturer->id }}" @selected($selectedManufacturerId === (string) $manufacturer->id) @disabled(! $manufacturer->is_active && $selectedManufacturerId !== (string) $manufacturer->id)>{{ $manufacturer->name }}{{ $manufacturer->is_active ? '' : ' (скрыт)' }}</option>@endforeach</select><p class="field__hint"><a class="text-link" href="{{ route('admin.products.bike-racks.manufacturers.index') }}">Открыть справочник производителей</a></p>@error('manufacturer_id')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="country_of_origin">Страна производства</label><input id="country_of_origin" name="country_of_origin" maxlength="255" value="{{ old('country_of_origin', $product->country_of_origin ?? '') }}">@error('country_of_origin')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field field--wide"><label for="product_model">Модель товара</label><input id="product_model" name="product_model" maxlength="255" value="{{ old('product_model', $product->product_model ?? '') }}">@error('product_model')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="mounting_type">Тип крепления</label><select id="mounting_type" name="mounting_type"><option value="">Не выбран</option>@foreach (['На крышу', 'На фаркоп', 'На заднюю дверь'] as $type)<option value="{{ $type }}" @selected(old('mounting_type', $bikeRack?->mounting_type ?? '') === $type)>{{ $type }}</option>@endforeach</select>@error('mounting_type')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="bike_capacity">Вместимость, велосипедов</label><input id="bike_capacity" name="bike_capacity" type="number" min="1" max="10" value="{{ old('bike_capacity', $bikeRack?->bike_capacity ?? '') }}">@error('bike_capacity')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="load_capacity_kg">Грузоподъёмность, кг</label><input id="load_capacity_kg" name="load_capacity_kg" type="number" min="0" step="0.1" value="{{ old('load_capacity_kg', $bikeRack?->load_capacity_kg ?? '') }}">@error('load_capacity_kg')<p class="field__error">{{ $message }}</p>@enderror</div>
        </div>
    </section>

    <section id="bike-photos-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="bike-photos-tab" hidden>
        <div class="product-editor__panel-heading"><h2>Фото</h2><p>Изображения для галереи карточки товара.</p></div>
        <div class="form-grid"><div class="field field--wide"><label for="images">Фотографии</label><input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp,image/gif" multiple><p class="field__hint">До 10 файлов за один раз, каждый до 6 МБ.</p>@error('images.*')<p class="field__error">{{ $message }}</p>@enderror</div>@if (isset($product) && $product->images->isNotEmpty())<fieldset class="field field--wide image-manager"><legend>Загруженные фотографии</legend><div class="image-manager__grid">@foreach ($product->images as $image)<label class="image-manager__item"><img src="{{ asset($image->path) }}" alt="{{ $image->alt }}"><span><input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}"> Удалить при сохранении</span></label>@endforeach</div></fieldset>@endif</div>
    </section>

    <section id="bike-seo-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="bike-seo-tab" hidden>
        <div class="product-editor__panel-heading"><h2>SEO</h2><p>Если поля оставить пустыми, используются название и описание товара.</p></div>
        <div class="form-grid"><div class="field field--wide"><label for="meta_title">SEO-заголовок</label><input id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $product->meta_title ?? '') }}">@error('meta_title')<p class="field__error">{{ $message }}</p>@enderror</div><div class="field field--wide"><label for="meta_description">SEO-описание</label><textarea id="meta_description" name="meta_description" rows="4" maxlength="500">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>@error('meta_description')<p class="field__error">{{ $message }}</p>@enderror</div></div>
    </section>
</div>

@once @push('scripts')<script src="{{ asset('js/product-editor-tabs.js') }}" defer></script>@endpush @endonce

<div class="form-actions"><button class="button button--primary button--inline" type="submit">Сохранить</button><a class="button button--secondary" href="{{ route('admin.products.bike-racks.index') }}">Отмена</a>@if (isset($product) && $product->is_active)<a class="text-link form-actions__preview" href="{{ route('products.show', $product) }}" target="_blank" rel="noopener">Открыть на сайте ↗</a>@endif</div>
