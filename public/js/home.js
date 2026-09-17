document.addEventListener('DOMContentLoaded', () => {
    const metrikaCounterId = Number(window.metrikaCounterId);
    const reachMetrikaGoal = (goal, params) => {
        if (! Number.isInteger(metrikaCounterId) || typeof window.ym !== 'function') return;

        window.ym(metrikaCounterId, 'reachGoal', goal, params);
    };

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');
        if (! link) return;

        const href = link.getAttribute('href')?.toLowerCase() ?? '';
        if (href.startsWith('tel:')) reachMetrikaGoal('contact_phone');
        if (href.startsWith('mailto:')) reachMetrikaGoal('contact_email');
    });

    document.querySelectorAll('[data-placeholder]').forEach((link) => {
        link.addEventListener('click', (event) => event.preventDefault());
    });

    const menuButton = document.querySelector('#pull');
    const mobileMenu = document.querySelector('#mobile-menu');
    const mobileMenuBackdrop = document.querySelector('[data-mobile-menu-close]');

    const closeMobileMenu = ({ restoreFocus = false } = {}) => {
        if (! mobileMenu?.classList.contains('is-open')) return;

        mobileMenu.classList.remove('is-open');
        mobileMenu.setAttribute('aria-hidden', 'true');
        mobileMenu.setAttribute('inert', '');
        menuButton?.setAttribute('aria-expanded', 'false');
        mobileMenuBackdrop?.classList.remove('is-open');
        document.body.classList.remove('mobile-navigation-open');

        if (restoreFocus) menuButton?.focus();
    };

    menuButton?.addEventListener('click', (event) => {
        event.preventDefault();
        const isOpen = mobileMenu.classList.toggle('is-open');
        menuButton.setAttribute('aria-expanded', String(isOpen));
        mobileMenu.setAttribute('aria-hidden', String(! isOpen));
        mobileMenu.toggleAttribute('inert', ! isOpen);
        mobileMenuBackdrop?.classList.toggle('is-open', isOpen);
        document.body.classList.toggle('mobile-navigation-open', isOpen);
    });

    mobileMenuBackdrop?.addEventListener('click', () => closeMobileMenu());
    window.matchMedia('(min-width: 768px)').addEventListener('change', (event) => {
        if (event.matches) closeMobileMenu();
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
            closeMobileMenu({ restoreFocus: true });
        }
    });

    if (modal?.classList.contains('is-open')) document.body.classList.add('callback-widget-open');

    document.querySelectorAll('[data-model-picker]').forEach((picker) => {
        const search = picker.querySelector('[data-model-search]');
        const list = picker.querySelector('[data-model-list]');
        const cards = [...picker.querySelectorAll('[data-model-card]')];
        const empty = picker.querySelector('[data-model-empty]');
        const mobileViewport = window.matchMedia('(max-width: 640px)');

        const updateListVisibility = () => {
            list.open = !mobileViewport.matches || Boolean(search?.value.trim());
        };

        updateListVisibility();
        mobileViewport.addEventListener('change', updateListVisibility);

        search?.addEventListener('input', () => {
            const query = search.value.trim().toLocaleLowerCase('ru-RU');
            let matches = 0;

            cards.forEach((card) => {
                const visible = !query || card.dataset.modelName.includes(query);
                card.hidden = !visible;
                matches += Number(visible);
            });

            updateListVisibility();
            empty.hidden = !query || matches > 0;
        });
    });

    document.querySelectorAll('[data-brand-picker]').forEach((picker) => {
        const search = picker.querySelector('[data-brand-search]');
        const cards = [...picker.querySelectorAll('[data-category-card]')];
        const empty = picker.querySelector('[data-brand-empty]');

        search?.addEventListener('input', () => {
            const query = search.value.trim().toLocaleLowerCase('ru-RU');
            let matches = 0;

            cards.forEach((card) => {
                const visible = !query || card.dataset.brandName.includes(query);
                card.hidden = !visible;
                matches += Number(visible);
            });

            empty.hidden = !query || matches > 0;
        });
    });

});
