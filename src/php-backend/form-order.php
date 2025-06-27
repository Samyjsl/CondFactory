<?php
session_start();
require __DIR__ . '/db.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    die('Пользователь не авторизован');
}

$address = $_POST['address'] ?? '';
$entrance = $_POST['entrance'] ?? '';
$floor = $_POST['floor'] ?? '';
$apartment = $_POST['apartment'] ?? '';
$intercom = $_POST['intercom'] ?? '';
$message = $_POST['message'] ?? '';

if (!$address || !$entrance || !$floor || !$apartment || !$intercom) {
    die('Заполните все обязательные поля');
}

try {
    $stmt = $pdo->prepare("SELECT id_product, quantity FROM Basket WHERE id_user = :userId");
    $stmt->execute([':userId' => $userId]);
    $basketItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($basketItems)) {
        die('Корзина пуста');
    }

    $totalPrice = 0;
    $stmtPrice = $pdo->prepare("SELECT price FROM Products WHERE id_product = :product_id");

    foreach ($basketItems as $item) {
        $stmtPrice->execute([':product_id' => $item['id_product']]);
        $row = $stmtPrice->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $totalPrice += $row['price'] * $item['quantity'];
        }
    }

    $stmt = $pdo->prepare("INSERT INTO Orders (id_user, address, entrance, floor, apartment, intercom, comment, total_price, id_status, created_at)
        VALUES (:id_user, :address, :entrance, :floor, :apartment, :intercom, :comment, :total_price, :id_status, NOW())");
    $stmt->execute([
        ':id_user' => $userId,
        ':address' => $address,
        ':entrance' => $entrance,
        ':floor' => $floor,
        ':apartment' => $apartment,
        ':intercom' => $intercom,
        ':comment' => $message,
        ':total_price' => $totalPrice,
        ':id_status' => 1,
    ]);

    $orderId = $pdo->lastInsertId();

    $stmtInsert = $pdo->prepare("INSERT INTO Order_Items (id_order, id_product, quantity, price) VALUES (:id_order, :id_product, :quantity, :price)");

    foreach ($basketItems as $item) {
        $stmtPrice->execute([':product_id' => $item['id_product']]);
        $row = $stmtPrice->fetch(PDO::FETCH_ASSOC);
        $price = $row ? $row['price'] : 0;

        $stmtInsert->execute([
            ':id_order' => $orderId,
            ':id_product' => $item['id_product'],
            ':quantity' => $item['quantity'],
            ':price' => $price,
        ]);
    }

    $stmt = $pdo->prepare("DELETE FROM Basket WHERE id_user = :userId");
    $stmt->execute([':userId' => $userId]);

    header('Location: ../orders.php');
    exit;

} catch (PDOException $e) {
    echo "Ошибка при оформлении заказа: " . $e->getMessage();
}
