import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import vm from 'node:vm';

const script = readFileSync(new URL('../../public/js/home.js', import.meta.url), 'utf8');

function callbackDialog() {
    const listeners = {};
    const document = {
        addEventListener(type, callback) {
            if (type === 'DOMContentLoaded') callback();
            else listeners[type] = callback;
        },
        body: { classList: { add() {}, remove() {} } },
    };
    const element = () => {
        const classes = new Set();
        return {
            dataset: {},
            tabIndex: 0,
            attributes: {},
            classList: {
                contains: (name) => classes.has(name),
                add: (name) => classes.add(name),
                remove: (name) => classes.delete(name),
            },
            setAttribute(name, value) { this.attributes[name] = value; },
            addEventListener(type, callback) { this[type] = callback; },
            getClientRects: () => [{}],
            closest: () => null,
            focus() { document.activeElement = this; },
        };
    };
    const close = element();
    const name = element();
    const submit = element();
    const honeypot = element();
    honeypot.tabIndex = -1;
    const modal = element();
    modal.querySelector = () => name;
    modal.querySelectorAll = () => [close, name, honeypot, submit];
    const trigger = element();
    const overlay = element();
    document.querySelector = (selector) => ({
        '[data-callback-modal]': modal,
        '[data-callback-overlay]': overlay,
        '[data-callback-close]': close,
    })[selector] ?? null;
    document.querySelectorAll = (selector) => selector === '[data-callback-open]' ? [trigger] : [];
    vm.runInNewContext(script, { document, window: { matchMedia: () => ({ addEventListener() {} }) } });
    return {
        document, modal, trigger, name, close, submit,
        key(key, shiftKey = false) {
            let prevented = false;
            listeners.keydown({ key, shiftKey, preventDefault() { prevented = true; } });
            return prevented;
        },
    };
}

test('callback dialog keeps keyboard focus inside and Escape restores its opener', () => {
    const page = callbackDialog();
    page.trigger.click();
    assert.equal(page.document.activeElement, page.name);
    assert.equal(page.modal.attributes['aria-hidden'], 'false');
    page.submit.focus();
    assert.equal(page.key('Tab'), true);
    assert.equal(page.document.activeElement, page.close);
    assert.equal(page.key('Tab', true), true);
    assert.equal(page.document.activeElement, page.submit);
    page.key('Escape');
    assert.equal(page.modal.attributes['aria-hidden'], 'true');
    assert.equal(page.document.activeElement, page.trigger);
    assert.equal(page.key('Tab'), false);
});

function brandPicker(mobile = false) {
    const media = { matches: mobile, addEventListener(type, callback) { this[type] = callback; } };
    const control = () => ({
        value: '', hidden: false, attributes: {},
        addEventListener(type, callback) { this[type] = callback; },
        setAttribute(name, value) { this.attributes[name] = value; },
    });
    const search = control();
    const toggle = control();
    const empty = control();
    const cards = Array.from({ length: 20 }, (_, index) => {
        const image = {
            dataset: { brandSrc: `/logos/${index}.webp` },
            src: 'placeholder', deferred: true,
            removeAttribute() { this.deferred = false; },
        };
        return {
            hidden: false, dataset: { brandName: `марка ${index}` }, image,
            querySelector() { return image.deferred ? image : null; },
        };
    });
    const picker = {
        querySelector: (selector) => ({ '[data-brand-search]': search, '[data-brand-toggle]': toggle, '[data-brand-empty]': empty })[selector],
        querySelectorAll: () => cards,
        scrollIntoView() {},
    };
    const document = {
        addEventListener(type, callback) { if (type === 'DOMContentLoaded') callback(); },
        querySelector: () => null,
        querySelectorAll: (selector) => selector === '[data-brand-picker]' ? [picker] : [],
    };
    vm.runInNewContext(script, { document, window: { matchMedia: () => media } });
    return { cards, search, toggle, empty, media };
}

test('brand picker loads only visible logos and loads a previously hidden search result', () => {
    const page = brandPicker();
    assert.equal(page.cards.filter(card => !card.hidden).length, 12);
    assert.equal(page.cards.filter(card => card.image.src !== 'placeholder').length, 12);
    page.search.value = 'МАРКА 19';
    page.search.input();
    assert.equal(page.cards.filter(card => !card.hidden).length, 1);
    assert.equal(page.cards[19].image.src, '/logos/19.webp');
    assert.equal(page.cards[18].image.src, 'placeholder');
    assert.equal(page.empty.hidden, true);
    assert.equal(page.toggle.hidden, true);
    page.search.value = 'нет такой марки';
    page.search.input();
    assert.equal(page.empty.hidden, false);
});

test('brand picker reveals logos on expand and respects mobile and desktop limits', () => {
    const page = brandPicker(true);
    assert.equal(page.cards.filter(card => !card.hidden).length, 4);
    assert.equal(page.cards.filter(card => card.image.src !== 'placeholder').length, 4);
    page.media.matches = false;
    page.media.change();
    assert.equal(page.cards.filter(card => card.image.src !== 'placeholder').length, 12);
    page.toggle.click();
    assert.equal(page.cards.filter(card => !card.hidden).length, 20);
    assert.equal(page.cards.filter(card => card.image.src !== 'placeholder').length, 20);
    assert.equal(page.toggle.attributes['aria-expanded'], 'true');
    page.toggle.click();
    assert.equal(page.cards.filter(card => !card.hidden).length, 12);
    assert.equal(page.toggle.attributes['aria-expanded'], 'false');
});
