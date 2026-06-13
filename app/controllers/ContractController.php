<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Contract.php";

class ContractController
{
    // DANH SÁCH HỢP ĐỒNG
    public function index()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $contractModel = new Contract();
        
        // PAGINATION
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        
        // LẤY DANH SÁCH HỢP ĐỒNG
        $contracts = $contractModel->paginate($start, $limit);
        
        // TỔNG HỢP ĐỒNG
        $totalContract = $contractModel->countContract();
        
        // TỔNG SỐ TRANG
        $totalPage = ceil($totalContract / $limit);
        
        require_once "../app/views/contract/index.php";
    }

    // FORM THÊM HỢP ĐỒNG
    public function create()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $contractModel = new Contract();
        $employees = $contractModel->getEmployees();
        
        require_once "../app/views/contract/create.php";
    }

    // LƯU HỢP ĐỒNG
    public function store()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'employee_id' => (int)$_POST['employee_id'],
            'contract_code' => $_POST['contract_code'],
            'contract_type' => $_POST['contract_type'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'basic_salary' => (float)$_POST['basic_salary'],
            'allowance' => !empty($_POST['allowance']) ? (float)$_POST['allowance'] : 0,
            'content' => $_POST['content'] ?? null,
            'status' => $_POST['status'] ?? 'Active'
        ];

        $contract = new Contract();
        $contract->create($data);

        header("Location: " . BASE_URL . "index.php?controller=Contract&action=index");
    }

    public function edit()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $contract = new Contract();
        $row = $contract->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Contract&action=index");
            exit;
        }
        
        $employees = $contract->getEmployees();
        
        require_once "../app/views/contract/edit.php";
    }

    public function update()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $data = [
            'id' => $_POST['id'],
            'employee_id' => (int)$_POST['employee_id'],
            'contract_code' => $_POST['contract_code'],
            'contract_type' => $_POST['contract_type'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'basic_salary' => (float)$_POST['basic_salary'],
            'allowance' => !empty($_POST['allowance']) ? (float)$_POST['allowance'] : 0,
            'content' => $_POST['content'] ?? null,
            'status' => $_POST['status'] ?? 'Active'
        ];
        
        $contract = new Contract();
        $contract->update($data);

        header("Location: " . BASE_URL . "index.php?controller=Contract&action=index");
    }

    // HIỂN THỊ TRANG XÁC NHẬN XÓA HỢP ĐỒNG
    public function delete()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $contract = new Contract();
        $row = $contract->find($id);
        
        if (!$row) {
            header("Location: " . BASE_URL . "index.php?controller=Contract&action=index");
            exit;
        }

        require_once "../app/views/contract/delete.php";
    }

    // THỰC HIỆN XÓA HỢP ĐỒNG
    public function destroy()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $id = $_GET['id'];
        $contract = new Contract();
        $contract->delete($id);

        header("Location: " . BASE_URL . "index.php?controller=Contract&action=index");
    }

    public function search()
    {
        // Check admin permission
        Auth::requireAdmin();
        
        $keyword = $_GET['keyword'];
        $contract = new Contract();
        $contracts = $contract->search($keyword);

        require_once "../app/views/contract/index.php";
    }
}