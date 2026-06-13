<?php

class Payroll
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

    // LẤY TẤT CẢ LƯƠNG
    public function getAll()
    {
        $sql = "SELECT p.*, e.employee_code, e.full_name, d.department_name 
                FROM payrolls p 
                LEFT JOIN employees e ON p.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0
                ORDER BY p.payroll_year DESC, p.payroll_month DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    // THÊM LƯƠNG
    public function create($data)
    {
        $sql = "INSERT INTO payrolls
        (
            employee_id,
            payroll_month,
            payroll_year,
            standard_working_day,
            actual_working_day,
            basic_salary,
            allowance,
            bonus,
            deduction,
            total_salary,
            payment_status
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iiiddddddds",
            $data['employee_id'],
            $data['payroll_month'],
            $data['payroll_year'],
            $data['standard_working_day'],
            $data['actual_working_day'],
            $data['basic_salary'],
            $data['allowance'],
            $data['bonus'],
            $data['deduction'],
            $data['total_salary'],
            $data['payment_status']
        );

        return $stmt->execute();
    }
    
    public function find($id)
    {
        $sql = "SELECT p.*, e.employee_code, e.full_name, d.department_name 
                FROM payrolls p 
                LEFT JOIN employees e ON p.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE p.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($data)
    {
        $sql = "UPDATE payrolls
                SET
                    employee_id = ?,
                    payroll_month = ?,
                    payroll_year = ?,
                    standard_working_day = ?,
                    actual_working_day = ?,
                    basic_salary = ?,
                    allowance = ?,
                    bonus = ?,
                    deduction = ?,
                    total_salary = ?,
                    payment_status = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iiidddddddsi",
            $data['employee_id'],
            $data['payroll_month'],
            $data['payroll_year'],
            $data['standard_working_day'],
            $data['actual_working_day'],
            $data['basic_salary'],
            $data['allowance'],
            $data['bonus'],
            $data['deduction'],
            $data['total_salary'],
            $data['payment_status'],
            $data['id']
        );
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM payrolls WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    
    public function search($keyword)
    {
        $sql = "SELECT p.*, e.employee_code, e.full_name, d.department_name 
                FROM payrolls p 
                LEFT JOIN employees e ON p.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0 
                AND (e.full_name LIKE ? OR e.employee_code LIKE ?)
                ORDER BY p.payroll_year DESC, p.payroll_month DESC";
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function paginate($start, $limit)
    {
        $sql = "SELECT p.*, e.employee_code, e.full_name, d.department_name 
                FROM payrolls p 
                LEFT JOIN employees e ON p.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0
                ORDER BY p.payroll_year DESC, p.payroll_month DESC
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function countPayroll()
    {
        $sql = "SELECT COUNT(*) as total FROM payrolls p 
                LEFT JOIN employees e ON p.employee_id = e.id 
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
    
    public function getByEmployee($employee_id, $year = null)
    {
        $sql = "SELECT * FROM payrolls WHERE employee_id = ?";
        $params = [$employee_id];
        $types = "i";
        
        if ($year) {
            $sql .= " AND payroll_year = ?";
            $params[] = $year;
            $types .= "i";
        }
        
        $sql .= " ORDER BY payroll_year DESC, payroll_month DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function checkExists($employee_id, $month, $year)
    {
        $sql = "SELECT id FROM payrolls WHERE employee_id = ? AND payroll_month = ? AND payroll_year = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $employee_id, $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function getMonthlySummary($month, $year)
    {
        $sql = "SELECT p.*, e.employee_code, e.full_name, d.department_name 
                FROM payrolls p 
                LEFT JOIN employees e ON p.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE p.payroll_month = ? AND p.payroll_year = ? AND e.is_deleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result();
    }
}