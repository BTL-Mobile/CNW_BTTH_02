<?php
require_once "config/Database.php";

class Course {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getByInstructor($instructor_id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM courses WHERE instructor_id = ?"
        );
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO courses 
        (title, description, instructor_id, category_id, price, duration_weeks, level, image)
        VALUES (?,?,?,?,?,?,?,?)";
        return $this->db->prepare($sql)->execute($data);
    }
}
