// Функция обновления корзины, при нажатии на минус, плюс и т.д.
function updateBasket(action, productId) {
    fetch('../php-backend/update-cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action, productId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const container = document.querySelector(`.container-product[data-id='${productId}']`);
            const qtyText = container?.querySelector('p');

            if (!container || !qtyText) return;

            if (action === 'plus') {
                qtyText.textContent = parseInt(qtyText.textContent) + 1;
                updatePrice(container);
            } else if (action === 'minus') {
                const newQty = parseInt(qtyText.textContent) - 1;
                if (newQty <= 0) {
                    container.remove();
                    toggleFormAndMessage();
                } else {
                    qtyText.textContent = newQty;
                    updatePrice(container);
                }
            }
            updateTotalPrice();
        } else {
            alert(data.message || "Ошибка при обновлении корзины");
        }
    });
}
// Функция для удаления товара из корзины, отправка и получение сообщений с сервера.
function deleteFromBasket(productId) {
    fetch('../php-backend/update-cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete', productId: productId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const productBlock = document.querySelector(`.container-product[data-id='${productId}']`);
            if (productBlock) productBlock.remove();

            toggleFormAndMessage();
            updateTotalPrice();
        } else {
            alert(data.message || "Ошибка при удалении товара");
        }
    });
}

// Функция для обновления цены на продукт при его увеличении
function updatePrice(container) {
    const qty = parseInt(container.querySelector('p').textContent);
    const pricePerOne = parseFloat(container.dataset.price);
    const priceElem = container.querySelector('h2');
    priceElem.textContent = (qty * pricePerOne) + ' ₽';
}
// Функция для отключения видимости блока с товаром при его удалении.
function toggleFormAndMessage() {
    const products = document.querySelectorAll('.container-product');
    const form = document.querySelector('.form-container');
    const emptyMsg = document.getElementById('empty-basket-message');

    if (products.length === 0) {
        if (form) form.style.display = 'none';
        if (emptyMsg) emptyMsg.style.display = 'flex';
    } else {
        if (form) form.style.display = 'flex';
        if (emptyMsg) emptyMsg.style.display = 'none';
    }
}

// Функция для обновления итогового значения суммы корзины
function updateTotalPrice() {
    const totalPriceElem = document.querySelector('h2.price');
    const totalPriceInput = document.getElementById('total_price');

    let total = 0;
    document.querySelectorAll('.container-product').forEach(product => {
        const qty = parseInt(product.querySelector('p').textContent) || 0;
        const pricePerOne = parseFloat(product.dataset.price) || 0;
        total += qty * pricePerOne;
    });
    if (totalPriceElem) totalPriceElem.textContent = `${total} рублей`;
    if (totalPriceInput) totalPriceInput.value = total;
}

document.addEventListener('DOMContentLoaded', () => {
    toggleFormAndMessage();
    updateTotalPrice();

    document.addEventListener('click', e => {
        if (e.target.classList.contains('plus')) {
            const productId = e.target.dataset.productId;
            updateBasket('plus', productId);
        }

        if (e.target.classList.contains('minus')) {
            const productId = e.target.dataset.productId;
            updateBasket('minus', productId);
        }

        if (e.target.classList.contains('button-delete')) {
            const productId = e.target.dataset.productId;
            deleteFromBasket(productId);
        }
    });
});
