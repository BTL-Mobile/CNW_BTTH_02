<h2><?= $course['title'] ?></h2>

<p><?= $course['description'] ?></p>
<p>Giá: <?= $course['price'] ?> VND</p>
<p>Cấp độ: <?= $course['level'] ?></p>

<a href="index.php?controller=enrollment&action=enroll&course_id=<?= $course['id'] ?>">
    Đăng ký khóa học
</a>
