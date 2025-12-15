<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>

        body { font-family: Arial, sans-serif; display: flex; justify-content: center; margin-top: 50px; }
        .form-container { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        .error-msg { color: red; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2 style="text-align: center;">Đăng ký</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=register" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-submit">Đăng ký ngay</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập</a>
        </p>
    </div>

</body>
</html>