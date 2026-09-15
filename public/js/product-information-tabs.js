document.querySelectorAll('[data-product-information-tabs]').forEach((tabs) => {
    const controls = Array.from(tabs.querySelectorAll('[role="tab"]'));
    const panels = Array.from(tabs.querySelectorAll('[role="tabpanel"]'));

    const select = (control) => {
        controls.forEach((item) => {
            const active = item === control;
            item.setAttribute('aria-selected', String(active));
            item.tabIndex = active ? 0 : -1;
        });
        panels.forEach((panel) => {
            panel.hidden = panel.id !== control.getAttribute('aria-controls');
        });
    };

    controls.forEach((control, index) => {
        control.addEventListener('click', () => select(control));
        control.addEventListener('keydown', (event) => {
            if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) {
                return;
            }

            event.preventDefault();
            const nextIndex = event.key === 'Home' ? 0
                : event.key === 'End' ? controls.length - 1
                    : (index + (event.key === 'ArrowRight' ? 1 : controls.length - 1)) % controls.length;
            controls[nextIndex].focus();
            select(controls[nextIndex]);
        });
    });
});
