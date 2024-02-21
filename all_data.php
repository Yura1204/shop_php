<?php
require_once 'config/db.php';

// Вывод данных из таблицы app_orders
$sql = "SELECT * FROM app_orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<h2>app_orders</h2><table border='1'>
  <tr>
    <th>order_id</th>
    <th>user_id</th>
    <th>order_status</th>
  </tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>" . $row["order_id"]. "</td>
      <td>" . $row["user_id"]. "</td>
      <td>" . $row["order_status"]. "</td>
    </tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}

// Вывод данных из таблицы app_products
$sql = "SELECT * FROM app_products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<h2>app_products</h2><table border='1'>
  <tr>
    <th>product_id</th>
    <th>product_name</th>
    <th>description</th>
    <th>price</th>
    <th>image</th>
  </tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>" . $row["product_id"]. "</td>
      <td>" . $row["product_name"]. "</td>
      <td>" . $row["description"]. "</td>
      <td>" . $row["price"]. "</td>
      <td><img width='200' height='200' src='data:image/jpeg;base64,".base64_encode($row['image'])."'></td>
    </tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}

// Вывод данных из таблицы app_users
$sql = "SELECT * FROM app_users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<h2>app_users</h2><table border='1'>
  <tr>
    <th>user_id</th>
    <th>login</th>
    <th>first_name</th>
    <th>last_name</th>
    <th>email</th>
    <th>region</th>
    <th>password</th>
    <th>user_type</th>
  </tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>" . $row["user_id"]. "</td>
      <td>" . $row["login"]. "</td>
      <td>" . $row["first_name"]. "</td>
      <td>" . $row["last_name"]. "</td> <td>" . $row["email"]. "</td> <td>" . $row["region"]. "</td> <td>" . $row["password"]. "</td> <td>" . $row["user_type"]. "</td> </tr>"; } echo "</table>"; } else { echo "0 results"; }
      
      $conn->close();
      ?>