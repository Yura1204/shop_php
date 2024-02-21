<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/UserController.php';

$userId = $_SESSION['user_id'];
$userController = new UserController($conn);
$userData = $userController->getUserById($userId);

if ($userData['user_type'] === 'admin') {
    include 'admin_profile.php';
} elseif ($userData['user_type'] === 'manager') {
    include 'manager_profile.php';
} else {
    include 'user_profile.php';
}
?>
