<?php
require_once 'models/Course.php';

class CourseController {
    private $courseModel;

    public function __construct() {
        $this->courseModel = new Course();
    }

    public function manage() {
        $instructor_id = $_SESSION['user_id'];
        $courses = $this->courseModel->getByInstructor($instructor_id);
        include 'views/instructor/courses/manage.php';
    }

    public function create() {
        include 'views/instructor/courses/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->courseModel->create($_POST['title'], $_POST['description'], $_SESSION['user_id']);
            header("Location: index.php?controller=Course&action=manage");
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $course = $this->courseModel->find($id, $_SESSION['user_id']);
        if (!$course) die("Không tìm thấy khóa học.");
        include 'views/instructor/courses/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->courseModel->update($_POST['id'], $_POST['title'], $_POST['description'], $_SESSION['user_id']);
            header("Location: index.php?controller=Course&action=manage");
        }
    }

    public function delete() {
        $id = $_GET['id'];
        $this->courseModel->delete($id, $_SESSION['user_id']);
        header("Location: index.php?controller=Course&action=manage");
    }
}
?>