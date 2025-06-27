document.querySelectorAll('.btn-show-table').forEach(button => {
    button.addEventListener('click', function () {
        const modalType = this.dataset.modal;

        // Скрытие всех контейнеров и их очистка
        document.querySelectorAll('.container-list-column').forEach(container => {
            container.style.display = 'none';
            container.innerHTML = '';
        });

        // Показ выбранного контейнера
        const container = document.querySelector(`.container-list-column.${modalType}`);
        container.style.display = 'flex';

        // Получение данных с сервера и их представление в HTML форме
        fetch(`php-backend/get-tables.php?type=${modalType}`)
            .then(response => response.json())
            .then(data => {
                console.log(`Данные для ${modalType}:`, data);

                if (modalType === 'products') {
                    data.forEach(p => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Изделие ID = ${p.id_product}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Название: </span>${p.name}</h1>
                                <h1><span>Тип продукции: </span>${p.id_type_product}</h1>
                                <h1><span>Цена: </span>${p.price} ₽</h1>
                                <h1><span>Грамм: </span>${p.number_of_grams}</h1>
                                <h1><span>Описание: </span>${p.description}</h1>
                                <h1><span>Состав: </span>${p.constituent}</h1>
                                <h1><span>Путь к картинке: </span>${p.image}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }

                if (modalType === 'users') {
                    data.forEach(u => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Пользователь ID = ${u.id_user}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Имя: </span>${u.name}</h1>
                                <h1><span>Фамилия: </span>${u.surname}</h1>
                                <h1><span>Почта: </span>${u.email}</h1>
                                <h1><span>Пароль: </span>${u.password}</h1>
                                <h1><span>Тип пользователя: </span>${u.id_type_user}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }

                if (modalType === 'orders') {
                    data.forEach(o => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Заказ ID = ${o.id_order}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>ID пользователя: </span>${o.id_user}</h1>
                                <h1><span>Адрес: </span>${o.address}</h1>
                                <h1><span>Подъезд: </span>${o.entrance}</h1>
                                <h1><span>Этаж: </span>${o.floor}</h1>
                                <h1><span>Квартира: </span>${o.apartment}</h1>
                                <h1><span>Домофон: </span>${o.intercom}</h1>
                                <h1><span>Комментарий: </span>${o.comment || '—'}</h1>
                                <h1><span>Сумма: </span>${o.total_price} ₽</h1>
                                <h1><span>Статус: </span>${o.id_status}</h1>
                                <h1><span>Создан: </span>${o.created_at}</h1>
                                <h1><span>Обновлён: </span>${o.updated_at}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'order_items') {
                    data.forEach(oi => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Товар в заказе ID = ${oi.id_order_item}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>ID заказа: </span>${oi.id_order}</h1>
                                <h1><span>ID изделия: </span>${oi.id_product}</h1>
                                <h1><span>Количество: </span>${oi.quantity}</h1>
                                <h1><span>Цена за единицу: </span>${oi.price} ₽</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'basket') {
                    data.forEach(b => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Корзина ID = ${b.id_basket}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>ID пользователя: </span>${b.id_user}</h1>
                                <h1><span>ID продукта: </span>${b.id_product}</h1>
                                <h1><span>Количество: </span>${b.quantity}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'feedback') {
                    data.forEach(fb => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Сообщение ID = ${fb.id}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Имя: </span>${fb.first_name}</h1>
                                <h1><span>Фамилия: </span>${fb.last_name}</h1>
                                <h1><span>Email: </span>${fb.email}</h1>
                                <h1><span>Сообщение: </span>${fb.message}</h1>
                                <h1><span>Создано: </span>${fb.created_at}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'status') {
                    data.forEach(s => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Статус ID = ${s.id_status}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Название: </span>${s.name}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'ingredients') {
                    data.forEach(i => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Ингредиент ID = ${i.id_ingredient}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Название: </span>${i.name}</h1>
                                <h1><span>Тип: </span>${i.type}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'product_ingredients') {
                    data.forEach(pi => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Состав изделия</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>ID изделия: </span>${pi.id_product}</h1>
                                <h1><span>ID ингредиента: </span>${pi.id_ingredient}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'type_product') {
                    data.forEach(tp => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Тип изделия ID = ${tp.id_type_product}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Название типа: </span>${tp.name}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'type_user') {
                    data.forEach(tu => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Тип пользователя ID = ${tu.id_type_user}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Название типа: </span>${tu.name}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'suppliers') {
                    data.forEach(supplier => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Поставщик ID = ${supplier.id_supplier}</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>Название поставщика: </span>${supplier.name}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (modalType === 'supplier_products') {
                    data.forEach(sp => {
                        const block = document.createElement('div');
                        block.classList.add('block-table');
                        block.innerHTML = `
                            <div class="block-mid">
                                <h1>Изделие у поставщика</h1>
                            </div>
                            <div class="block-text">
                                <h1><span>ID поставщика: </span>${sp.id_supplier}</h1>
                                <h1><span>ID изделия: </span>${sp.id_product}</h1>
                            </div>
                        `;
                        container.appendChild(block);
                    });
                }
                if (data.length === 0) {
                    const block = document.createElement('div');
                    block.classList.add('block-table');
                    block.innerHTML = `<h1>Нет данных для отображения.</h1>`;
                    container.appendChild(block);
                }
            })
            .catch(error => {
                console.error('Ошибка при получении данных:', error);
                const block = document.createElement('div');
                block.classList.add('block-table');
                block.innerHTML = `<h1>Ошибка загрузки данных</h1>`;
                container.appendChild(block);
            });
    });
});

document.getElementById('btn-clear').addEventListener('click', () => {
    // Скрытие всех контейнеров и их очистка
    document.querySelectorAll('.container-list-column').forEach(container => {
        container.style.display = 'none';
        container.innerHTML = '';
    });

    // Прокрутка страницы в самый вверх
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
