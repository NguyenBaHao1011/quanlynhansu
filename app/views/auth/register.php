<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>

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

        <h1>Đăng ký</h1>

        <p class="subtitle">
            Tạo tài khoản mới
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

        <form action="/hrm-system/public/index.php?controller=Auth&action=store"
            method="POST">

            <!-- Họ tên -->
            <div class="input-group">

                <i class="fa-solid fa-user"></i>

                <input type="text"
                    name="fullname"
                    placeholder="Họ và tên"
                    required>

            </div>

            <div class="input-group">

                <i class="fa-solid fa-envelope"></i>

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

            <div class="input-group">

                <i class="fa-solid fa-shield-halved"></i>

                <input type="password"
                    name="confirm_password"
                    placeholder="Xác nhận lại mật khẩu"
                    required>

            </div>
            <div class="input-group">

                <select name="role" class="form-control">

                    <option value="employee">
                        Employee
                    </option>

                    <option value="admin">
                        Admin
                    </option>

                </select>

            </div>
            <button type="submit" class="btn-login">
                Đăng ký
            </button>

        </form>

        <p class="bottom-text">

            Đã có tài khoản?

        <a href="/hrm-system/public/index.php?controller=Auth&action=login">
            Đăng nhập
        </a>

        </p>

    </div>

</div>

</body>
</html>