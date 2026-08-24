@if ($selectedVehicle)
    <div class="selected-vehicle" aria-label="Выбранный автомобиль">
        <span class="selected-vehicle__icon" aria-hidden="true">🚗</span>
        <span class="selected-vehicle__content">
            <strong>{{ $selectedVehicle->vehicle_label }}</strong>
            <span>
                <a href="{{ route('catalog.vehicle-fitment.index') }}">изменить</a>
                <span aria-hidden="true">·</span>
                <a href="{{ request()->fullUrlWithQuery(['vehicle_configuration_id' => 'clear']) }}">сбросить</a>
            </span>
        </span>
    </div>
@endif
