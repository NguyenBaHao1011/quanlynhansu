<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Employee.php";
require_once "../app/models/Attendance.php";
require_once "../app/models/Leave.php";
require_once "../app/models/Payroll.php";
require_once "../app/models/User.php";

class EmployeeDashboardController
{
    public function index()
    {
        // Check authentication and employee role
        Auth::requireEmployee();
        
        $userModel = new User();
        $user = $userModel->findById(Auth::id());
        $emp_id = $user['employee_id'] ?? Auth::id();
        
        // Get employee info
        $employeeModel = new Employee();
        $employee = $employeeModel->find($emp_id);
        
        // Get today's attendance
        $attendanceModel = new Attendance();
        $today = date('Y-m-d');
        $todayAttendance = $attendanceModel->checkExists($emp_id, $today);
        
        // Get leave requests count
        $leaveModel = new Leave();
        $myLeaves = $leaveModel->getByEmployee($emp_id);
        $pendingLeaves = 0;
        if ($myLeaves) {
            while ($lv = $myLeaves->fetch_assoc()) {
                if ($lv['status'] == 'Pending') $pendingLeaves++;
            }
        }
        
        // Get latest payroll
        $payrollModel = new Payroll();
        $myPayrolls = $payrollModel->getByEmployee($emp_id);
        $latestPayroll = $myPayrolls ? $myPayrolls->fetch_assoc() : null;
        
        require_once "../app/views/employee/dashboard.php";
    }
}