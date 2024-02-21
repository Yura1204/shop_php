<?php
class UserModel {
    private $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    public function registerUser($login, $password, $first_name, $last_name, $email, $region, $user_type) {
        $query = "INSERT INTO app_users (login, password, first_name, last_name, email, region, user_type) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
    
        // 'sssssss' для строковых параметров
        $stmt->bind_param('sssssss', $login, $password, $first_name, $last_name, $email, $region, $user_type);
        $stmt->execute();
        $stmt->close();
    }

    public function loginUser($login, $password) {
        // Получение хэша пароля из базы данных
        $query = "SELECT user_id, login, password FROM app_users WHERE login = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->bind_result($user_id, $db_login, $db_password);
        $stmt->fetch();
        $stmt->close();
    
        // Проверка совпадения хэша пароля
        if (password_verify($password, $db_password)) {
            // Успешный вход, сохранение информации о пользователе в сессии, если нужно
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['login'] = $db_login;
            return true;
        } else {
            return false;
        }
    }

    public function getUserId($login) {
        $query = "SELECT user_id FROM app_users WHERE login = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
    
        return $user_id;
    }

    public function getUserData($userId) {
        $query = "SELECT * FROM app_users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();
    
        return $userData;
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM app_users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function getUserType($userId) {
        $query = "SELECT user_type FROM app_users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($userType);
        $stmt->fetch();
        $stmt->close();
        return $userType;
    }
}
?>
