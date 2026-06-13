<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Leave.php";

class LeaveController
{
    // DANH SÁCH NGHỈ PHÉP
    public function index()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $leaveModel = new Leave();
        
        // PAGINATION
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        
        // LẤY DANH SÁCH NGHỈ PHÉP
        $leaves = $leaveModel->paginate($start, $limit);
        
        // TỔNG NGHỈ PHÉP
        $totalLeave = $leaveModel->countLeave();
        
        // TỔNG SỐ TRANG
        $totalPage = ceil($totalLeave / $limit);
        
        require_once "../app/views/leave/index.php";
    }

    // FORM THÊM NGHỈ PHÉP
    public function create()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $leaveModel = new Leave();
        $employees = $leaveModel->getEmployees();
        
        require_once "../app/views/leave/create.php";
    }

    // LƯU NGHỈ PHÉP
    public function store()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'employee_id' => (int)$_POST['employee_id'],
            'leave_type' => $_POST['leave_type'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'reason' => $_POST['reason'],
            'status' => $_POST['status'] ?? 'Pending',
            'approved_by' => !empty($_POST['approved_by']) ? (int)$_POST['approved_by'] : null
        ];

        $leave = new Leave();
        $leave->create($data);

        header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
    }

    public function edit()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $leave = new Leave();
        $row = $leave->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
            exit;
        }
        
        $employees = $leave->getEmployees();
        
        require_once "../app/views/leave/edit.php";
    }

    public function update()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'id' => $_POST['id'],
            'employee_id' => (int)$_POST['employee_id'],
            'leave_type' => $_POST['leave_type'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'reason' => $_POST['reason'],
            'status' => $_POST['status'] ?? 'Pending',
            'approved_by' => !empty($_POST['approved_by']) ? (int)$_POST['approved_by'] : null
        ];
        
        $leave = new Leave();
        $leave->update($data);

        header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
    }

    // HIỂN THỊ TRANG XÁC NHẬN XÓA NGHỈ PHÉP
    public function delete()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $leave = new Leave();
        $row = $leave->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
            exit;
        }

        require_once "../app/views/leave/delete.php";
    }

    // THỰC HIỆN XÓA NGHỈ PHÉP
    public function destroy()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $leave = new Leave();
        $leave->delete($id);

        header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
    }

    public function search()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $keyword = $_GET['keyword'];
        $leave = new Leave();
        $leaves = $leave->search($keyword);

        require_once "../app/views/leave/index.php";
    }
    
    // DUYỆT NGHỈ PHÉP
    public function approve()
    {
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $leave = new Leave();
        $row = $leave->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
            exit;
        }
        
        $data = [
            'id' => $id,
            'employee_id' => $row['employee_id'],
            'leave_type' => $row['leave_type'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'reason' => $row['reason'],
            'status' => 'Approved',
            'approved_by' => Auth::id()
        ];
        
        $leave->update($data);
        $_SESSION['success'] = "Đã duyệt đơn nghỉ phép!";
        
        header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
    }
    
    // TỪ CHỐI NGHỈ PHÉP
    public function reject()
    {
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $leave = new Leave();
        $row = $leave->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
            exit;
        }
        
        $data = [
            'id' => $id,
            'employee_id' => $row['employee_id'],
            'leave_type' => $row['leave_type'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'reason' => $row['reason'],
            'status' => 'Rejected',
            'approved_by' => Auth::id()
        ];
        
        $leave->update($data);
        $_SESSION['success'] = "Đã từ chối đơn nghỉ phép!";
        
        header("Location: " . BASE_URL . "index.php?controller=Leave&action=index");
    }
    
    // DANH SÁCH NGHỈ PHÉP CỦA NHÂN VIÊN
    public function myLeaves()
    {
        Auth::requireEmployee();
        
        $employee_id = Auth::id();
        // Get employee_id from users table
        $userModel = new \User();
        $user = $userModel->findById($employee_id);
        $emp_id = $user['employee_id'] ?? $employee_id;
        
        $leaveModel = new Leave();
        $leaves = $leaveModel->getByEmployee($emp_id);
        
        require_once "../app/views/leave/my_leaves.php";
    }
}