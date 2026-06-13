-- ============================================
-- SEED DATA for HRM System Testing
-- ============================================
-- Run this AFTER importing hrm_management.sql
-- ============================================

-- ===== DEPARTMENTS (update existing with proper codes) =====
UPDATE `departments` SET `department_code` = 'TTSX' WHERE `id` = 1;
UPDATE `departments` SET `department_code` = 'HCNS' WHERE `id` = 2;
UPDATE `departments` SET `department_code` = 'TTDA' WHERE `id` = 3;
UPDATE `departments` SET `department_code` = 'TTKD' WHERE `id` = 4;

INSERT INTO `departments` (`department_code`, `department_name`, `manager_id`, `phone`, `email`, `description`) VALUES
('KT', 'Kế Toán', NULL, '0243789456', 'ketoan@hrm.vn', 'Phòng kế toán tài chính'),
('IT', 'Công Nghệ', NULL, '0243789457', 'congnghe@hrm.vn', 'Phòng công nghệ thông tin'),
('KTCL', 'Kiểm Tra Chất Lượng', NULL, '0243789458', 'kiemtra@hrm.vn', 'Phòng kiểm tra chất lượng');

-- ===== EMPLOYEES (11 employees with various statuses) =====
INSERT INTO `employees` (`employee_code`, `full_name`, `gender`, `date_of_birth`, `phone`, `email`, `address`, `avatar`, `department_id`, `position`, `hire_date`, `status`) VALUES
('EMP001', 'Nguyễn Văn An', 'Male', '1995-03-15', '0912345678', 'nguyenvanan@hrm.vn', '12 Nguyễn Huệ, Q.1, TP.HCM', NULL, 2, 'Trưởng phòng HCNS', '2022-01-15', 'Working'),
('EMP002', 'Trần Thị Bích', 'Female', '1998-07-22', '0923456789', 'tranthibich@hrm.vn', '45 Lê Lợi, Q.1, TP.HCM', NULL, 2, 'Chuyên viên nhân sự', '2022-03-01', 'Working'),
('EMP003', 'Lê Hoàng Cường', 'Male', '1992-11-08', '0934567890', 'lehoangcuong@hrm.vn', '78 Hai Bà Trưng, Q.3, TP.HCM', NULL, 1, 'Quản đốc sản xuất', '2021-06-01', 'Working'),
('EMP004', 'Phạm Thị Dung', 'Female', '2000-05-18', '0945678901', 'phamthidung@hrm.vn', '23 Điện Biên Phủ, Q.BT, TP.HCM', NULL, 1, 'Công nhân sản xuất', '2023-09-01', 'Working'),
('EMP005', 'Hoàng Văn Em', 'Male', '1997-09-30', '0956789012', 'hoangvanem@hrm.vn', '56 Cách Mạng Tháng 8, Q.TB, TP.HCM', NULL, 3, 'Trưởng phòng dự án', '2021-01-01', 'Working'),
('EMP006', 'Đỗ Thị Phương', 'Female', '1999-02-14', '0967890123', 'dothiphuong@hrm.vn', '89 Nguyễn Đình Chiểu, Q.3, TP.HCM', NULL, 4, 'Nhân viên kinh doanh', '2023-03-15', 'Working'),
('EMP007', 'Vũ Minh Giàu', 'Male', '1994-06-25', '0978901234', 'vuminhgiau@hrm.vn', '12 Trần Hưng Đạo, Q.5, TP.HCM', NULL, 5, 'Kế toán trưởng', '2020-10-01', 'Working'),
('EMP008', 'Lý Thị Hạnh', 'Female', '2001-12-05', '0989012345', 'lythihanh@hrm.vn', '34 Phạm Văn Đồng, Q.TĐ, TP.HCM', NULL, 6, 'Lập trình viên', '2024-01-01', 'Probation'),
('EMP009', 'Trịnh Văn In', 'Male', '1996-08-17', '0990123456', 'trinhvanin@hrm.vn', '67 Lê Văn Sỹ, Q.3, TP.HCM', NULL, 7, 'Kiểm soát viên chất lượng', '2022-06-01', 'Working'),
('EMP010', 'Bùi Thị Kim', 'Female', '1990-04-28', '0901234567', 'buithikim@hrm.vn', '90 Nguyễn Thị Minh Khai, Q.1, TP.HCM', NULL, 5, 'Kế toán viên', '2023-01-01', 'Working'),
('EMP011', 'Đàm Văn Lộc', 'Male', '1993-01-10', '0912345670', 'damvanloc@hrm.vn', '15 Hoàng Diệu, Q.4, TP.HCM', NULL, 6, 'Lập trình viên', '2021-11-01', 'Working');

