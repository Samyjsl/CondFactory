document.addEventListener('DOMContentLoaded', () => {
    // Общие элементы и утилиты
    const allContainers = document.querySelectorAll('.container-list-column');
    const allModals = document.querySelectorAll('.container-form');

    // Функция скрытия всех контейнеров, кроме указанного
    const hideAllContainers = (exceptClass = null) => {
        allContainers.forEach(container => {
            if (container) { // Проверка на существование элемента
                if (!exceptClass || !container.classList.contains(exceptClass)) {
                    container.style.display = 'none';
                    container.innerHTML = '';
                } else {
                    container.style.display = 'flex';
                }
            }
        });
    };

    // Общие функции для работы с данными
    const loadData = async (action, container, renderCallback) => {
        if (!container) { // Проверка на существование контейнера
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
            hideAllContainers(action);
            renderCallback(data, container);
        } catch (error) {
            alert(`Ошибка загрузки ${action}: ${error.message}`);
            console.error(error);
        }
    };

    const setupViewListener = (container, action, form, modal, customHandler) => {
        if (!container || !form || !modal) { // Проверка элементов
            console.error(`Не найдены элементы для ${action}`);
            return;
        }

        container.addEventListener('click', async (e) => {
            if (!e.target.classList.contains('btn-view')) return;

            const id = e.target.dataset.id;
            try {
                const response = await fetch(`php-backend/data-handler.php?action=${action}&id=${id}`);
                const data = await response.json();

                if (!data || data.error) {
                    throw new Error(data.error || 'Данные не получены');
                }

                form.dataset.id = id;
                if (customHandler) {
                    customHandler(data, form);
                } else {
                    // Автозаполнение формы
                    Object.keys(data).forEach(key => {
                        if (form[key]) form[key].value = data[key] || '';
                    });
                }

                modal.style.display = 'flex';
            } catch (error) {
                alert(`Ошибка просмотра ${action}: ${error.message}`);
            }
        });
    };

    const setupFormSubmit = (form, type, successCallback) => {
        if (!form) { // Проверка формы
            console.error(`Форма для ${type} не найдена`);
            return;
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const data = { type };
            if (form.dataset.id) data[`id_${type}`] = form.dataset.id;

            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }

            try {
                const response = await fetch('php-backend/update-tables.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('Успешно сохранено!');
                    if (successCallback) successCallback();
                } else {
                    throw new Error(result.error || 'Ошибка сервера');
                }
            } catch (error) {
                alert(`Ошибка сохранения: ${error.message}`);
            }
        });
    };

    // Конфигурация для всех таблиц
    const tablesConfig = {
        products: {
            container: document.querySelector('.products'),
            modal: document.getElementById('modal-products'),
            form: document.getElementById('form-add-product'),
            type: 'product',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="block-table" data-id="${item.id_product}">
                            <h1>ID = ${item.id_product}</h1>
                            <h1>${item.name}</h1>
                            <h1>Цена: ${item.price} ₽</h1>
                            <button class="btn-view" data-id="${item.id_product}">Просмотр</button>
                        </div>
                    `;
                });
            }
        },
        users: {
            container: document.querySelector('.users'),
            modal: document.getElementById('modal-users'),
            form: document.getElementById('form-add-user'),
            type: 'user',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="block-table" data-id="${item.id_user}">
                            <h1>ID = ${item.id_user}</h1>
                            <h1>${item.full_name}</h1>
                            <h1>${item.email}</h1>
                            <button class="btn-view" data-id="${item.id_user}">Просмотр</button>
                        </div>
                    `;
                });
            }
        },

        orders: {
            container: document.querySelector('.orders'),
            modal: document.getElementById('modal-orders'),
            form: document.getElementById('form-add-order'),
            type: 'order',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="block-table" data-id="${item.id_order}">
                            <h1>ID = ${item.id_order}</h1>
                            <h1>Пользователь: ${item.id_user}</h1>
                            <h1>Адрес: ${item.address}</h1>
                            <h1>Сумма: ${item.total_price} ₽</h1>
                            <button class="btn-view" data-id="${item.id_order}">Просмотр</button>
                        </div>
                    `;
                });
            },
            viewHandler: async (data, form) => {
                // Загрузка пользователей и статусов
                const [users, status] = await Promise.all([
                    fetch('php-backend/data-handler.php?action=users-list').then(r => r.json()),
                    fetch('php-backend/data-handler.php?action=status-list').then(r => r.json())
                ]);

                form.id_user.innerHTML = users.map(u =>
                    `<option value="${u.id_user}">${u.full_name}</option>`
                ).join('');

                form.id_status.innerHTML = status.map(s =>
                    `<option value="${s.id_status}">${s.name}</option>`
                ).join('');

                // Заполнение полей
                Object.keys(data).forEach(key => {
                    if (form[key]) form[key].value = data[key] || '';
                });
            }
        },

        order_items: {
            container: document.querySelector('.order_items'),
            modal: document.getElementById('modal-order_items'),
            form: document.getElementById('form-add-order-item'),
            type: 'order_item',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="block-table" data-id="${item.id_order_item}">
                            <h1>ID = ${item.id_order_item}</h1>
                            <h1>Заказ №${item.id_order}</h1>
                            <h1>Изделие №${item.id_product}</h1>
                            <h1>Кол-во: ${item.quantity}</h1>
                            <button class="btn-view" data-id="${item.id_order_item}">Просмотр</button>
                        </div>
                    `;
                });
            },
            viewHandler: async (data, form) => {
                // Загрузка списка заказов и продуктов
                const [orders, products] = await Promise.all([
                    fetch('php-backend/data-handler.php?action=orders').then(r => r.json()),
                    fetch('php-backend/data-handler.php?action=products-list').then(r => r.json())
                ]);

                // Заполнение select для заказов
                form.id_order.innerHTML = orders.map(o =>
                    `<option value="${o.id_order}">Заказ №${o.id_order}</option>`
                ).join('');

                // Заполнение select для продуктов
                form.id_product.innerHTML = products.map(p =>
                    `<option value="${p.id_product}">${p.name}</option>`
                ).join('');

                // Установка выбранных значений
                if (data.id_order) form.id_order.value = data.id_order;
                if (data.id_product) form.id_product.value = data.id_product;
                if (data.quantity) form.quantity.value = data.quantity;
                if (data.price) form.price.value = data.price;
            }
        },

        basket: {
            container: document.querySelector('.basket'),
            modal: document.getElementById('modal-basket'),
            form: document.getElementById('form-add-basket'),
            type: 'basket',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="block-table" data-id="${item.id_basket}">
                            <h1>ID = ${item.id_basket}</h1>
                            <h1>Пользователь: ${item.id_user}</h1>
                            <h1>Товар: ${item.id_product}</h1>
                            <h1>Кол-во: ${item.quantity}</h1>
                            <button class="btn-view" data-id="${item.id_basket}">Просмотр</button>
                        </div>
                    `;
                });
            },
            viewHandler: async (data, form) => {
                // Загрузка списка пользователей и продуктов
                const [users, products] = await Promise.all([
                    fetch('php-backend/data-handler.php?action=users-list').then(r => r.json()),
                    fetch('php-backend/data-handler.php?action=products-list').then(r => r.json())
                ]);

                // Заполнение select для пользователей
                form.id_user.innerHTML = users.map(u =>
                    `<option value="${u.id_user}">${u.full_name}</option>`
                ).join('');

                // Заполнение select для продуктов
                form.id_product.innerHTML = products.map(p =>
                    `<option value="${p.id_product}">${p.name}</option>`
                ).join('');

                // Установка выбранных значений
                if (data.id_user) form.id_user.value = data.id_user;
                if (data.id_product) form.id_product.value = data.id_product;
                if (data.quantity) form.quantity.value = data.quantity;
            }
        },
        status: {
            container: document.querySelector('.status'),
            modal: document.getElementById('modal-status'),
            form: document.getElementById('form-add-status'),
            type: 'status',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                        <div class="block-table" data-id="${item.id_status}">
                            <h1>ID = ${item.id_status}</h1>
                            <h1>${item.name}</h1>
                            <button class="btn-view" data-id="${item.id_status}">Просмотр</button>
                        </div>
                    `;
                });
            }
        },
        feedback: {
            container: document.querySelector('.feedback'),
            modal: document.getElementById('modal-feedback'),
            form: document.getElementById('form-add-feedback'),
            type: 'feedback',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                    <div class="block-table" data-id="${item.id}">
                        <h1>ID = ${item.id}</h1>
                        <h1>${item.first_name} ${item.last_name}</h1>
                        <h1>Email: ${item.email}</h1>
                        <button class="btn-view" data-id="${item.id}">Просмотр</button>
                    </div>
                `;
                });
            }
        },

        ingredients: {
            container: document.querySelector('.ingredients'),
            modal: document.getElementById('modal-ingredients'),
            form: document.getElementById('form-add-ingredients'),
            type: 'ingredient',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                    <div class="block-table" data-id="${item.id_ingredient}">
                        <h1>ID = ${item.id_ingredient}</h1>
                        <h1>${item.name}</h1>
                        <h1>Тип: ${item.type}</h1>
                        <button class="btn-view" data-id="${item.id_ingredient}">Просмотр</button>
                    </div>
                `;
                });
            }
        },

        product_ingredients: {
            container: document.querySelector('.product_ingredients'),
            modal: document.getElementById('modal-product_ingredients'),
            form: document.getElementById('form-add-product-ingredients'),
            type: 'product_ingredient',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                    <div class="block-table" data-id="${item.id_product_ingredients}">
                        <h1>ID = ${item.id_product_ingredients}</h1>
                        <h1>Изделие: ${item.product_name || item.id_product}</h1>
                        <h1>Ингредиент: ${item.ingredient_name || item.id_ingredient}</h1>
                        <button class="btn-view" data-id="${item.id_product_ingredients}">Просмотр</button>
                    </div>
                `;
                });
            },
            viewHandler: async (data, form) => {
                const [products, ingredients] = await Promise.all([
                    fetch('php-backend/data-handler.php?action=products-list').then(r => r.json()),
                    fetch('php-backend/data-handler.php?action=ingredients-list').then(r => r.json())
                ]);

                form.id_product_pi.innerHTML = products.map(p =>
                    `<option value="${p.id_product}">${p.name}</option>`
                ).join('');

                form.id_ingredient_pi.innerHTML = ingredients.map(i =>
                    `<option value="${i.id_ingredient}">${i.name}</option>`
                ).join('');

                if (data.id_product) form.id_product_pi.value = data.id_product;
                if (data.id_ingredient) form.id_ingredient_pi.value = data.id_ingredient;
                if (data.id_product_ingredients) {form.id_product_ingredients_pi.value = data.id_product_ingredients;}
            }
        },

        type_user: {
            container: document.querySelector('.type_user'),
            modal: document.getElementById('modal-type_user'),
            form: document.getElementById('form-add-type_user'),
            type: 'type_user',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                    <div class="block-table" data-id="${item.id_type_user}">
                        <h1>ID = ${item.id_type_user}</h1>
                        <h1>${item.name}</h1>
                        <button class="btn-view" data-id="${item.id_type_user}">Просмотр</button>
                    </div>
                `;
                });
            }
        },

        suppliers: {
            container: document.querySelector('.suppliers'),
            modal: document.getElementById('modal-suppliers'),
            form: document.getElementById('form-add-suppliers'),
            type: 'supplier',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                    <div class="block-table" data-id="${item.id_supplier}">
                        <h1>ID = ${item.id_supplier}</h1>
                        <h1>${item.name}</h1>
                        <button class="btn-view" data-id="${item.id_supplier}">Просмотр</button>
                    </div>
                `;
                });
            }
        },

        supplier_products: {
            container: document.querySelector('.supplier_products'),
            modal: document.getElementById('modal-supplier_products'),
            form: document.getElementById('form-add-supplier_products'),
            type: 'supplier_product',
            render: (data, container) => {
                data.forEach(item => {
                    container.innerHTML += `
                    <div class="block-table" data-id="${item.id_supplier_product}">
                        <h1>ID = ${item.id_supplier_product}</h1>
                        <h1>Поставщик: ${item.supplier_name || item.id_supplier}</h1>
                        <h1>Изделие: ${item.product_name || item.id_product}</h1>
                        <button class="btn-view" data-id="${item.id_supplier_product}">Просмотр</button>
                    </div>
                `;
                });
            },
            viewHandler: async (data, form) => {
                const [suppliers, products] = await Promise.all([
                    fetch('php-backend/data-handler.php?action=suppliers-list').then(r => r.json()),
                    fetch('php-backend/data-handler.php?action=products-list').then(r => r.json())
                ]);

                form.id_supplier.innerHTML = suppliers.map(s =>
                    `<option value="${s.id_supplier}">${s.name}</option>`
                ).join('');

                form.id_product_supplier.innerHTML = products.map(p =>
                    `<option value="${p.id_product}">${p.name}</option>`
                ).join('');

                // Установка выбранных значений
                if (data.id_supplier) form.id_supplier.value = data.id_supplier;
                if (data.id_product) form.id_product_supplier.value = data.id_product;
            }
        }
    };

    // Инициализация всех обработчиков
    Object.entries(tablesConfig).forEach(([action, config]) => {
        const button = document.querySelector(`[data-modal="${action}"]`);
        if (!button) {
            console.error(`Кнопка для ${action} не найдена`);
            return;
        }

        // Кнопка показа таблицы
        button.addEventListener('click', () => {
            loadData(action, config.container, config.render);
        });

        // Обработчик просмотра элемента
        if (config.modal && config.form) {
            setupViewListener(
                config.container,
                action,
                config.form,
                config.modal,
                config.viewHandler
            );

            // Обработчик отправки формы
            setupFormSubmit(config.form, config.type, () => {
                config.modal.style.display = 'none';
                button.click();
            });
        }
    });

    // Закрытие модальных окон при клике вне формы
    allModals.forEach(modal => {
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    });
});

document.getElementById('btn-clear').addEventListener('click', () => {
    // Скрытие всеъ контейнеров и их очистка
    document.querySelectorAll('.container-list-column').forEach(container => {
        container.style.display = 'none';
        container.innerHTML = '';
    });

    // Прокручивание страницы в самый верх
    window.scrollTo({ top: 0, behavior: 'smooth' });
});