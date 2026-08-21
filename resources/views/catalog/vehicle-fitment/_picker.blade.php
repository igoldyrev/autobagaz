<form class="vehicle-picker" method="get" action="{{ route('catalog.vehicle-fitment.index') }}" data-vehicle-picker>
    <div>
        <h2 class="vehicle-picker__title">ПОДБОР ПО АВТОМОБИЛЮ</h2>
    </div>
    <div class="vehicle-picker__fields">
        <label>
            <span>Марка</span>
            <select name="make_id" required data-vehicle-make>
                <option value="">Выберите марку</option>
                @foreach ($vehicleMakes as $vehicleMake)
                    <option value="{{ $vehicleMake->id }}" @selected(($make?->id ?? null) === $vehicleMake->id)>{{ $vehicleMake->name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>Модель</span>
            <select name="model_id" required data-vehicle-model @disabled(! $make)>
                <option value="">Выберите модель</option>
                @if ($make)
                    @foreach ($make->models()->active()->get(['id', 'name']) as $vehicleModel)
                        <option value="{{ $vehicleModel->id }}" @selected(($model?->id ?? null) === $vehicleModel->id)>{{ $vehicleModel->name }}</option>
                    @endforeach
                @endif
            </select>
        </label>
        <label>
            <span>Кузов</span>
            <select name="body_type_id" required data-vehicle-body-type @disabled(! $model)>
                <option value="">Выберите кузов</option>
                @if ($model)
                    @foreach ($model->bodyTypes()->active()->get(['id', 'name', 'source_name', 'year_label']) as $vehicleBodyType)
                        <option value="{{ $vehicleBodyType->id }}" @selected(($bodyType?->id ?? null) === $vehicleBodyType->id)>{{ $vehicleBodyType->source_name ?: $vehicleBodyType->name }}{{ $vehicleBodyType->year_label ? ' · '.$vehicleBodyType->year_label : '' }}</option>
                    @endforeach
                @endif
            </select>
        </label>
        <button class="vehicle-picker__submit" type="submit">Подобрать</button>
    </div>
</form>

@once
    @push('scripts')
        <script src="{{ asset('js/vehicle-picker.js') }}" defer></script>
    @endpush
@endonce
