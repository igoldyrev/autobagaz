document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-vehicle-picker]').forEach((picker) => {
        const fields = {
            make: picker.querySelector('[data-vehicle-make]'),
            model: picker.querySelector('[data-vehicle-model]'),
            bodywork: picker.querySelector('[data-vehicle-bodywork]'),
            mounting: picker.querySelector('[data-vehicle-mounting]'),
        };
        const input = picker.querySelector('[data-vehicle-configuration-input]');
        const submit = picker.querySelector('[data-vehicle-submit]');
        const status = picker.querySelector('[data-vehicle-status]');
        const selectedConfiguration = picker.dataset.selectedConfiguration;
        let configurations = [];

        const reset = (select, placeholder) => {
            select.replaceChildren(new Option(placeholder, ''));
            select.disabled = true;
        };

        const setOptions = (select, values, placeholder, desired = '') => {
            select.replaceChildren(new Option(placeholder, ''));
            values.forEach(({ value, label }) => select.add(new Option(label, String(value))));
            select.disabled = values.length === 0;
            if (values.some((value) => String(value.value) === String(desired))) {
                select.value = String(desired);
            } else if (values.length === 1) {
                select.value = String(values[0].value);
            }
        };

        const uniqueBodyworks = () => {
            const options = new Map();
            configurations.forEach((configuration) => options.set(configuration.bodywork.key, {
                value: configuration.bodywork.key,
                label: configuration.bodywork.label,
            }));

            return [...options.values()];
        };

        const updateMountings = (desiredConfiguration = '') => {
            const values = configurations
                .filter((configuration) => configuration.bodywork.key === fields.bodywork.value)
                .map((configuration) => ({ value: configuration.id, label: configuration.mounting.label }));
            setOptions(fields.mounting, values, 'Выберите тип крепления', desiredConfiguration);
            input.value = fields.mounting.value;
            submit.disabled = !input.value;
        };

        const populateConfigurations = () => {
            const selected = configurations.find((configuration) => String(configuration.id) === String(selectedConfiguration));
            setOptions(fields.bodywork, uniqueBodyworks(), 'Выберите кузов и годы', selected?.bodywork.key);
            updateMountings(selected?.id);
        };

        const loadConfigurations = async () => {
            configurations = [];
            input.value = '';
            submit.disabled = true;
            reset(fields.bodywork, 'Загрузка…');
            reset(fields.mounting, 'Ожидание выбора');
            status.textContent = '';

            try {
                const response = await fetch(`/podbor-avto/configurations?model_id=${encodeURIComponent(fields.model.value)}`, {
                    headers: { Accept: 'application/json' },
                });
                if (!response.ok) throw new Error('Unable to load configurations');
                configurations = await response.json();
                if (configurations.length === 0) {
                    reset(fields.bodywork, 'Нет доступных вариантов');
                    return;
                }
                populateConfigurations();
            } catch (_) {
                reset(fields.bodywork, 'Не удалось загрузить список');
                status.textContent = 'Не удалось загрузить конфигурации. Обновите страницу и попробуйте снова.';
            }
        };

        fields.make.addEventListener('change', async () => {
            reset(fields.model, fields.make.value ? 'Загрузка…' : 'Сначала выберите марку');
            reset(fields.bodywork, 'Ожидание выбора');
            reset(fields.mounting, 'Ожидание выбора');
            input.value = '';
            submit.disabled = true;
            if (!fields.make.value) return;

            try {
                const response = await fetch(`/podbor-avto/models?make_id=${encodeURIComponent(fields.make.value)}`, {
                    headers: { Accept: 'application/json' },
                });
                if (!response.ok) throw new Error('Unable to load models');
                const models = await response.json();
                setOptions(fields.model, models.map((model) => ({ value: model.id, label: model.name })), 'Модель автомобиля');
            } catch (_) {
                reset(fields.model, 'Не удалось загрузить список');
            }
        });
        fields.model.addEventListener('change', () => {
            if (fields.model.value) loadConfigurations();
            else reset(fields.bodywork, 'Сначала выберите модель');
        });
        fields.bodywork.addEventListener('change', () => updateMountings());
        fields.mounting.addEventListener('change', () => {
            input.value = fields.mounting.value;
            submit.disabled = !input.value;
        });

        if (fields.model.value) loadConfigurations();
    });
});
