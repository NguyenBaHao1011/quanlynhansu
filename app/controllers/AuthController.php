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
        $userModel = new User();
        $roles = $userModel->getRoles();
        $employees = $userModel->getEmployeesWithoutUser();
        
        require_once "../app/views/auth/register.php";
    }

    // XỬ LÝ ĐĂNG KÝ
    public function store()
    {
        session_start();

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $role_id = (int)$_POST['role_id'];
        $employee_id = !empty($_POST['employee_id']) ? (int)$_POST['employee_id'] : null;

        // CHECK CONFIRM PASSWORD
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Mật khẩu xác nhận không khớp";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=register");
            return;
        }

        $user = new User();

        $result = $user->register($username, $email, $password, $role_id, $employee_id);

        if ($result) {
            // Set success message
            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            exit;
        } else {
            // Check if email already exists
            if ($user->findByEmail($email)) {
                $_SESSION['error'] = "Email đã tồn tại. Vui lòng dùng email khác.";
            } elseif ($user->findByUsername($username)) {
                $_SESSION['error'] = "Tên đăng nhập đã tồn tại. Vui lòng dùng tên khác.";
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

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // FR-LOGIN-02: Kiểm tra dữ liệu đầu vào không để trống
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            return;
        }

        // FR-LOGIN-02: Kiểm tra định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            return;
        }

        $userModel = new User();
        $user = $userModel->login($email, $password);

        // FR-LOGIN-06: Tài khoản bị khóa
        if ($user === 'locked') {
            $_SESSION['error'] = "Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.";
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            return;
        }

        if ($user) {
            // Update last login
            $userModel->updateLastLogin($user['id']);
            
            // Use Auth helper to login
            Auth::login($user);

            // FR-LOGIN-04: Phân quyền và điều hướng theo vai trò
            if ($user['role_name'] == 'Admin') {
                header("Location: " . BASE_URL . "index.php?controller=AdminDashboard&action=index");
            } elseif ($user['role_name'] == 'HR') {
                header("Location: " . BASE_URL . "index.php?controller=AdminDashboard&action=index");
            } else {
                header("Location: " . BASE_URL . "index.php?controller=EmployeeDashboard&action=index");
            }
        } else {
            // FR-LOGIN-05: Xử lý sai thông tin
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