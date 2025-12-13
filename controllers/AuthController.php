<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function register() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);

            $user->username = trim($_POST['username'] ?? '');
            $user->email = trim($_POST['email'] ?? '');
            $user->password = $_POST['password'] ?? '';

            
            if ($user->register()) {
                header("Location: index.php?controller=auth&action=login");
                exit();
            } else {
                $error = "Đăng ký không thành công. Username hoặc Email có thể đã tồn tại.";
            }
        }

        include __DIR__ . '/../views/auth/register.php';
    }

    public function login() {
        include __DIR__ . '/../views/auth/login.php';
    }
}
?>