<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$orderId = intval($data['orderId'] ?? 0);

if (!$orderId) {
    echo json_encode(['success' => false, 'message' => 'Не указан заказ']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id_status FROM Orders WHERE id_order = :orderId AND id_user = :userId");
    $stmt->execute(['orderId' => $orderId, 'userId' => $userId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Заказ не найден']);
        exit;
    }

    if ($order['id_status'] != 1) {
        echo json_encode(['success' => false, 'message' => 'Отмена возможна только на стадии фасовки']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE Orders SET id_status = 2 WHERE id_order = :orderId");
    $stmt->execute(['orderId' => $orderId]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы: ' . $e->getMessage()]);
}
