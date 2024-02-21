<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';
require_once '../controllers/UserController.php';
require_once '../controllers/OrderController.php';

$userController = new UserController($conn);
$orderController = new OrderController($conn);

$userData = $userController->getUserData($_SESSION['user_id']);
$userOrders = $orderController->getUserOrders($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Личный кабинет</title>
    <style>
        .profile-container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.profile-container h2 {
    text-align: center;
    color: #333;
}

.profile-container p {
    margin-bottom: 10px;
    color: #333;
}

.profile-container a {
    display: block;
    text-align: center;
    text-decoration: none;
    color: #fff;
    background-color: #333;
    padding: 10px 15px;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.profile-container a:hover {
    background-color: #555;
}
    </style>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="profile-container">
        <h2>Личный кабинет</h2>
        <p>Привет, <?php echo $userData['first_name']; ?>!</p>
        <p>Ваш логин: <?php echo $userData['login']; ?></p>
        <p>Ваша фамилия: <?php echo $userData['last_name']; ?></p>
        <p>Email: <?php echo $userData['email']; ?></p>
        <p>Регион: <?php echo $userData['region']; ?></p>

        <h3>Ваши заказы:</h3>
        <?php if ($userOrders): ?>
            <ul>
                <?php foreach ($userOrders as $order): ?>
                    <li>
                        Заказ №<?php echo $order['order_id']; ?>,
                        Статус: <?php echo $orderController->getStatusNameRussian($order['order_status']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>У вас пока нет заказов.</p>
        <?php endif; ?>

        <a href="logout.php">Выйти</a>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
