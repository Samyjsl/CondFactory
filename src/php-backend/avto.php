<?php
session_start();
require_once(__DIR__ . '/db.php');
header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Введите email и пароль']);
    exit;
}

$stmt = $conn->prepare("SELECT id_user, name, surname, password, id_type_user FROM Users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['password'] !== $password) {
    echo json_encode(['success' => false, 'message' => 'Неверный email или пароль']);
    exit;
}

$_SESSION['user_id'] = $user['id_user'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_surname'] = $user['surname'];
$_SESSION['user_type'] = $user['id_type_user'];

setcookie('user_id', $user['id_user'], [
    'expires' => time() + 60 * 60 * 24 * 7,
    'path' => '/',
    'httponly' => true,
    'secure' => true,
    'samesite' => 'Strict'
]);

echo json_encode([
    'success' => true,
    'message' => 'Вы успешно авторизованы',
    'user_type' => $user['id_type_user']
]);
