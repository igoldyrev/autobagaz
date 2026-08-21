document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-vehicle-picker]').forEach((picker) => {
        const makeSelect = picker.querySelector('[data-vehicle-make]');
        const modelSelect = picker.querySelector('[data-vehicle-model]');
        const bodyTypeSelect = picker.querySelector('[data-vehicle-body-type]');

        const reset = (select, placeholder) => {
            select.innerHTML = '';
            select.add(new Option(placeholder, ''));
            select.disabled = true;
        };

        const load = async (select, url, placeholder, label) => {
            reset(select, 'Загрузка…');
            try {
                const response = await fetch(url, { headers: { Accept: 'application/json' } });
                if (!response.ok) throw new Error('Unable to load options');
                const values = await response.json();
                reset(select, placeholder);
                values.forEach((value) => {
                    const suffix = value.year_label ? ` · ${value.year_label}` : '';
                    select.add(new Option(`${label(value)}${suffix}`, value.id));
                });
                select.disabled = false;
            } catch (_) {
                reset(select, 'Не удалось загрузить список');
            }
        };

        makeSelect?.addEventListener('change', () => {
            reset(bodyTypeSelect, 'Сначала выберите модель');
            if (!makeSelect.value) {
                reset(modelSelect, 'Сначала выберите марку');
                return;
            }
            load(modelSelect, `/podbor-avto/models?make_id=${encodeURIComponent(makeSelect.value)}`, 'Выберите модель', (model) => model.name);
        });

        modelSelect?.addEventListener('change', () => {
            if (!modelSelect.value) {
                reset(bodyTypeSelect, 'Сначала выберите модель');
                return;
            }
            load(bodyTypeSelect, `/podbor-avto/kuzova?model_id=${encodeURIComponent(modelSelect.value)}`, 'Выберите кузов', (bodyType) => bodyType.source_name || bodyType.name);
        });
    });
});
