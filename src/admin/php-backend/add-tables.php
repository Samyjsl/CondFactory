<?php
require 'db.php';
header('Content-Type: application/json');

try {
    $type = $_POST['type'] ?? '';

    switch ($type) {
        case 'user':
            $name = trim($_POST['name'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $id_type_user = intval($_POST['id_type_user'] ?? 0);

            if (!$name || !$surname || !$email || !$password || !$id_type_user) {
                echo json_encode(['success' => false, 'message' => 'Заполните все обязательные поля.']);
                exit;
            }

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                echo json_encode(['success' => false, 'message' => 'Пользователь с таким email уже существует.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Users (name, surname, email, password, id_type_user) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $surname, $email, $password, $id_type_user]);
            echo json_encode(['success' => true]);
            break;

        case 'product':
            $name = $_POST['name'] ?? '';
            $id_type_product = $_POST['id_type_product'] ?? '';
            $price = $_POST['price'] ?? '';
            $grams = $_POST['number_of_grams'] ?? '';
            $description = $_POST['description'] ?? '';
            $constituent = $_POST['constituent'] ?? '';
            $image = $_POST['image'] ?? '';
            $stock = $_POST['stock_quantity'] ?? '';

            if (!$name || !$id_type_product || !$price || !$grams || !$image || $stock === '') {
                echo json_encode(['success' => false, 'message' => 'Заполните все обязательные поля.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Products (name, id_type_product, price, number_of_grams, description, constituent, image, stock_quantity) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $id_type_product, $price, $grams, $description, $constituent, $image, $stock]);
            echo json_encode(['success' => true]);
            break;

        case 'order':
            $id_user = $_POST['id_user'] ?? '';
            $address = $_POST['address'] ?? '';
            $entrance = $_POST['entrance'] ?? '';
            $floor = $_POST['floor'] ?? '';
            $apartment = $_POST['apartment'] ?? '';
            $intercom = $_POST['intercom'] ?? '';
            $comment = $_POST['comment'] ?? '';
            $total_price = $_POST['total_price'] ?? '';
            $id_status = $_POST['id_status'] ?? '';

            if (!$id_user || !$address || $total_price === '' || !$id_status) {
                echo json_encode(['success' => false, 'message' => 'Обязательные поля не заполнены']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Orders (id_user, address, entrance, floor, apartment, intercom, comment, total_price, id_status)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$id_user, $address, $entrance, $floor, $apartment, $intercom, $comment, $total_price, $id_status]);
            echo json_encode(['success' => $result]);
            break;

        case 'order_item':
            $id_order = intval($_POST['id_order'] ?? 0);
            $id_product = intval($_POST['id_product'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 0);
            $price = floatval($_POST['price'] ?? 0);

            if (!$id_order || !$id_product || !$quantity || !$price) {
                echo json_encode(['success' => false, 'message' => 'Заполните все обязательные поля.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Order_Items (id_order, id_product, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_order, $id_product, $quantity, $price]);

            echo json_encode(['success' => true]);
            break;

        case 'basket':
            $id_user = $_POST['id_user'] ?? '';
            $id_product = $_POST['id_product'] ?? '';
            $quantity = $_POST['quantity'] ?? '1';

            if (!$id_user || !$id_product || !$quantity) {
                echo json_encode(['success' => false, 'message' => 'Заполните все обязательные поля.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Basket (id_user, id_product, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$id_user, $id_product, $quantity]);

            echo json_encode(['success' => true]);
            break;

        case 'status':
            $name = trim($_POST['name'] ?? '');

            if (!$name) {
                echo json_encode(['success' => false, 'message' => 'Введите название статуса.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Status (name) VALUES (?)");
            $stmt->execute([$name]);

            echo json_encode(['success' => true]);
            break;

        case 'feedback':
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (!$first_name || !$last_name || !$email || !$message) {
                echo json_encode(['success' => false, 'message' => 'Заполните все обязательные поля.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Feedback_Messages (first_name, last_name, email, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $message]);

            echo json_encode(['success' => true]);
            break;

        case 'ingredient':
            $name = trim($_POST['name'] ?? '');
            $type = trim($_POST['type'] ?? '');

            if (!$name || !$type) {
                echo json_encode(['success' => false, 'message' => 'Заполните все обязательные поля.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Ingredients (name, type) VALUES (?, ?)");
            $stmt->execute([$name, $type]);

            echo json_encode(['success' => true]);
            break;

        case 'product_ingredient':
            $id_product = $_POST['id_product'] ?? '';
            $id_ingredient = $_POST['id_ingredient'] ?? '';

            if (!$id_product || !$id_ingredient) {
                echo json_encode(['success' => false, 'message' => 'Выберите товар и ингредиент.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Product_Ingredients (id_product, id_ingredient) VALUES (?, ?)");
            $stmt->execute([$id_product, $id_ingredient]);

            echo json_encode(['success' => true]);
            break;

        case 'type_user':
            $name = trim($_POST['name'] ?? '');
            if (!$name) {
                echo json_encode(['success' => false, 'message' => 'Название обязательно.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Type_User (name) VALUES (?)");
            $stmt->execute([$name]);
            echo json_encode(['success' => true]);
            break;

        case 'suppliers':
            $name = trim($_POST['name'] ?? '');
            if (!$name) {
                echo json_encode(['success' => false, 'message' => 'Название поставщика обязательно.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Suppliers (name) VALUES (?)");
            $stmt->execute([$name]);
            echo json_encode(['success' => true]);
            break;

        case 'supplier_products':
            $id_supplier = $_POST['id_supplier'] ?? '';
            $id_product = $_POST['id_product'] ?? '';

            if (!$id_supplier || !$id_product) {
                echo json_encode(['success' => false, 'message' => 'Выберите поставщика и изделие.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO Supplier_Products (id_supplier, id_product) VALUES (?, ?)");
            $stmt->execute([$id_supplier, $id_product]);
            echo json_encode(['success' => true]);
            break;



        default:
            echo json_encode(['success' => false, 'message' => 'Неизвестный тип добавления']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка БД: ' . $e->getMessage()]);
}
