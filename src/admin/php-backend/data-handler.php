<?php

require 'db.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

try {
    switch ($action) {
        case 'products':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Products WHERE id_product = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT id_product, name, price FROM Products");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'users':
            if ($id) {
                $stmt = $pdo->prepare("SELECT id_user, name, surname, email, id_type_user FROM Users WHERE id_user = ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $user['full_name'] = $user['name'] . ' ' . $user['surname'];
                }
                echo json_encode($user);
            } else {
                $stmt = $pdo->query("SELECT id_user, CONCAT(name, ' ', surname) AS full_name, email FROM Users");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'orders':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Orders WHERE id_order = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT id_order, id_user, address, total_price FROM Orders");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'order_items':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Order_Items WHERE id_order_item = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT id_order_item, id_order, id_product, quantity, price FROM Order_Items");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'basket':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Basket WHERE id_basket = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM Basket");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'status':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Status WHERE id_status = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT id_status, name FROM Status");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'users-list':
            $stmt = $pdo->query("SELECT id_user, CONCAT(name, ' ', surname) AS full_name FROM Users");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'status-list':
            $stmt = $pdo->query("SELECT id_status, name FROM Status");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'feedback':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Feedback_Messages WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM Feedback_Messages ORDER BY created_at DESC");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'ingredients':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Ingredients WHERE id_ingredient = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM Ingredients ORDER BY name ASC");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'products-list':
            $stmt = $pdo->query("SELECT id_product, name FROM Products");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'ingredients-list':
            $stmt = $pdo->query("SELECT id_ingredient, name FROM Ingredients");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'product_ingredients':
            if (!empty($_GET['id'])) {
                $stmt = $pdo->prepare("
            SELECT 
            pi.id_product_ingredients,
            pi.id_product,
            pi.id_ingredient,
            p.name AS product_name,
            i.name AS ingredient_name
            FROM Product_Ingredients pi
            JOIN Products p ON pi.id_product = p.id_product
            JOIN Ingredients i ON pi.id_ingredient = i.id_ingredient
            WHERE pi.id_product_ingredients = ?
        ");
                $stmt->execute([$_GET['id']]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("
            SELECT 
            pi.id_product_ingredients,
            pi.id_product,
            pi.id_ingredient,
            p.name AS product_name,
            i.name AS ingredient_name
            FROM Product_Ingredients pi
            JOIN Products p ON pi.id_product = p.id_product
            JOIN Ingredients i ON pi.id_ingredient = i.id_ingredient
            ");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'type_user':
            if (!empty($_GET['id'])) {
                $stmt = $pdo->prepare("SELECT * FROM Type_User WHERE id_type_user = ?");
                $stmt->execute([$_GET['id']]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM Type_User");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'suppliers':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Suppliers WHERE id_supplier = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("SELECT * FROM Suppliers");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'supplier_products':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Supplier_Products WHERE id_supplier_product = ?");
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                $stmt = $pdo->query("
                    SELECT sp.id_supplier_product, sp.id_supplier, sp.id_product, 
                           s.name AS supplier_name, p.name AS product_name 
                    FROM Supplier_Products sp 
                    JOIN Suppliers s ON sp.id_supplier = s.id_supplier 
                    JOIN Products p ON sp.id_product = p.id_product
                ");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            break;

        case 'suppliers-list':
            $stmt = $pdo->query("SELECT id_supplier, name FROM Suppliers");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;


        default:
            echo json_encode(['error' => 'Неверное действие']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
