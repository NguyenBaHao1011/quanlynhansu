<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Department.php";

class DepartmentController
{
    // DANH SÁCH PHÒNG BAN
    public function index()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $departmentModel = new Department();
        
        // PAGINATION
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        
        // LẤY DANH SÁCH PHÒNG BAN
        $departments = $departmentModel->paginate($start, $limit);
        
        // TỔNG PHÒNG BAN
        $totalDepartment = $departmentModel->countDepartment();
        
        // TỔNG SỐ TRANG
        $totalPage = ceil($totalDepartment / $limit);
        
        require_once "../app/views/department/index.php";
    }

    // FORM THÊM PHÒNG BAN
    public function create()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $departmentModel = new Department();
        $employees = $departmentModel->getEmployees();
        
        require_once "../app/views/department/create.php";
    }

    // LƯU PHÒNG BAN
    public function store()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'department_code' => $_POST['department_code'],
            'department_name' => $_POST['department_name'],
            'manager_id' => !empty($_POST['manager_id']) ? (int)$_POST['manager_id'] : null,
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'description' => $_POST['description']
        ];

        $department = new Department();
        $department->create($data);

        header("Location: " . BASE_URL . "index.php?controller=Department&action=index");
    }

    public function edit()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $department = new Department();
        $row = $department->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Department&action=index");
            exit;
        }
        
        $employees = $department->getEmployees();
        
        require_once "../app/views/department/edit.php";
    }

    public function update()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'id' => $_POST['id'],
            'department_code' => $_POST['department_code'],
            'department_name' => $_POST['department_name'],
            'manager_id' => !empty($_POST['manager_id']) ? (int)$_POST['manager_id'] : null,
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'description' => $_POST['description']
        ];
        
        $department = new Department();
        $department->update($data);

        header("Location: " . BASE_URL . "index.php?controller=Department&action=index");
    }

    // HIỂN THỊ TRANG XÁC NHẬN XÓA PHÒNG BAN
    public function delete()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $department = new Department();
        $row = $department->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Department&action=index");
            exit;
        }

        require_once "../app/views/department/delete.php";
    }

    // THỰC HIỆN XÓA PHÒNG BAN
    public function destroy()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $department = new Department();
        $department->delete($id);

        header("Location: " . BASE_URL . "index.php?controller=Department&action=index");
    }

    public function search()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $keyword = $_GET['keyword'];
        $department = new Department();
        $departments = $department->search($keyword);

        require_once "../app/views/department/index.php";
    }
}