<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<div class="main-content">
    <h1>Thêm bài học mới</h1>
    
    <form method="post" action="index.php?controller=Lesson&action=store" class="form">
        <input type="hidden" name="course_id" value="<?php echo $_GET['course_id']; ?>">
        
        <label>Tên bài học:</label>
        <input type="text" name="title" required placeholder="Ví dụ: Bài 1 - Giới thiệu">
        
        <label>Link Video (YouTube/Drive):</label>
        <input type="text" name="video_url" placeholder="https://youtube.com/...">
        
        <label>Nội dung bài học:</label>
        <textarea name="content" rows="6" placeholder="Nhập nội dung chi tiết bài học..."></textarea>
        
        <label>Thứ tự hiển thị:</label>
        <input type="number" name="order" value="1" style="width: 100px;">
        
        <br><br>
        <button type="submit" class="btn">Lưu bài học</button>
        <a href="index.php?controller=Lesson&action=manage&course_id=<?php echo $_GET['course_id']; ?>" 
           style="margin-left: 10px; text-decoration: none; color: #666;">Hủy</a>
    </form>
</div>

<?php require 'views/instructor/layout/footer.php'; ?>