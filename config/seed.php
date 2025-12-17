<?php
require_once 'config/Database.php';

// Tăng thời gian chạy tối đa lên 5 phút để tránh bị ngắt giữa chừng
set_time_limit(300); 

// --- 1. CÁC HÀM HỖ TRỢ RANDOM (MÁY TÍNH TỰ NGHĨ TÊN) ---

function getRandomName() {
    $ho = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng'];
    $dem = ['Văn', 'Thị', 'Đức', 'Ngọc', 'Hữu', 'Minh', 'Thanh', 'Quốc', 'Gia', 'Xuân'];
    $ten = ['Anh', 'Bảo', 'Bình', 'Cường', 'Dũng', 'Giang', 'Hùng', 'Huy', 'Khánh', 'Lan', 'Linh', 'Minh', 'Nam', 'Nghĩa', 'Phúc', 'Quân', 'Sơn', 'Thắng', 'Trang', 'Tú', 'Uyên', 'Vinh', 'Yến'];
    
    return $ho[array_rand($ho)] . ' ' . $dem[array_rand($dem)] . ' ' . $ten[array_rand($ten)];
}

function getRandomCourseTitle() {
    $prefix = ['Khóa học', 'Làm chủ', 'Thành thạo', 'Tuyệt đỉnh', 'Nhập môn', 'Lập trình', 'Học', 'Chinh phục'];
    $subject = ['PHP', 'Java', 'Python', 'ReactJS', 'NodeJS', 'Excel', 'Photoshop', 'Marketing', 'Tiếng Anh', 'Tiếng Hàn', 'Kỹ năng mềm'];
    $level = ['Cơ bản', 'Nâng cao', 'Cấp tốc', 'Trong 30 ngày', 'Cho người đi làm', 'Thực chiến', 'Toàn tập'];
    
    return $prefix[array_rand($prefix)] . ' ' . $subject[array_rand($subject)] . ' - ' . $level[array_rand($level)];
}

function getRandomEmail($name) {
    // Chuyển tên tiếng Việt có dấu thành không dấu để làm email
    $str = str_replace([' ', 'đ'], ['', 'd'], mb_strtolower($name, 'UTF-8')); // Cơ bản thôi
    $domains = ['@gmail.com', '@yahoo.com', '@outlook.com', '@student.edu.vn'];
    return $str . rand(100, 9999) . $domains[array_rand($domains)];
}

// --- 2. BẮT ĐẦU QUÁ TRÌNH TẠO DỮ LIỆU ---

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    echo "<div style='font-family: Arial; line-height: 1.6;'>";
    echo "<h2>🤖 ĐANG CHẠY TOOL AUTO-GENERATE DATA...</h2>";

    // A. XÓA DỮ LIỆU CŨ (RESET)
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
    $conn->exec("TRUNCATE TABLE materials");
    $conn->exec("TRUNCATE TABLE lessons");
    $conn->exec("TRUNCATE TABLE courses");
    $conn->exec("TRUNCATE TABLE categories");
    $conn->exec("TRUNCATE TABLE users");
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "✅ Đã dọn sạch database cũ.<br>";

    // B. TỰ ĐỘNG TẠO 10 GIẢNG VIÊN
    $instructor_ids = [];
    $stmtUser = $conn->prepare("INSERT INTO users (username, email, password, fullname, role) VALUES (?, ?, ?, ?, 1)");
    
    for ($i = 0; $i < 10; $i++) {
        $fullname = getRandomName();
        $email = getRandomEmail($fullname);
        $username = explode('@', $email)[0]; // Lấy phần đầu email làm username
        
        $stmtUser->execute([$username, $email, password_hash('123456', PASSWORD_DEFAULT), $fullname]);
        $instructor_ids[] = $conn->lastInsertId();
    }
    echo "✅ Đã 'thuê' thành công 10 Giảng viên ảo.<br>";

    // C. TẠO 6 DANH MỤC
    $categories = ['Công nghệ thông tin', 'Thiết kế đồ họa', 'Ngoại ngữ', 'Marketing & Sale', 'Tin học văn phòng', 'Phát triển cá nhân'];
    $category_ids = [];
    foreach ($categories as $cat) {
        $conn->exec("INSERT INTO categories (name, description) VALUES ('$cat', 'Các khóa học về $cat')");
        $category_ids[] = $conn->lastInsertId();
    }
    echo "✅ Đã tạo xong danh mục.<br>";

    // D. TỰ ĐỘNG TẠO 50 KHÓA HỌC (SỐ LƯỢNG LỚN)
    $stmtCourse = $conn->prepare("INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    $levels = ['Beginner', 'Intermediate', 'Advanced'];
    $course_ids = [];

    for ($i = 0; $i < 50; $i++) {
        $title = getRandomCourseTitle();
        $desc = "Đây là khóa học $title được biên soạn kỹ lưỡng, giúp bạn thành thạo kỹ năng chỉ trong thời gian ngắn.";
        $inst_id = $instructor_ids[array_rand($instructor_ids)];
        $cat_id = $category_ids[array_rand($category_ids)];
        $price = rand(1, 20) * 100000; // Random giá từ 100k đến 2 triệu
        $weeks = rand(4, 20);
        $level = $levels[array_rand($levels)];
        // Ảnh placeholder ngẫu nhiên từ mạng
        $img = "https://placehold.co/600x400?text=" . urlencode($title); 

        $stmtCourse->execute([$title, $desc, $inst_id, $cat_id, $price, $weeks, $level, $img]);
        $course_ids[] = $conn->lastInsertId();
    }
    echo "✅ Đã xuất bản 50 Khóa học ngẫu nhiên.<br>";

    // E. TỰ ĐỘNG TẠO BÀI HỌC (Mỗi khóa 5-10 bài)
    $stmtLesson = $conn->prepare("INSERT INTO lessons (course_id, title, content, `order`) VALUES (?, ?, ?, ?)");
    $totalLessons = 0;

    foreach ($course_ids as $cid) {
        $num_lessons = rand(5, 10); // Mỗi khóa random 5 đến 10 bài
        for ($j = 1; $j <= $num_lessons; $j++) {
            $l_title = "Bài $j: Nội dung quan trọng phần $j";
            $l_content = "Nội dung chi tiết của bài học số $j. Lorem ipsum dolor sit amet...";
            $stmtLesson->execute([$cid, $l_title, $l_content, $j]);
            $totalLessons++;
        }
    }
    echo "✅ Đã soạn xong $totalLessons bài giảng.<br>";

    echo "<hr><h2 style='color:green'>🎉 HOÀN TẤT! Dữ liệu đã được sinh tự động.</h2>";
    echo "<a href='index.php?controller=Course&action=manage' style='background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>👉 Vào xem thành quả ngay</a>";
    echo "</div>";

} catch (Exception $e) {
    echo "<h1 style='color:red'>Lỗi: " . $e->getMessage() . "</h1>";
}
?>