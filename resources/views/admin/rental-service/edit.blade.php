@extends('layouts.admin')
@section('title', 'Услуга проката')
@section('body')
<div class="admin-shell">
    @include('admin.partials.header')
    <main class="admin-content admin-content--form">
        @include('admin.partials.flash')
        <p class="eyebrow">Товары</p><h1>Услуга проката</h1>
        <p class="admin-content__lead">Тарифы и документы страницы проката. Изменения не пересчитывают уже созданные заявки.</p>
        <form class="admin-form form-grid rental-admin-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.rental-service.update') }}">
            @csrf @method('PUT')
            <label class="field field--wide">Название<input name="name" value="{{ old('name', $service->name) }}" maxlength="255" required></label>
            <label class="field field--wide">Описание<textarea name="description" rows="4" maxlength="5000" required>{{ old('description', $service->description) }}</textarea></label>
            <label class="field field--wide">Условия и залог<textarea name="conditions" rows="5" maxlength="5000" required>{{ old('conditions', $service->conditions) }}</textarea></label>
            <label class="checkbox field--wide"><input type="checkbox" name="is_available" value="1" @checked(old('is_available', $service->is_available))> Принимать заявки на прокат</label>
            @foreach($service->groups as $i => $group)
                <label class="field field--wide">Группа оборудования {{ $i + 1 }}<input name="groups[{{ $i }}]" value="{{ old('groups.'.$i, $group) }}" maxlength="255" required></label>
            @endforeach
            <div class="field--wide table-wrap rental-rates-editor"><table class="admin-table"><thead><tr><th>От дней</th><th>До дней</th><th>Группа 1, ₽/день</th><th>Группа 2, ₽/день</th></tr></thead><tbody>
                @foreach($service->rates as $i => $rate)
                    <tr><td><input aria-label="Минимум дней, тариф {{ $i + 1 }}" type="number" min="1" max="730" name="rates[{{ $i }}][min_days]" value="{{ old('rates.'.$i.'.min_days', $rate['min_days']) }}" required></td>
                        <td>@if($i < 2)<input aria-label="Максимум дней, тариф {{ $i + 1 }}" type="number" min="1" max="730" name="rates[{{ $i }}][max_days]" value="{{ old('rates.'.$i.'.max_days', $rate['max_days']) }}" required>@else Без ограничения @endif</td>
                        @foreach($rate['prices'] as $j => $price)<td><input aria-label="Цена группы {{ $j + 1 }}, тариф {{ $i + 1 }}" type="number" min="0.01" max="1000000" step="0.01" name="rates[{{ $i }}][prices][{{ $j }}]" value="{{ old('rates.'.$i.'.prices.'.$j, $price) }}" required></td>@endforeach
                    </tr>
                @endforeach
            </tbody></table><p class="field__hint">Диапазоны идут подряд от 1 дня. Стоимость указана за единицу оборудования в календарный день.</p></div>
            @foreach(['contract' => 'Договор проката', 'rules' => 'Правила эксплуатации'] as $kind => $label)
                <label class="field field--wide">{{ $label }}<a class="text-link" href="{{ $service->documentUrl($kind) }}">Скачать текущий документ</a><input type="file" name="{{ $kind }}" accept=".pdf,.doc,.docx"><span class="field__hint">PDF, DOC или DOCX, до 10 МБ. Пустое поле сохраняет текущий документ.</span></label>
            @endforeach
            <div class="form-actions field--wide"><button class="button button--primary button--inline" type="submit">Сохранить</button><a class="button button--secondary button--inline" href="{{ route('admin.products.index') }}">К товарам</a></div>
        </form>
    </main>
</div>
@endsection
