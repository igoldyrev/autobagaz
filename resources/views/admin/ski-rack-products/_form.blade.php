@csrf
@if (isset($product)) @method('PUT') @endif

@php
    $skiRack = isset($product) ? $product->skiRack : null;
    $manufacturerId = (string) old('manufacturer_id', $skiRack?->manufacturer_id ?? '');
@endphp

@include('admin.partials.help', ['title' => 'Как заполнять карточку лыжного крепления', 'text' => 'Лыжные крепления универсальны: их не нужно связывать с автомобилями. Заполняйте карточку последовательно по вкладкам.', 'items' => ['«Основное» — название, цена, остаток, описание и публикация. Остаток 0 означает «Под заказ».', '«Характеристики» — производитель, страна, модель и вместимость. Указывайте количество пар лыж и сноубордов по данным производителя.', '«Фото» — изображения для галереи. За одну загрузку допускается до 10 файлов, каждый до 6 МБ.', '«SEO» — адрес страницы, SEO-заголовок и SEO-описание. Адрес можно не заполнять: он сформируется из названия. Для поисковой выдачи используйте уникальный краткий текст с ключевыми характеристиками товара.']])

<div class="product-editor" data-product-editor-tabs>
    <div class="product-editor__tabs" role="tablist" aria-label="Разделы карточки товара">
        <button id="ski-main-tab" class="product-editor__tab" type="button" role="tab" aria-selected="true" aria-controls="ski-main-panel">Основное</button>
        <button id="ski-specifications-tab" class="product-editor__tab" type="button" role="tab" aria-selected="false" aria-controls="ski-specifications-panel" tabindex="-1">Характеристики</button>
        <button id="ski-photos-tab" class="product-editor__tab" type="button" role="tab" aria-selected="false" aria-controls="ski-photos-panel" tabindex="-1">Фото</button>
        <button id="ski-seo-tab" class="product-editor__tab" type="button" role="tab" aria-selected="false" aria-controls="ski-seo-panel" tabindex="-1">SEO</button>
    </div>

    <section id="ski-main-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="ski-main-tab">
        <div class="product-editor__panel-heading"><h2>Основное</h2><p>Название, наличие, описание и статус публикации.</p></div>
        <div class="form-grid">
            <div class="field field--wide"><label for="name">Название товара</label><input id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>@error('name')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="price">Цена, ₽</label><input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price ?? '0') }}" required>@error('price')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="stock">Остаток, шт.</label><input id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock ?? 0) }}" required>@error('stock')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field field--wide"><label for="description">Описание</label><textarea id="description" name="description" rows="8">{{ old('description', $product->description ?? '') }}</textarea>@error('description')<p class="field__error">{{ $message }}</p>@enderror</div>
            <label class="checkbox field--wide"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? false))><span>Опубликовать товар на сайте</span><span class="field__hint">Скрытый товар остаётся в админке, но не показывается покупателям.</span></label>
        </div>
    </section>

    <section id="ski-specifications-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="ski-specifications-tab" hidden>
        <div class="product-editor__panel-heading"><h2>Характеристики</h2><p>Данные, которые покупатель увидит в таблице характеристик.</p></div>
        <div class="form-grid">
            <div class="field"><label for="manufacturer_id">Производитель</label><select id="manufacturer_id" name="manufacturer_id"><option value="">Не выбран</option>@foreach ($skiRackManufacturers as $manufacturer)<option value="{{ $manufacturer->id }}" @selected($manufacturerId === (string) $manufacturer->id) @disabled(! $manufacturer->is_active && $manufacturerId !== (string) $manufacturer->id)>{{ $manufacturer->name }}{{ $manufacturer->is_active ? '' : ' (скрыт)' }}</option>@endforeach</select><p class="field__hint"><a class="text-link" href="{{ route('admin.products.ski-racks.manufacturers.index') }}">Открыть справочник производителей</a></p>@error('manufacturer_id')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="country_of_origin">Страна производства</label><input id="country_of_origin" name="country_of_origin" value="{{ old('country_of_origin', $product->country_of_origin ?? '') }}">@error('country_of_origin')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field field--wide"><label for="product_model">Модель товара</label><input id="product_model" name="product_model" value="{{ old('product_model', $product->product_model ?? '') }}">@error('product_model')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="ski_pairs_capacity">Вместимость, пар лыж</label><input id="ski_pairs_capacity" name="ski_pairs_capacity" type="number" min="1" value="{{ old('ski_pairs_capacity', $skiRack?->ski_pairs_capacity ?? '') }}">@error('ski_pairs_capacity')<p class="field__error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="snowboard_capacity">Вместимость, сноубордов</label><input id="snowboard_capacity" name="snowboard_capacity" type="number" min="1" value="{{ old('snowboard_capacity', $skiRack?->snowboard_capacity ?? '') }}">@error('snowboard_capacity')<p class="field__error">{{ $message }}</p>@enderror</div>
        </div>
    </section>

    <section id="ski-photos-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="ski-photos-tab" hidden>
        <div class="product-editor__panel-heading"><h2>Фото</h2><p>Добавьте изображения для галереи карточки товара.</p></div>
        <div class="form-grid"><div class="field field--wide"><label for="images">Фотографии</label><input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp,image/gif" multiple><p class="field__hint">До 10 файлов за один раз, каждый до 6 МБ.</p>@error('images.*')<p class="field__error">{{ $message }}</p>@enderror</div>@if (isset($product) && $product->images->isNotEmpty())<fieldset class="field field--wide image-manager"><legend>Загруженные фотографии</legend><div class="image-manager__grid">@foreach ($product->images as $image)<label class="image-manager__item"><img src="{{ asset($image->path) }}" alt="{{ $image->alt }}"><span><input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}"> Удалить при сохранении</span></label>@endforeach</div></fieldset>@endif</div>
    </section>

    <section id="ski-seo-panel" class="product-editor__panel" role="tabpanel" aria-labelledby="ski-seo-tab" hidden>
        <div class="product-editor__panel-heading"><h2>SEO</h2><p>Если поля SEO пустые, в выдаче используются название и описание товара.</p></div>
        <div class="form-grid"><div class="field field--wide"><label for="slug">Адрес страницы</label><input id="slug" name="slug" value="{{ old('slug', $product->slug ?? '') }}" placeholder="Заполнится автоматически">@error('slug')<p class="field__error">{{ $message }}</p>@enderror</div><div class="field field--wide"><label for="meta_title">SEO-заголовок</label><input id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $product->meta_title ?? '') }}">@error('meta_title')<p class="field__error">{{ $message }}</p>@enderror</div><div class="field field--wide"><label for="meta_description">SEO-описание</label><textarea id="meta_description" name="meta_description" rows="4" maxlength="500">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>@error('meta_description')<p class="field__error">{{ $message }}</p>@enderror</div></div>
    </section>
</div>

@once @push('scripts')<script src="{{ asset('js/product-editor-tabs.js') }}" defer></script>@endpush @endonce

<div class="form-actions"><button class="button button--primary button--inline" type="submit">Сохранить</button><a class="button button--secondary" href="{{ route('admin.products.ski-racks.index') }}">Отмена</a>@if (isset($product) && $product->is_active)<a class="text-link form-actions__preview" href="{{ route('products.show', $product) }}" target="_blank" rel="noopener">Открыть на сайте ↗</a>@endif</div>
