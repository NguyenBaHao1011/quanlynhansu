<?php

class Department
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

    // LẤY TẤT CẢ PHÒNG BAN
    public function getAll()
    {
        $sql = "SELECT d.*, e.full_name as manager_name FROM departments d 
                LEFT JOIN employees e ON d.manager_id = e.id";
        $result = $this->conn->query($sql);
        return $result;
    }

    // THÊM PHÒNG BAN
    public function create($data)
    {
        $sql = "INSERT INTO departments
        (
            department_code,
            department_name,
            manager_id,
            phone,
            email,
            description
        )
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssisss",
            $data['department_code'],
            $data['department_name'],
            $data['manager_id'],
            $data['phone'],
            $data['email'],
            $data['description']
        );

        return $stmt->execute();
    }
    
    public function find($id)
    {
        $sql = "SELECT d.*, e.full_name as manager_name FROM departments d 
                LEFT JOIN employees e ON d.manager_id = e.id
                WHERE d.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($data)
    {
        $sql = "UPDATE departments
                SET
                    department_code = ?,
                    department_name = ?,
                    manager_id = ?,
                    phone = ?,
                    email = ?,
                    description = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssisssi",
            $data['department_code'],
            $data['department_name'],
            $data['manager_id'],
            $data['phone'],
            $data['email'],
            $data['description'],
            $data['id']
        );
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM departments WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    
    public function search($keyword)
    {
        $sql = "SELECT d.*, e.full_name as manager_name FROM departments d 
                LEFT JOIN employees e ON d.manager_id = e.id
                WHERE d.department_name LIKE ? OR d.department_code LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function paginate($start, $limit)
    {
        $sql = "SELECT d.*, e.full_name as manager_name FROM departments d 
                LEFT JOIN employees e ON d.manager_id = e.id
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function countDepartment()
    {
        $sql = "SELECT COUNT(*) as total FROM departments";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function getEmployees()
    {
        $sql = "SELECT id, full_name FROM employees WHERE is_deleted = 0";
        $result = $this->conn->query($sql);
        return $result;
    }
}