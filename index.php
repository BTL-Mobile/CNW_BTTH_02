<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once './config/Database.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
    case 'auth':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        if ($action == 'register') $auth->register();
        elseif ($action == 'login') $auth->login();
        elseif ($action == 'logout') $auth->logout(); 
        break;

    case 'admin':
        require_once 'controllers/AdminController.php';
        $admin = new AdminController();
        if ($action == 'index') $admin->index();
        elseif ($action == 'delete') $admin->delete();
        break;
        
    default:
        echo "Trang chủ (Đang cập nhật...)";
        break;
}
?>