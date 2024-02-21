<?php
class ProductModel {
    private $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    public function getProducts() {
        $query = "SELECT * FROM app_products";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($productId) {
        $query = "SELECT * FROM app_products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        return $product;
    }

    public function isProductExists($productId) {
        $query = "SELECT COUNT(*) FROM app_products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }
}
?>
