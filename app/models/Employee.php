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
            "hrm_management"
        );

        if($this->conn->connect_error)
        {
            die("Kết nối thất bại");
        }
    }

    // LẤY TẤT CẢ NHÂN VIÊN
    public function getAll()
    {
        $sql = "SELECT e.*, d.department_name FROM employees e 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0";

        $result = $this->conn->query($sql);

        return $result;
    }

    // THÊM NHÂN VIÊN
    public function create($data)
    {
        $sql = "INSERT INTO employees
        (
            employee_code,
            full_name,
            gender,
            date_of_birth,
            phone,
            email,
            address,
            avatar,
            department_id,
            position,
            hire_date,
            status
        )

        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssssssssisss",

            $data['employee_code'],
            $data['full_name'],
            $data['gender'],
            $data['date_of_birth'],
            $data['phone'],
            $data['email'],
            $data['address'],
            $data['avatar'],
            $data['department_id'],
            $data['position'],
            $data['hire_date'],
            $data['status']
        );

        return $stmt->execute();
    }
    
    public function find($id)
    {
        $sql = "SELECT e.*, d.department_name FROM employees e 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.id = ? AND e.is_deleted = 0";
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
                    full_name = ?,
                    gender = ?,
                    date_of_birth = ?,
                    phone = ?,
                    email = ?,
                    address = ?,
                    avatar = ?,
                    department_id = ?,
                    position = ?,
                    hire_date = ?,
                    status = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssisssi",
            $data['employee_code'],
            $data['full_name'],
            $data['gender'],
            $data['date_of_birth'],
            $data['phone'],
            $data['email'],
            $data['address'],
            $data['avatar'],
            $data['department_id'],
            $data['position'],
            $data['hire_date'],
            $data['status'],
            $data['id']
        );
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "UPDATE employees SET is_deleted = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    
    public function hardDelete($id)
    {
        $sql = "DELETE FROM employees WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function search($keyword)
    {
        $sql = "SELECT e.*, d.department_name FROM employees e 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0 
                AND (e.full_name LIKE ? OR e.employee_code LIKE ? OR e.email LIKE ?)";
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function paginate($start, $limit)
    {
        $sql = "SELECT e.*, d.department_name FROM employees e 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function countEmployee()
    {
        $sql = "SELECT COUNT(*) as total FROM employees WHERE is_deleted = 0";

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        return $row['total'];
    }
    
    public function getDepartments()
    {
        $sql = "SELECT id, department_name FROM departments";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function getByDepartment($department_id)
    {
        $sql = "SELECT e.*, d.department_name FROM employees e 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.department_id = ? AND e.is_deleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $department_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}