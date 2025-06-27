<?php
require_once(__DIR__ . '/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($first_name && $last_name && $email && $message) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO Feedback_Messages (first_name, last_name, email, message)
                VALUES (:first_name, :last_name, :email, :message)
            ");

            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name'  => $last_name,
                ':email'      => $email,
                ':message'    => $message
            ]);

            echo "Спасибо! Ваше сообщение успешно отправлено.";
        } catch (PDOException $e) {
            echo "Ошибка при отправке сообщения: " . $e->getMessage();
        }
    } 
}
?>
