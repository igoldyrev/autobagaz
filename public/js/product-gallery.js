document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.querySelector('#product-main-image');
    const thumbnails = document.querySelectorAll('[data-product-thumbnail]');

    if (!mainImage || thumbnails.length === 0) {
        return;
    }

    thumbnails.forEach((thumbnail) => {
        thumbnail.addEventListener('click', () => {
            mainImage.src = thumbnail.dataset.imageSrc;
            mainImage.alt = thumbnail.dataset.imageAlt;

            thumbnails.forEach((item) => {
                const isActive = item === thumbnail;
                item.classList.toggle('product-gallery__thumbnail--active', isActive);
                item.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
        });
    });
});
