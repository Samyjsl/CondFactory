<?php
session_start();
require __DIR__ . '/php-backend/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT 
        b.quantity, 
        p.id_product, 
        p.name, 
        p.price, 
        p.image
    FROM Basket b
    JOIN Products p ON b.id_product = p.id_product
    WHERE b.id_user = ?
");
$stmt->execute([$userId]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT COUNT(*) FROM Basket WHERE id_user = :userId");
$stmt->execute([':userId' => $userId]);
$basketCount = $stmt->fetchColumn();

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
    <link rel="stylesheet" href="css/basket.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Корзина</title>
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

    <section id="basket">
        <div class="container-basket-all">
            <div class="title">Корзина</div>
            <div class="container-basket">
                <div class="block-left-products">
                    <?php foreach ($products as $product): ?>
                        <div class="container-product" data-id="<?= $product['id_product'] ?>" data-price="<?= $product['price'] ?>">
                            <a href="cart-product.php?id=<?= $product['id_product'] ?>">
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            </a>
                            <div class="block-product-right">
                                <div class="product-title">
                                    <h2><?= $product['price'] * $product['quantity'] ?> ₽</h2>
                                    <a href="cart-product.php?id=<?= $product['id_product'] ?>">
                                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                                    </a>
                                </div>
                                <div class="block-buttons" data-id="<?= $product['id_product'] ?>">
                                    <div class="block-add-button">
                                        <button class="minus" data-product-id="<?= $product['id_product'] ?>">-</button>
                                        <p><?= $product['quantity'] ?></p>
                                        <button class="plus" data-product-id="<?= $product['id_product'] ?>">+</button>
                                    </div>
                                    <button class="button-delete" data-product-id="<?= $product['id_product'] ?>">Убрать из корзины</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="block-right-form">
                    <?php if ($basketCount > 0): ?>
                        <div class="form-container">
                            <h2 class="form-title">Оформление заказа</h2>
                            <form action="/php-backend/form-order.php" method="POST">
                                <input class="form-input" type="text" name="address" placeholder="Адрес*" required />
                                <div class="block-inputs">
                                    <input class="form-input-small" type="text" name="entrance" placeholder="Подъезд*" required />
                                    <input class="form-input-small" type="text" name="floor" placeholder="Этаж*" required />
                                    <input class="form-input-small" type="text" name="apartment" placeholder="Квартира*" required />
                                    <input class="form-input-small" type="text" name="intercom" placeholder="Домофон*" required />
                                </div>
                                <textarea class="form-textarea" name="message" placeholder="Комментарий к заказу"></textarea>
                                <h2 class="price">Итоговая стоимость: <?= $totalPrice ?> ₽</h2>
                                <button class="form-button" type="submit">Перейти к оформлению</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <h3 class="title-2" id="empty-basket-message" style="display:none;">Ваша корзина пуста</h3>
                    <?php endif; ?>
                    <h3 class="title-2" id="empty-basket-message" style="display:none;">Ваша корзина пуста</h3>
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
    <script src="js/basket-inside.js"></script>
</body>

</html>