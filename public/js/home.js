document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-placeholder]').forEach((link) => {
        link.addEventListener('click', (event) => event.preventDefault());
    });

    const menuButton = document.querySelector('#pull');
    const mobileMenu = document.querySelector('#mobile-menu');

    menuButton?.addEventListener('click', (event) => {
        event.preventDefault();
        const isOpen = mobileMenu.classList.toggle('is-open');
        menuButton.setAttribute('aria-expanded', String(isOpen));
    });

    const modal = document.querySelector('.modal-call');
    const overlay = document.querySelector('.modal-call__overlay');
    const openButton = document.querySelector('.modal-call__button');
    const closeButton = document.querySelector('.modal-call__close');
    const callbackForm = document.querySelector('.js-modal-call-form');

    const closeModal = () => {
        modal?.classList.remove('modal-call--active');
        overlay?.classList.remove('modal-call__overlay--active');
    };

    openButton?.addEventListener('click', () => {
        modal?.classList.add('modal-call--active');
        overlay?.classList.add('modal-call__overlay--active');
    });

    closeButton?.addEventListener('click', closeModal);
    overlay?.addEventListener('click', (event) => {
        if (event.target === overlay) {
            closeModal();
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    callbackForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        callbackForm.querySelector('.form-placeholder')?.removeAttribute('hidden');
    });

    const topHeader = document.querySelector('.top-header');
    const topHeaderInner = document.querySelector('.top-header__inner');
    const topHeaderLabel = document.querySelector('.top-header__address');
    const shopAddress = document.querySelector('.top-header__shop-address');
    const lastShop = document.querySelector('.top-header__shop-last');

    window.addEventListener('scroll', () => {
        const isCompact = window.scrollY > 50;

        topHeader?.classList.toggle('top-header__height-30', isCompact);
        topHeaderInner?.classList.toggle('top-header__center', isCompact);
        topHeaderLabel?.classList.toggle('top-header__hidden', isCompact);
        shopAddress?.classList.toggle('top-header__hidden', isCompact);
        lastShop?.classList.toggle('top-header__shop-last-child', !isCompact);
    });
});
