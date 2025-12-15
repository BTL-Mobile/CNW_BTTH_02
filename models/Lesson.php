<?php
require_once 'config/Database.php';

class Lesson {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getByCourse($course_id) {
        $stmt = $this->conn->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY `order` ASC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- CẬP NHẬT: Thêm $video_url vào hàm create ---
    public function create($course_id, $title, $content, $video_url, $order) {
        $sql = "INSERT INTO lessons (course_id, title, content, video_url, `order`, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$course_id, $title, $content, $video_url, $order]);
    }
    
    // (Bạn nên thêm hàm update, delete tương tự nếu cần)
}
?> 