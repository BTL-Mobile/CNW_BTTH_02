<?php
require_once 'config/Database.php';

// --- CẤU HÌNH SỐ LƯỢNG DỮ LIỆU MUỐN TẠO ---
$LIMIT_INSTRUCTORS = 30;   // Tạo 30 giảng viên
$LIMIT_COURSES     = 200;  // Tạo 200 khóa học (Thoải mái cuộn trang)
$LIMIT_LESSONS_MIN = 5;    // Mỗi khóa ít nhất 5 bài
$LIMIT_LESSONS_MAX = 12;   // Mỗi khóa nhiều nhất 12 bài

// Cho phép chạy không giới hạn thời gian (để tạo nhiều dữ liệu không bị lỗi timeout)
set_time_limit(0);
ini_set('memory_limit', '512M'); // Tăng bộ nhớ nếu cần

// --- 1. TỪ ĐIỂN DỮ LIỆU (MỞ RỘNG ĐỂ ÍT TRÙNG LẶP) ---

function getRandomName() {
    $ho = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng', 'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Lý'];
    $dem = ['Văn', 'Thị', 'Đức', 'Ngọc', 'Hữu', 'Minh', 'Thanh', 'Quốc', 'Gia', 'Xuân', 'Khánh', 'Hải', 'Tuấn', 'Mạnh', 'Phương'];
    $ten = ['Anh', 'Bảo', 'Bình', 'Cường', 'Dũng', 'Giang', 'Hùng', 'Huy', 'Khánh', 'Lan', 'Linh', 'Minh', 'Nam', 'Nghĩa', 'Phúc', 'Quân', 'Sơn', 'Thắng', 'Trang', 'Tú', 'Uyên', 'Vinh', 'Yến', 'Nhi', 'Hương', 'Tâm', 'Thảo'];
    return $ho[array_rand($ho)] . ' ' . $dem[array_rand($dem)] . ' ' . $ten[array_rand($ten)];
}

function getRandomCourseTitle() {
    $prefix = ['Khóa học', 'Làm chủ', 'Thành thạo', 'Tuyệt đỉnh', 'Nhập môn', 'Lập trình', 'Học', 'Chinh phục', 'Master', 'Zero to Hero', 'Cấp tốc'];
    $subject = ['PHP', 'Java', 'Python', 'ReactJS', 'NodeJS', 'Excel', 'Photoshop', 'Marketing', 'Tiếng Anh', 'Tiếng Hàn', 'Kỹ năng mềm', 'Blockchain', 'AI', 'Machine Learning', 'Data Science', 'Docker', 'Kubernetes', 'Flutter', 'C# .NET', 'Digital Marketing', 'SEO', 'Content Writing'];
    $suffix = ['Cơ bản', 'Nâng cao', 'Cấp tốc', 'Trong 30 ngày', 'Cho người đi làm', 'Thực chiến', 'Toàn tập', '2024', 'Cho người mới bắt đầu', 'Chuyên sâu'];
    
    return $prefix[array_rand($prefix)] . ' ' . $subject[array_rand($subject)] . ' - ' . $suffix[array_rand($suffix)];
}

function getRandomEmail($name) {
    $str = str_replace([' ', 'đ'], ['', 'd'], mb_strtolower($name, 'UTF-8'));
    // Xóa dấu tiếng Việt cơ bản
    $str = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $str);
    $str = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $str);
    $str = preg_replace('/[iíìỉĩị]/u', 'i', $str);
    $str = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $str);
    $str = preg_replace('/[úùủũụưứừửữự]/u', 'u', $str);
    $str = preg_replace('/[ýỳỷỹỵ]/u', 'y', $str);
    
    $domains = ['@gmail.com', '@yahoo.com', '@outlook.com', '@student.edu.vn', '@company.com'];
    return $str . rand(100, 99999) . $domains[array_rand($domains)];
}

function getRandomVideoUrl() {
    $ids = ['dQw4w9WgXcQ', '3JZ_D3ELwOQ', 'kJQP7kiw5Fk', 'JGwWNGJdvx8', '9bZkp7q19f0', 'L_jWHffIx5E', 'fJ9rUzIMcZQ'];
    return "https://www.youtube.com/watch?v=" . $ids[array_rand($ids)];
}

