<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Tạo khóa học mới</h1>
<form method="post" action="index.php?controller=Course&action=store" class="form">
    <label>Tiêu đề:</label>
    <input type="text" name="title" required>
    <label>Mô tả:</label>
    <textarea name="description" rows="5"></textarea>
    <button type="submit" class="btn">Lưu</button>
</form>

<?php require 'views/instructor/layout/footer.php'; ?>