<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="icon" sizes="16x16" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/orders.css">
    <link rel="stylesheet" href="css/reg-avto.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Заказы</title>
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
            <div class="block-header-exit-acc">
                <a href="/php-backend/logout.php" class="btn-exit-acc">Выйти из аккаунта</a>
            </div>

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

    <section id="orders">
        <div class="container-orders">
            <div class="title">Заказы</div>
            <?php
            session_start();
            require __DIR__ . '/php-backend/db.php';

            $userId = $_SESSION['user_id'] ?? null;
            try {
                $stmt = $pdo->prepare("SELECT * FROM Orders WHERE id_user = :userId ORDER BY created_at DESC");
                $stmt->execute(['userId' => $userId]);
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($orders)) {
                    echo '<h3 class="title-2">Ваш список с заказами пуст</h3>';
                }

                foreach ($orders as $order) {
                    $orderId = $order['id_order'];
                    $isCancelable = ($order['id_status'] == 1);

                    $stmtItems = $pdo->prepare("
                        SELECT oi.quantity, oi.price, p.name
                        FROM Order_Items oi
                        JOIN Products p ON oi.id_product = p.id_product
                        WHERE oi.id_order = :orderId
                    ");
                    $stmtItems->execute(['orderId' => $orderId]);
                    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

                    echo '<div class="block-order">';
                    echo '  <div class="row-order-up">';
                    echo '    <div class="block-left-up">';
                    echo "      <h3>Заказ №{$orderId}</h3>";
                    echo "      <p>Статус: " . htmlspecialchars(getStatusName($order['id_status'])) . "</p>";
                    echo '    </div>';
                    echo '    <div class="block-right-up">';
                    echo "      <h2>" . number_format($order['total_price'], 0, ',', ' ') . " ₽</h2>";
                    echo '    </div>';
                    echo '  </div>';

                    echo '  <div class="row-order-middle">';
                    echo '    <p>Изделия:</p>';
                    echo '    <ul>';
                    foreach ($items as $item) {
                        $sum = $item['price'] * $item['quantity'];
                        echo "<li>{$item['quantity']} шт - " . htmlspecialchars($item['name']) . " - " . number_format($sum, 0, ',', ' ') . " ₽</li>";
                    }
                    echo '    </ul>';
                    echo '  </div>';

                    echo '  <div class="row-order-end">';
                    echo '    <button class="btn-cancel-order" data-order-id="' . $orderId . '" ' .
                        ($isCancelable ? '' : 'disabled style="opacity: 0.5; cursor: default;"') . '>Отменить</button>';
                    echo '  </div>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo '<p>Ошибка при загрузке заказов: ' . $e->getMessage() . '</p>';
            }

            function getStatusName($statusId)
            {
                $statuses = [
                    1 => 'Фасовка',
                    2 => 'Отменён',
                    3 => 'Выполнен',
                    4 => 'У курьера'
                ];
                return $statuses[$statusId] ?? 'Неизвестно';
            }

            ?>
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
    <script src="js/cancel-order.js"></script>
</body>

</html>