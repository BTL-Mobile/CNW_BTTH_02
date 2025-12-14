<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Thêm bài học mới</h1>
<form method="post" action="index.php?controller=Lesson&action=store" class="form">
    <input type="hidden" name="course_id" value="<?php echo $_GET['course_id']; ?>">
    
    <label>Tên bài học:</label>
    <input type="text" name="title" required>
    
    <label>Nội dung:</label>
    <textarea name="content" rows="4"></textarea>
    
    <label>Thứ tự hiển thị:</label>
    <input type="number" name="order" value="1">
    
    <button type="submit" class="btn">Lưu bài học</button>
</form>

<?php require 'views/instructor/layout/footer.php'; ?>