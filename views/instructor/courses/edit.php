<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Sửa khóa học</h1>
<form method="post" action="index.php?controller=Course&action=update" class="form">
    <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
    <label>Tiêu đề:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
    <label>Mô tả:</label>
    <textarea name="description" rows="5"><?php echo htmlspecialchars($course['description']); ?></textarea>
    <button type="submit" class="btn">Cập nhật</button>
</form>

<?php require 'views/instructor/layout/footer.php'; ?>