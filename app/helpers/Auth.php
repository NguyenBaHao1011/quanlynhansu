<?php

class Auth
{
    /**
     * Check if user is authenticated
     * @return bool
     */
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    /**
     * Check if user is admin
     * @return bool
     */
    public static function isAdmin()
    {
        return self::check() && $_SESSION['user']['role'] === 'admin';
    }

    /**
     * Check if user is employee
     * @return bool
     */
    public static function isEmployee()
    {
        return self::check() && $_SESSION['user']['role'] === 'employee';
    }

    /**
     * Get current user
     * @return array|null
     */
    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Get user ID
     * @return int|null
     */
    public static function id()
    {
        return $_SESSION['user']['id'] ?? null;
    }

    /**
     * Get user role
     * @return string|null
     */
    public static function role()
    {
        return $_SESSION['user']['role'] ?? null;
    }

    /**
     * Require authentication - redirect to login if not authenticated
     */
    public static function requireAuth()
    {
        if (!self::check()) {
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            exit;
        }
    }

    /**
     * Require admin role - redirect to dashboard or login if not admin
     */
    public static function requireAdmin()
    {
        if (!self::check()) {
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            exit;
        }
        
        if (!self::isAdmin()) {
            // Redirect to appropriate dashboard based on role
            if (self::isEmployee()) {
                header("Location: " . BASE_URL . "index.php?controller=EmployeeDashboard&action=index");
            } else {
                header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            }
            exit;
        }
    }

    /**
     * Require employee role - redirect to dashboard or login if not employee
     */
    public static function requireEmployee()
    {
        if (!self::check()) {
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            exit;
        }
        
        if (!self::isEmployee()) {
            // Redirect to appropriate dashboard based on role
            if (self::isAdmin()) {
                header("Location: " . BASE_URL . "index.php?controller=AdminDashboard&action=index");
            } else {
                header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            }
            exit;
        }
    }

    /**
     * Require specific role
     * @param string $role
     */
    public static function requireRole($role)
    {
        if (!self::check()) {
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            exit;
        }
        
        if (self::role() !== $role) {
            header("Location: " . BASE_URL . "index.php?controller=Auth&action=login");
            exit;
        }
    }

    /**
     * Login user
     * @param array $user
     */
    public static function login($user)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['user'] = $user;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
    }

    /**
     * Logout user
     */
    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION['user']);
        unset($_SESSION['logged_in']);
        unset($_SESSION['login_time']);
        session_destroy();
    }

    /**
     * Check if user can access admin area
     * @return bool
     */
    public static function canAccessAdmin()
    {
        return self::isAdmin();
    }

    /**
     * Check if user can access employee area
     * @return bool
     */
    public static function canAccessEmployee()
    {
        return self::isEmployee() || self::isAdmin();
    }

    /**
     * Get flash message
     * @param string $key
     * @return mixed
     */
    public static function getFlash($key = 'error')
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }
        
        return null;
    }

    /**
     * Set flash message
     * @param string $key
     * @param mixed $value
     */
    public static function setFlash($key, $value)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION[$key] = $value;
    }
}
