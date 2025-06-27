document.addEventListener('DOMContentLoaded', () => {
    // Общие элементы
    const allContainers = document.querySelectorAll('.container-list-column');
    const tableButtons = document.querySelectorAll('[data-modal]');

    // Функция скрытия всех контейнеров
    const hideAllContainers = () => {
        allContainers.forEach(container => {
            if (container) container.style.display = 'none';
        });
    };

    // Функция загрузки данных с сервера
    const loadData = async (action, container, renderCallback) => {
        if (!container) {
            console.error(`Контейнер для ${action} не найден`);
            return;
        }

        try {
            const response = await fetch(`php-backend/data-handler.php?action=${action}`);
            const data = await response.json();

            if (!Array.isArray(data)) {
                throw new Error('Некорректный формат данных');
            }

            container.innerHTML = '';
            hideAllContainers();
            container.style.display = 'flex';
            renderCallback(data, container);
        } catch (error) {
            alert(`Ошибка загрузки ${action}: ${error.message}`);
            console.error(error);
        }
    };

    // Функция удаления элемента из БД, а именно обращение к серверу с этим запросом
    const deleteItem = async (type, id, action, container, renderCallback) => {
        if (!confirm('Вы уверены, что хотите удалить эту запись?')) return;

        try {
            const idParam = type === 'product_ingredient' ? 'id_product_ingredient' : `id_${type}`;

            const response = await fetch('php-backend/delete-tables.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    type: type,
                    [idParam]: id
                })
            });

            // Проверка статуса ответа
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error ${response.status}: ${errorText}`);
            }

            const result = await response.json();

            if (result.success) {
                alert('Запись успешно удалена!');
                loadData(action, container, renderCallback);
            } else {
                throw new Error(result.error || 'Ошибка сервера');
            }
        } catch (error) {
            console.error('Ошибка удаления:', error);
            alert(`Ошибка удаления: ${error.message}`);
        }
    };

    // Конфигурация для всех таблиц
    const tablesConfig = {
        products: {
            container: document.querySelector('.products'),
            type: 'product',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_product}</h1>
                        <h1>${item.name}</h1>
                        <h1>Цена: ${item.price} ₽</h1>
                        <button class="btn-delete" data-id="${item.id_product}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        users: {
            container: document.querySelector('.users'),
            type: 'user',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_user}</h1>
                        <h1>${item.full_name || item.name + ' ' + item.surname}</h1>
                        <h1>${item.email}</h1>
                        <button class="btn-delete" data-id="${item.id_user}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        orders: {
            container: document.querySelector('.orders'),
            type: 'order',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_order}</h1>
                        <h1>Пользователь: ${item.id_user}</h1>
                        <h1>Адрес: ${item.address}</h1>
                        <h1>Сумма: ${item.total_price} ₽</h1>
                        <button class="btn-delete" data-id="${item.id_order}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        order_items: {
            container: document.querySelector('.order_items'),
            type: 'order_item',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_order_item}</h1>
                        <h1>Заказ №${item.id_order}</h1>
                        <h1>Изделие №${item.id_product}</h1>
                        <h1>Кол-во: ${item.quantity}</h1>
                        <button class="btn-delete" data-id="${item.id_order_item}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        basket: {
            container: document.querySelector('.basket'),
            type: 'basket',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_basket}</h1>
                        <h1>Пользователь: ${item.id_user}</h1>
                        <h1>Товар: ${item.id_product}</h1>
                        <h1>Кол-во: ${item.quantity}</h1>
                        <button class="btn-delete" data-id="${item.id_basket}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        feedback: {
            container: document.querySelector('.feedback'),
            type: 'feedback',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id}</h1>
                        <h1>${item.first_name} ${item.last_name}</h1>
                        <h1>Email: ${item.email}</h1>
                        <button class="btn-delete" data-id="${item.id}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        ingredients: {
            container: document.querySelector('.ingredients'),
            type: 'ingredient',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_ingredient}</h1>
                        <h1>${item.name}</h1>
                        <h1>Тип: ${item.type}</h1>
                        <button class="btn-delete" data-id="${item.id_ingredient}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        product_ingredients: {
            container: document.querySelector('.product_ingredients'),
            type: 'product_ingredient',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                <h1>ID = ${item.id_product_ingredients}</h1>
                <h1>Изделие: ${item.product_name || item.id_product}</h1>
                <h1>Ингредиент: ${item.ingredient_name || item.id_ingredient}</h1>
                <button class="btn-delete" data-id="${item.id_product_ingredients}">Удалить</button>
            `;
                    container.appendChild(block);
                });
            }
        },
        status: {
            container: document.querySelector('.status'),
            type: 'status',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_status}</h1>
                        <h1>${item.name}</h1>
                        <button class="btn-delete" data-id="${item.id_status}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        suppliers: {
            container: document.querySelector('.suppliers'),
            type: 'supplier',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_supplier}</h1>
                        <h1>${item.name}</h1>
                        <button class="btn-delete" data-id="${item.id_supplier}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        supplier_products: {
            container: document.querySelector('.supplier_products'),
            type: 'supplier_product',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_supplier_product}</h1>
                        <h1>Поставщик: ${item.supplier_name || item.id_supplier}</h1>
                        <h1>Изделие: ${item.product_name || item.id_product}</h1>
                        <button class="btn-delete" data-id="${item.id_supplier_product}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        type_product: {
            container: document.querySelector('.type_product'),
            type: 'type_product',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_type_product}</h1>
                        <h1>${item.name}</h1>
                        <button class="btn-delete" data-id="${item.id_type_product}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        },
        type_user: {
            container: document.querySelector('.type_user'),
            type: 'type_user',
            render: (data, container) => {
                data.forEach(item => {
                    const block = document.createElement('div');
                    block.className = 'block-table';
                    block.innerHTML = `
                        <h1>ID = ${item.id_type_user}</h1>
                        <h1>${item.name}</h1>
                        <button class="btn-delete" data-id="${item.id_type_user}">Удалить</button>
                    `;
                    container.appendChild(block);
                });
            }
        }
    };

    // Инициализация кнопок таблиц
    tableButtons.forEach(button => {
        const action = button.dataset.modal;
        const config = tablesConfig[action];

        if (!config || !config.container) {
            console.error(`Конфигурация для ${action} не найдена`);
            return;
        }

        button.addEventListener('click', () => {
            loadData(action, config.container, config.render);
        });
    });

    // Глобальный обработчик удаления
    document.addEventListener('click', async (e) => {
        if (!e.target.classList.contains('btn-delete')) return;

        const button = e.target;
        const block = button.closest('.block-table');
        if (!block) return;

        const action = Object.keys(tablesConfig).find(key =>
            block.parentElement.classList.contains(key) ||
            block.parentElement.classList.contains(`${key}s`)
        );

        if (!action) {
            console.error('Не удалось определить действие для удаления');
            return;
        }

        const config = tablesConfig[action];
        const id = button.dataset.id;

        await deleteItem(config.type, id, action, config.container, config.render);
    });
});

document.getElementById('btn-clear').addEventListener('click', () => {
    // Скрытие всех контейнеров и их очистка
    document.querySelectorAll('.container-list-column').forEach(container => {
        container.style.display = 'none';
        container.innerHTML = '';
    });

    // Прокручивание страницы в самый верх
    window.scrollTo({ top: 0, behavior: 'smooth' });
});