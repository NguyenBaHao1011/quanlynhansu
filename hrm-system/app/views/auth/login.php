<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="container">
    <div class="left">
        <img src="assets/images/bg.png" alt="">
    </div>

    <div class="right">
        <form action="index.php?controller=Auth&action=login" method="POST">
            <h2>Đăng nhập</h2>

            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>

            <button type="submit">Đăng nhập</button>

            <div class="social">
                <a href="facebook_login.php" class="fb">Facebook</a>
                <a href="google_login.php" class="gg">Google</a>
            </div>

            <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
        </form>
    </div>
</div>

</body>
</html>