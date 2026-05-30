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
        
        require_once "../app/views/employee/create.php";
    }

    // LƯU NHÂN VIÊN
    public function store()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'employee_code' => $_POST['employee_code'],
            'fullname' => $_POST['fullname'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'gender' => $_POST['gender'],
            'birthday' => $_POST['birthday'],
            'address' => $_POST['address'],
            'department' => $_POST['department'],
            'position' => $_POST['position'],
            'salary' => $_POST['salary']
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

        require_once "../app/views/employee/edit.php";
    }

    public function update()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $employee = new Employee();
        $employee->update($_POST);

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