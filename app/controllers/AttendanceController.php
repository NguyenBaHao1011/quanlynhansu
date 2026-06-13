<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Attendance.php";

class AttendanceController
{
    // DANH SÁCH CHẤM CÔNG
    public function index()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $attendanceModel = new Attendance();
        
        // PAGINATION
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        
        // LẤY DANH SÁCH CHẤM CÔNG
        $attendances = $attendanceModel->paginate($start, $limit);
        
        // TỔNG CHẤM CÔNG
        $totalAttendance = $attendanceModel->countAttendance();
        
        // TỔNG SỐ TRANG
        $totalPage = ceil($totalAttendance / $limit);
        
        require_once "../app/views/attendance/index.php";
    }

    // FORM THÊM CHẤM CÔNG
    public function create()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $attendanceModel = new Attendance();
        $employees = $attendanceModel->getEmployees();
        
        require_once "../app/views/attendance/create.php";
    }

    // LƯU CHẤM CÔNG
    public function store()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'employee_id' => (int)$_POST['employee_id'],
            'attendance_date' => $_POST['attendance_date'],
            'check_in' => $_POST['check_in'] ?? null,
            'check_out' => $_POST['check_out'] ?? null,
            'working_hours' => !empty($_POST['working_hours']) ? (float)$_POST['working_hours'] : null,
            'working_day' => !empty($_POST['working_day']) ? (float)$_POST['working_day'] : 1.0,
            'note' => $_POST['note'] ?? null
        ];

        $attendance = new Attendance();
        $attendance->create($data);

        header("Location: " . BASE_URL . "index.php?controller=Attendance&action=index");
    }

    public function edit()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $attendance = new Attendance();
        $row = $attendance->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Attendance&action=index");
            exit;
        }
        
        $employees = $attendance->getEmployees();
        
        require_once "../app/views/attendance/edit.php";
    }

    public function update()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'id' => $_POST['id'],
            'employee_id' => (int)$_POST['employee_id'],
            'attendance_date' => $_POST['attendance_date'],
            'check_in' => $_POST['check_in'] ?? null,
            'check_out' => $_POST['check_out'] ?? null,
            'working_hours' => !empty($_POST['working_hours']) ? (float)$_POST['working_hours'] : null,
            'working_day' => !empty($_POST['working_day']) ? (float)$_POST['working_day'] : 1.0,
            'note' => $_POST['note'] ?? null
        ];
        
        $attendance = new Attendance();
        $attendance->update($data);

        header("Location: " . BASE_URL . "index.php?controller=Attendance&action=index");
    }

    // HIỂN THỊ TRANG XÁC NHẬN XÓA CHẤM CÔNG
    public function delete()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $attendance = new Attendance();
        $row = $attendance->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Attendance&action=index");
            exit;
        }

        require_once "../app/views/attendance/delete.php";
    }

    // THỰC HIỆN XÓA CHẤM CÔNG
    public function destroy()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $attendance = new Attendance();
        $attendance->delete($id);

        header("Location: " . BASE_URL . "index.php?controller=Attendance&action=index");
    }

    public function search()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $keyword = $_GET['keyword'];
        $attendance = new Attendance();
        $attendances = $attendance->search($keyword);

        require_once "../app/views/attendance/index.php";
    }
    
    // CHẤM CÔNG NHANH (CHECK IN/OUT)
    public function quickCheckIn()
    {
        Auth::requireAuth();
        
        $employee_id = Auth::id();
        $today = date('Y-m-d');
        
        $attendance = new Attendance();
        $existing = $attendance->checkExists($employee_id, $today);
        
        if ($existing) {
            // Check out
            $data = [
                'id' => $existing['id'],
                'employee_id' => $employee_id,
                'attendance_date' => $today,
                'check_out' => date('H:i:s'),
                'note' => 'Auto check-out'
            ];
            
            // Calculate working hours
            $checkInTime = strtotime($today . ' ' . $existing['check_in']);
            $checkOutTime = strtotime($today . ' ' . date('H:i:s'));
            $workingHours = ($checkOutTime - $checkInTime) / 3600;
            $data['working_hours'] = round($workingHours, 2);
            $data['working_day'] = $workingHours >= 8 ? 1.0 : 0.5;
            
            $attendance->update($data);
            $_SESSION['success'] = "Check-out thành công!";
        } else {
            // Check in
            $data = [
                'employee_id' => $employee_id,
                'attendance_date' => $today,
                'check_in' => date('H:i:s'),
                'working_day' => 1.0,
                'note' => 'Auto check-in'
            ];
            
            $attendance->create($data);
            $_SESSION['success'] = "Check-in thành công!";
        }
        
        header("Location: " . BASE_URL . "index.php?controller=EmployeeDashboard&action=index");
    }
}