<?php

require_once "../app/helpers/Auth.php";

class EmployeeDashboardController
{
    public function index()
    {
        // Check authentication and employee role
        Auth::requireEmployee();
        
        require_once "../app/views/employee/dashboard.php";
    }
}