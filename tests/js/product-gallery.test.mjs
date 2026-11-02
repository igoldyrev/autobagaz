import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import test from 'node:test';
import vm from 'node:vm';

const script = readFileSync(new URL('../../public/js/product-gallery.js', import.meta.url), 'utf8');

test('gallery switches responsive sources and clears them when the next image has no variants', () => {
    const attributes = {};
    const originalLink = {};
    const main = { setAttribute: (key, value) => { attributes[key] = value; }, removeAttribute: (key) => { delete attributes[key]; } };
    const thumbs = [
        { imageSrc: '/large.webp', imageOriginal: '/full.png', imageSrcset: '/small.webp 480w, /large.webp 960w', imageWidth: '960', imageHeight: '600', imageAlt: 'First' },
        { imageSrc: '/original.jpg', imageAlt: 'Second' },
    ].map((dataset) => ({ dataset, classList: { toggle() {} }, setAttribute() {}, addEventListener(_, callback) { this.click = callback; } }));
    vm.runInNewContext(script, { document: { addEventListener: (_, callback) => callback(), querySelector: (selector) => selector === '#product-original-link' ? originalLink : main, querySelectorAll: () => thumbs } });
    thumbs[0].click();
    assert.equal(main.src, '/large.webp');
    assert.equal(originalLink.href, '/full.png');
    assert.equal(main.srcset, '/small.webp 480w, /large.webp 960w');
    assert.deepEqual(attributes, { width: '960', height: '600' });
    thumbs[1].click();
    assert.equal(main.src, '/original.jpg');
    assert.equal(originalLink.href, '/original.jpg');
    assert.equal(main.srcset, '');
    assert.equal(main.alt, 'Second');
    assert.deepEqual(attributes, {});
});
