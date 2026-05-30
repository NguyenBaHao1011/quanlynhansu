<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configuration
require_once "../app/config/config.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get controller and action from URL with proper defaults
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// If controller is empty or just 'index.php', default to Auth controller
if (empty($controller) || $controller === 'index.php') {
    $controller = 'Auth';
    $action = 'login';
}

// Sanitize controller and action names (only allow alphanumeric characters)
$controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
$action = preg_replace('/[^a-zA-Z0-9]/', '', $action);

// Build controller file path
$controllerFile = "../app/controllers/" . $controller . "Controller.php";

// Check if controller file exists
if (!file_exists($controllerFile)) {
    http_response_code(404);
    die("Controller not found: " . $controller);
}

// Include controller file
require_once $controllerFile;

// Build controller class name
$controllerName = $controller . "Controller";

// Check if class exists
if (!class_exists($controllerName)) {
    http_response_code(404);
    die("Controller class not found: " . $controllerName);
}

// Instantiate controller
$controllerObject = new $controllerName();

// Check if action method exists
if (!method_exists($controllerObject, $action)) {
    http_response_code(404);
    die("Action not found: " . $action . " in " . $controllerName);
}

// Call action method
$controllerObject->$action();
