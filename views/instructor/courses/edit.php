<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Sửa khóa học</h1>

<form method="post" action="index.php?controller=Course&action=update" enctype="multipart/form-data" class="form">
    <input type="hidden" name="id" value="<?php echo $course['id']; ?>">

    <label>Tên khóa học:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>

    <label>Mô tả:</label>
    <textarea name="description" rows="5"><?php echo htmlspecialchars($course['description']); ?></textarea>

    <div style="display: flex; gap: 20px;">
        <div style="flex: 1;">
            <label>Danh mục (ID):</label>
            <input type="number" name="category_id" value="<?php echo $course['category_id']; ?>" required>
        </div>
        <div style="flex: 1;">
            <label>Giá (VNĐ):</label>
            <input type="number" name="price" value="<?php echo $course['price']; ?>">
        </div>
    </div>

    <div style="display: flex; gap: 20px;">
        <div style="flex: 1;">
            <label>Thời lượng (Tuần):</label>
            <input type="number" name="duration_weeks" value="<?php echo $course['duration_weeks']; ?>">
        </div>
        <div style="flex: 1;">
            <label>Trình độ:</label>
            <select name="level" style="width: 100%; padding: 10px; margin-top: 10px;">
                <option value="Beginner" <?php echo ($course['level'] == 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                <option value="Intermediate" <?php echo ($course['level'] == 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="Advanced" <?php echo ($course['level'] == 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
            </select>
        </div>
    </div>

    <label>Ảnh đại diện hiện tại:</label><br>
    <?php if (!empty($course['image'])): ?>
        <img src="<?php echo $course['image']; ?>" width="150" style="margin: 10px 0; border: 1px solid #ddd; padding: 5px;">
    <?php else: ?>
        <p>Chưa có ảnh</p>
    <?php endif; ?>
    <br>
    <label>Thay đổi ảnh (Nếu cần):</label>
    <input type="file" name="image" accept="image/*">
    <br><br>

    <button type="submit" class="btn">Cập nhật</button>
</form>

<?php require 'views/instructor/layout/footer.php'; ?>