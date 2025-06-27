<?php
require __DIR__ . '/db.php';
session_start();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$categories = $_POST['category'] ?? [];
$order = (isset($_POST['order']) && strtolower($_POST['order']) === 'desc') ? 'DESC' : 'ASC';

$sql = "SELECT p.* FROM Products p";
$params = [];

if (!empty($categories)) {
    $placeholders = implode(',', array_fill(0, count($categories), '?'));
    $sql .= " WHERE p.id_type_product IN ($placeholders)";
    $params = $categories;
}

$sql .= " ORDER BY p.price $order";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$userId = $_SESSION['user_id'] ?? null;
$basket = [];

if ($userId) {
    $stmtBasket = $pdo->prepare("SELECT id_product, quantity FROM Basket WHERE id_user = ?");
    $stmtBasket->execute([$userId]);
    $basketRows = $stmtBasket->fetchAll(PDO::FETCH_ASSOC);
    foreach ($basketRows as $row) {
        $basket[(int)$row['id_product']] = (int)$row['quantity'];
    }
}

echo '<div class="product-grid">';

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = (int)$row['id_product'];
    $name = htmlspecialchars($row['name']);
    $price = htmlspecialchars($row['price']);
    $weight = htmlspecialchars($row['number_of_grams']);
    $image = htmlspecialchars($row['image']);

    $inCart = isset($basket[$id]);
    $quantity = $inCart ? $basket[$id] : 1;

    echo '<div class="product-card" id="product-' . $id . '">';
    echo '<a href="cart-product.php?id=' . $id . '">';
    echo '<div class="block-img"><img src="' . $image . '" alt="' . $name . '"></div></a>';
    echo '<div class="block-text">';
    echo '<h2>' . $price . ' ₽</h2>';
    echo '<a href="cart-product.php?id=' . $id . '"><h3>' . $name . '</h3></a>';
    echo '<h4>' . $weight . ' г</h4>';
    echo '</div>';

    echo '<div class="block-product-button" data-id="' . $id . '" style="display: ' . ($inCart ? 'none' : 'block') . ';">';
    echo '<button class="button-product" data-product-id="' . $id . '">Добавить в корзину</button>';
    echo '</div>';

    echo '<div class="block-add-button" data-id="' . $id . '" style="display: ' . ($inCart ? 'flex' : 'none') . ';">';
    echo '<button class="minus" data-product-id="' . $id . '">-</button>';
    echo '<p>' . $quantity . '</p>';
    echo '<button class="plus" data-product-id="' . $id . '">+</button>';
    echo '</div>';

    echo '</div>';
}

echo '</div>';
