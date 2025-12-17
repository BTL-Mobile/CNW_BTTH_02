<?php
session_start();

// Giả lập đăng nhập (Vì chưa có hệ thống Login)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; 
}

require_once 'config/Database.php';

$controllerName = $_GET['controller'] ?? 'Course';
$action = $_GET['action'] ?? 'manage';

// Bảo mật: Chỉ cho phép tên controller chứ chữ cái và số
if (!preg_match('/^[a-zA-Z0-9]+$/', $controllerName)) {
    die("Controller không hợp lệ.");
}

$controllerFile = "controllers/{$controllerName}Controller.php";
$controllerClass = $controllerName . 'Controller';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $controllerObj = new $controllerClass();
        if (method_exists($controllerObj, $action)) {
            $controllerObj->$action();
        } else {
            die("Action '$action' không tồn tại.");
        }
    } else {
        die("Class '$controllerClass' không tồn tại.");
    }
} else {
    die("File Controller '$controllerFile' không tìm thấy.");
}
?>