-- ===== EMPLOYEE USERS (for testing login as employee) =====
-- Password for all: 123456
INSERT INTO `users` (`username`, `email`, `password`, `role_id`, `employee_id`, `is_active`) VALUES
('employee1', 'nguyenvanan@hrm.vn', '$2y$10$p7ffTqNi4MJttgqZlCvGsO4ce9cll8SIdEHFoGpf5Er3kA6FDqyZ2', 3, 1, 1),
('employee2', 'tranthibich@hrm.vn', '$2y$10$p7ffTqNi4MJttgqZlCvGsO4ce9cll8SIdEHFoGpf5Er3kA6FDqyZ2', 3, 2, 1),
('employee3', 'lehoangcuong@hrm.vn', '$2y$10$p7ffTqNi4MJttgqZlCvGsO4ce9cll8SIdEHFoGpf5Er3kA6FDqyZ2', 3, 3, 1),
('employee4', 'phamthidung@hrm.vn', '$2y$10$p7ffTqNi4MJttgqZlCvGsO4ce9cll8SIdEHFoGpf5Er3kA6FDqyZ2', 3, 4, 1),
('employee5', 'hoangvanem@hrm.vn', '$2y$10$p7ffTqNi4MJttgqZlCvGsO4ce9cll8SIdEHFoGpf5Er3kA6FDqyZ2', 3, 5, 1),
('employeefull', 'dothiphuong@hrm.vn', '$2y$10$p7ffTqNi4MJttgqZlCvGsO4ce9cll8SIdEHFoGpf5Er3kA6FDqyZ2', 3, 6, 1),
('employee7', 'vuminhgiau@hrm.vn', '$2y$10$p7ffTqNi4MJttgqZlCvGsO4ce9cll8SIdEHFoGpf5Er3kA6FDqyZ2', 3, 7, 1);

-- Update department managers
UPDATE `departments` SET `manager_id` = 1 WHERE `id` = 2; -- HCNS -> Nguyễn Văn An
UPDATE `departments` SET `manager_id` = 3 WHERE `id` = 1; -- TTSX -> Lê Hoàng Cường
UPDATE `departments` SET `manager_id` = 5 WHERE `id` = 3; -- TTDA -> Hoàng Văn Em
UPDATE `departments` SET `manager_id` = 7 WHERE `id` = 5; -- KT -> Vũ Minh Giàu

-- ===== CONTRACTS =====
INSERT INTO `contracts` (`employee_id`, `contract_code`, `contract_type`, `start_date`, `end_date`, `basic_salary`, `allowance`, `content`, `status`) VALUES
(1, 'HD-2022-001', 'Official', '2022-01-15', '2025-01-14', 15000000, 2000000, 'Hợp đồng chính thức - Trưởng phòng HCNS', 'Active'),
(2, 'HD-2022-002', 'Official', '2022-03-01', '2025-02-28', 10000000, 1000000, 'Hợp đồng chính thức - Chuyên viên nhân sự', 'Active'),
(3, 'HD-2021-001', 'Official', '2021-06-01', '2024-05-31', 18000000, 2000000, 'Hợp đồng chính thức - Quản đốc sản xuất', 'Active'),
(4, 'HD-2023-001', 'Probation', '2023-09-01', '2024-02-28', 7000000, 500000, 'Hợp đồng thử việc - Công nhân sản xuất', 'Active'),
(5, 'HD-2021-002', 'Official', '2021-01-01', '2024-12-31', 16000000, 2000000, 'Hợp đồng chính thức - Trưởng phòng dự án', 'Active'),
(6, 'HD-2023-002', 'Official', '2023-03-15', '2026-03-14', 12000000, 1500000, 'Hợp đồng chính thức - Nhân viên kinh doanh', 'Active'),
(7, 'HD-2020-001', 'Official', '2020-10-01', '2025-09-30', 20000000, 3000000, 'Hợp đồng chính thức - Kế toán trưởng', 'Active'),
(8, 'HD-2024-001', 'Probation', '2024-01-01', '2024-06-30', 8000000, 500000, 'Hợp đồng thử việc - Lập trình viên', 'Active'),
(9, 'HD-2022-003', 'Official', '2022-06-01', '2025-05-31', 11000000, 1000000, 'Hợp đồng chính thức - Kiểm soát viên chất lượng', 'Active'),
(10, 'HD-2023-003', 'Official', '2023-01-01', '2025-12-31', 10000000, 1000000, 'Hợp đồng chính thức - Kế toán viên', 'Active'),
(11, 'HD-2021-003', 'Official', '2021-11-01', '2024-10-31', 13000000, 1500000, 'Hợp đồng chính thức - Lập trình viên', 'Active');

