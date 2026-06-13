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
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
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
            <div class="error-message alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Display success message if exists -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

       <form action="/hrm-system/public/index.php?controller=Auth&action=authenticate"
            method="POST">

            <div class="input-group mb-3">

                    <i class="fa-solid fa-envelope"></i>

                    <input type="email"
                        name="email"
                        class="form-control"
                        placeholder="Email"
                        required>

            </div>

             <div class="input-group mb-3">

                    <i class="fa-solid fa-lock"></i>

                    <input type="password"
                        name="password"
                        class="form-control"
                        placeholder="Mật khẩu"
                        required>

            </div>

            <div class="remember mb-3">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" class="btn-login w-100">
                Đăng nhập
            </button>

        </form>

        <div class="register-link mt-3">
            Chưa có tài khoản?
            <a href="/hrm-system/public/index.php?controller=Auth&action=register">
                Đăng ký
            </a>
        </div>

    </div>

</div>

</body>
</html>