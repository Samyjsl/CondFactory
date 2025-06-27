<?php
$host = 'mysql-docker';
$dbname = 'ConfectioneryFactory';
$user = 'root';
$pass = '1';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
    $conn = $pdo;
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
