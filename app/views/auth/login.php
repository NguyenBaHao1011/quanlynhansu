<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/hrm-system/public/assets/css/auth.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="overlay">

    <div class="auth-box">

        <div class="icon">
            <i class="fa fa-user"></i>
        </div>

        <h1>Đăng nhập</h1>

        <p class="subtitle">
            Chào mừng bạn quay trở lại!
        </p>

        <!-- Display error message if exists -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Display success message if exists -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

       <form action="/hrm-system/public/index.php?controller=Auth&action=authenticate"
            method="POST">

            <div class="input-group">

                    <i class="fa-solid fa-user"></i>

                    <input type="email"
                        name="email"
                        placeholder="Email"
                        required>

            </div>

             <div class="input-group">

                    <i class="fa-solid fa-lock"></i>

                    <input type="password"
                        name="password"
                        placeholder="Mật khẩu"
                        required>

            </div>

            <div class="remember">
                <input type="checkbox" name="remember">
                <label>Remember me</label>
            </div>

            <button type="submit" class="btn-login">
                Đăng nhập
            </button>

        </form>

        <div class="register-link">
            Chưa có tài khoản?
            <a href="/hrm-system/public/index.php?controller=Auth&action=register">
                Đăng ký
            </a>
        </div>

    </div>

</div>

</body>
</html>