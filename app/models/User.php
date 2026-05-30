<?php

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "hrm_system");

        if($this->conn->connect_error)
        {
            die("Kết nối DB thất bại");
        }
    }

    // ĐĂNG KÝ
    public function register($fullname, $email, $password, $role)
    {
        // Check if email already exists
        if ($this->findByEmail($email)) {
            return false; // Email already exists
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(fullname,email,password,role)
        VALUES(?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssss",
            $fullname,
            $email,
            $password,
            $role
        );

        return $stmt->execute();
    }

    // LOGIN
    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

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
}