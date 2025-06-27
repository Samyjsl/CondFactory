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
    <title>Представления (Админ-панель)</title>
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
    <section id="item-table">
        <div class="title">Представления</div>
        <div class="container-list-add">
            <div class="container-list-row">
                <button class="btn-show-table v1" data-modal="view_1" title="Получить список всех продуктов определенной категории.">Представление 1</button>
                <button class="btn-show-table v2" data-modal="view_2" title="Получить список всех заказов определенного клиента.">Представление 2</button>
                <button class="btn-show-table v3" data-modal="view_3" title="Получить список всех поставщиков, у которых есть ингредиенты определенного типа.">Представление 3</button>
                <button class="btn-show-table v4" data-modal="view_4" title="Получить список всех продуктов, у которых количество на складе меньше заданного значения.">Представление 4</button>
                <button class="btn-show-table v5" data-modal="view_5" title="Получить список всех заказов, сделанных в определенный период времени.">Представление 5</button>
                <button class="btn-show-table v6" data-modal="view_6" title="Получить список всех поставщиков, предоставляющих определенный продукт.">Представление 6</button>
                <button class="btn-show-table v7" data-modal="view_7" title="Получить список всех заказов, у которых статус равен определенному значению.">Представление 7</button>
                <button class="btn-show-table v8" data-modal="view_8" title="Получить список всех заказов с указанием имени клиента и продукта.">Представление 8</button>
                <button class="btn-show-table v9" data-modal="view_9" title="Получить список суммарного количества каждого продукта, проданного за определенный период времени.">Представление 9</button>
                <button class="btn-show-table v10" data-modal="view_10" title="Получить список всех продуктов, у которых количество в наличии меньше заданного значения и они находятся в определенной категории.">Представление 10</button>
            </div>
        </div>
    </section>
    <script src="js-admin/get-view.js"></script>
</body>

</html>