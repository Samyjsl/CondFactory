<?php
session_start();
header('Content-Type: application/json');

require __DIR__ . '/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? null;
$productId = intval($data['productId'] ?? 0);
$userId = $_SESSION['user_id'] ?? null;

if (!$userId || !$productId || !$action) {
    echo json_encode(['success' => false, 'message' => 'Недостаточно данных']);
    exit;
}

try {
    switch ($action) {
        case 'add':
            $stmt = $pdo->prepare("INSERT INTO Basket (id_user, id_product, quantity)
                VALUES (:userId, :productId, 1)
                ON DUPLICATE KEY UPDATE quantity = quantity + 1");
            $stmt->execute(['userId' => $userId, 'productId' => $productId]);
            break;

        case 'plus':
            $stmt = $pdo->prepare("UPDATE Basket SET quantity = quantity + 1
                WHERE id_user = :userId AND id_product = :productId");
            $stmt->execute(['userId' => $userId, 'productId' => $productId]);
            break;

        case 'minus':
            $stmt = $pdo->prepare("UPDATE Basket SET quantity = quantity - 1
                WHERE id_user = :userId AND id_product = :productId");
            $stmt->execute(['userId' => $userId, 'productId' => $productId]);

            $stmt = $pdo->prepare("DELETE FROM Basket
                WHERE id_user = :userId AND id_product = :productId AND quantity <= 0");
            $stmt->execute(['userId' => $userId, 'productId' => $productId]);
            break;

        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM Basket WHERE id_user = :userId AND id_product = :productId");
            $stmt->execute(['userId' => $userId, 'productId' => $productId]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Неверное действие']);
            exit;
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы: ' . $e->getMessage()]);
    exit;
}
