<?php
// Подключение файла настроек базы данных
require_once 'config/db.php';

// Подключение контроллеров и моделей
require_once 'controllers/ProductController.php';
require_once 'models/ProductModel.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>My Online Store</title>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <?php
    // Создание объекта контроллера товаров
    $productController = new ProductController($conn);

    // Проверяем, есть ли product_id в запросе
    if (isset($_GET['product_id'])) {
        // Если есть, вызываем метод showProduct
        $productController->showProduct($_GET['product_id']);
    } else {
        // Если нет, отображаем каталог товаров
        $productController->showCatalog();
    }
    ?>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
