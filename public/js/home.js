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

});
