<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/OrderController.php';
require_once __DIR__ . '/../models/OrderModel.php';

$userController = new UserController($conn);
$orderController = new OrderController($conn);
$orderModel = new OrderModel($conn);

// Проверка типа пользователя
$userId = $_SESSION['user_id'];
$userType = $userController->getUserType($userId);

if ($userType !== 'manager') {
    // Если не менеджер, перенаправляем на другую страницу
    header("Location: /profile.php");
    exit();
}

// Обработка изменения статуса заказа
if (isset($_POST['change_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];

    // Изменение статуса заказа
    $orderController->changeOrderStatus($orderId, $newStatus);
}

// Получение списка всех заказов для удобства выбора
$orders = $orderModel->getOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/manager_profile_style.css">
    <title>Менеджер</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="manager-container">
        <h2>Менеджер</h2>
        <form action="profile.php" method="POST">
            <h3>Изменить статус заказа</h3>
            <label for="order_id">Выберите заказ:</label>
            <select name="order_id" required>
                <?php foreach ($orders as $order): ?>
                    <option value="<?php echo $order['order_id']; ?>"><?php echo $order['order_id']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="new_status">Выберите новый статус:</label>
            <select name="new_status" required>
                <option value="shipped">Отправлен</option>
                <option value="pending">В ожидании</option>
                <option value="delivered">Доставлен</option>
            </select>

            <button type="submit" name="change_status">Изменить статус</button>
        </form>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
