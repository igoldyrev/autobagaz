@csrf
@if(isset($item)) @method('PUT') @endif
@include('admin.partials.help', ['title' => 'Заполнение справочника', 'text' => 'Используйте короткое общепринятое название без вариантов написания. Код можно оставить пустым для автоматического формирования, а порядок задаёт место в списках выбора.', 'items' => []])
<div class="form-grid">
    <div class="field field--wide"><label for="name">Название</label><input id="name" name="name" value="{{ old('name', $item->name ?? '') }}" required>@error('name')<p class="field__error">{{ $message }}</p>@enderror</div>
    <div class="field"><label for="slug">Код / URL</label><input id="slug" name="slug" value="{{ old('slug', $item->slug ?? '') }}" placeholder="Заполнится автоматически">@error('slug')<p class="field__error">{{ $message }}</p>@enderror</div>
    <div class="field"><label for="sort_order">Порядок</label><input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? $nextSortOrder ?? 0) }}" required>@error('sort_order')<p class="field__error">{{ $message }}</p>@enderror</div>
    <label class="checkbox field--wide"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))><span>Использовать в конфигурациях</span></label>
</div>
<div class="form-actions"><button class="button button--primary button--inline">Сохранить</button><a class="button button--secondary" href="{{ route($routePrefix.'.index') }}">Отмена</a></div>
