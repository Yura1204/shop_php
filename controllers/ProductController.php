<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/ProductModel.php';

function processImage($imageData) {
    return file_get_contents($_FILES['image']['tmp_name']);
}

class ProductController {
    private $productModel;
    private $db;

    public function __construct(mysqli $db) {
        // Инициализация модели товаров, передача объекта базы данных
        $this->productModel = new ProductModel($db);
        $this->db = $db;
    }

    public function showCatalog() {
        // Получение данных о продуктах из базы данных
        $products = $this->productModel->getProducts();

        // Отображение страницы с каталогом товаров
        include 'templates/catalog.php';

        // Закрытие соединения с базой данных
        $this->db->close();
    }

    public function showProduct($productId) {
        // Проверяем существование товара перед отображением страницы
        $productExists = $this->productModel->isProductExists($productId);

        if ($productExists) {
            // Если товар существует, получаем информацию о нем и возвращаем
            return $this->productModel->getProductById($productId);
        } else {
            // Если товар не существует, возвращаем null или выполняем другие действия, например, перенаправление на страницу ошибки
            return null;
        }
    }

    public function addProduct($productName, $description, $price, $imageData) {
        $query = "INSERT INTO app_products (product_name, description, price, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        $processedImageData = processImage($imageData);
        
        $stmt->bind_param("ssds", $productName, $description, $price, $processedImageData);
        
        if ($stmt->execute()) {
            // Успешно добавлено
            echo "Товар успешно добавлен!";
        } else {
            // Ошибка при добавлении
            echo "Ошибка при добавлении товара: " . $stmt->error;
        }
    
        $stmt->close();
    }
    
    public function deleteProduct($productId) {
        $query = "DELETE FROM app_products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
    
        if ($stmt->execute()) {
            // Успешно удалено
            echo "Продукт успешно удален!";
        } else {
            // Ошибка при удалении
            echo "Ошибка при удалении продукта: " . $stmt->error;
        }
    
        $stmt->close();
    }

}
?>
