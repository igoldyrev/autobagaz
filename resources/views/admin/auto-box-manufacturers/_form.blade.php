@csrf
@if (isset($manufacturer)) @method('PUT') @endif

@include('admin.partials.help', ['title' => 'Заполнение производителя', 'text' => 'Используйте официальное и единообразное название бренда. Активный производитель доступен в карточках автомобильных боксов; отключение не удаляет уже созданные товары.', 'items' => []])

<div class="form-grid">
    <div class="field field--wide">
        <label for="name">Название</label>
        <input id="name" name="name" type="text" value="{{ old('name', $manufacturer->name ?? '') }}" maxlength="255" required>
        @error('name') <p class="field__error">{{ $message }}</p> @enderror
    </div>
    <label class="checkbox field--wide">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $manufacturer->is_active ?? true))>
        <span>Производитель активен — доступен в формах товаров</span>
    </label>
</div>

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">Сохранить</button>
    <a class="button button--secondary" href="{{ route('admin.products.auto-boxes.manufacturers.index') }}">Отмена</a>
</div>
