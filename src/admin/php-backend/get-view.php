<?php
require 'db.php';
header('Content-Type: application/json');

// Проверка параметра
if (!isset($_GET['view'])) {
    echo json_encode(['error' => 'Нет параметра view']);
    exit;
}

$view = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['view']);

try {
    $stmt = $pdo->query("SELECT * FROM $view");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
} catch (Exception $e) {
    echo json_encode(['error' => 'Ошибка запроса: ' . $e->getMessage()]);
}
