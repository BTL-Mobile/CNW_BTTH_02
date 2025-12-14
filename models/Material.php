<?php
require_once 'config/Database.php';

class Material {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function upload($lesson_id, $file) {
        $filename = $file['name'];
        $path = 'assets/uploads/materials/' . $filename;
        move_uploaded_file($file['tmp_name'], $path);

        $stmt = $this->conn->prepare(
            "INSERT INTO materials(lesson_id, filename, file_path)
             VALUES (?, ?, ?)"
        );
        return $stmt->execute([$lesson_id, $filename, $path]);
    }
}
