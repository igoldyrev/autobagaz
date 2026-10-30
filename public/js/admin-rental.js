(() => {
    const type = document.querySelector('[data-rental-deposit-type]');
    if (!type) return;

    const fields = type.form.querySelectorAll('[data-rental-deposit-field]');
    const updateDepositFields = () => {
        fields.forEach((field) => {
            const active = field.dataset.rentalDepositField === type.value;
            field.hidden = !active;
            field.querySelectorAll('input').forEach((input) => {
                input.disabled = !active;
                input.required = active;
            });
        });
    };

    type.addEventListener('change', updateDepositFields);
    window.addEventListener('pageshow', updateDepositFields);
    updateDepositFields();
})();
