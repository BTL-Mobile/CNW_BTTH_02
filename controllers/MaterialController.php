<?php
require_once 'models/Material.php';

class MaterialController {
    private $materialModel;

    public function __construct() {
        $this->materialModel = new Material();
    }

    public function upload() {
        $lesson_id = $_GET['lesson_id'];
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $result = $this->materialModel->upload($lesson_id, $_FILES['file']);
            if ($result === true) {
                $message = "Upload thành công!";
            } else {
                $message = $result;
            }
        }
        include 'views/instructor/materials/upload.php';
    }
}
?>