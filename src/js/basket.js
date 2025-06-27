function updateBasket(action, productId) {
    fetch('../php-backend/update-cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: action, productId: productId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const buttonBlock = document.querySelector(`.block-product-button[data-id='${productId}']`);
            const addBlock = document.querySelector(`.block-add-button[data-id='${productId}']`);
            const qtyText = addBlock?.querySelector('p');

            if (action === 'add') {
                if (buttonBlock) buttonBlock.style.display = 'none';
                if (addBlock) {
                    addBlock.style.display = 'flex';
                    if (qtyText) qtyText.textContent = '1';
                }
            } else if (action === 'plus' && qtyText) {
                qtyText.textContent = parseInt(qtyText.textContent) + 1;
            } else if (action === 'minus' && qtyText) {
                const newQty = parseInt(qtyText.textContent) - 1;
                if (newQty <= 0) {
                    if (addBlock) addBlock.style.display = 'none';
                    if (buttonBlock) buttonBlock.style.display = 'block';
                } else {
                    qtyText.textContent = newQty;
                }
            }
        } else {
            alert(data.message || "Ошибка обработки корзины");
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.body.addEventListener('click', (event) => {
        const target = event.target;

        if (target.classList.contains('button-product')) {
            const productId = target.dataset.productId;
            if (!productId) return;

            fetch('../php-backend/check-auth.php')
                .then(res => res.json())
                .then(data => {
                    if (data.authorized) {
                        updateBasket('add', productId);
                    } else {
                        openModal('modal-register');
                    }
                });
        }

        if (target.classList.contains('plus')) {
            const productId = target.dataset.productId;
            if (productId) updateBasket('plus', productId);
        }

        if (target.classList.contains('minus')) {
            const productId = target.dataset.productId;
            if (productId) updateBasket('minus', productId);
        }
    });
});
