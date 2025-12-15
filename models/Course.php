<?php
class Course {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getByInstructor($instructor_id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE instructor_id = ? ORDER BY id DESC");
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title, $description, $instructor_id) {
        $sql = "INSERT INTO courses (title, description, instructor_id, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$title, $description, $instructor_id]);
    }

    public function find($id, $instructor_id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id=? AND instructor_id=?");
        $stmt->execute([$id, $instructor_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $instructor_id) {
        $sql = "UPDATE courses SET title=?, description=?, updated_at=NOW() WHERE id=? AND instructor_id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$title, $description, $id, $instructor_id]);
    }

    public function delete($id, $instructor_id) {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id=? AND instructor_id=?");
        return $stmt->execute([$id, $instructor_id]);
    }
}
?>