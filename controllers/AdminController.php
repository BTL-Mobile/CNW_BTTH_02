<?php
require_once 'config/Database.php';
require_once 'models/User.php';

class AdminController {

    public function __construct() {
        // [QUAN TRỌNG] Kiểm tra quyền Admin ngay khi khởi tạo
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Nếu chưa đăng nhập HOẶC role không phải là 2 (Admin)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            // Đuổi về trang login hoặc trang chủ
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    // Hiển thị danh sách User
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $userModel = new User($db);

        // Lấy danh sách từ Model
        $users = $userModel->getAllUsers();

        // Gọi View để hiển thị
        //include 'views/admin/users/manage.php';
        require 'views/admin/users/manage.php';
    }

    // Chức năng xóa user
    public function delete() {
        if (isset($_GET['id'])) {
            $database = new Database();
            $db = $database->getConnection();
            $userModel = new User($db);
            
            $userModel->delete($_GET['id']);
            
            // Xóa xong quay lại trang danh sách
            header("Location: index.php?controller=admin&action=index");
        }
    }
}
?>