document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.checkout-form');
    const submitButton = form?.querySelector('button[type="submit"]');
    let submitting = false;

    form?.addEventListener('submit', (event) => {
        if (submitting) {
            event.preventDefault();
            return;
        }

        submitting = true;
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Оформляем заказ…';
        }
    });

    window.addEventListener('pageshow', () => {
        submitting = false;
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Оформить заказ';
        }
    });

    const address = document.querySelector('[data-delivery-address]');
    const options = document.querySelectorAll('input[name="delivery_method"]');

    const updateAddressVisibility = () => {
        const needsAddress = document.querySelector('input[name="delivery_method"]:checked')?.value === 'delivery';
        address.hidden = !needsAddress;
        address.querySelector('input').required = needsAddress;
    };

    options.forEach((option) => option.addEventListener('change', updateAddressVisibility));
    updateAddressVisibility();
});
