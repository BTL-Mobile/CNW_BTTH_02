<h2>Khóa học của tôi</h2>

<?php if (empty($courses)): ?>
    <p>Bạn chưa đăng ký khóa học nào.</p>
<?php endif; ?>

<?php foreach ($courses as $course): ?>
    <div>
        <h3><?= $course['title'] ?></h3>
        <p>Tiến độ: <?= $course['progress'] ?>%</p>
        <p>Trạng thái: <?= $course['status'] ?></p>
    </div>
    <hr>
<?php endforeach; ?>
