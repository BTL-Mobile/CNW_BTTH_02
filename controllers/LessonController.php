<?php
require_once 'models/Lesson.php';

class LessonController {
    private $lessonModel;

    public function __construct() {
        $this->lessonModel = new Lesson();
    }

    public function manage() {
        $course_id = $_GET['course_id'];
        $lessons = $this->lessonModel->getByCourse($course_id);
        include 'views/instructor/lessons/manage.php';
    }

    public function create() {
        $course_id = $_GET['course_id'];
        include 'views/instructor/lessons/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->lessonModel->create($_POST['course_id'], $_POST['title'], $_POST['content'], $_POST['order']);
            header("Location: index.php?controller=Lesson&action=manage&course_id=" . $_POST['course_id']);
        }
    }
}
?>