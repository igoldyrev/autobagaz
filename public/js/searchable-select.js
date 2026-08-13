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

        const filterOptions = () => {
            const query = normalize(searchInput.value);
            let visibleCount = 0;

            Array.from(select.children).forEach((child) => {
                if (child.tagName === 'OPTGROUP') {
                    const groupMatches = normalize(child.label).includes(query);
                    let visibleInGroup = 0;

                    Array.from(child.children).forEach((option) => {
                        const matches = query === '' || groupMatches || normalize(option.textContent).includes(query);
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
                    const matches = query === '' || normalize(child.textContent).includes(query);
                    child.hidden = !matches;
                    child.disabled = !matches;

                    if (matches) {
                        visibleCount += 1;
                    }
                }
            });

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
