<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;
    private $db;

    public function __construct(mysqli $db) {
        $this->userModel = new UserModel($db);
        $this->db = $db;
    }

    public function registerUser($userData) {
        // Обработка данных формы регистрации
        $login = $userData['login'];
        $password = password_hash($userData['password'], PASSWORD_DEFAULT);
        $first_name = $userData['first_name'];
        $last_name = $userData['last_name'];
        $email = $userData['email'];
        $region = $userData['region'];

        // Установка роли "regular" по умолчанию
        $user_type = 'regular';

        // Регистрация пользователя
        $this->userModel->registerUser($login, $password, $first_name, $last_name, $email, $region, $user_type);

        // Перенаправление на страницу после успешной регистрации
        header("Location: login.php");
        exit();
    }

    public function loginUser($userData) {
        // Обработка данных формы входа
        $login = $userData['login'];
        $password = $userData['password'];
    
        // Проверка входа пользователя
        $loggedIn = $this->userModel->loginUser($login, $password);
    
        if ($loggedIn) {
            // Перенаправление на страницу личного кабинета после успешного входа
            header("Location: profile.php");
            exit();
        } else {
            // Ошибка входа, например, отобразить сообщение об ошибке
            echo "Неправильный логин или пароль.";
        }
    }
    
    public function getUserData($userId) {
        return $this->userModel->getUserData($userId);
    }

    public function getUserById($userId) {
        // Получение данных о пользователе по его идентификатору
        return $this->userModel->getUserById($userId);
    }
    
    // Добавляем этот метод в контроллер, если его еще нет
    public function getUserType($userId) {
        // Получение типа пользователя по его идентификатору
        return $this->userModel->getUserType($userId);
    }
}
?>
