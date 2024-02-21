<?php
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обработка формы регистрации
    require_once '../controllers/UserController.php';

    $userController = new UserController($conn);
    $userController->registerUser($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/register_style.css">
    <title>Регистрация</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="form-register">
        <h2>Регистрация</h2>
        <form action="register.php" method="POST">
            <label for="login">Логин:</label>
            <input type="text" name="login" required class="input-register">

            <label for="password">Пароль:</label>
            <input type="password" name="password" required class="input-register">

            <label for="first_name">Имя:</label>
            <input type="text" name="first_name" required class="input-register">

            <label for="last_name">Фамилия:</label>
            <input type="text" name="last_name" required class="input-register">

            <label for="email">Email:</label>
            <input type="email" name="email" required class="input-register">

            <label for="region">Регион:</label>
            <input type="text" name="region" class="input-register">

            <button type="submit">Зарегистрироваться</button>
        </form>
        <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
