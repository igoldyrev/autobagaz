document.querySelectorAll('[data-installation-kit]').forEach((form) => {
    const checkbox = form.querySelector('[data-installation-service]');
    const total = form.querySelector('[data-installation-kit-total]');

    if (!checkbox || !total) {
        return;
    }

    const productsTotal = Number(form.dataset.kitProductsTotal);
    const servicePrice = Number(checkbox.dataset.installationServicePrice);
    const formatPrice = (price) => new Intl.NumberFormat('ru-RU', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(price)+' ₽';

    checkbox.addEventListener('change', () => {
        total.textContent = 'Итого: '+formatPrice(productsTotal + (checkbox.checked ? servicePrice : 0));
    });
});
