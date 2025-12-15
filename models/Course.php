<?php
// models/Course.php
require_once 'config/Database.php';

class Course {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy khóa học theo giảng viên
    public function getByInstructor($instructor_id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE instructor_id = ? ORDER BY id DESC");
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- CẬP NHẬT HÀM CREATE (Thêm price, level, image, category_id...) ---
    public function create($data) {
        $sql = "INSERT INTO courses 
                (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['instructor_id'],
            $data['category_id'],
            $data['price'],
            $data['duration_weeks'],
            $data['level'],
            $data['image']
        ]);
    }

    // Tìm chi tiết khóa học
    public function find($id, $instructor_id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id=? AND instructor_id=?");
        $stmt->execute([$id, $instructor_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- CẬP NHẬT HÀM UPDATE ---
    public function update($id, $data) {
        $sql = "UPDATE courses SET 
                title=?, description=?, category_id=?, price=?, duration_weeks=?, level=?, image=?, updated_at=NOW() 
                WHERE id=? AND instructor_id=?";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['category_id'],
            $data['price'],
            $data['duration_weeks'],
            $data['level'],
            $data['image'], // Đường dẫn ảnh mới (hoặc cũ)
            $id,
            $data['instructor_id']
        ]);
    }

    public function delete($id, $instructor_id) {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id=? AND instructor_id=?");
        return $stmt->execute([$id, $instructor_id]);
    }
}
?>