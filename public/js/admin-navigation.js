(() => {
    const navigation = document.querySelector('.admin-section-nav');
    if (!navigation) return;

    const groups = [...navigation.querySelectorAll('details')];
    const closeOthers = (current) => {
        groups.forEach((group) => {
            if (group !== current) group.open = false;
        });
    };

    navigation.addEventListener('click', (event) => {
        const summary = event.target.closest('summary');
        if (summary && navigation.contains(summary)) closeOthers(summary.parentElement);
    });
    document.addEventListener('click', (event) => {
        if (!navigation.contains(event.target)) closeOthers(null);
    });
    navigation.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            const open = groups.find((group) => group.open);
            if (open) {
                open.open = false;
                open.querySelector('summary').focus();
                event.preventDefault();
            }
        }
    });
    navigation.addEventListener('focusout', (event) => {
        if (event.relatedTarget && !navigation.contains(event.relatedTarget)) closeOthers(null);
    });
})();
