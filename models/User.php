<?php
class user {
    private $conn;
    private $table_name = "users";
    
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;
    public $fullname;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " (username, email, fullname, password, role) VALUES (:username, :email, :fullname, :password, :role)";
        $stmt = $this->conn->prepare($query);

        // 1. Làm sạch dữ liệu
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        
        // Gán giá trị vào biến trước khi bindParam
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
        $role_default = 0; // Tạo biến cho role mặc định

        // Bind các biến vào câu truy vấn
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":password", $hashed_password); 
        $stmt->bindParam(":role", $role_default);       

    }

    public function login() {
        $query = "SELECT id, username, password, role, fullname FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->role = $row['role'];
                $this->fullname = $row['fullname'];
                return true;
            }
        }
        return false;
    }
    public function getAllUsers() {
        $query = "SELECT id, username, email, fullname, role, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm hàm Xóa User
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}