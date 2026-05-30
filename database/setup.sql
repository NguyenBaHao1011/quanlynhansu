-- HRM System Database Setup Script
-- Run this script to create all required tables

-- Create database (uncomment if you need to create the database)
-- CREATE DATABASE IF NOT EXISTS hrm_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE hrm_system;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employee') DEFAULT 'employee',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employees table
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_code VARCHAR(50) UNIQUE NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20),
    gender ENUM('Nam', 'Nữ', 'Khác') DEFAULT 'Nam',
    birthday DATE,
    address TEXT,
    department VARCHAR(100),
    position VARCHAR(100),
    salary DECIMAL(15,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user
-- Email: admin@hrm.com
-- Password: admin123 (hashed with password_hash)
INSERT INTO users (fullname, email, password, role) 
VALUES (
    'Admin', 
    'admin@hrm.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'admin'
)
ON DUPLICATE KEY UPDATE email=email;

-- Insert sample employee data (optional)
INSERT INTO employees (employee_code, fullname, email, phone, gender, birthday, address, department, position, salary) 
VALUES 
    ('EMP001', 'Nguyễn Văn A', 'nva@example.com', '0901234567', 'Nam', '1990-01-15', 'Hà Nội', 'IT', 'Developer', 15000000),
    ('EMP002', 'Trần Thị B', 'ttb@example.com', '0912345678', 'Nữ', '1992-05-20', 'TP.HCM', 'Marketing', 'Marketing Manager', 20000000),
    ('EMP003', 'Lê Văn C', 'lvc@example.com', '0923456789', 'Nam', '1988-08-10', 'Đà Nẵng', 'HR', 'HR Manager', 18000000)
ON DUPLICATE KEY UPDATE email=email;