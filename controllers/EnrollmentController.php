<?php
require_once 'models/Enrollment.php';

class EnrollmentController {

    // Đăng ký khóa học
    public function enroll() {
        session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $studentId = $_SESSION['user']['id'];
        $courseId = $_GET['course_id'];

        $db = Database::getConnection();
        $enrollmentModel = new Enrollment($db);

        if (!$enrollmentModel->isEnrolled($studentId, $courseId)) {
            $enrollmentModel->enroll($studentId, $courseId);
        }

        header("Location: index.php?controller=enrollment&action=myCourses");
    }

    // Xem khóa học đã đăng ký
    public function myCourses() {
        session_start();

        $studentId = $_SESSION['user']['id'];
        $db = Database::getConnection();

        $enrollmentModel = new Enrollment($db);
        $courses = $enrollmentModel->getMyCourses($studentId);

        require 'views/student/my_courses.php';
    }
}
