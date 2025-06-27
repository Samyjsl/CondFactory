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
    <title>Главная страница (Админ панель)</title>
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
    <section id="main-menu">
        <h1>Добро пожаловать в админ-панель</h1>
    </section>
</body>
</html>