<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Payroll.php";

class PayrollController
{
    // DANH SÁCH LƯƠNG
    public function index()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $payrollModel = new Payroll();
        
        // PAGINATION
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        
        // LẤY DANH SÁCH LƯƠNG
        $payrolls = $payrollModel->paginate($start, $limit);
        
        // TỔNG LƯƠNG
        $totalPayroll = $payrollModel->countPayroll();
        
        // TỔNG SỐ TRANG
        $totalPage = ceil($totalPayroll / $limit);
        
        require_once "../app/views/payroll/index.php";
    }

    // FORM THÊM LƯƠNG
    public function create()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $payrollModel = new Payroll();
        $employees = $payrollModel->getEmployees();
        
        require_once "../app/views/payroll/create.php";
    }

    // LƯU LƯƠNG
    public function store()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'employee_id' => (int)$_POST['employee_id'],
            'payroll_month' => (int)$_POST['payroll_month'],
            'payroll_year' => (int)$_POST['payroll_year'],
            'standard_working_day' => (int)$_POST['standard_working_day'] ?? 26,
            'actual_working_day' => !empty($_POST['actual_working_day']) ? (float)$_POST['actual_working_day'] : null,
            'basic_salary' => (float)$_POST['basic_salary'],
            'allowance' => !empty($_POST['allowance']) ? (float)$_POST['allowance'] : 0,
            'bonus' => !empty($_POST['bonus']) ? (float)$_POST['bonus'] : 0,
            'deduction' => !empty($_POST['deduction']) ? (float)$_POST['deduction'] : 0,
            'total_salary' => (float)$_POST['total_salary'],
            'payment_status' => $_POST['payment_status'] ?? 'Pending'
        ];

        $payroll = new Payroll();
        $payroll->create($data);

        header("Location: " . BASE_URL . "index.php?controller=Payroll&action=index");
    }

    public function edit()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $payroll = new Payroll();
        $row = $payroll->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Payroll&action=index");
            exit;
        }
        
        $employees = $payroll->getEmployees();
        
        require_once "../app/views/payroll/edit.php";
    }

    public function update()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'id' => $_POST['id'],
            'employee_id' => (int)$_POST['employee_id'],
            'payroll_month' => (int)$_POST['payroll_month'],
            'payroll_year' => (int)$_POST['payroll_year'],
            'standard_working_day' => (int)$_POST['standard_working_day'] ?? 26,
            'actual_working_day' => !empty($_POST['actual_working_day']) ? (float)$_POST['actual_working_day'] : null,
            'basic_salary' => (float)$_POST['basic_salary'],
            'allowance' => !empty($_POST['allowance']) ? (float)$_POST['allowance'] : 0,
            'bonus' => !empty($_POST['bonus']) ? (float)$_POST['bonus'] : 0,
            'deduction' => !empty($_POST['deduction']) ? (float)$_POST['deduction'] : 0,
            'total_salary' => (float)$_POST['total_salary'],
            'payment_status' => $_POST['payment_status'] ?? 'Pending'
        ];
        
        $payroll = new Payroll();
        $payroll->update($data);

        header("Location: " . BASE_URL . "index.php?controller=Payroll&action=index");
    }

    // HIỂN THỊ TRANG XÁC NHẬN XÓA LƯƠNG
    public function delete()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $payroll = new Payroll();
        $row = $payroll->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Payroll&action=index");
            exit;
        }

        require_once "../app/views/payroll/delete.php";
    }

    // THỰC HIỆN XÓA LƯƠNG
    public function destroy()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $payroll = new Payroll();
        $payroll->delete($id);

        header("Location: " . BASE_URL . "index.php?controller=Payroll&action=index");
    }

    public function search()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $keyword = $_GET['keyword'];
        $payroll = new Payroll();
        $payrolls = $payroll->search($keyword);

        require_once "../app/views/payroll/index.php";
    }
    
    // TÍNH LƯƠNG TỰ ĐỘNG
    public function calculate()
    {
        Auth::requireAdmin();
        
        $month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
        $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
        
        $payrollModel = new Payroll();
        $attendanceModel = new \Attendance();
        $contractModel = new \Contract();
        $employeeModel = new \Employee();
        $leaveModel = new \Leave();
        
        $employees = $employeeModel->getAll();
        
        while ($emp = $employees->fetch_assoc()) {
            // Check if payroll already exists
            $existing = $payrollModel->checkExists($emp['id'], $month, $year);
            if ($existing) continue;
            
            // Get active contract
            $contract = $contractModel->getActiveByEmployee($emp['id']);
            if (!$contract) continue;
            
            // Calculate working days from attendance
            $attendances = $attendanceModel->getByEmployee($emp['id'], $month, $year);
            $actualWorkingDay = 0;
            while ($att = $attendances->fetch_assoc()) {
                $actualWorkingDay += $att['working_day'] ?? 0;
            }
            
            // Get leaves in this month
            $leaves = $leaveModel->getByEmployee($emp['id']);
            $leaveDays = 0;
            while ($lv = $leaves->fetch_assoc()) {
                if ($lv['status'] == 'Approved') {
                    $start = new DateTime($lv['start_date']);
                    $end = new DateTime($lv['end_date']);
                    if ($start->format('m') == $month && $start->format('Y') == $year) {
                        $leaveDays += $start->diff($end)->days + 1;
                    }
                }
            }
            
            // Calculate salary
            $basicSalary = $contract['basic_salary'];
            $allowance = $contract['allowance'];
            $standardDays = 26;
            $dailyRate = $basicSalary / $standardDays;
            $salary = $dailyRate * ($actualWorkingDay + $leaveDays) + $allowance;
            
            $data = [
                'employee_id' => $emp['id'],
                'payroll_month' => $month,
                'payroll_year' => $year,
                'standard_working_day' => $standardDays,
                'actual_working_day' => $actualWorkingDay,
                'basic_salary' => $basicSalary,
                'allowance' => $allowance,
                'bonus' => 0,
                'deduction' => 0,
                'total_salary' => $salary,
                'payment_status' => 'Pending'
            ];
            
            $payrollModel->create($data);
        }
        
        $_SESSION['success'] = "Đã tính lương tháng $month/$year!";
        header("Location: " . BASE_URL . "index.php?controller=Payroll&action=index");
    }
    
    // XEM LƯƠNG CỦA NHÂN VIÊN
    public function myPayroll()
    {
        Auth::requireEmployee();
        
        $userModel = new \User();
        $user = $userModel->findById(Auth::id());
        $emp_id = $user['employee_id'] ?? Auth::id();
        
        $payrollModel = new Payroll();
        $payrolls = $payrollModel->getByEmployee($emp_id);
        
        require_once "../app/views/payroll/my_payroll.php";
    }
}