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
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
          
    <style>
        /* Override for register page - more compact layout */
        .auth-box.register-box {
            max-width: 450px !important;
            padding: 30px 28px !important;
        }

        .register-box .icon {
            width: 65px;
            height: 65px;
            margin: -65px auto 15px auto;
        }

        .register-box .icon i {
            font-size: 26px;
        }

        .register-box h1 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        .register-box .subtitle {
            font-size: 13px;
            margin-bottom: 18px;
        }

        /* Row layout for 2-column fields */
        .register-row {
            display: flex;
            gap: 10px;
            margin-bottom: 0;
        }

        .register-row .input-group {
            flex: 1;
        }

        /* Squeeze input groups tighter */
        .register-box .input-group {
            margin-bottom: 12px;
        }

        .register-box .input-group input,
        .register-box .input-group select.form-control {
            height: 42px;
            font-size: 13px;
        }

        .register-box .input-group input {
            padding: 0 14px 0 40px;
        }

        .register-box .input-group i {
            font-size: 14px;
            left: 14px;
        }

        /* Select styling with icon */
        .register-box .input-group select.form-control {
            padding: 0 32px 0 40px;
        }

        /* Error/success messages compact */
        .register-box .error-message,
        .register-box .success-message {
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .register-box .btn-login {
            height: 42px;
            font-size: 15px;
        }

        .register-box .bottom-text {
            margin-top: 14px;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            .register-row {
                flex-direction: column;
                gap: 0;
            }
            
            .auth-box.register-box {
                padding: 22px 18px !important;
            }
        }
    </style>
</head>

<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="overlay">

    <div class="auth-box register-box">

        <div class="icon">
            <i class="fa fa-user-plus"></i>
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
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <form action="/hrm-system/public/index.php?controller=Auth&action=store"
            method="POST">

            <!-- Row 1: Username + Fullname -->
            <div class="register-row">
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text"
                        name="username"
                        class="form-control"
                        placeholder="Tên đăng nhập"
                        required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-id-card"></i>
                    <input type="text"
                        name="fullname"
                        class="form-control"
                        placeholder="Họ và tên"
                        required>
                </div>
            </div>

            <!-- Row 2: Email + Role -->
            <div class="register-row">
                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email"
                        name="email"
                        class="form-control"
                        placeholder="Email"
                        required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-shield-halved"></i>
                    <select name="role_id" class="form-control" required>
                        <option value="">-- Vai trò --</option>
                        <?php if(isset($roles) && $roles->num_rows > 0): ?>
                            <?php while($role = $roles->fetch_assoc()): ?>
                                <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Row 3: Password + Confirm -->
            <div class="register-row">
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password"
                        name="password"
                        class="form-control"
                        placeholder="Mật khẩu"
                        required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password"
                        name="confirm_password"
                        class="form-control"
                        placeholder="Xác nhận mật khẩu"
                        required>
                </div>
            </div>

            <button type="submit" class="btn-login w-100">
                <i class="fa-solid fa-user-plus"></i> Đăng ký
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