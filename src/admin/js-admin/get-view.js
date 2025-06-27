document.querySelectorAll('.btn-show-table').forEach(button => {
    button.addEventListener('click', async () => {
        const rawView = button.dataset.modal;
        const view = rawView.replace('_', '');

        try {
            const res = await fetch(`php-backend/get-view.php?view=${view}`);
            const data = await res.json();

            if (!Array.isArray(data) || data.length === 0) {
                alert('Нет данных или ошибка в представлении');
                return;
            }

            const lines = data.map((row, i) => {
                return `[${i + 1}] ` + Object.entries(row)
                    .map(([key, value]) => `${key}: ${value}`).join(', ');
            });

            alert(lines.join('\n'));
        } catch (err) {
            console.error(err);
            alert('Ошибка при загрузке данных');
        }
    });
});
