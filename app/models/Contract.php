<?php

class Contract
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

    // LẤY TẤT CẢ HỢP ĐỒNG
    public function getAll()
    {
        $sql = "SELECT c.*, e.employee_code, e.full_name, d.department_name 
                FROM contracts c 
                LEFT JOIN employees e ON c.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0
                ORDER BY c.start_date DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    // THÊM HỢP ĐỒNG
    public function create($data)
    {
        $sql = "INSERT INTO contracts
        (
            employee_id,
            contract_code,
            contract_type,
            start_date,
            end_date,
            basic_salary,
            allowance,
            content,
            status
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "issssddss",
            $data['employee_id'],
            $data['contract_code'],
            $data['contract_type'],
            $data['start_date'],
            $data['end_date'],
            $data['basic_salary'],
            $data['allowance'],
            $data['content'],
            $data['status']
        );

        return $stmt->execute();
    }
    
    public function find($id)
    {
        $sql = "SELECT c.*, e.employee_code, e.full_name, d.department_name 
                FROM contracts c 
                LEFT JOIN employees e ON c.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE c.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($data)
    {
        $sql = "UPDATE contracts
                SET
                    employee_id = ?,
                    contract_code = ?,
                    contract_type = ?,
                    start_date = ?,
                    end_date = ?,
                    basic_salary = ?,
                    allowance = ?,
                    content = ?,
                    status = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "issssddssi",
            $data['employee_id'],
            $data['contract_code'],
            $data['contract_type'],
            $data['start_date'],
            $data['end_date'],
            $data['basic_salary'],
            $data['allowance'],
            $data['content'],
            $data['status'],
            $data['id']
        );
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM contracts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    
    public function search($keyword)
    {
        $sql = "SELECT c.*, e.employee_code, e.full_name, d.department_name 
                FROM contracts c 
                LEFT JOIN employees e ON c.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0 
                AND (e.full_name LIKE ? OR e.employee_code LIKE ? OR c.contract_code LIKE ?)
                ORDER BY c.start_date DESC";
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function paginate($start, $limit)
    {
        $sql = "SELECT c.*, e.employee_code, e.full_name, d.department_name 
                FROM contracts c 
                LEFT JOIN employees e ON c.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0
                ORDER BY c.start_date DESC
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function countContract()
    {
        $sql = "SELECT COUNT(*) as total FROM contracts c 
                LEFT JOIN employees e ON c.employee_id = e.id 
                WHERE e.is_deleted = 0";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function getEmployees()
    {
        $sql = "SELECT id, employee_code, full_name FROM employees WHERE is_deleted = 0";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function getActiveByEmployee($employee_id)
    {
        $sql = "SELECT * FROM contracts 
                WHERE employee_id = ? AND status = 'Active' 
                AND end_date >= CURDATE()
                ORDER BY start_date DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}