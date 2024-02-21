<?php
class OrderController {
    private $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    public function changeOrderStatus($orderId, $newStatus) {
        $query = "UPDATE app_orders SET order_status = ? WHERE order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $newStatus, $orderId);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function createOrder($userId, $cart) {
        $orderNumber = $this->generateOrderNumber();

        $stmt = $this->db->prepare("INSERT INTO app_orders (user_id, product_id, quantity, order_status) VALUES (?, ?, ?, 'pending')");

        foreach ($cart as $productId => $cartItem) {
            $stmt->bind_param("iii", $userId, $productId, $cartItem['quantity']);
            $stmt->execute();
        }

        unset($_SESSION['cart']);

        return true;
    }

    private function generateOrderNumber() {
        return 'ORDER' . uniqid();
    }

    public function getUserOrders($userId) {
        $query = "SELECT * FROM app_orders WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $orders = [];

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();

        return $orders;
    }

    public function getStatusNameRussian($status) {
        switch ($status) {
            case 'pending':
                return 'В ожидании';
            case 'shipped':
                return 'Отправлен';
            case 'delivered':
                return 'Доставлен';
            default:
                return 'Неизвестный статус';
        }
    }
}
?>
