import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import vm from 'node:vm';

const script = readFileSync(new URL('../../public/js/checkout.js', import.meta.url), 'utf8');

function checkout({ confirmation = false, empty = false, delivery = false } = {}) {
    const formListeners = {};
    const windowListeners = {};
    const button = {
        textContent: confirmation ? 'Подтвердить изменения и оформить заказ' : 'Оформить заказ',
        disabled: empty,
    };
    const addressInput = {};
    const address = { hidden: false, querySelector: () => addressInput };
    const notes = ['pickup', 'delivery'].map((value) => ({ dataset: { deliveryInfo: value } }));
    let focused = false;
    const form = {
        querySelector: () => button,
        addEventListener: (type, callback) => { formListeners[type] = callback; },
    };
    vm.runInNewContext(script, {
        document: {
            addEventListener: (_, callback) => callback(),
            querySelector: (selector) => ({
                '.checkout-form': form,
                '[data-checkout-changes]': confirmation ? { focus: () => { focused = true; } } : null,
                '[data-delivery-address]': address,
                'input[name="delivery_method"]:checked': { value: delivery ? 'delivery' : 'pickup' },
            })[selector],
            querySelectorAll: (selector) => selector === '[data-delivery-info]' ? notes : [],
        },
        window: { addEventListener: (type, callback) => { (windowListeners[type] ??= []).push(callback); } },
    });
    return {
        button, address, addressInput, notes,
        focused: () => focused,
        submit() {
            let prevented = false;
            formListeners.submit({ preventDefault() { prevented = true; } });
            return !prevented;
        },
        pageshow: () => windowListeners.pageshow.forEach((callback) => callback()),
    };
}

for (const confirmation of [false, true]) {
    test(`pending native submission blocks repeated clicks (confirmation=${confirmation})`, async () => {
        const page = checkout({ confirmation });
        assert.equal(page.submit(), true);
        assert.equal(page.button.disabled, true);
        assert.equal(page.button.textContent, 'Оформляем заказ…');
        assert.equal(page.submit(), false);
        // No timer may unlock the form while the network response is pending.
        await new Promise((resolve) => setTimeout(resolve, 100));
        assert.equal(page.submit(), false);
        assert.equal(page.button.disabled, true);
        page.pageshow();
        assert.equal(page.button.disabled, false);
        assert.equal(page.button.textContent, confirmation ? 'Подтвердить изменения и оформить заказ' : 'Оформить заказ');
        assert.equal(page.submit(), true);
    });
}

test('empty checkout stays disabled after returning with browser Back', () => {
    const page = checkout({ empty: true });
    page.pageshow();
    assert.equal(page.button.disabled, true);
});

test('updated conditions receive focus and delivery fields keep their state', () => {
    const page = checkout({ confirmation: true, delivery: true });
    assert.equal(page.focused(), true);
    assert.equal(page.address.hidden, false);
    assert.equal(page.addressInput.required, true);
    page.pageshow();
    assert.equal(page.notes[0].hidden, true);
    assert.equal(page.notes[1].hidden, false);
});
