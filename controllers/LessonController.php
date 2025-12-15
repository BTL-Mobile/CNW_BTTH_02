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

    // --- CẬP NHẬT: Lấy video_url từ $_POST ---
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $course_id = $_POST['course_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $video_url = $_POST['video_url']; // Lấy link video
            $order = $_POST['order'];

            // Gọi hàm create với đầy đủ 5 tham số
            $this->lessonModel->create($course_id, $title, $content, $video_url, $order);

            header("Location: index.php?controller=Lesson&action=manage&course_id=" . $course_id);
            exit();
        }
    }
}
?>