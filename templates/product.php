<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "shop_db");

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Создание объекта контроллера товаров и передача объекта базы данных
$productController = new ProductController($conn);

// Получаем идентификатор товара из параметров запроса
$productId = !empty($_GET['product_id']) ? (int)$_GET['product_id'] : null;

// Получаем данные о товаре из базы данных
$product = $productController->showProduct($productId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Каталог товаров</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="product-container-single">
        <?php if ($product): ?>
        <img src='data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>' alt="<?php echo $product['product_name']; ?>">
        <h3><?php echo $product['product_name']; ?></h3>
        <p><?php echo $product['description']; ?></p>
        <p>Цена: <?php echo $product['price']; ?> руб.</p>
        <form action="add_to_cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
            <input type="number" name="quantity" min="1" value="1">
            <button type="submit">Add to Cart</button>
        </form>
    <?php else: ?>
        <p>Товар не найден.</p>
    <?php endif; ?>

    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
