<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-delete { color: red; text-decoration: none; font-weight: bold; }
        .header { display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>
    <div style="padding: 20px;">
        <div class="header">
            <h2>Danh sách người dùng (Admin Dashboard)</h2>
            <a href="index.php?controller=auth&action=logout" style="padding: 10px; background: red; color: white; text-decoration: none;">Đăng xuất</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Họ tên</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['fullname']; ?></td>
                    <td>
                        <?php 
                            if ($user['role'] == 2) echo '<span style="color:red">Admin</span>';
                            elseif ($user['role'] == 1) echo '<span style="color:blue">Giảng viên</span>';
                            else echo 'Học viên';
                        ?>
                    </td>
                    <td><?php echo $user['created_at']; ?></td>
                    <td>
                        <a href="index.php?controller=admin&action=delete&id=<?php echo $user['id']; ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa user này?');" 
                           class="btn-delete">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>