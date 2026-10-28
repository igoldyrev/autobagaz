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
