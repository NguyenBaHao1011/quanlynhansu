<?php

class Attendance
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

    // LẤY TẤT CẢ CHẤM CÔNG
    public function getAll()
    {
        $sql = "SELECT a.*, e.employee_code, e.full_name, d.department_name 
                FROM attendances a 
                LEFT JOIN employees e ON a.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0
                ORDER BY a.attendance_date DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    // THÊM CHẤM CÔNG
    public function create($data)
    {
        $sql = "INSERT INTO attendances
        (
            employee_id,
            attendance_date,
            check_in,
            check_out,
            working_hours,
            working_day,
            note
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "isssdds",
            $data['employee_id'],
            $data['attendance_date'],
            $data['check_in'],
            $data['check_out'],
            $data['working_hours'],
            $data['working_day'],
            $data['note']
        );

        return $stmt->execute();
    }
    
    public function find($id)
    {
        $sql = "SELECT a.*, e.employee_code, e.full_name, d.department_name 
                FROM attendances a 
                LEFT JOIN employees e ON a.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE a.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($data)
    {
        $sql = "UPDATE attendances
                SET
                    employee_id = ?,
                    attendance_date = ?,
                    check_in = ?,
                    check_out = ?,
                    working_hours = ?,
                    working_day = ?,
                    note = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isssddsi",
            $data['employee_id'],
            $data['attendance_date'],
            $data['check_in'],
            $data['check_out'],
            $data['working_hours'],
            $data['working_day'],
            $data['note'],
            $data['id']
        );
        
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM attendances WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    
    public function search($keyword)
    {
        $sql = "SELECT a.*, e.employee_code, e.full_name, d.department_name 
                FROM attendances a 
                LEFT JOIN employees e ON a.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0 
                AND (e.full_name LIKE ? OR e.employee_code LIKE ? OR a.attendance_date LIKE ?)
                ORDER BY a.attendance_date DESC";
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function paginate($start, $limit)
    {
        $sql = "SELECT a.*, e.employee_code, e.full_name, d.department_name 
                FROM attendances a 
                LEFT JOIN employees e ON a.employee_id = e.id 
                LEFT JOIN departments d ON e.department_id = d.id
                WHERE e.is_deleted = 0
                ORDER BY a.attendance_date DESC
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function countAttendance()
    {
        $sql = "SELECT COUNT(*) as total FROM attendances a 
                LEFT JOIN employees e ON a.employee_id = e.id 
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
    
    public function getByEmployee($employee_id, $month = null, $year = null)
    {
        $sql = "SELECT * FROM attendances WHERE employee_id = ?";
        $params = [$employee_id];
        $types = "i";
        
        if ($month && $year) {
            $sql .= " AND MONTH(attendance_date) = ? AND YEAR(attendance_date) = ?";
            $params[] = $month;
            $params[] = $year;
            $types .= "ii";
        }
        
        $sql .= " ORDER BY attendance_date DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function checkExists($employee_id, $date)
    {
        $sql = "SELECT id FROM attendances WHERE employee_id = ? AND attendance_date = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $employee_id, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}