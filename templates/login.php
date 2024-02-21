<?php
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обработка формы входа
    require_once '../controllers/UserController.php';

    $userController = new UserController($conn);
    $userController->loginUser($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login_style.css">
    <title>Вход</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="form-login">
        <h2>Вход</h2>
        <form action="login.php" method="POST">
            <label for="login">Логин:</label>
            <input type="text" name="login" required class="input-login">

            <label for="password">Пароль:</label>
            <input type="password" name="password" required class="input-login">

            <button type="submit">Войти</button>
        </form>
        <p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
