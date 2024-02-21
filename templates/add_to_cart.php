<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405); // Method Not Allowed
    die('Please submit the form through the provided interface.');
}

$productId = filter_var(trim($_POST['product_id'] ?? null), FILTER_VALIDATE_INT);
$quantity = trim($_POST['quantity'] ?? null);

if (!$productId || $productId <= 0) {
    header('Location: index.php?error=missing_or_invalid_product_id');
    exit;
}

if (!is_numeric($quantity) || $quantity <= 0) {
    $quantity = 1;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (array_key_exists($productId, $_SESSION['cart'])) {
    ++$_SESSION['cart'][$productId]['quantity'];
} else {
    $_SESSION['cart'][$productId] = [
        'quantity' => $quantity,
    ];
}

header('Location: cart.php');
exit;
?>
