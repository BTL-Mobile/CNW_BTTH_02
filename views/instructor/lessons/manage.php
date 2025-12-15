<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<div class="main-content">
    <h1>Quản lý Bài học (Course ID: <?php echo $_GET['course_id']; ?>)</h1>
    
    <div style="margin-bottom: 20px;">
        <a href="index.php?controller=Lesson&action=create&course_id=<?php echo $_GET['course_id']; ?>" class="btn">Thêm bài học</a>
        <a href="index.php?controller=Course&action=manage" class="btn" style="background:#7f8c8d">Quay lại Khóa học</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Thứ tự</th>
                <th>Tên bài học</th>
                <th>Video URL</th>
                <th>Nội dung</th>
                <th>Tài liệu</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($lessons)): ?>
            <?php foreach($lessons as $lesson): ?>
            <tr>
                <td style="text-align: center;"><?php echo $lesson['order']; ?></td>
                <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                
                <td>
                    <?php if(!empty($lesson['video_url'])): ?>
                        <a href="<?php echo htmlspecialchars($lesson['video_url']); ?>" target="_blank">Xem Video</a>
                    <?php else: ?>
                        <span style="color: #ccc;">Không có</span>
                    <?php endif; ?>
                </td>
                
                <td>
                    <?php echo substr(htmlspecialchars($lesson['content']), 0, 50) . '...'; ?>
                </td>

                <td style="text-align: center;">
                    <a href="index.php?controller=Material&action=upload&lesson_id=<?php echo $lesson['id']; ?>">Upload File</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align: center;">Chưa có bài học nào.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require 'views/instructor/layout/footer.php'; ?>