<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Tạo khóa học mới</h1>

<form method="post" action="index.php?controller=Course&action=store" enctype="multipart/form-data" class="form">
    
    <label>Tên khóa học:</label>
    <input type="text" name="title" required>

    <label>Mô tả:</label>
    <textarea name="description" rows="5"></textarea>

    <div style="display: flex; gap: 20px;">
        <div style="flex: 1;">
            <label>Danh mục (ID):</label>
            <input type="number" name="category_id" placeholder="Nhập ID danh mục (VD: 1)" required>
        </div>
        <div style="flex: 1;">
            <label>Giá (VNĐ):</label>
            <input type="number" name="price" value="0">
        </div>
    </div>

    <div style="display: flex; gap: 20px;">
        <div style="flex: 1;">
            <label>Thời lượng (Tuần):</label>
            <input type="number" name="duration_weeks" value="4">
        </div>
        <div style="flex: 1;">
            <label>Trình độ:</label>
            <select name="level" style="width: 100%; padding: 10px; margin-top: 10px;">
                <option value="Beginner">Beginner (Cơ bản)</option>
                <option value="Intermediate">Intermediate (Trung bình)</option>
                <option value="Advanced">Advanced (Nâng cao)</option>
            </select>
        </div>
    </div>

    <label>Ảnh đại diện:</label>
    <input type="file" name="image" accept="image/*">
    <br><br>

    <button type="submit" class="btn">Lưu khóa học</button>
</form>

<?php require 'views/instructor/layout/footer.php'; ?>