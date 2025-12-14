<?php
require_once "models/Course.php";

function checkRole($role) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != $role) {
        die("Không có quyền truy cập");
    }
}

class CourseController {

    public function myCourses() {
        // giả lập đăng nhập giảng viên
        $_SESSION['user'] = ['id' => 1, 'role' => 1];

        $courses = (new Course())->getByInstructor($_SESSION['user']['id']);
        require "views/instructor/course/my_courses.php";
    }
}
