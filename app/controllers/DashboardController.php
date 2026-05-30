<?php

class DashboardController
{
    public function index()
    {
        session_start();

        // middleware check login
        if(!isset($_SESSION['user']))
        {
            header("Location: /hrm-system/public/index.php");
            exit;
        }
          require_once "../app/views/dashboard/index.php";
    }
}