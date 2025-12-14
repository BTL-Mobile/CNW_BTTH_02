<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Upload tài liệu cho bài học ID: <?php echo $_GET['lesson_id']; ?></h1>

<?php if(isset($message) && $message != ''): ?>
    <p style="color: red; font-weight: bold;"><?php echo $message; ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="form">
    <label>Chọn file (PDF, Video, Doc):</label>
    <input type="file" name="file" required>
    <br><br>
    <button type="submit" class="btn">Upload</button>
</form>

<a href="javascript:history.back()">Quay lại</a>

<?php require 'views/instructor/layout/footer.php'; ?>