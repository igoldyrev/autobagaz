@php
    $pickerVehicle = $selectedVehicle ?? null;
    $pickerModel = $pickerVehicle?->generation?->vehicleModel;
    $pickerMake = $pickerModel?->make;
@endphp

<form
    class="vehicle-picker"
    method="get"
    action="{{ route('catalog.vehicle-fitment.index') }}"
    data-vehicle-picker
    data-selected-configuration="{{ $pickerVehicle?->id }}"
>
    <div>
        <h2 class="vehicle-picker__title">Подберите оборудование для автомобиля</h2>
        <p class="vehicle-picker__lead">Выберите кузов с годами выпуска и доступный для него тип крепления.</p>
    </div>
    <div class="vehicle-picker__fields">
        <label>
            <span>Марка</span>
            <select required data-vehicle-make>
                <option value="">Выберите марку</option>
                @foreach ($vehicleMakes as $vehicleMake)
                    <option value="{{ $vehicleMake->id }}" @selected($pickerMake?->id === $vehicleMake->id)>{{ $vehicleMake->name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>Модель</span>
            <select required data-vehicle-model @disabled(! $pickerMake)>
                <option value="">Выберите модель</option>
                @if ($pickerMake)
                    @foreach ($pickerMake->models()->active()->get(['id', 'name']) as $vehicleModel)
                        <option value="{{ $vehicleModel->id }}" @selected($pickerModel?->id === $vehicleModel->id)>{{ $vehicleModel->name }}</option>
                    @endforeach
                @endif
            </select>
        </label>
        <label>
            <span>Кузов и годы</span>
            <select required data-vehicle-bodywork disabled><option value="">Сначала выберите модель</option></select>
        </label>
        <label>
            <span>Тип крепления</span>
            <select required data-vehicle-mounting disabled><option value="">Сначала выберите кузов</option></select>
        </label>
        <input type="hidden" name="vehicle_configuration_id" value="{{ $pickerVehicle?->id }}" data-vehicle-configuration-input>
        <input type="hidden" name="vehicle_year" value="">
        <button class="vehicle-picker__submit" type="submit" data-vehicle-submit @disabled(! $pickerVehicle)>Показать подходящие товары</button>
    </div>
    <p class="vehicle-picker__status" data-vehicle-status aria-live="polite"></p>
</form>

@once
    @push('scripts')
        <script src="{{ asset('js/vehicle-picker.js') }}" defer></script>
    @endpush
@endonce
