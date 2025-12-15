<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<div class="main-content">
    <h1>Danh sách khóa học</h1>
    <a href="index.php?controller=Course&action=create" class="btn">Thêm khóa học mới</a>

    <style>
        .course-img { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
        table th { background-color: #3498db; color: white; text-align: center; }
        table td { vertical-align: middle; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .bg-beginner { background: #2ecc71; color: white; }
        .bg-intermediate { background: #f1c40f; color: black; }
        .bg-advanced { background: #e74c3c; color: white; }
    </style>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên khóa học</th>
                <th>Giá (VNĐ)</th>
                <th>Trình độ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($courses)): ?>
            <?php foreach($courses as $course): ?>
            <tr>
                <td style="text-align: center;"><?php echo $course['id']; ?></td>
                
                <td style="text-align: center;">
                    <?php if (!empty($course['image'])): ?>
                        <img src="<?php echo $course['image']; ?>" class="course-img" alt="Course Image">
                    <?php else: ?>
                        <span style="color: #999; font-size: 12px;">Không có ảnh</span>
                    <?php endif; ?>
                </td>

                <td>
                    <strong><?php echo htmlspecialchars($course['title']); ?></strong><br>
                    <small style="color: #666;"><?php echo $course['duration_weeks']; ?> tuần</small>
                </td>

                <td style="text-align: right;">
                    <?php echo number_format($course['price']); ?> đ
                </td>

                <td style="text-align: center;">
                    <?php 
                        $class = 'bg-beginner';
                        if ($course['level'] == 'Intermediate') $class = 'bg-intermediate';
                        if ($course['level'] == 'Advanced') $class = 'bg-advanced';
                    ?>
                    <span class="badge <?php echo $class; ?>">
                        <?php echo $course['level']; ?>
                    </span>
                </td>

                <td style="text-align: center;">
                    <a href="index.php?controller=Lesson&action=manage&course_id=<?php echo $course['id']; ?>">Quản lý Bài học</a> | 
                    <a href="index.php?controller=Course&action=edit&id=<?php echo $course['id']; ?>">Sửa</a> |
                    <a href="index.php?controller=Course&action=delete&id=<?php echo $course['id']; ?>" 
                       onclick="return confirm('Bạn chắc chắn muốn xóa khóa học này?');" style="color: red;">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align: center; padding: 20px;">Chưa có khóa học nào.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require 'views/instructor/layout/footer.php'; ?>