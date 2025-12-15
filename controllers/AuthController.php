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
            $user->fullname = trim($_POST['fullname'] ?? '');

            
            if ($user->register()) {
                header("Location: index.php?controller=auth&action=login");
                exit();
            } else {
                $error = "Đăng ký không thành công. Username hoặc Email có thể đã tồn tại.";
            }
        }

        include __DIR__ . '/../views/auth/register.php';
    }

    // Cập nhật hàm login() trong AuthController.php
    public function login() {
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);

            $user->username = trim($_POST['username'] ?? '');
            $user->password = $_POST['password'] ?? '';

            if($user->login()) {
                // Đăng nhập thành công: Lưu thông tin vào SESSION
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role; // Quan trọng để phân quyền
                $_SESSION['fullname'] = $user->fullname;

                // Kiểm tra quyền để chuyển hướng (Role 1: Giảng viên, 0: Học viên)
                if($user->role == 1) {
                    header("Location: index.php?controller=instructor&action=index");
                } elseif ($user->role == 2) {
                    header("Location: index.php?controller=admin&action=index");
                } else {
                    header("Location: index.php?controller=student&action=index");
                }
                exit();
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không chính xác!";
            }
        }
        // Hiển thị view login
        include 'views/auth/login.php';
    }

    // hàm Đăng xuất (Logout) 
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy(); // Xóa sạch session
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
}
?>