-- ===== ATTENDANCE (current month - May 2026) =====
INSERT INTO `attendances` (`employee_id`, `attendance_date`, `check_in`, `check_out`, `working_hours`, `working_day`, `note`) VALUES
-- Employee 1 - Nguyễn Văn An (full attendance)
(1, '2026-05-04', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(1, '2026-05-05', '08:15:00', '17:30:00', 9.25, 1.0, NULL),
(1, '2026-05-06', '07:45:00', '17:00:00', 9.25, 1.0, NULL),
(1, '2026-05-07', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(1, '2026-05-08', '08:30:00', '17:30:00', 9.00, 1.0, 'Đi muộn 30 phút'),
(1, '2026-05-11', '07:50:00', '17:15:00', 9.42, 1.0, NULL),
(1, '2026-05-12', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(1, '2026-05-13', '08:10:00', '17:30:00', 9.33, 1.0, NULL),
(1, '2026-05-14', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
(1, '2026-05-15', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(1, '2026-05-18', '07:55:00', '17:25:00', 9.50, 1.0, NULL),
(1, '2026-05-19', '08:05:00', '17:30:00', 9.42, 1.0, NULL),
(1, '2026-05-20', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(1, '2026-05-21', '07:45:00', '17:00:00', 9.25, 1.0, NULL),
(1, '2026-05-22', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
-- Employee 2 - Trần Thị Bích
(2, '2026-05-04', '07:55:00', '17:15:00', 9.33, 1.0, NULL),
(2, '2026-05-05', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
(2, '2026-05-06', '08:10:00', '17:30:00', 9.33, 1.0, NULL),
(2, '2026-05-07', '07:50:00', '17:00:00', 9.17, 1.0, NULL),
(2, '2026-05-08', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(2, '2026-05-11', '08:20:00', '17:30:00', 9.17, 1.0, 'Đi muộn 20 phút'),
(2, '2026-05-12', '08:00:00', '17:15:00', 9.25, 1.0, NULL),
(2, '2026-05-13', '07:45:00', '17:00:00', 9.25, 1.0, NULL),
(2, '2026-05-14', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(2, '2026-05-15', '08:05:00', '17:00:00', 8.92, 1.0, NULL),
(2, '2026-05-18', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(2, '2026-05-19', '07:55:00', '17:15:00', 9.33, 1.0, NULL),
(2, '2026-05-20', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
(2, '2026-05-21', '08:15:00', '17:30:00', 9.25, 1.0, NULL),
(2, '2026-05-22', '07:50:00', '17:00:00', 9.17, 1.0, NULL),
-- Employee 3 - Lê Hoàng Cường (some absences)
(3, '2026-05-04', '07:30:00', '17:00:00', 9.50, 1.0, NULL),
(3, '2026-05-05', '07:45:00', '17:30:00', 9.75, 1.0, NULL),
(3, '2026-05-06', '07:00:00', '17:00:00', 10.00, 1.0, NULL),
(3, '2026-05-07', '07:30:00', '17:30:00', 10.00, 1.0, NULL),
(3, '2026-05-08', '07:40:00', '17:00:00', 9.33, 1.0, NULL),
(3, '2026-05-11', '07:20:00', '17:30:00', 10.17, 1.0, NULL),
(3, '2026-05-12', '07:00:00', '17:00:00', 10.00, 1.0, NULL),
(3, '2026-05-13', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(3, '2026-05-14', '07:30:00', '17:00:00', 9.50, 1.0, NULL),
(3, '2026-05-15', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(3, '2026-05-18', '07:30:00', '17:00:00', 9.50, 1.0, NULL),
(3, '2026-05-19', '07:45:00', '17:30:00', 9.75, 1.0, NULL),
(3, '2026-05-20', '07:20:00', '17:00:00', 9.67, 1.0, NULL),
(3, '2026-05-21', '07:30:00', '17:30:00', 10.00, 1.0, NULL),
(3, '2026-05-22', '07:00:00', '16:30:00', 9.50, 1.0, NULL),
-- Employee 6 - Đỗ Thị Phương (fewer days - new employee)
(6, '2026-05-05', '08:15:00', '17:30:00', 9.25, 1.0, NULL),
(6, '2026-05-06', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
(6, '2026-05-07', '08:20:00', '17:30:00', 9.17, 1.0, NULL),
(6, '2026-05-08', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
(6, '2026-05-12', '08:10:00', '17:30:00', 9.33, 1.0, NULL),
(6, '2026-05-13', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
(6, '2026-05-14', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(6, '2026-05-15', '08:05:00', '17:00:00', 8.92, 1.0, NULL),
(6, '2026-05-19', '08:00:00', '17:30:00', 9.50, 1.0, NULL),
(6, '2026-05-20', '08:30:00', '17:30:00', 9.00, 1.0, 'Đi muộn 30 phút'),
(6, '2026-05-21', '08:00:00', '17:00:00', 9.00, 1.0, NULL),
(6, '2026-05-22', '08:15:00', '17:00:00', 8.75, 1.0, NULL);

-- ===== LEAVES =====
INSERT INTO `leaves` (`employee_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`, `approved_by`) VALUES
(2, 'Annual', '2026-05-20', '2026-05-21', 'Nghỉ phép năm về quê', 'Approved', 1),
(4, 'Sick', '2026-05-15', '2026-05-15', 'Bị cảm sốt', 'Approved', 1),
(6, 'Annual', '2026-05-23', '2026-05-25', 'Nghỉ phép năm du lịch', 'Pending', NULL),
(8, 'Sick', '2026-05-19', '2026-05-20', 'Không khỏe, đi khám bệnh', 'Approved', 1),
(9, 'Unpaid', '2026-05-27', '2026-05-28', 'Có việc gia đình', 'Pending', NULL),
(10, 'Annual', '2026-05-10', '2026-05-10', 'Nghỉ phép cá nhân', 'Approved', 1);

-- ===== PAYROLL (April 2026) =====
INSERT INTO `payrolls` (`employee_id`, `payroll_month`, `payroll_year`, `standard_working_day`, `actual_working_day`, `basic_salary`, `allowance`, `bonus`, `deduction`, `total_salary`, `payment_status`) VALUES
(1, 4, 2026, 22, 22.0, 15000000, 2000000, 1000000, 0, 18000000, 'Paid'),
(2, 4, 2026, 22, 22.0, 10000000, 1000000, 500000, 0, 11500000, 'Paid'),
(3, 4, 2026, 22, 20.0, 18000000, 2000000, 1500000, 200000, 21100000, 'Paid'),
(4, 4, 2026, 22, 20.0, 7000000, 500000, 0, 0, 7200000, 'Paid'),
(5, 4, 2026, 22, 22.0, 16000000, 2000000, 2000000, 500000, 19500000, 'Paid'),
(6, 4, 2026, 22, 18.0, 12000000, 1500000, 300000, 0, 12900000, 'Paid'),
(7, 4, 2026, 22, 22.0, 20000000, 3000000, 1000000, 500000, 23500000, 'Paid'),
(8, 4, 2026, 22, 20.0, 8000000, 500000, 0, 0, 8100000, 'Paid'),
(9, 4, 2026, 22, 22.0, 11000000, 1000000, 500000, 0, 12500000, 'Paid'),
(10, 4, 2026, 22, 21.0, 10000000, 1000000, 200000, 0, 10800000, 'Paid'),
(11, 4, 2026, 22, 22.0, 13000000, 1500000, 800000, 300000, 14700000, 'Paid');

-- ===== PAYROLL (May 2026 - current month, Pending) =====
INSERT INTO `payrolls` (`employee_id`, `payroll_month`, `payroll_year`, `standard_working_day`, `actual_working_day`, `basic_salary`, `allowance`, `bonus`, `deduction`, `total_salary`, `payment_status`) VALUES
(1, 5, 2026, 22, 15.0, 15000000, 2000000, 0, 0, 15680000, 'Pending'),
(2, 5, 2026, 22, 15.0, 10000000, 1000000, 0, 0, 10410000, 'Pending'),
(3, 5, 2026, 22, 15.0, 18000000, 2000000, 0, 0, 19010000, 'Pending'),
(4, 5, 2026, 22, 10.0, 7000000, 500000, 0, 0, 5500000, 'Pending'),
(5, 5, 2026, 22, 15.0, 16000000, 2000000, 0, 0, 16820000, 'Pending'),
(6, 5, 2026, 22, 12.0, 12000000, 1500000, 0, 0, 10010000, 'Pending');

-- ===== UPDATE auto-increment counters =====
ALTER TABLE `employees` AUTO_INCREMENT = 12;
ALTER TABLE `contracts` AUTO_INCREMENT = 12;
ALTER TABLE `attendances` AUTO_INCREMENT = 100;
ALTER TABLE `leaves` AUTO_INCREMENT = 10;
ALTER TABLE `payrolls` AUTO_INCREMENT = 20;
ALTER TABLE `departments` AUTO_INCREMENT = 8;