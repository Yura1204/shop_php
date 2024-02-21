<?php
class OrderModel {
    private $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    public function getOrders() {
        $query = "SELECT * FROM app_orders";
        $result = $this->db->query($query);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>