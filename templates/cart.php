<?php
session_start();
require_once '../config/db.php';

// Проверяем авторизацию пользователя
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function getProductDetails($productId)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM app_products WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function createOrder($userId, $products)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO app_orders (user_id, product_id, quantity, order_status) VALUES (?, ?, ?, 'pending')");
    
    foreach ($products as $productId => $cartItem) {
        $stmt->bind_param("iii", $userId, $productId, $cartItem['quantity']);
        $stmt->execute();
    }

    return $conn->insert_id;
}

$totalPrice = 0;
$itemCount = 0;

include '../templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/cart_style.css">
    <title>Your Cart</title>
</head>
<body>

<div class="cart-container"> <!-- Добавим контейнер -->
    <?php
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Ваша корзина пуста.</p>";
    } else {
        echo '<table border="1"><tr><th>Product Name</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr>';
        foreach ($_SESSION['cart'] as $productId => $cartItem) {
            $productDetails = getProductDetails($productId);
            if (!$productDetails) continue;

            $unitPrice = $productDetails['price'];
            $quantity = isset($cartItem['quantity']) ? $cartItem['quantity'] : 1;
            $subtotal = $unitPrice * $quantity;

            // Обновим общую стоимость и количество товаров
            $totalPrice += $subtotal;
            $itemCount += $quantity;

            echo "<tr>
                    <td>{$productDetails['product_name']}</td>
                    <td>$quantity</td>
                    <td>\$$unitPrice</td>
                    <td>\$$subtotal</td>
                    <td>
                        <form action=\"remove_from_cart.php\" method=\"post\">
                            <input type=\"hidden\" name=\"product_id\" value=\"$productId\">
                            <button type=\"submit\">Удалить</button>
                        </form>
                    </td>
                  </tr>";
        }

        echo '</table>';

        printf('<p>%d элемент(ов) – Итог: %.2f</p>', $itemCount, $totalPrice);

        // Добавляем кнопку "Оформить заказ"
        echo <<<HTML
            <form action="place_order.php" method="post">
                <button type="submit" name="place_order">Оформить заказ</button>
            </form>
        HTML;
    }
    ?>
</div>

<?php include '../templates/footer.php'; ?>
</body>
</html>
