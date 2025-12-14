<?php require 'views/instructor/layout/header.php'; ?>
<?php require 'views/instructor/layout/sidebar.php'; ?>

<h1>Danh sách khóa học</h1>
<a href="index.php?controller=Course&action=create" class="btn">Thêm khóa học mới</a>
<table>
    <thead>
        <tr>
            <th>Tên khóa học</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($courses as $course): ?>
        <tr>
            <td><?php echo htmlspecialchars($course['title']); ?></td>
            <td>
                <a href="index.php?controller=Lesson&action=manage&course_id=<?php echo $course['id']; ?>">Quản lý Bài học</a> | 
                <a href="index.php?controller=Course&action=edit&id=<?php echo $course['id']; ?>">Sửa</a> |
                <a href="index.php?controller=Course&action=delete&id=<?php echo $course['id']; ?>" onclick="return confirm('Xóa khóa học này?');">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require 'views/instructor/layout/footer.php'; ?>