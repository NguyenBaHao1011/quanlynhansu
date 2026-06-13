<?php

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "hrm_management");

        if($this->conn->connect_error)
        {
            die("Kết nối DB thất bại");
        }
    }

    // ĐĂNG KÝ
    public function register($username, $email, $password, $role_id, $employee_id = null)
    {
        // Check if email already exists
        if ($this->findByEmail($email)) {
            return false; // Email already exists
        }

        // Check if username already exists
        if ($this->findByUsername($username)) {
            return false; // Username already exists
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, email, password, role_id, employee_id)
        VALUES(?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssii",
            $username,
            $email,
            $password,
            $role_id,
            $employee_id
        );

        return $stmt->execute();
    }

    // LOGIN
    public function login($email, $password)
    {
        $sql = "SELECT u.*, r.role_name FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.email = ? AND u.is_active = 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        // Check if account is locked (FR-LOGIN-06)
        if ($user && $user['is_locked'] == 1) {
            return 'locked';
        }

        // kiểm tra password
        if($user && password_verify($password, $user['password']))
        {
            return $user;
        }

        return false;
    }

    // Check if user exists by email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Check if user exists by username
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Get user by ID with role info
    public function findById($id)
    {
        $sql = "SELECT u.*, r.role_name FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Get all users
    public function getAll()
    {
        $sql = "SELECT u.*, r.role_name FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.is_active = 1";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    // Get all roles
    public function getRoles()
    {
        $sql = "SELECT id, role_name FROM roles";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    // Get employees without user account
    public function getEmployeesWithoutUser()
    {
        $sql = "SELECT e.id, e.employee_code, e.full_name, e.email 
                FROM employees e 
                LEFT JOIN users u ON e.id = u.employee_id 
                WHERE e.is_deleted = 0 AND u.id IS NULL";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    // Update user
    public function update($data)
    {
        $sql = "UPDATE users SET username = ?, email = ?, role_id = ?, employee_id = ?, is_active = ?, is_locked = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiiiii", 
            $data['username'], 
            $data['email'], 
            $data['role_id'], 
            $data['employee_id'], 
            $data['is_active'], 
            $data['is_locked'],
            $data['id']
        );
        return $stmt->execute();
    }
    
    // Update password
    public function updatePassword($id, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $password, $id);
        return $stmt->execute();
    }
    
    // Update last login
    public function updateLastLogin($id)
    {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}