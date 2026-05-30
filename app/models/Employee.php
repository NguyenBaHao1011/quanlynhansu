<?php

class Employee
{
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli(
            "localhost",
            "root",
            "",
            "hrm_system"
        );

        if($this->conn->connect_error)
        {
            die("Kết nối thất bại");
        }
    }

    // LẤY TẤT CẢ NHÂN VIÊN
    public function getAll()
    {
        $sql = "SELECT * FROM employees";

        $result = $this->conn->query($sql);

        return $result;
    }

    // THÊM NHÂN VIÊN
    public function create($data)
    {
        $sql = "INSERT INTO employees
        (
            employee_code,
            fullname,
            email,
            phone,
            gender,
            birthday,
            address,
            department,
            position,
            salary
        )

        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssssssssd",

            $data['employee_code'],
            $data['fullname'],
            $data['email'],
            $data['phone'],
            $data['gender'],
            $data['birthday'],
            $data['address'],
            $data['department'],
            $data['position'],
            $data['salary']
        );

        return $stmt->execute();
    }
    public function find($id)
    {
        $sql = "SELECT * FROM employees WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($data)
    {
        $sql = "UPDATE employees
                SET
                    employee_code = ?,
                    fullname = ?,
                    email = ?,
                    department = ?,
                    position = ?,
                    salary = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssssii",
            $data['employee_code'],
            $data['fullname'],
            $data['email'],
            $data['department'],
            $data['position'],
            $data['salary'],
            $data['id']
        );
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM employees WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function search($keyword)
    {
        $sql = "SELECT * FROM employees
                WHERE fullname LIKE ?
                OR employee_code LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function paginate($start, $limit)
    {
        $sql = "SELECT * FROM employees LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function countEmployee()
    {
        $sql = "SELECT COUNT(*) as total FROM employees";

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        return $row['total'];
    }
}