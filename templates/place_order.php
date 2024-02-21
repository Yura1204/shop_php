<?php
session_start();

require_once '../config/db.php';
require_once '../controllers/OrderController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $userId = $_SESSION['user_id'];
        $cart = $_SESSION['cart'];

        $orderController = new OrderController($conn);

        if ($orderController->createOrder($userId, $cart)) {
            $message = "Заказ успешно оформлен!";
            $divClass = "success-message";
        } else {
            $message = "Ошибка оформления заказа.";
            $divClass = "error-message";
        }
    } else {
        $message = "Недостаточно данных для создания заказа.";
        $divClass = "error-message";
    }
} else {
    $message = "Invalid request method.";
    $divClass = "error-message";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Добавленные стили для div-контейнера */
        .message-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .success-message {
            background-color: #dff0d8; /* Зеленый цвет для успешных сообщений */
            color: #3c763d;
        }

        .error-message {
            background-color: #f2dede; /* Красный цвет для сообщений об ошибках */
            color: #a94442;
        }
    </style>
    <title>Order Status</title>
</head>
<body>

<?php include '../templates/header.php'; ?>

<!-- Добавленный div-контейнер -->
<div class="message-container <?php echo $divClass; ?>">
    <p><?php echo $message; ?></p>
</div>

<?php include '../templates/footer.php'; ?>

</body>
</html>
