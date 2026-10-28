import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import vm from 'node:vm';

const script = readFileSync(new URL('../../public/js/cart.js', import.meta.url), 'utf8');

function cart(stock, { fail = false, hold = false } = {}) {
    const listeners = {};
    const input = { value: '1', reportValidity() { return Number.isInteger(Number(this.value)) && Number(this.value) >= 1 && Number(this.value) <= 100; } };
    const checkout = { href: '/checkout', addEventListener: (_, callback) => { checkout.click = callback; } };
    const requests = [];
    const releases = [];
    const navigations = [];
    let reloads = 0;
    let pageshow;
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
            querySelector: (selector) => selector === '[data-cart-installation-price]' ? null : selector === '[data-cart-checkout]' ? checkout : ({}),
            querySelectorAll: (selector) => selector === '[data-cart-item]' ? [item] : [form],
        },
        Intl,
        clearTimeout: () => { pending = undefined; },
        setTimeout: (callback) => { pending = callback; },
        FormData: class { constructor() { this.quantity = Number(input.value); this.method = 'PATCH'; } },
        window: {
            location: { assign: (url) => navigations.push(url), reload: () => { reloads++; } },
            addEventListener: (_, callback) => { pageshow = callback; },
        },
        fetch: async (_, request) => {
            requests.push(request);
            if (hold) await new Promise((resolve) => releases.push(resolve));
            if (fail) throw new Error('Network unavailable');
            return { ok: true, json: async () => ({ stock: serverStock, cart_total: 500, cart_count: 5 }) };
        },
    });
    return {
        available, backorder, warning, requests, navigations, input,
        reloads: () => reloads,
        checkout: () => checkout.click({ preventDefault() {} }),
        release: () => releases.shift()(),
        pageshow: () => pageshow(),
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


test('immediate checkout saves the current quantity before navigating', async () => {
    const page = cart(3, { hold: true });
    page.change(6);
    const navigation = page.checkout();
    await Promise.resolve();
    assert.equal(page.requests.length, 1);
    assert.equal(page.requests[0].method, 'POST');
    assert.equal(page.requests[0].body.method, 'PATCH');
    assert.equal(page.requests[0].body.quantity, 6);
    assert.deepEqual(page.navigations, []);
    assert.equal(page.input.disabled, true);
    await page.checkout();
    assert.equal(page.requests.length, 1);
    page.release();
    await navigation;
    assert.deepEqual(page.navigations, ['/checkout']);
    page.pageshow();
    assert.equal(page.input.disabled, false);
});

test('checkout waits for an in-flight save and serializes the next quantity', async () => {
    const page = cart(3, { hold: true });
    page.change(2);
    const first = page.save(3);
    await Promise.resolve();
    page.change(4);
    const navigation = page.checkout();
    assert.equal(page.requests.length, 1);
    page.release();
    await first;
    await Promise.resolve();
    assert.equal(page.requests.length, 2);
    assert.equal(page.requests[1].body.quantity, 4);
    assert.deepEqual(page.navigations, []);
    page.release();
    await navigation;
    assert.deepEqual(page.navigations, ['/checkout']);
});

test('failed saves and invalid quantities do not proceed to checkout', async () => {
    const page = cart(3, { fail: true });
    page.change(4);
    await page.checkout();
    assert.equal(page.reloads(), 1);
    assert.deepEqual(page.navigations, []);
    const invalid = cart(3);
    invalid.change(101);
    await invalid.checkout();
    assert.equal(invalid.requests.length, 0);
    assert.deepEqual(invalid.navigations, []);
});
