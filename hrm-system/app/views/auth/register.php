<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="container">
    <div class="left">
        <img src="assets/images/bg.png" alt="">
    </div>

    <div class="right">
        <form action="index.php?controller=Auth&action=register" method="POST">
            <h2>Đăng ký</h2>

            <input type="text" name="name" placeholder="Họ tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>

            <button type="submit">Đăng ký</button>

            <div class="social">
                <a href="facebook_login.php" class="fb">Facebook</a>
                <a href="google_login.php" class="gg">Google</a>
            </div>

            <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
        </form>
    </div>
</div>

</body>
</html>