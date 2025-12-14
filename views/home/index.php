<h2>Danh sách khóa học</h2>

<form method="GET">
    <input type="hidden" name="controller" value="home">
    <input type="hidden" name="action" value="index">

    <input type="text" name="keyword" placeholder="Tìm khóa học...">

    <select name="category">
        <option value="">-- Tất cả danh mục --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>">
                <?= $cat['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Tìm kiếm</button>
</form>

<hr>

<?php foreach ($courses as $course): ?>
    <div>
        <h3><?= $course['title'] ?></h3>
        <p><?= substr($course['description'], 0, 100) ?>...</p>
        <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>">
            Xem chi tiết
        </a>
    </div>
    <hr>
<?php endforeach; ?>
