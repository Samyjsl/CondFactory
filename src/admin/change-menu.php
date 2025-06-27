<?php
session_start();

if (!isset($_SESSION['user_type'])) {
    header('Location: /main-menu.php');
    exit;
}

if ($_SESSION['user_type'] != 2) {
    header('Location: /main-menu.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css-admin/header-footer.css">
    <link rel="icon" sizes="16x16" type="image/png" href="../img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Изменить (Админ-панель)</title>
</head>

<body>
    <header>
        <div class="left-header">
            <a href="main-menu.php" class="header-logo">
                <img src="../img/logo.svg" alt="Логотип" class="header-image-logo">
            </a>

            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="add-menu.php" class="header-text">Добавление</a></li>
                    <li><a href="change-menu.php" class="header-text">Изменение</a></li>
                    <li><a href="delete-menu.php" class="header-text">Удаление</a></li>
                    <li><a href="view.php" class="header-text">Просмотр</a></li>
                    <li><a href="pred.php" class="header-text">Представления</a></li>
                </ul>
            </nav>
        </div>

        <div class="right-header">
            <div class="block-header-exit-acc">
                <a href="/php-backend/logout.php" class="btn-exit-acc">Выйти из аккаунта</a>
            </div>
        </div>
    </header>
    <button id="btn-clear">Очистка</button>
    <section id="item-table">
        <div class="title">Изменение</div>
        <div class="container-list">
            <div class="container-list-column products" style="display:none;"></div>
            <div class="container-list-column users" style="display:none;"></div>
            <div class="container-list-column orders" style="display:none;"></div>
            <div class="container-list-column order_items" style="display: none;"></div>
            <div class="container-list-column basket" style="display: none;"></div>
            <div class="container-list-column status" style="display: none;"></div>
            <div class="container-list-column feedback" style="display: none;"></div>
            <div class="container-list-column ingredients" style="display: none;"></div>
            <div class="container-list-column product_ingredients" style="display: none;"></div>
            <div class="container-list-column type_user" style="display: none;"></div>
            <div class="container-list-column suppliers" style="display: none;"></div>
            <div class="container-list-column supplier_products" style="display: none;"></div>
        </div>
        <div class="container-list-add">
            <div class="container-list-row">
                <button class="btn-show-table" data-modal="products">Таблица изделия</button>
                <button class="btn-show-table" data-modal="users">Таблица пользователи</button>
                <button class="btn-show-table" data-modal="orders">Таблица заказы</button>
                <button class="btn-show-table" data-modal="order_items">Таблица изделия в заказах</button>
                <button class="btn-show-table" data-modal="basket">Таблица корзина</button>
                <button class="btn-show-table" data-modal="status">Таблица статусы</button>
                <button class="btn-show-table" data-modal="feedback">Таблица обратная связь</button>
                <button class="btn-show-table" data-modal="ingredients">Таблица ингредиенты</button>
                <button class="btn-show-table" data-modal="product_ingredients">Таблица состав изделия</button>
                <button class="btn-show-table" data-modal="type_user">Таблица тип пользователей</button>
                <button class="btn-show-table" data-modal="suppliers">Таблица поставщики</button>
                <button class="btn-show-table" data-modal="supplier_products">Таблица изделия у поставщиков</button>
            </div>
        </div>
    </section>

    <div class="container-form" id="modal-users" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменение пользователя</h2>
            <form id="form-add-user">
                <input class="form-input" type="text" name="name" placeholder="Имя*" required />
                <input class="form-input" type="text" name="surname" placeholder="Фамилия*" required />
                <input class="form-input" type="email" name="email" placeholder="E-mail*" required />
                <input class="form-input" type="text" name="password" placeholder="Пароль*" required />
                <div class="block-select">
                    <label for="id_type_user" class="label">Тип пользователя*</label>
                    <select name="id_type_user" id="id_type_user" class="select-value" required>
                        <option value="">Выберите тип</option>
                        <option value="1">Пользователь</option>
                        <option value="2">Админ</option>
                    </select>
                </div>
                <button class="form-button" type="submit">Изменить</button>
            </form>

        </div>
    </div>

    <div class="container-form" id="modal-products" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменение изделия</h2>
            <form id="form-add-product">
                <input class="form-input" type="text" name="name" placeholder="Название изделия*" required />
                <div class="block-select">
                    <label for="id_type_product" class="label">Тип изделия*</label>
                    <select name="id_type_product" id="id_type_product" class="select-value" required>
                        <option value="">Выберите тип</option>
                        <option value="1">Вафля</option>
                        <option value="2">Батончик</option>
                        <option value="3">Шоколад</option>
                        <option value="4">Пончик</option>
                        <option value="5">Маффин</option>
                        <option value="6">Печенье</option>
                    </select>
                </div>
                <input class="form-input" type="number" name="price" placeholder="Цена*" required />
                <input class="form-input" type="number" name="number_of_grams" placeholder="Вес (граммы)*" required />
                <textarea class="form-textarea" name="description" placeholder="Описание"></textarea>
                <textarea class="form-textarea" name="constituent" placeholder="Состав"></textarea>
                <input class="form-input" type="text" name="image" placeholder="Путь к изображению*" required />
                <p class="title-form-p">Количество</p>
                <input class="form-input" type="number" name="stock_quantity" placeholder="Количество на складе*" value="0" min="0" />

                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>


    <div class="container-form" id="modal-orders" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменение заказа</h2>
            <form id="form-add-order">
                <div class="block-select">
                    <label for="id_user" class="label">Пользователь*</label>
                    <select name="id_user" id="id_user" class="select-value" required>
                        <option value="">Выберите пользователя</option>
                    </select>
                </div>

                <input class="form-input" type="text" name="address" placeholder="Адрес доставки*" required />

                <input class="form-input" type="text" name="entrance" placeholder="Подъезд*" />
                <input class="form-input" type="text" name="floor" placeholder="Этаж*" />
                <input class="form-input" type="text" name="apartment" placeholder="Квартира*" />
                <input class="form-input" type="text" name="intercom" placeholder="Домофон*" />

                <textarea class="form-textarea" name="comment" placeholder="Комментарий"></textarea>

                <input class="form-input" type="number" name="total_price" placeholder="Итоговая сумма*" required min="0" step="1" />

                <div class="block-select">
                    <label for="id_status" class="label">Статус заказа*</label>
                    <select name="id_status" id="id_status" class="select-value" required>
                        <option value="">Выберите статус</option>
                    </select>
                </div>

                <button class="form-button" type="submit">Изменить</button>
            </form>

        </div>
    </div>

    <div class="container-form" id="modal-order_items" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменения изделия в заказ</h2>
            <form id="form-add-order-item">
                <div class="block-select">
                    <label for="id_order" class="label">Выберите заказ*</label>
                    <select name="id_order" id="id_order" class="select-value" required>
                        <option value="">Выберите заказ</option>
                    </select>
                </div>

                <div class="block-select">
                    <label for="id_product" class="label">Выберите изделие*</label>
                    <select name="id_product" id="id_product" class="select-value" required>
                        <option value="">Выберите изделие</option>
                    </select>
                </div>

                <input class="form-input" type="number" name="quantity" placeholder="Количество*" required />
                <input class="form-input" type="number" name="price" placeholder="Цена*" required />
                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <div class="container-form" id="modal-basket" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменения в корзину</h2>
            <form id="form-add-basket">
                <div class="block-select">
                    <label for="id_user_basket" class="label">Пользователь*</label>
                    <select name="id_user" id="id_user_basket" class="select-value" required>
                        <option value="">Выберите пользователя</option>
                    </select>
                </div>

                <div class="block-select">
                    <label for="id_product_basket" class="label">Изделие*</label>
                    <select name="id_product" id="id_product_basket" class="select-value" required>
                        <option value="">Выберите изделие</option>
                    </select>
                </div>

                <input class="form-input" type="number" name="quantity" placeholder="Количество*" min="1" required />

                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>


    <div class="container-form" id="modal-status" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменения статуса</h2>
            <form id="form-add-status">
                <input class="form-input" type="text" name="name" placeholder="Название статуса*" required />
                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <div class="container-form" id="modal-feedback" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменения сообщения обратной связи</h2>
            <form id="form-add-feedback">
                <input class="form-input" type="text" name="first_name" placeholder="Имя*" required />
                <input class="form-input" type="text" name="last_name" placeholder="Фамилия*" required />
                <input class="form-input" type="email" name="email" placeholder="Email*" required />
                <textarea class="form-textarea" name="message" placeholder="Сообщение*" required></textarea>
                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <div class="container-form" id="modal-ingredients" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменения ингредиента</h2>
            <form id="form-add-ingredients">
                <input class="form-input" type="text" name="name" placeholder="Название ингредиента*" required />
                <input class="form-input" type="text" name="ingredient_type" placeholder="Тип ингредиента*" required />
                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <div class="container-form" id="modal-product_ingredients" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменение состава изделия</h2>
            <form id="form-add-product-ingredients">
                <input type="hidden" name="id_product_ingredients" id="id_product_ingredients_pi">
                <div class="block-select">
                    <label for="id_product_pi" class="label">Изделие*</label>
                    <select name="id_product" id="id_product_pi" class="select-value" required>
                        <option value="">Выберите изделие</option>
                    </select>
                </div>

                <div class="block-select">
                    <label for="id_ingredient_pi" class="label">Ингредиент*</label>
                    <select name="id_ingredient" id="id_ingredient_pi" class="select-value" required>
                        <option value="">Выберите ингредиент</option>
                    </select>
                </div>

                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <div class="container-form" id="modal-type_user" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменение типа пользователя</h2>
            <form id="form-add-type_user">
                <input type="text" name="name" class="form-input" placeholder="Название типа*" required />

                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <div class="container-form" id="modal-suppliers" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменение поставщика</h2>
            <form id="form-add-suppliers">
                <input type="text" name="name" class="form-input" placeholder="Название поставщика*" required />
                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>


    <div class="container-form" id="modal-supplier_products" style="display:none;">
        <div class="block-form">
            <h2 class="form-title">Изменение изделие поставщику</h2>
            <form id="form-add-supplier_products">
                <div class="block-select">
                    <label for="id_supplier" class="label">Поставщик*</label>
                    <select name="id_supplier" id="id_supplier" class="select-value" required>
                        <option value="">Выберите поставщика</option>
                    </select>
                </div>

                <div class="block-select">
                    <label for="id_product_supplier" class="label">Изделие*</label>
                    <select name="id_product" id="id_product_supplier" class="select-value" required>
                        <option value="">Выберите изделие</option>
                    </select>
                </div>

                <button class="form-button" type="submit">Изменить</button>
            </form>
        </div>
    </div>

    <script src="js-admin/change-form.js"></script>
    <script src="js-admin/clear.js"></script>
</body>

</html>