<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$userController = new UserController($conn);
$productController = new ProductController($conn);
$productModel = new ProductModel($conn);

// Проверка типа пользователя
$userId = $_SESSION['user_id'];
$userType = $userController->getUserType($userId);

if ($userType !== 'admin') {
    header("Location: /profile.php");
    exit();
}

// Обработка добавления товара
if (isset($_POST['add_product'])) {
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Обработка загрузки изображения
    $image = null;
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $imageData = file_get_contents($image['tmp_name']);
    }

    // Добавление товара
    $productController->addProduct($productName, $description, $price, $image);
}

// Обработка удаления товара
if (isset($_POST['delete_product'])) {
    $productIdToDelete = $_POST['product_id_to_delete'];

    $productToDelete = $productModel->getProductById($productIdToDelete);

    $productController->deleteProduct($productIdToDelete);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin_profile_style.css">
    <title>Администратор</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="admin-container">
        <h2>Администратор</h2>
        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <h3>Добавить новый товар</h3>
            <label for="product_name">Название товара:</label>
            <input type="text" name="product_name" required>

            <label for="description">Описание товара:</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="price">Цена товара:</label>
            <input type="number" name="price" step="0.01" required>

            <label for="image">Изображение товара:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit" name="add_product">Добавить товар</button>
        </form>
        <br>

        <hr>

        <h2>Удаление продукта</h2>
        <form action="profile.php" method="POST">
            <h3>Удалить товар</h3>
            <label for="product_id_to_delete">Выберите товар для удаления:</label>
            <select name="product_id_to_delete" required>
                <?php foreach ($productModel->getProducts() as $product): ?>
                    <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="delete_product">Удалить товар</button>
        </form>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
