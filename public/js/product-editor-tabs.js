document.querySelectorAll('[data-product-editor-tabs]').forEach((editor) => {
    const controls = Array.from(editor.querySelectorAll('[role="tab"]'));
    const panels = Array.from(editor.querySelectorAll('[role="tabpanel"]'));

    const activate = (control) => {
        controls.forEach((item) => {
            const selected = item === control;
            item.setAttribute('aria-selected', String(selected));
            item.tabIndex = selected ? 0 : -1;
            const panel = editor.querySelector(`#${item.getAttribute('aria-controls')}`);
            if (panel) panel.hidden = !selected;
        });
    };

    controls.forEach((control, index) => {
        control.addEventListener('click', () => activate(control));
        control.addEventListener('keydown', (event) => {
            if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
            event.preventDefault();
            const next = event.key === 'Home' ? 0 : event.key === 'End' ? controls.length - 1 : (index + (event.key === 'ArrowRight' ? 1 : -1) + controls.length) % controls.length;
            controls[next].focus();
            activate(controls[next]);
        });
    });

    const panelWithError = panels.find((panel) => panel.querySelector('.field__error'));
    if (panelWithError) {
        const control = controls.find((item) => item.getAttribute('aria-controls') === panelWithError.id);
        if (control) activate(control);
    }
});
