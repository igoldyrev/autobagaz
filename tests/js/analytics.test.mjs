import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import vm from 'node:vm';

const source = readFileSync(new URL('../../public/js/analytics.js', import.meta.url), 'utf8');
const cookieName = 'autobagaz_analytics_consent';
const timestamp = 1800000000;
const choice = (value, time = timestamp, version = 'v1') => `${cookieName}=${encodeURIComponent(`${version}:${value}:${time}`)}`;

function browser({ cookie = '', goal = null, params = null, blocked = false } = {}) {
    let now = timestamp * 1000;
    const jar = new Map(cookie.split('; ').filter(Boolean).map((entry) => entry.split('=')));
    const elements = new Map();
    const calls = [];
    const scripts = [];
    const listeners = {};
    let reloads = 0;
    let fieldProtected = false;
    for (const name of ['cookie-notice', 'analytics-status', 'analytics-close', 'analytics-settings', 'analytics-accept', 'analytics-reject']) {
        elements.set(`[data-${name}]`, { hidden: true, textContent: '', listeners: {}, addEventListener(type, callback) { this.listeners[type] = callback; } });
    }
    const document = {
        get cookie() { return [...jar].map(([key, value]) => `${key}=${value}`).join('; '); },
        set cookie(value) {
            if (blocked) return;
            const [pair] = value.split(';');
            const [key, data] = pair.split('=');
            if (value.includes('Max-Age=0;')) jar.delete(key);
            else jar.set(key, data);
        },
        getElementById: () => ({ textContent: JSON.stringify({ counterId: 123, goal, params }) }),
        querySelector: (selector) => elements.get(selector),
        querySelectorAll: (selector) => selector === 'input, textarea, select'
            ? [{ classList: { add(name) { fieldProtected = name === 'ym-disable-keys'; } } }]
            : selector === '[data-analytics-settings]' ? [elements.get(selector)] : [],
        createElement: () => ({ remove() {} }),
        head: { append(script) { scripts.push(script); } }, body: {},
    };
    const window = {
        location: { protocol: 'https:', hostname: 'new.autobagaz.ru', reload() { reloads++; } },
        localStorage: { setItem() {} },
        addEventListener: (name, callback) => { listeners[name] = callback; },
        setInterval(callback) { listeners.interval = callback; },
    };
    vm.runInNewContext(source, {
        window, document, MutationObserver: class { observe() {} }, Date: { now: () => now },
    });
    return {
        calls, scripts, window, jar,
        protected: () => fieldProtected,
        notice: elements.get('[data-cookie-notice]'),
        reloads: () => reloads,
        click(name) { elements.get(`[data-analytics-${name}]`).listeners.click(); },
        load() { window.ym = (...args) => calls.push(args); scripts.at(-1).onload(); },
        goal(name, parameters) { window.autobagazAnalytics.reachGoal(name, parameters); },
        tick(seconds) { now += seconds * 1000; listeners.interval(); },
        external(value) {
            jar.set(cookieName, encodeURIComponent(`v1:${value}:${timestamp}`));
            listeners.storage({ key: cookieName });
        },
    };
}

for (const cookie of ['', 'autobagaz_cookie_notice=accepted', choice('rejected'), choice('accepted', timestamp, 'old'), choice('accepted', timestamp - 30 * 86400), `${cookieName}=%E0%A4%A`]) {
    test(`no counter request or goal without current consent (${cookie})`, () => {
        const page = browser({ cookie, goal: 'callback_sent' });
        page.goal('contact_phone');
        assert.equal(page.scripts.length, 0);
        assert.equal(page.calls.length, 0);
        assert.equal(page.window.disableYaCounter123, true);
    });
}

test('acceptance loads once, protects fields, starts Webvisor and skips historical goals', () => {
    const page = browser({ goal: 'order_created', params: { order_price: 100, phone: 'secret' } });
    page.goal('contact_phone');
    page.click('accept');
    page.click('accept');
    assert.equal(page.scripts.length, 1);
    assert.equal(page.calls.length, 0);
    assert.equal(page.protected(), true);
    page.goal('contact_email');
    page.load();
    assert.equal(page.calls[0][1], 'init');
    assert.equal(page.calls[0][2].webvisor, true);
    assert.deepEqual(page.calls.filter((event) => event[1] === 'reachGoal').map((event) => event[2]), ['contact_email']);
    assert.equal(page.notice.hidden, true);
});

test('previous consent sends current success goal with whitelisted parameters', () => {
    const page = browser({ cookie: choice('accepted'), goal: 'order_created', params: { order_price: 100, phone: 'secret', currency: 'USD' } });
    page.load();
    const event = page.calls.find((entry) => entry[1] === 'reachGoal');
    assert.equal(JSON.stringify(event[3]), '{"order_price":100,"currency":"RUB"}');
    page.goal('unexpected_goal', { phone: 'secret' });
    assert.equal(page.calls.length, 2);
});

test('rejection is remembered, settings can reopen, and rejection never loads a counter', () => {
    const page = browser();
    page.click('reject');
    assert.equal(page.notice.hidden, true);
    assert.equal(page.scripts.length, 0);
    assert.match(decodeURIComponent(page.jar.get(cookieName)), /^v1:rejected:/);
    page.click('settings');
    assert.equal(page.notice.hidden, false);
});

test('withdrawal destroys recording, clears first-party analytics cookies and blocks further goals', () => {
    const page = browser({ cookie: `${choice('accepted')}; _ym_uid=secret` });
    page.load();
    page.click('settings');
    page.click('reject');
    page.goal('callback_sent');
    assert.equal(page.window.disableYaCounter123, true);
    assert.equal(page.jar.has('_ym_uid'), false);
    assert.equal(page.calls.at(-1)[1], 'destruct');
    assert.equal(page.reloads(), 1);
    assert.equal(page.calls.filter((entry) => entry[1] === 'reachGoal').length, 0);
});

test('withdrawal during load prevents initialization and discards queued events', () => {
    const page = browser();
    page.click('accept');
    page.goal('contact_phone');
    page.click('reject');
    page.load();
    assert.equal(page.calls.length, 0);
    assert.equal(page.reloads(), 1);
});

for (const action of ['expiry', 'other-tab']) {
    test(`${action} stops recording in an already open page`, () => {
        const page = browser({ cookie: choice('accepted') });
        page.load();
        if (action === 'expiry') page.tick(30 * 86400);
        else page.external('rejected');
        assert.equal(page.window.disableYaCounter123, true);
        assert.equal(page.reloads(), 1);
    });
}

test('blocked cookies fail closed without loading analytics', () => {
    const page = browser({ blocked: true });
    page.click('accept');
    assert.equal(page.scripts.length, 0);
    assert.equal(page.notice.hidden, false);
});
