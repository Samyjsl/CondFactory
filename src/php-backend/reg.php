<?php
session_start();
require_once(__DIR__ . '/db.php');
header('Content-Type: application/json');

$name = trim($_POST['first_name'] ?? '');
$surname = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (!$name || !$surname || !$email || !$password || !$confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Заполните все поля']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Некорректный email']);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Пароли не совпадают']);
    exit;
}

$stmt = $conn->prepare("SELECT COUNT(*) FROM Users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetchColumn() > 0) {
    echo json_encode(['success' => false, 'message' => 'Пользователь с таким email уже существует']);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO Users (name, surname, email, password, id_type_user) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $surname, $email, $password, 1]);

    echo json_encode(['success' => true, 'message' => 'Регистрация прошла успешно. Теперь вы можете войти.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка при регистрации']);
}

if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $name) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $surname)) {
    echo json_encode(['success' => false, 'message' => 'Имя и фамилия содержат недопустимые символы']);
    exit;
}

if (strlen($password) < 8 || 
    !preg_match('/[a-zA-Z]/', $password) || 
    !preg_match('/\d/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Пароль должен быть не менее 8 символов, содержать хотя бы одну букву и одну цифру']);
    exit;
}

