<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_db";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
  die("Соединение с базой данных не удалось: " . $conn->connect_error);
}
?>