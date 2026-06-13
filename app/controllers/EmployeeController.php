<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Employee.php";

class EmployeeController
{
    // DANH SÁCH NHÂN VIÊN
    public function index()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $employeeModel = new Employee();
        
        // PAGINATION
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        
        // LẤY DANH SÁCH NHÂN VIÊN
        $employees = $employeeModel->paginate($start, $limit);
        
        // TỔNG NHÂN VIÊN
        $totalEmployee = $employeeModel->countEmployee();
        
        // TỔNG SỐ TRANG
        $totalPage = ceil($totalEmployee / $limit);
        
        require_once "../app/views/admin/dashboard.php";
    }

    // FORM THÊM NHÂN VIÊN
    public function create()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $employeeModel = new Employee();
        $departments = $employeeModel->getDepartments();
        
        require_once "../app/views/employee/create.php";
    }

    // LƯU NHÂN VIÊN
    public function store()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'employee_code' => $_POST['employee_code'],
            'full_name' => $_POST['full_name'],
            'gender' => $_POST['gender'],
            'date_of_birth' => $_POST['date_of_birth'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'avatar' => $_POST['avatar'] ?? null,
            'department_id' => !empty($_POST['department_id']) ? (int)$_POST['department_id'] : null,
            'position' => $_POST['position'],
            'hire_date' => $_POST['hire_date'],
            'status' => $_POST['status'] ?? 'Working'
        ];

        $employee = new Employee();
        $employee->create($data);

        header("Location: " . BASE_URL . "index.php?controller=Employee&action=index");
    }

    public function edit()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $employee = new Employee();
        $row = $employee->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Employee&action=index");
            exit;
        }
        
        $departments = $employee->getDepartments();
        
        require_once "../app/views/employee/edit.php";
    }

    public function update()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'id' => $_POST['id'],
            'employee_code' => $_POST['employee_code'],
            'full_name' => $_POST['full_name'],
            'gender' => $_POST['gender'],
            'date_of_birth' => $_POST['date_of_birth'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'avatar' => $_POST['avatar'] ?? null,
            'department_id' => !empty($_POST['department_id']) ? (int)$_POST['department_id'] : null,
            'position' => $_POST['position'],
            'hire_date' => $_POST['hire_date'],
            'status' => $_POST['status'] ?? 'Working'
        ];
        
        $employee = new Employee();
        $employee->update($data);

        header("Location: " . BASE_URL . "index.php?controller=Employee&action=index");
    }

    // HIỂN THỊ TRANG XÁC NHẬN XÓA NHÂN VIÊN
    public function delete()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $employee = new Employee();
        $row = $employee->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Employee&action=index");
            exit;
        }

        require_once "../app/views/employee/delete.php";
    }

    // THỰC HIỆN XÓA NHÂN VIÊN
    public function destroy()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $employee = new Employee();
        $employee->delete($id);

        header("Location: " . BASE_URL . "index.php?controller=Employee&action=index");
    }

    public function search()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $keyword = $_GET['keyword'];
        $employee = new Employee();
        $employees = $employee->search($keyword);

        require_once "../app/views/admin/dashboard.php";
    }
}