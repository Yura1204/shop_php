<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    die('Please submit the form through the provided interface.');
}

$productId = filter_var(trim($_POST['product_id'] ?? null), FILTER_VALIDATE_INT);

if (!$productId || $productId <= 0) {
    header('Location: cart.php?error=missing_or_invalid_product_id');
    exit;
}

if (isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
}

header('Location: cart.php?message=Product%20removed%20from%20cart.');
exit;
?>
