<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/User.php";

class AuthController
{
    // FORM LOGIN
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check()) {
            if (Auth::isAdmin()) {
                header("Location: " . BASE_URL . "index.php?controller=AdminDashboard&action=index");
            } else {
                header("Location: " . BASE_URL . "index.php?controller=EmployeeDashboard&action=index");
            }
            exit;
        }
        
        require_once "../app/views/auth/login.php";
    }

    // FORM REGISTER
    public function register()
    {
        require_once "../app/views/auth/register.php";
    }

    // XỬ LÝ ĐĂNG KÝ
    public function store()
    {
        session_start();

        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $role = $_POST['role'];

        // CHECK CONFIRM PASSWORD
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Mật khẩu xác nhận không khớp";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=register");
            return;
        }

        $user = new User();

        $result = $user->register($fullname, $email, $password, $role);

        if ($result) {
            // Set success message
            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            exit;
        } else {
            // Check if email already exists
            if ($user->findByEmail($email)) {
                $_SESSION['error'] = "Email đã tồn tại. Vui lòng dùng email khác.";
            } else {
                $_SESSION['error'] = "Đăng ký thất bại. Vui lòng thử lại.";
            }
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=register");
            exit;
        }
    }

    // XỬ LÝ LOGIN
    public function authenticate()
    {
        session_start();

        $email = $_POST['email'];
        $password = $_POST['password'];

        $userModel = new User();
        $user = $userModel->login($email, $password);

        if ($user) {
            // Use Auth helper to login
            Auth::login($user);

            if ($user['role'] == 'admin') {
                header("Location: " . BASE_URL . "index.php?controller=AdminDashboard&action=index");
            } else {
                header("Location: " . BASE_URL . "index.php?controller=EmployeeDashboard&action=index");
            }
        } else {
            $_SESSION['error'] = "Sai email hoặc mật khẩu";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
        }
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
    }
}