document.addEventListener('DOMContentLoaded', () => {
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
