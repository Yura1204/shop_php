<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/catalog_style.css">
    <title>Каталог товаров</title>
</head>
<body>

    <div class="product-container">
        <?php foreach ($products as $product): ?>
            <div class="product" onclick="redirectToProduct(<?php echo $product['product_id']; ?>)">
                <img src='data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>' alt="<?php echo $product['product_name']; ?>">
                <h3><?php echo $product['product_name']; ?></h3>
                <p>Цена: <?php echo $product['price']; ?> руб.</p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function redirectToProduct(productId) {
            // Перенаправление на страницу товара с уникальным идентификатором productId
            window.location.href = 'templates/product.php?product_id=' + productId;
        }
    </script>

</body>
</html>
