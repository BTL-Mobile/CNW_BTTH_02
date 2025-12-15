<?php
// controllers/CourseController.php
require_once 'models/Course.php';

class CourseController {
    private $courseModel;

    public function __construct() {
        $this->courseModel = new Course();
        // Giả lập login (Khi ghép code Auth của Thế Anh thì xóa dòng này)
        if (!isset($_SESSION['user_id'])) {
             $_SESSION['user_id'] = 1; 
        }
    }

    public function manage() {
        $instructor_id = $_SESSION['user_id'];
        $courses = $this->courseModel->getByInstructor($instructor_id);
        include 'views/instructor/courses/manage.php';
    }

    public function create() {
        include 'views/instructor/courses/create.php';
    }

    // --- XỬ LÝ LƯU KHÓA HỌC MỚI ---
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = ""; // Mặc định không có ảnh

            // Xử lý Upload Ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/courses/";
                if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); } // Tạo folder nếu chưa có

                // Đổi tên file để tránh trùng
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $fileName;
                
                // Chỉ cho phép ảnh
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check !== false) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $imagePath = $target_file;
                    }
                }
            }

            // Gom dữ liệu
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'instructor_id' => $_SESSION['user_id'],
                'category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : null,
                'price' => !empty($_POST['price']) ? $_POST['price'] : 0,
                'duration_weeks' => !empty($_POST['duration_weeks']) ? $_POST['duration_weeks'] : 0,
                'level' => $_POST['level'],
                'image' => $imagePath
            ];

            $this->courseModel->create($data);
            header("Location: index.php?controller=Course&action=manage");
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $course = $this->courseModel->find($id, $_SESSION['user_id']);
        if (!$course) die("Không tìm thấy khóa học.");
        include 'views/instructor/courses/edit.php';
    }

    // --- XỬ LÝ CẬP NHẬT KHÓA HỌC ---
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            
            // Lấy thông tin cũ để giữ lại ảnh cũ nếu người dùng KHÔNG upload ảnh mới
            $oldCourse = $this->courseModel->find($id, $_SESSION['user_id']);
            $imagePath = $oldCourse['image']; 

            // Nếu có upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/courses/";
                if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $fileName;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imagePath = $target_file; // Cập nhật đường dẫn mới
                    // (Optional) Xóa ảnh cũ trên server nếu cần
                }
            }

            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'instructor_id' => $_SESSION['user_id'],
                'category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : null,
                'price' => !empty($_POST['price']) ? $_POST['price'] : 0,
                'duration_weeks' => !empty($_POST['duration_weeks']) ? $_POST['duration_weeks'] : 0,
                'level' => $_POST['level'],
                'image' => $imagePath
            ];

            $this->courseModel->update($id, $data);
            header("Location: index.php?controller=Course&action=manage");
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'];
        $this->courseModel->delete($id, $_SESSION['user_id']);
        header("Location: index.php?controller=Course&action=manage");
        exit();
    }
}
?>