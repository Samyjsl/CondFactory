<?php
session_start();

header('Content-Type: application/json');

$response = ['authorized' => false, 'redirect' => null];

if (isset($_SESSION['user_id'])) {
    $response['authorized'] = true;
    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
        $response['redirect'] = 'admin/main.menu.php';
    } else {
        $response['redirect'] = '#';
    }
}

echo json_encode($response);
