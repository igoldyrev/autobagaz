@extends('layouts.admin')
@section('title', 'Проверка совместимости')
@section('body')
<div class="admin-shell">@include('admin.partials.header')<main class="admin-content admin-content--wide">@include('admin.partials.flash')
<div class="page-heading"><div><p class="eyebrow">Совместимость</p><h1>Проверка с объяснением</h1></div><a class="button button--secondary button--inline" href="{{ route('admin.compatibility-overrides.index') }}">Ручные исключения</a></div>
@include('admin.partials.help', ['id' => 'compatibility-preview-help-title', 'title' => 'Как пользоваться проверкой', 'text' => 'Выберите автомобиль и проверяемый товар. Для багажника система проверяет применяемость к выбранному автомобилю.', 'items' => ['Для проверки автобокса выберите базовый багажник. Бокс устанавливается на поперечины багажника, который подходит автомобилю.', 'Ручное исключение может изменить результат той проверки, для которой оно задано.']])
<form class="admin-form" method="GET"><div class="form-grid">
<div class="field field--wide">
    <label for="vehicle_configuration_id">Автомобиль</label>
    <div class="select-search">
        <label class="visually-hidden" for="vehicle-configuration-search">Поиск по марке, модели или году</label>
        <input id="vehicle-configuration-search" type="search" placeholder="Марка, модель или год" autocomplete="off" data-select-search="vehicle_configuration_id" data-select-search-by-year>
        <span class="select-search__result" data-select-search-result="vehicle_configuration_id" aria-live="polite"></span>
    </div>
    <select id="vehicle_configuration_id" name="vehicle_configuration_id" data-searchable-select required>
        <option value="">Выберите конфигурацию</option>
        @foreach ($vehicleConfigurations as $configuration)
            @php($vehicleName = $configuration->generation->vehicleModel->make->name.' '.$configuration->generation->vehicleModel->name)
            <option value="{{ $configuration->id }}"
                data-vehicle-name="{{ $vehicleName }}"
                data-year-from="{{ $configuration->year_from ?: $configuration->generation->year_from }}"
                data-year-to="{{ $configuration->year_to ?: $configuration->generation->year_to }}"
                @selected((string) request('vehicle_configuration_id') === (string) $configuration->id)
            >{{ $vehicleName }} · {{ $configuration->generation->display_name }} · {{ $configuration->display_name }}</option>
        @endforeach
    </select>
</div>
<div class="field field--wide"><label for="product_id">Проверяемый товар</label><select id="product_id" name="product_id" data-searchable-select required><option value="">Выберите товар</option>@foreach($products as $product)<option value="{{ $product->id }}" @selected((string)request('product_id') === (string)$product->id)>{{ $product->name }} · {{ $product->roofRack ? 'багажник' : 'автобокс' }}</option>@endforeach</select></div>
<div class="field field--wide"><label for="base_product_id">Базовый багажник для автобокса</label><select id="base_product_id" name="base_product_id" data-searchable-select><option value="">Выберите багажник</option>@foreach($baseProducts as $product)<option value="{{ $product->id }}" @selected((string)request('base_product_id') === (string)$product->id)>{{ $product->name }}</option>@endforeach</select></div>
</div><div class="form-actions"><button class="button button--primary button--inline">Проверить</button></div></form>
@if ($result)
    <section>
        <h2>Результат: {{ $result->statusLabel() }}</h2>
        @if ($selectedProduct->autoBox)
            <p>Проверяемый комплект: {{ $selectedProduct->name }} + {{ $selectedBase->name }}</p>
            <p>{{ match ($result->status) {
                \App\Compatibility\CompatibilityResult::COMPATIBLE => 'Выбранный багажник подходит автомобилю. Бокс устанавливается на его поперечины.',
                \App\Compatibility\CompatibilityResult::INCOMPATIBLE => 'Выбранный багажник не подходит для этой конфигурации автомобиля.',
                default => $result->statusExplanation(),
            } }}</p>
        @else
            <p>{{ $result->statusExplanation() }}</p>
            @if ($result->matchedBaseProductId)
                <p>Подходящий багажник: {{ $baseProducts->firstWhere('id', $result->matchedBaseProductId)?->name }}</p>
            @endif
        @endif
        @if ($result->appliedOverrideId)
            <p><strong>Применено ручное исключение #{{ $result->appliedOverrideId }}</strong></p>
        @endif
        <h3>Объяснение проверки</h3>
        <ul>
            @foreach ($result->reasons as $reason)
                <li>{{ $reason }}</li>
            @endforeach
        </ul>
        @if ($result->missingData)
            <h3>Нужно заполнить</h3>
            <ul>
                @foreach ($result->missingData as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endif
    </section>
@elseif ($selectedProduct)
    <section>
        <h2>Для подтверждения совместимости выберите багажник</h2>
        <p>Для установки бокса нужны поперечины багажника, подходящего выбранному автомобилю.</p>
    </section>
@endif
</main></div>
@once @push('scripts')<script src="{{ asset('js/searchable-select.js') }}?v={{ filemtime(public_path('js/searchable-select.js')) }}" defer></script>@endpush @endonce
@endsection
