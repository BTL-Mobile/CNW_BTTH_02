<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; margin-top: 50px; }
        .form-container { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        .error-msg { color: red; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="text-align: center;">Đăng Nhập</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=login" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-submit">Đăng nhập</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            Chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký ngay</a>
        </p>
    </div>
</body>
</html>