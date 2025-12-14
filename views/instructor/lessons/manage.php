<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Bài học trong khóa: ID <?php echo $_GET['course_id']; ?></h1>
<a href="index.php?controller=Lesson&action=create&course_id=<?php echo $_GET['course_id']; ?>" class="btn">Thêm bài học</a>
<a href="index.php?controller=Course&action=manage" class="btn" style="background:#7f8c8d">Quay lại Khóa học</a>

<table>
    <tr>
        <th>Thứ tự</th>
        <th>Tên bài học</th>
        <th>Tài liệu</th>
    </tr>
    <?php foreach($lessons as $lesson): ?>
    <tr>
        <td><?php echo $lesson['order']; ?></td>
        <td><?php echo htmlspecialchars($lesson['title']); ?></td>
        <td>
            <a href="index.php?controller=Material&action=upload&lesson_id=<?php echo $lesson['id']; ?>">Upload File</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require 'views/instructor/layout/footer.php'; ?>