import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import vm from 'node:vm';

const script = readFileSync(new URL('../../public/js/cart.js', import.meta.url), 'utf8');

function cart(stock) {
    const listeners = {};
    const input = { value: '1' };
    const available = {};
    const backorder = {};
    const warning = {};
    const lineTotal = {};
    const item = {
        dataset: { stock, unitPrice: 100 },
        querySelector: (selector) => ({
            '[data-cart-quantity]': input,
            '[data-cart-available]': available,
            '[data-cart-backorder]': backorder,
            '[data-cart-stock-warning]': warning,
            '[data-cart-line-total]': lineTotal,
        })[selector],
    };
    input.addEventListener = (event, callback) => { listeners[event] = callback; };
    const form = {
        action: '/cart/1',
        querySelector: (selector) => selector === '[data-cart-quantity]' ? input : { value: 'csrf' },
        closest: () => item,
        addEventListener() {},
    };
    let pending;
    let serverStock = stock;
    vm.runInNewContext(script, {
        document: {
            addEventListener: (_, callback) => callback(),
            querySelector: (selector) => selector === '[data-cart-installation-price]' ? null : ({}),
            querySelectorAll: (selector) => selector === '[data-cart-item]' ? [item] : [form],
        },
        Intl,
        clearTimeout: () => { pending = undefined; },
        setTimeout: (callback) => { pending = callback; },
        FormData: class {},
        fetch: async () => ({ ok: true, json: async () => ({ stock: serverStock, cart_total: 500, cart_count: 5 }) }),
    });
    return {
        available, backorder, warning,
        change(quantity) { input.value = String(quantity); listeners.input(); },
        async save(stock) { serverStock = stock; await pending(); },
    };
}

test('quantity edits recalculate availability and toggle warning at the stock boundary', () => {
    const page = cart(3);
    for (const [quantity, available, backorder] of [[2, 2, 0], [3, 3, 0], [5, 3, 2], [1, 1, 0]]) {
        page.change(quantity);
        assert.equal(page.available.textContent, available);
        assert.equal(page.backorder.textContent, backorder);
        assert.equal(page.warning.hidden, backorder === 0);
    }
});

for (const stock of [0, -3]) {
    test(`nonpositive stock ${stock} puts all 100 units on backorder`, () => {
        const page = cart(stock);
        page.change(100);
        assert.equal(page.available.textContent, 0);
        assert.equal(page.backorder.textContent, 100);
        assert.equal(page.warning.hidden, false);
        page.change(101);
        assert.equal(page.backorder.textContent, 100);
    });
}

test('server response refreshes stock using the current input quantity', async () => {
    const page = cart(3);
    page.change(5);
    await page.save(1);
    assert.equal(page.available.textContent, 1);
    assert.equal(page.backorder.textContent, 4);
    assert.equal(page.warning.hidden, false);
});
