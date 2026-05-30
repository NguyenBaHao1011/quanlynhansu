<?php

require_once "../app/helpers/Auth.php";
require_once "../app/models/Employee.php";

class AdminDashboardController
{
    public function index()
    {
        // Check authentication and admin role
        Auth::requireAdmin();
        
        $employeeModel = new Employee();
        $employees = $employeeModel->getAll();
        
        require_once "../app/views/admin/dashboard.php";
    }
}