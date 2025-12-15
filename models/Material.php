<?php
class Material {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function upload($lesson_id, $file) {
        $allowed = ['pdf', 'doc', 'docx', 'mp4', 'zip', 'jpg', 'png'];
        $filename = $file['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return "Định dạng file không cho phép.";
        }

        // Đổi tên file để bảo mật
        $new_name = uniqid() . '.' . $ext;
        $destination = "assets/uploads/materials/" . $new_name;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $stmt = $this->conn->prepare("INSERT INTO materials (lesson_id, filename, file_path, file_type, uploaded_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$lesson_id, $filename, $destination, $ext]);
            return true;
        }
        return "Lỗi khi lưu file.";
    }
}
?>