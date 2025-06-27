<?php
session_start();
include __DIR__ . '/php-backend/db.php';

$userId = $_SESSION['user_id'] ?? null;

$stmt = $pdo->query("SELECT * FROM Products");

$basket = [];
if ($userId) {
    $stmtBasket = $pdo->prepare("SELECT id_product, quantity FROM Basket WHERE id_user = ?");
    $stmtBasket->execute([$userId]);
    $basketRows = $stmtBasket->fetchAll(PDO::FETCH_ASSOC);
    foreach ($basketRows as $row) {
        $basket[(int)$row['id_product']] = (int)$row['quantity'];
    }
}
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
    header('Location: /admin/main-menu.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="icon" sizes="16x16" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/product-catalog.css">
    <link rel="stylesheet" href="css/reg-avto.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Каталог изделий</title>
</head>

<body>
    <header>
        <div class="left-header">
            <a href="main-menu.php" class="header-logo">
                <img src="img/logo.svg" alt="Логотип" class="header-image-logo">
            </a>

            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="product-catalog.php" class="header-text">Каталог продукции</a></li>
                    <li><a href="about-company.php" class="header-text">О компании</a></li>
                    <li><a href="contacts.php" class="header-text">Контакты</a></li>
                </ul>
            </nav>
        </div>

        <div class="right-header">
            <a href="orders.php" class="header-link">
                <div class="block-header-text-image">
                    <img src="img/box.svg" alt="Иконка заказов" class="header-image">
                    <span class="header-text">Заказы</span>
                </div>
            </a>

            <a href="basket.php" class="header-link">
                <div class="block-header-text-image">
                    <img src="img/shopping-cart.svg" alt="Иконка корзины" class="header-image">
                    <span class="header-text">Корзина</span>
                </div>
            </a>
        </div>
    </header>

    <div class="container-form-reg" id="modal-register">
        <div class="block-reg">
            <h2 class="form-title-areg">Регистрация</h2>
            <form action="reg.php" method="POST" id="reg-form">
                <input class="form-input-areg" type="text" name="first_name" placeholder="Ваше имя*"
                    pattern="[a-zA-Zа-яА-ЯёЁ\s\-]+" title="Допустимы только буквы, пробел и дефис" required>
                <input class="form-input-areg" type="text" name="last_name" placeholder="Ваша фамилия*"
                    pattern="[a-zA-Zа-яА-ЯёЁ\s\-]+" title="Допустимы только буквы, пробел и дефис" required>
                <input class="form-input-areg" type="email" name="email" placeholder="E-mail*" required>
                <input class="form-input-areg" type="password" name="password" placeholder="Пароль*"
                    minlength="8" pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"
                    title="Минимум 8 символов, хотя бы одна латинская буква и одна цифра" required>
                <input class="form-input-areg" type="password" name="confirm_password" placeholder="Подтверждение пароля*" required>
                <button class="form-button-areg" type="submit">Создать аккаунт</button>
                <button class="form-button-avtoreg" id="link-btn-avto">Уже зарегистрированы? - Авторизация</button>
            </form>
        </div>
    </div>

    <div class="container-form-avto" id="modal-avto">
        <div class="block-avto">
            <h2 class="form-title-areg">Авторизация</h2>
            <form action="avto.php" method="POST">
                <input class="form-input-areg" type="email" name="email" placeholder="E-mail*" required>
                <input class="form-input-areg" type="password" name="password" placeholder="Пароль*" required>
                <button class="form-button-areg" type="submit">Авторизоваться</button>
                <button class="form-button-avtoreg" id="link-btn-reg">Нет аккаунта? - Регистрация</button>
            </form>
        </div>
    </div>

    <section id="catalog">
        <div class="container-catalog">
            <div class="container-filter">
                <div class="block-title-filter">Фильтрация по<br>категории изделия</div>

                <form id="product-filter-form">
                    <div class="block-label-input">
                        <div>
                            <label>Плитки шоколада<input type="checkbox" name="category[]" value="3"></label>
                        </div>
                        <div>
                            <label>Вафли<input type="checkbox" name="category[]" value="1"></label>
                        </div>
                        <div>
                            <label>Маффины<input type="checkbox" name="category[]" value="5"></label>
                        </div>
                        <div>
                            <label>Батончики<input type="checkbox" name="category[]" value="2"></label>
                        </div>
                        <div>
                            <label>Пончики<input type="checkbox" name="category[]" value="4"></label>
                        </div>
                        <div>
                            <label>Печенье<input type="checkbox" name="category[]" value="6"></label>
                        </div>
                    </div>
                    <div class="block-button-filter">
                        <button type="submit" class="form-button-filter">Фильтровать</button>
                    </div>
                </form>
            </div>

            <div id="right-block-products">
                <div class="sort-block">
                    <span>Сортировка:</span>
                    <button type="button" id="sort-price" data-order="asc">сначала дешевые↑</button>
                </div>
                <div class="container-product">
                    <div class="product-grid">
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $id = (int)$row['id_product'];
                            $name = htmlspecialchars($row['name']);
                            $price = htmlspecialchars($row['price']);
                            $weight = htmlspecialchars($row['number_of_grams']);
                            $image = htmlspecialchars($row['image']);

                            $inCart = isset($basket[$id]);
                            $quantity = $inCart ? $basket[$id] : 1;
                        ?>
                            <div class="product-card" id="product-<?= $id ?>">
                                <a href="cart-product.php?id=<?= $id ?>">
                                    <div class="block-img">
                                        <img src="<?= $image ?>" alt="<?= $name ?>">
                                    </div>
                                </a>
                                <div class="block-text">
                                    <h2><?= $price ?> ₽</h2>
                                    <a href="cart-product.php?id=<?= $id ?>">
                                        <h3><?= $name ?></h3>
                                    </a>
                                    <h4><?= $weight ?> г</h4>
                                </div>
                                <div class="block-product-button" data-id="" style="display: <?= $inCart ? 'none' : 'block' ?>;">
                                    <button class="button-product" data-product-id="">Добавить в корзину</button>
                                </div>
                                <div class="block-add-button" data-id="<?= $id ?>" style="display: <?= $inCart ? 'flex' : 'none' ?>;">
                                    <button class="minus" data-product-id="<?= $id ?>">-</button>
                                    <p><?= $quantity ?></p>
                                    <button class="plus" data-product-id="<?= $id ?>">+</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container-logo-nav-footer">
            <a href="main-menu.php"><img src="img/ЛоготипФулл.png" alt="Сладкоед"></a>
            <div class="block-nav-footer">
                <a href="product-catalog.php">Каталог продукции</a>
                <a href="about-company.php">О компании</a>
                <a href="contacts.php">Контакты</a>
            </div>
        </div>
        <div class="address-footer">
            <h3>Россия, г. Москва,<br>Ул. Дымкова, к.1, офис 11.</h3>
        </div>
        <div class="contacts-footer">
            <div class="block-number-footer">
                <h2>8-800-450-21-21</h2>
            </div>
            <div class="block-number-footer-text">
                <h3>Горячая линия, звонок бесплатный из<br>любого региона России</h3>
            </div>
        </div>
    </footer>
    <script src="js/filter-sort.js"></script>
    <script src="js/modal-reg-avto.js"></script>
    <script src="js/basket.js"></script>
</body>

</html>