<?php
require 'db.php';
header('Content-Type: application/json');

try {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!$data || !isset($data['type'])) {
        throw new Exception('Неверные данные для удаления');
    }

    $pdo->beginTransaction();

    switch ($data['type']) {
        case 'product':
            $id = (int)$data['id_product'];
            // Сначала удаляем связанные записи
            $stmt = $pdo->prepare("DELETE FROM Order_Items WHERE id_product = ?");
            $stmt->execute([$id]);
            $stmt = $pdo->prepare("DELETE FROM Product_Ingredients WHERE id_product = ?");
            $stmt->execute([$id]);
            $stmt = $pdo->prepare("DELETE FROM Supplier_Products WHERE id_product = ?");
            $stmt->execute([$id]);
            $stmt = $pdo->prepare("DELETE FROM Basket WHERE id_product = ?");
            $stmt->execute([$id]);
            // Затем сам продукт
            $stmt = $pdo->prepare("DELETE FROM Products WHERE id_product = ?");
            $stmt->execute([$id]);
            break;

        case 'user':
            $id = (int)$data['id_user'];
            // Сначала заказы пользователя
            $stmt = $pdo->prepare("SELECT id_order FROM Orders WHERE id_user = ?");
            $stmt->execute([$id]);
            $orders = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if ($orders) {
                $in = str_repeat('?,', count($orders) - 1) . '?';
                $stmt = $pdo->prepare("DELETE FROM Order_Items WHERE id_order IN ($in)");
                $stmt->execute($orders);
                $stmt = $pdo->prepare("DELETE FROM Orders WHERE id_user = ?");
                $stmt->execute([$id]);
            }
            // Затем корзину и самого пользователя
            $stmt = $pdo->prepare("DELETE FROM Basket WHERE id_user = ?");
            $stmt->execute([$id]);
            $stmt = $pdo->prepare("DELETE FROM Users WHERE id_user = ?");
            $stmt->execute([$id]);
            break;

        case 'order':
            $id = (int)$data['id_order'];
            // Сначала элементы заказа
            $stmt = $pdo->prepare("DELETE FROM Order_Items WHERE id_order = ?");
            $stmt->execute([$id]);
            // Затем сам заказ
            $stmt = $pdo->prepare("DELETE FROM Orders WHERE id_order = ?");
            $stmt->execute([$id]);
            break;

        case 'order_item':
            $id = (int)$data['id_order_item'];
            $stmt = $pdo->prepare("DELETE FROM Order_Items WHERE id_order_item = ?");
            $stmt->execute([$id]);
            break;

        // Удаление корзины
        case 'basket':
            $id = (int)$data['id_basket'];
            $stmt = $pdo->prepare("DELETE FROM Basket WHERE id_basket = ?");
            $stmt->execute([$id]);
            break;

        case 'feedback':
            $id = isset($data['id_feedback']) ? (int)$data['id_feedback'] : (isset($data['id']) ? (int)$data['id'] : null);

            if ($id === null) {
                throw new Exception('Не указан ID сообщения для удаления');
            }

            $stmt = $pdo->prepare("DELETE FROM Feedback_Messages WHERE id = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() === 0) {
                throw new Exception('Сообщение не найдено или уже удалено');
            }
            break;

        // Удаление ингредиента
        case 'ingredient':
            $id = (int)$data['id_ingredient'];
            // Удаляем связи с продуктами
            $stmt = $pdo->prepare("DELETE FROM Product_Ingredients WHERE id_ingredient = ?");
            $stmt->execute([$id]);
            // Удаляем сам ингредиент
            $stmt = $pdo->prepare("DELETE FROM Ingredients WHERE id_ingredient = ?");
            $stmt->execute([$id]);
            break;

        // Удаление связи продукт-ингредиент
        case 'product_ingredient':
            // Используем 'id_product_ingredient' вместо 'id_product_ingredients'
            if (!isset($data['id_product_ingredient'])) {
                throw new Exception('Не указан ID связи продукт-ингредиент для удаления');
            }

            $id = (int)$data['id_product_ingredient'];
            $stmt = $pdo->prepare("DELETE FROM Product_Ingredients WHERE id_product_ingredients = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() === 0) {
                throw new Exception('Связь продукт-ингредиент не найдена или уже удалена');
            }
            break;

        // Удаление статуса
        case 'status':
            $id = (int)$data['id_status'];
            // Проверяем, используется ли статус в заказах
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Orders WHERE id_status = ?");
            $stmt->execute([$id]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                throw new Exception('Невозможно удалить статус: существуют заказы с этим статусом');
            }

            $stmt = $pdo->prepare("DELETE FROM Status WHERE id_status = ?");
            $stmt->execute([$id]);
            break;

        // Удаление поставщика
        case 'supplier':
            $id = (int)$data['id_supplier'];
            // Удаляем связи с продуктами
            $stmt = $pdo->prepare("DELETE FROM Supplier_Products WHERE id_supplier = ?");
            $stmt->execute([$id]);
            // Удаляем самого поставщика
            $stmt = $pdo->prepare("DELETE FROM Suppliers WHERE id_supplier = ?");
            $stmt->execute([$id]);
            break;

        // Удаление связи поставщик-продукт
        case 'supplier_product':
            $id = (int)$data['id_supplier_product'];
            $stmt = $pdo->prepare("DELETE FROM Supplier_Products WHERE id_supplier_product = ?");
            $stmt->execute([$id]);
            break;

        // Удаление типа продукта
        case 'type_product':
            $id = (int)$data['id_type_product'];
            // Проверяем, есть ли продукты этого типа
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Products WHERE id_type_product = ?");
            $stmt->execute([$id]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                throw new Exception('Невозможно удалить тип продукта: существуют продукты этого типа');
            }

            $stmt = $pdo->prepare("DELETE FROM Type_Product WHERE id_type_product = ?");
            $stmt->execute([$id]);
            break;

        // Удаление типа пользователя
        case 'type_user':
            $id = (int)$data['id_type_user'];
            // Проверяем, есть ли пользователи этого типа
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE id_type_user = ?");
            $stmt->execute([$id]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                throw new Exception('Невозможно удалить тип пользователя: существуют пользователи этого типа');
            }

            $stmt = $pdo->prepare("DELETE FROM Type_User WHERE id_type_user = ?");
            $stmt->execute([$id]);
            break;

        // Добавьте другие типы по аналогии
        default:
            throw new Exception('Неизвестный тип для удаления');
    }

    if (isset($stmt) && $stmt->rowCount() === 0 && !in_array($data['type'], ['order_item', 'basket', 'feedback', 'product_ingredient', 'supplier_product'])) {
        throw new Exception('Запись не найдена или уже удалена');
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['error' => $e->getMessage()]);
}
