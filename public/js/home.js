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

    const modal = document.querySelector('[data-callback-modal]');
    const overlay = document.querySelector('[data-callback-overlay]');
    const openButton = document.querySelector('[data-callback-open]');
    const closeButton = document.querySelector('[data-callback-close]');

    const closeModal = () => {
        modal?.classList.remove('is-open');
        modal?.setAttribute('aria-hidden', 'true');
        overlay?.classList.remove('is-open');
        document.body.classList.remove('callback-widget-open');
    };

    openButton?.addEventListener('click', () => {
        modal?.classList.add('is-open');
        modal?.setAttribute('aria-hidden', 'false');
        overlay?.classList.add('is-open');
        document.body.classList.add('callback-widget-open');
        modal?.querySelector('input[name="name"]')?.focus();
    });

    closeButton?.addEventListener('click', closeModal);
    overlay?.addEventListener('click', (event) => {
        if (event.target === overlay) closeModal();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    if (modal?.classList.contains('is-open')) document.body.classList.add('callback-widget-open');

});
