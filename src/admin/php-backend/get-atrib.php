<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 2) {
    http_response_code(403);
    echo json_encode(['error' => 'Нет доступа']);
    exit;
}

require 'db.php';
header('Content-Type: application/json');

$type = $_GET['type'] ?? '';

try {
    switch ($type) {
        case 'users':
            $stmt = $pdo->query("SELECT id_user, name, surname FROM Users ORDER BY name, surname");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users);
            break;

        case 'orders_products':
            $orders = $pdo->query("SELECT id_order FROM Orders ORDER BY id_order DESC")->fetchAll(PDO::FETCH_ASSOC);
            $products = $pdo->query("SELECT id_product, name FROM Products ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['orders' => $orders, 'products' => $products]);
            break;

        case 'products':
            $stmt = $pdo->query("SELECT id_product, name FROM Products ORDER BY name");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'ingredients':
            $stmt = $pdo->query("SELECT id_ingredient, name FROM Ingredients ORDER BY name");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'statuses':
            $stmt = $pdo->query("SELECT id_status, name FROM Status ORDER BY id_status");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;
        case 'type_user':
            $stmt = $pdo->query("SELECT id_type_user, name FROM Type_User ORDER BY id_type_user");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'suppliers':
            $stmt = $pdo->query("SELECT id_supplier, name FROM Suppliers ORDER BY name");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;



        default:
            http_response_code(400);
            echo json_encode(['error' => 'Неизвестный тип данных']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка сервера: ' . $e->getMessage()]);
}