// --- 2. THỰC THI ---

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    echo "<div style='font-family: Arial; line-height: 1.6; padding: 20px; max-width: 800px; margin: 0 auto;'>";
    echo "<h1 style='color: #2c3e50;'>🚀 SUPER SEED: ĐANG TẠO BIG DATA...</h1>";
    echo "<p>Cấu hình: <b>$LIMIT_INSTRUCTORS</b> Giảng viên | <b>$LIMIT_COURSES</b> Khóa học.</p>";
    echo "<hr>";

    // A. RESET DATABASE
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
    $conn->exec("TRUNCATE TABLE materials");
    $conn->exec("TRUNCATE TABLE lessons");
    $conn->exec("TRUNCATE TABLE courses");
    $conn->exec("TRUNCATE TABLE categories");
    $conn->exec("TRUNCATE TABLE users");
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "✅ <span style='color:gray'>Đã dọn dẹp dữ liệu cũ.</span><br>";

    // B. TẠO GIẢNG VIÊN
    $instructor_ids = [];
    $stmtUser = $conn->prepare("INSERT INTO users (username, email, password, fullname, role) VALUES (?, ?, ?, ?, 1)");
    
    for ($i = 0; $i < $LIMIT_INSTRUCTORS; $i++) {
        $fullname = getRandomName();
        $email = getRandomEmail($fullname);
        $username = explode('@', $email)[0];
        $stmtUser->execute([$username, $email, password_hash('123456', PASSWORD_DEFAULT), $fullname]);
        $instructor_ids[] = $conn->lastInsertId();
    }
    echo "✅ Đã tạo <b>" . count($instructor_ids) . "</b> Giảng viên.<br>";

    // C. TẠO DANH MỤC (Nhiều hơn chút)
    $categories = [
        'Công nghệ thông tin', 'Thiết kế đồ họa', 'Ngoại ngữ', 'Marketing & Sale', 
        'Tin học văn phòng', 'Phát triển cá nhân', 'Kinh doanh & Khởi nghiệp', 
        'Nhiếp ảnh & Quay phim', 'Sức khỏe & Làm đẹp', 'Âm nhạc & Nghệ thuật'
    ];
    $category_ids = [];
    foreach ($categories as $cat) {
        $conn->exec("INSERT INTO categories (name, description) VALUES ('$cat', 'Các khóa học chuyên sâu về $cat')");
        $category_ids[] = $conn->lastInsertId();
    }
    echo "✅ Đã tạo <b>" . count($category_ids) . "</b> Danh mục.<br>";

    // D. TẠO KHÓA HỌC (BIG DATA)
    $stmtCourse = $conn->prepare("INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    $levels = ['Beginner', 'Intermediate', 'Advanced'];
    $course_ids = [];

    // Bắt đầu vòng lặp lớn
    for ($i = 0; $i < $LIMIT_COURSES; $i++) {
        $title = getRandomCourseTitle();
        // Mô tả ngẫu nhiên độ dài khác nhau
        $desc = "Khóa học $title sẽ giúp bạn làm chủ kiến thức. " . str_repeat("Nội dung chất lượng cao. ", rand(1, 3));
        
        $inst_id = $instructor_ids[array_rand($instructor_ids)];
        $cat_id = $category_ids[array_rand($category_ids)];
        
        // Random giá lẻ (Ví dụ: 499,000)
        $price = (rand(1, 50) * 100000) - (rand(0, 1) * 1000); 
        $weeks = rand(4, 24);
        $level = $levels[array_rand($levels)];
        
        // Ảnh ngẫu nhiên theo ID để không bị cache giống nhau
        $img = "https://picsum.photos/seed/" . ($i + 100) . "/300/200"; 

        $stmtCourse->execute([$title, $desc, $inst_id, $cat_id, $price, $weeks, $level, $img]);
        $course_ids[] = $conn->lastInsertId();
    }
    echo "✅ Đã tạo <b>$LIMIT_COURSES</b> Khóa học.<br>";

    // E. TẠO BÀI HỌC
    $stmtLesson = $conn->prepare("INSERT INTO lessons (course_id, title, content, video_url, `order`, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $totalLessons = 0;

    foreach ($course_ids as $cid) {
        $num_lessons = rand($LIMIT_LESSONS_MIN, $LIMIT_LESSONS_MAX); 
        for ($j = 1; $j <= $num_lessons; $j++) {
            $l_title = "Bài $j: " . getRandomCourseTitle(); // Lấy random title làm tên bài học cho phong phú
            $l_content = "Nội dung bài học số $j.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.";
            $l_video = getRandomVideoUrl();
            
            $stmtLesson->execute([$cid, $l_title, $l_content, $l_video, $j]);
            $totalLessons++;
        }
    }
    echo "✅ Đã tạo tổng cộng <b>$totalLessons</b> Bài học.<br>";

    echo "<hr><h2 style='color:green'>🎉 HOÀN TẤT!</h2>";
    echo "<p>Bây giờ database của bạn đã đầy ắp dữ liệu.</p>";
    echo "<a href='index.php?controller=Course&action=manage' style='background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;'>👉 VÀO XEM NGAY</a>";
    echo "</div>";

} catch (Exception $e) {
    echo "<h2 style='color:red'>Lỗi: " . $e->getMessage() . "</h2>";
}
?>