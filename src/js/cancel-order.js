document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-cancel-order').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const button = e.currentTarget;
            if (button.disabled) return;

            const orderId = button.dataset.orderId;
            if (!orderId) return;

            if (!confirm('Вы уверены, что хотите отменить заказ?')) return;

            try {
                const response = await fetch('php-backend/cancel-order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ orderId })
                });
                const data = await response.json();

                if (data.success) {
                    const statusP = button.closest('.block-order').querySelector('.block-left-up p');
                    statusP.textContent = 'Статус: Отменён';
                    button.disabled = true;
                    button.style.opacity = '0.5';
                    button.style.cursor = 'default';
                } else {
                    alert(data.message || 'Ошибка при отмене заказа');
                }
            } catch (err) {
                alert('Ошибка сети');
            }
        });
    });
});