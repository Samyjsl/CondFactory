<?php
require_once(__DIR__ . '/db.php');

$type = $_GET['type'] ?? '';

if ($type === 'products') {
    $stmt = $conn->query("SELECT * FROM Products");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'users') {
    $stmt = $conn->query("SELECT * FROM Users");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'orders') {
    $stmt = $conn->query("SELECT * FROM Orders");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'order_items') {
    $stmt = $conn->query("SELECT * FROM Order_Items");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'basket') {
    $stmt = $conn->query("SELECT * FROM Basket");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'feedback') {
    $stmt = $conn->query("SELECT * FROM Feedback_Messages");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'status') {
    $stmt = $conn->query("SELECT * FROM Status");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'ingredients') {
    $stmt = $conn->query("SELECT * FROM Ingredients");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} elseif ($type === 'product_ingredients') {
    $stmt = $conn->query("SELECT * FROM Product_Ingredients");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} 
elseif ($type === 'type_product') {
    $stmt = $conn->query("SELECT * FROM Type_Product");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}
elseif ($type === 'type_user') {
    $stmt = $conn->query("SELECT * FROM Type_User");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}
elseif ($type === 'suppliers') {
    $stmt = $conn->query("SELECT * FROM Suppliers");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}
elseif ($type === 'supplier_products') {
    $stmt = $conn->query("SELECT * FROM Supplier_Products");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

 else {
    echo json_encode([]);
}
?>
