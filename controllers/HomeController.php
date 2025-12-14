<?php
require_once 'models/Category.php';
require_once 'models/Course.php';

class HomeController {
    public function index() {
        $db = Database::getConnection();

        $categoryModel = new Category($db);
        $categories = $categoryModel->getAll();

        $courseModel = new Course($db);

        $keyword = $_GET['keyword'] ?? '';
        $categoryId = $_GET['category'] ?? null;

        $courses = $courseModel->search($keyword, $categoryId);

        require 'views/home/index.php';
    }
}
