document.addEventListener('DOMContentLoaded', () => {
    const formatPrice = (value) => `${new Intl.NumberFormat('ru-RU', {
        maximumFractionDigits: 0,
    }).format(value)} ₽`;

    const totalElement = document.querySelector('[data-cart-total]');
    const cartCountElement = document.querySelector('.header__cart-count');

    const recalculate = () => {
        let total = 0;

        document.querySelectorAll('[data-cart-item]').forEach((item) => {
            const quantity = Number(item.querySelector('[data-cart-quantity]').value);
            const lineTotal = Number(item.dataset.unitPrice) * quantity;
            item.querySelector('[data-cart-line-total]').textContent = formatPrice(lineTotal);
            total += lineTotal;
        });

        totalElement.textContent = formatPrice(total);
    };

    document.querySelectorAll('[data-cart-quantity-form]').forEach((form) => {
        let timer;
        const input = form.querySelector('[data-cart-quantity]');

        form.addEventListener('submit', (event) => event.preventDefault());
        input.addEventListener('input', () => {
            const quantity = Number(input.value);
            if (!Number.isInteger(quantity) || quantity < 1 || quantity > 100) {
                return;
            }

            recalculate();
            clearTimeout(timer);
            timer = setTimeout(async () => {
                const response = await fetch(form.action, {
                    method: 'PATCH',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
                    },
                    body: new FormData(form),
                });

                if (!response.ok) {
                    window.location.reload();
                    return;
                }

                const cart = await response.json();
                totalElement.textContent = formatPrice(cart.cart_total);
                cartCountElement.textContent = cart.cart_count;
            }, 350);
        });
    });
});
