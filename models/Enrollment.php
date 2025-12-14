<?php
class Enrollment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kiểm tra sinh viên đã đăng ký khóa học chưa
    public function isEnrolled($studentId, $courseId) {
        $sql = "SELECT * FROM enrollments 
                WHERE student_id = ? AND course_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->rowCount() > 0;
    }

    // Đăng ký khóa học
    public function enroll($studentId, $courseId) {
        $sql = "INSERT INTO enrollments(course_id, student_id, enrolled_date, status, progress)
                VALUES (?, ?, NOW(), 'active', 0)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$courseId, $studentId]);
    }

    // Lấy danh sách khóa học đã đăng ký
    public function getMyCourses($studentId) {
        $sql = "SELECT c.*, e.progress, e.status
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.student_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
