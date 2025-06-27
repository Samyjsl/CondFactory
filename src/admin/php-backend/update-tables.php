<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 2) {
    header('Location: /main-menu.php');
    exit;
}

require 'db.php';
header('Content-Type: application/json');

try {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!$data || !isset($data['type'])) {
        throw new Exception('Неверный формат запроса');
    }

    $type = $data['type'];

    switch ($type) {
        case 'product':
            if (empty($data['id_product'])) throw new Exception('Нет ID изделия');

            $stmt = $pdo->prepare("
                UPDATE Products SET 
                    name = :name,
                    id_type_product = :id_type_product,
                    price = :price,
                    number_of_grams = :number_of_grams,
                    description = :description,
                    constituent = :constituent,
                    image = :image,
                    stock_quantity = :stock_quantity
                WHERE id_product = :id_product
            ");
            $stmt->execute([
                ':name' => $data['name'],
                ':id_type_product' => $data['id_type_product'],
                ':price' => $data['price'],
                ':number_of_grams' => $data['number_of_grams'],
                ':description' => $data['description'],
                ':constituent' => $data['constituent'],
                ':image' => $data['image'],
                ':stock_quantity' => $data['stock_quantity'],
                ':id_product' => $data['id_product'],
            ]);
            break;

        case 'user':
            if (empty($data['id_user'])) throw new Exception('Нет ID пользователя');

            $stmt = $pdo->prepare("
                UPDATE Users SET 
                    name = :name,
                    surname = :surname,
                    email = :email,
                    password = :password,
                    id_type_user = :id_type_user
                WHERE id_user = :id_user
            ");
            $stmt->execute([
                ':name' => $data['name'],
                ':surname' => $data['surname'],
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':id_type_user' => $data['id_type_user'],
                ':id_user' => $data['id_user']
            ]);
            break;

        case 'order':
            if (empty($data['id_order'])) throw new Exception('Нет ID заказа');

            $stmt = $pdo->prepare("
                UPDATE Orders SET 
                    id_user = :id_user,
                    address = :address,
                    entrance = :entrance,
                    floor = :floor,
                    apartment = :apartment,
                    intercom = :intercom,
                    comment = :comment,
                    total_price = :total_price,
                    id_status = :id_status
                WHERE id_order = :id_order
            ");
            $stmt->execute([
                ':id_user' => $data['id_user'],
                ':address' => $data['address'],
                ':entrance' => $data['entrance'],
                ':floor' => $data['floor'],
                ':apartment' => $data['apartment'],
                ':intercom' => $data['intercom'],
                ':comment' => $data['comment'],
                ':total_price' => $data['total_price'],
                ':id_status' => $data['id_status'],
                ':id_order' => $data['id_order']
            ]);
            break;
        case 'order_item':
            if (empty($data['id_order_item'])) throw new Exception('Нет ID записи');
            $stmt = $pdo->prepare("
                UPDATE Order_Items SET 
                id_order = :id_order,
                id_product = :id_product,
                quantity = :quantity,
                price = :price
                WHERE id_order_item = :id_order_item
                ");
            $stmt->execute([
                ':id_order' => $data['id_order'],
                ':id_product' => $data['id_product'],
                ':quantity' => $data['quantity'],
                ':price' => $data['price'],
                ':id_order_item' => $data['id_order_item']
            ]);
            break;

        case 'basket':
            if (empty($data['id_basket'])) throw new Exception('Нет ID записи корзины');

            $stmt = $pdo->prepare("
                UPDATE Basket SET 
                id_user = :id_user,
                id_product = :id_product,
                quantity = :quantity
                WHERE id_basket = :id_basket
                ");
            $stmt->execute([
                ':id_user' => $data['id_user'],
                ':id_product' => $data['id_product'],
                ':quantity' => $data['quantity'],
                ':id_basket' => $data['id_basket']
            ]);
            break;

        case 'status':
            if (empty($data['id_status'])) throw new Exception('Нет ID статуса');

            $stmt = $pdo->prepare("UPDATE Status SET name = :name WHERE id_status = :id_status");
            $stmt->execute([
                ':name' => $data['name'],
                ':id_status' => $data['id_status']
            ]);
            break;

        case 'feedback':
            if (empty($data['id'])) throw new Exception('Нет ID отзыва');

            $stmt = $pdo->prepare("
                UPDATE Feedback_Messages 
                SET first_name = ?, last_name = ?, email = ?, message = ?
                WHERE id = ?
                ");
            $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['message'],
                $data['id']
            ]);
            break;

        case 'ingredient':
            if (empty($data['id_ingredient'])) throw new Exception('Нет ID ингредиента');

            $stmt = $pdo->prepare("
                UPDATE Ingredients SET 
                name = ?, 
                type = ?
                WHERE id_ingredient = ?
                ");
            $stmt->execute([
                $data['name'],
                $data['ingredient_type'],
                $data['id_ingredient']
            ]);
            break;

        case 'product_ingredient':
            if (empty($data['id_product_ingredients'])) throw new Exception('Нет ID записи состава изделия');

            $stmt = $pdo->prepare("
                UPDATE Product_Ingredients SET 
                id_product = ?,
                id_ingredient = ?
                WHERE id_product_ingredients = ?
                ");
            $stmt->execute([
                $data['id_product'],
                $data['id_ingredient'],
                $data['id_product_ingredients']
            ]);
            break;

        case 'type_user':
            if (empty($data['id_type_user']) || empty($data['name'])) {
                echo json_encode(['error' => 'Поля обязательны']);
                exit;
            }
            $stmt = $pdo->prepare("UPDATE Type_User SET name = ? WHERE id_type_user = ?");
            $success = $stmt->execute([$data['name'], $data['id_type_user']]);
            break;

        case 'supplier':
            if (empty($data['id_supplier'])) throw new Exception('Нет ID поставщика');

            $stmt = $pdo->prepare("UPDATE Suppliers SET name = :name WHERE id_supplier = :id_supplier");
            $stmt->execute([
                ':name' => $data['name'],
                ':id_supplier' => $data['id_supplier']
            ]);
            break;

        case 'supplier_product':
            if (empty($data['id_supplier_product'])) throw new Exception('Нет ID изделия у поставщика');
            if (empty($data['id_supplier'])) throw new Exception('Не выбран поставщик');
            if (empty($data['id_product'])) throw new Exception('Не выбрано изделие');

            $stmt = $pdo->prepare("
                UPDATE Supplier_Products SET 
                    id_supplier = :id_supplier,
                    id_product = :id_product
                WHERE id_supplier_product = :id_supplier_product
            ");
            $stmt->execute([
                ':id_supplier' => $data['id_supplier'],
                ':id_product' => $data['id_product'],
                ':id_supplier_product' => $data['id_supplier_product'],
            ]);
            break;


        default:
            throw new Exception('Неизвестный тип обновления');
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
