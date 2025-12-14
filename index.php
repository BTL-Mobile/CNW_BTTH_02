<?php
session_start();

$controller = $_GET['controller'] ?? 'course';
$action = $_GET['action'] ?? 'myCourses';

$controllerName = ucfirst($controller) . "Controller";
$file = "controllers/$controllerName.php";

if (!file_exists($file)) {
    die("Controller không tồn tại");
}

require_once $file;
$object = new $controllerName();

if (!method_exists($object, $action)) {
    die("Action không tồn tại");
}

$object->$action();
