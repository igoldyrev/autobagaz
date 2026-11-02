document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.querySelector('#product-main-image');
    const originalLink = document.querySelector('#product-original-link');
    const thumbnails = document.querySelectorAll('[data-product-thumbnail]');

    if (!mainImage || thumbnails.length === 0) {
        return;
    }

    thumbnails.forEach((thumbnail) => {
        thumbnail.addEventListener('click', () => {
            mainImage.srcset = thumbnail.dataset.imageSrcset || '';
            mainImage.src = thumbnail.dataset.imageSrc;
            ['width', 'height'].forEach((name) => {
                const value = thumbnail.dataset[`image${name[0].toUpperCase()}${name.slice(1)}`];
                if (value) {
                    mainImage.setAttribute(name, value);
                } else {
                    mainImage.removeAttribute(name);
                }
            });
            mainImage.alt = thumbnail.dataset.imageAlt;
            if (originalLink) {
                originalLink.href = thumbnail.dataset.imageOriginal || thumbnail.dataset.imageSrc;
            }

            thumbnails.forEach((item) => {
                const isActive = item === thumbnail;
                item.classList.toggle('product-gallery__thumbnail--active', isActive);
                item.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
        });
    });
});
