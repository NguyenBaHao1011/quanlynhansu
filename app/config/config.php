<?php
// Define base URL for the application
define('BASE_URL', '/hrm-system/public/');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'hrm_management');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application settings
define('APP_NAME', 'HRM System');
define('APP_ENV', 'development');

// Session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Error reporting (development mode)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Bangkok');