import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import vm from 'node:vm';

const script = readFileSync(new URL('../../public/js/vehicle-picker.js', import.meta.url), 'utf8');

function pickerWithModels(models) {
    class Field {
        value = '';
        disabled = false;
        options = [];
        listeners = {};
        replaceChildren(...options) {
            this.options = options;
            this.value = options[0]?.value ?? '';
        }
        add(option) { this.options.push(option); }
        addEventListener(event, callback) { this.listeners[event] = callback; }
    }
    const elements = Object.fromEntries([
        'make', 'model', 'bodywork', 'mounting', 'configuration-input', 'submit', 'status',
    ].map((name) => [name, new Field()]));
    const requests = [];
    const picker = {
        dataset: {},
        querySelector: (selector) => elements[selector.slice('[data-vehicle-'.length, -1)],
    };
    vm.runInNewContext(script, {
        document: {
            addEventListener: (_, callback) => callback(),
            querySelectorAll: () => [picker],
        },
        Option: class { constructor(text, value) { this.text = text; this.value = value; } },
        fetch: async (url) => {
            requests.push(url);
            return {
                ok: true,
                json: async () => url.includes('/models?') ? models : [{
                    id: 1546,
                    bodywork: { key: 'minivan-2022', label: 'Минивэн — 2022–н.в.' },
                    mounting: { label: 'Гладкая крыша' },
                }],
            };
        },
    });
    return { elements, requests };
}

test('single model automatically loads bodywork, years and mounting (Zeekr 009)', async () => {
    const { elements, requests } = pickerWithModels([{ id: 873, name: '009' }]);
    elements.make.value = '85';
    await elements.make.listeners.change();

    assert.deepEqual(requests, ['/podbor-avto/models?make_id=85', '/podbor-avto/configurations?model_id=873']);
    assert.equal(elements.bodywork.value, 'minivan-2022');
    assert.equal(elements.bodywork.options[1].text, 'Минивэн — 2022–н.в.');
    assert.equal(elements.mounting.value, '1546');
    assert.equal(elements['configuration-input'].value, '1546');
    assert.equal(elements.submit.disabled, false);
});

test('multiple models wait for explicit selection before loading configurations', async () => {
    const { elements, requests } = pickerWithModels([{ id: 1, name: 'A' }, { id: 2, name: 'B' }]);
    elements.make.value = '1';
    await elements.make.listeners.change();

    assert.deepEqual(requests, ['/podbor-avto/models?make_id=1']);
    assert.equal(elements.model.value, '');
    assert.equal(elements.bodywork.disabled, true);
    assert.equal(elements.submit.disabled, true);
});

test('make without models leaves dependent controls disabled', async () => {
    const { elements, requests } = pickerWithModels([]);
    elements.make.value = '1';
    await elements.make.listeners.change();

    assert.equal(requests.length, 1);
    assert.equal(elements.model.disabled, true);
    assert.equal(elements.bodywork.disabled, true);
    assert.equal(elements.submit.disabled, true);
});
