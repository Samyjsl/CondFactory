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
    <title>Удаление (Админ-панель)</title>
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
        <div class="title">Удаление</div>
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

    <script src="js-admin/delete-form.js"></script>
</body>
</html>