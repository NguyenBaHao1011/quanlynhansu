<?php

class Leave
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

    // LẤY TẤT CẢ NGHỈ PHÉP
    public function getAll()
    {
        $sql = "SELECT l.*, e.employee_code, e.full_name, d.department_name, 
                       u.full_name as approved_by_name
                FROM leaves l 
                LEFT JOIN employees e ON l.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN users u ON l.approved_by = u.id
                WHERE e.is_deleted = 0
                ORDER BY l.start_date DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    // THÊM NGHỈ PHÉP
    public function create($data)
    {
        $sql = "INSERT INTO leaves
        (
            employee_id,
            leave_type,
            start_date,
            end_date,
            reason,
            status,
            approved_by
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "isssssi",
            $data['employee_id'],
            $data['leave_type'],
            $data['start_date'],
            $data['end_date'],
            $data['reason'],
            $data['status'],
            $data['approved_by']
        );

        return $stmt->execute();
    }
    
    public function find($id)
    {
        $sql = "SELECT l.*, e.employee_code, e.full_name, d.department_name, 
                       u.full_name as approved_by_name
                FROM leaves l 
                LEFT JOIN employees e ON l.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN users u ON l.approved_by = u.id
                WHERE l.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($data)
    {
        $sql = "UPDATE leaves
                SET
                    employee_id = ?,
                    leave_type = ?,
                    start_date = ?,
                    end_date = ?,
                    reason = ?,
                    status = ?,
                    approved_by = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isssssii",
            $data['employee_id'],
            $data['leave_type'],
            $data['start_date'],
            $data['end_date'],
            $data['reason'],
            $data['status'],
            $data['approved_by'],
            $data['id']
        );
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM leaves WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    
    public function search($keyword)
    {
        $sql = "SELECT l.*, e.employee_code, e.full_name, d.department_name, 
                       u.full_name as approved_by_name
                FROM leaves l 
                LEFT JOIN employees e ON l.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN users u ON l.approved_by = u.id
                WHERE e.is_deleted = 0 
                AND (e.full_name LIKE ? OR e.employee_code LIKE ? OR l.leave_type LIKE ?)
                ORDER BY l.start_date DESC";
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function paginate($start, $limit)
    {
        $sql = "SELECT l.*, e.employee_code, e.full_name, d.department_name, 
                       u.full_name as approved_by_name
                FROM leaves l 
                LEFT JOIN employees e ON l.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN users u ON l.approved_by = u.id
                WHERE e.is_deleted = 0
                ORDER BY l.start_date DESC
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function countLeave()
    {
        $sql = "SELECT COUNT(*) as total FROM leaves l 
                LEFT JOIN employees e ON l.employee_id = e.id 
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
    
    public function getPending()
    {
        $sql = "SELECT l.*, e.employee_code, e.full_name, d.department_name 
                FROM leaves l 
                LEFT JOIN employees e ON l.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE l.status = 'Pending' AND e.is_deleted = 0
                ORDER BY l.created_at ASC";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function getByEmployee($employee_id)
    {
        $sql = "SELECT * FROM leaves WHERE employee_id = ? ORDER BY start_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}