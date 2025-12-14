<h2>Khóa học của tôi</h2>

<?php if (empty($courses)): ?>
    <p>Chưa có khóa học nào</p>
<?php else: ?>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li><?= $course['title'] ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
