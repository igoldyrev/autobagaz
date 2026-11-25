document.addEventListener('DOMContentLoaded', () => {
    const normalize = (value) => value
        .toLocaleLowerCase('ru-RU')
        .replaceAll('ё', 'е')
        .trim();

    document.querySelectorAll('[data-select-search]').forEach((searchInput) => {
        const selectId = searchInput.dataset.selectSearch;
        const select = document.getElementById(selectId);
        const result = document.querySelector(`[data-select-search-result="${selectId}"]`);

        if (!select) {
            return;
        }

        const options = Array.from(select.options);
        const searchByYear = searchInput.hasAttribute('data-select-search-by-year');

        const filterOptions = () => {
            const query = normalize(searchInput.value);
            const terms = query.split(/\s+/);
            let visibleCount = 0;

            const matchesOption = (option, groupLabel = '') => {
                const label = normalize(option.textContent);
                if (!searchByYear) {
                    return groupLabel.includes(query) || label.includes(query);
                }

                const name = normalize(option.dataset.vehicleName ?? '');
                const from = Number(option.dataset.yearFrom);
                const to = Number(option.dataset.yearTo);
                return terms.every((term) => {
                    if (/^\d{4}$/.test(term) && (from || to) && !name.includes(term)) {
                        const year = Number(term);
                        return (!from || year >= from) && (!to || year <= to);
                    }

                    return name.includes(term) || label.includes(term) || groupLabel.includes(term);
                });
            };

            Array.from(select.children).forEach((child) => {
                if (child.tagName === 'OPTGROUP') {
                    const groupLabel = normalize(child.label);
                    let visibleInGroup = 0;

                    Array.from(child.children).forEach((option) => {
                        const matches = matchesOption(option, groupLabel);
                        option.hidden = !matches;
                        option.disabled = !matches;

                        if (matches) {
                            visibleInGroup += 1;
                            visibleCount += 1;
                        }
                    });

                    child.hidden = visibleInGroup === 0;

                    return;
                }

                if (child.tagName === 'OPTION') {
                    if (searchByYear && child.value === '') {
                        return;
                    }
                    const matches = matchesOption(child);
                    child.hidden = !matches;
                    child.disabled = !matches;

                    if (matches) {
                        visibleCount += 1;
                    }
                }
            });

            if (searchByYear && select.selectedOptions[0]?.disabled) {
                select.value = '';
            }

            if (result) {
                result.textContent = query === ''
                    ? ''
                    : visibleCount > 0
                        ? `Найдено: ${visibleCount}`
                        : 'Ничего не найдено';
            }
        };

        searchInput.addEventListener('input', filterOptions);

        select.form?.addEventListener('submit', () => {
            options.forEach((option) => {
                option.disabled = false;
            });
        });
    });
});
