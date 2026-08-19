document.querySelectorAll('[data-vehicle-fitment-picker]').forEach((picker) => {
    const search = picker.querySelector('[data-fitment-search]');
    const count = picker.querySelector('[data-fitment-count]');
    const empty = picker.querySelector('[data-fitment-empty]');
    const makes = [...picker.querySelectorAll('[data-fitment-make]')];
    const normalize = (value) => value.toLocaleLowerCase('ru-RU').replaceAll('ё', 'е').trim();

    const updateCount = () => {
        const models = picker.querySelectorAll('input[name="vehicle_model_ids[]"]:checked').length;
        const bodyTypes = picker.querySelectorAll('input[name="vehicle_body_type_ids[]"]:checked').length;
        count.textContent = `Выбрано: моделей — ${models}, вариантов — ${bodyTypes}`;
    };

    const updateModelState = (model) => {
        const wholeModel = model.querySelector('input[name="vehicle_model_ids[]"]');
        const bodyTypes = [...model.querySelectorAll('input[name="vehicle_body_type_ids[]"]')];

        bodyTypes.forEach((checkbox) => {
            checkbox.disabled = wholeModel.checked;
            checkbox.closest('[data-fitment-option]').classList.toggle('fitment-option--disabled', wholeModel.checked);
        });
    };

    picker.querySelectorAll('[data-fitment-model]').forEach((model) => {
        const wholeModel = model.querySelector('input[name="vehicle_model_ids[]"]');

        wholeModel.addEventListener('change', () => {
            if (wholeModel.checked) {
                model.querySelectorAll('input[name="vehicle_body_type_ids[]"]:checked').forEach((checkbox) => {
                    checkbox.checked = false;
                });
            }

            updateModelState(model);
            updateCount();
        });

        updateModelState(model);
    });

    picker.addEventListener('change', updateCount);

    search.addEventListener('input', () => {
        const query = normalize(search.value);
        let visibleMakes = 0;

        makes.forEach((make) => {
            const makeMatches = query !== '' && normalize(make.dataset.makeSearch).includes(query);
            let visibleModels = 0;

            make.querySelectorAll('[data-fitment-model]').forEach((model) => {
                const modelMatches = query !== '' && normalize(model.dataset.modelSearch).includes(query);
                let visibleOptions = 0;

                model.querySelectorAll('[data-fitment-option]').forEach((option) => {
                    const optionMatches = query === '' || makeMatches || modelMatches || normalize(option.dataset.searchText).includes(query);
                    option.hidden = !optionMatches;
                    visibleOptions += Number(optionMatches);
                });

                model.hidden = visibleOptions === 0;
                if (query !== '' && visibleOptions > 0) model.open = true;
                visibleModels += Number(visibleOptions > 0);
            });

            make.hidden = visibleModels === 0;
            if (query !== '' && visibleModels > 0) make.open = true;
            visibleMakes += Number(visibleModels > 0);
        });

        empty.hidden = visibleMakes > 0;
    });

    updateCount();
});
