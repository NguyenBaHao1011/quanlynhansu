<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard nhân viên</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet"
        href="/hrm-system/public/assets/css/admin.css">

</head>

<body>

<div class="sidebar">

    <div class="logo">
        HRM SYSTEM
    </div>

    <div class="menu">

        <a href="/hrm-system/public/index.php?controller=EmployeeDashboard&action=index"
            class="active-menu">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>

        <a href="/hrm-system/public/index.php?controller=Attendance&action=quickCheckIn">
            <i class="fa-solid fa-clock"></i>
            Chấm công
        </a>

        <a href="/hrm-system/public/index.php?controller=Leave&action=myLeaves">
            <i class="fa-solid fa-calendar-check"></i>
            Nghỉ phép của tôi
        </a>

        <a href="/hrm-system/public/index.php?controller=Payroll&action=myPayroll">
            <i class="fa-solid fa-money-bill"></i>
            Lương của tôi
        </a>

        <a href="/hrm-system/public/index.php?controller=Auth&action=logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>

    </div>

</div>

<div class="main-content">

    <div class="top-bar">

        <h1 class="page-title">

            <i class="fa-solid fa-user"></i>
            Dashboard

        </h1>

    </div>

    <div class="employee-card">

        <!-- Thông tin nhân viên -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="text-center">
                    <?php if(!empty($employee['avatar'])): ?>
                        <img src="<?= $employee['avatar'] ?>" alt="Avatar" class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle mb-2 bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 3rem;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    <?php endif; ?>
                    <h4><?= $employee['full_name'] ?? 'Nhân viên' ?></h4>
                    <p class="text-muted"><?= $employee['employee_code'] ?? '' ?></p>
                    <span class="badge bg-info"><?= $employee['position'] ?? 'Chưa có' ?></span>
                </div>
            </div>
            <div class="col-md-8">
                <h5>Thông tin cá nhân</h5>
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Mã nhân viên:</strong></td>
                        <td><?= $employee['employee_code'] ?? 'Chưa có' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Phòng ban:</strong></td>
                        <td><?= $employee['department_name'] ?? 'Chưa có' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Chức vụ:</strong></td>
                        <td><?= $employee['position'] ?? 'Chưa có' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Ngày vào làm:</strong></td>
                        <td><?= $employee['hire_date'] ?? 'Chưa có' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= $employee['email'] ?? 'Chưa có' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Số điện thoại:</strong></td>
                        <td><?= $employee['phone'] ?? 'Chưa có' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Trạng thái:</strong></td>
                        <td>
                            <?php 
                                $statusClass = '';
                                $statusText = '';
                                switch($employee['status']) {
                                    case 'Working':
                                        $statusClass = 'bg-success';
                                        $statusText = 'Đang làm việc';
                                        break;
                                    case 'Probation':
                                        $statusClass = 'bg-warning text-dark';
                                        $statusText = 'Thử việc';
                                        break;
                                    case 'Resigned':
                                        $statusClass = 'bg-danger';
                                        $statusText = 'Đã nghỉ việc';
                                        break;
                                    case 'Maternity Leave':
                                        $statusClass = 'bg-info';
                                        $statusText = 'Nghỉ thai sản';
                                        break;
                                    default:
                                        $statusClass = 'bg-secondary';
                                        $statusText = $employee['status'];
                                }
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <!-- Quick Stats -->
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>Chấm công hôm nay</h3>
                    <?php if($todayAttendance): ?>
                        <p>
                            <?php if($todayAttendance['check_in'] && !$todayAttendance['check_out']): ?>
                                <span class="badge bg-warning text-dark">Đã check-in</span>
                                <br><small>Giờ vào: <?= $todayAttendance['check_in'] ?></small>
                            <?php elseif($todayAttendance['check_in'] && $todayAttendance['check_out']): ?>
                                <span class="badge bg-success">Hoàn tất</span>
                                <br><small>Giờ ra: <?= $todayAttendance['check_out'] ?></small>
                            <?php else: ?>
                                <span class="badge bg-secondary">Chưa check-in</span>
                            <?php endif; ?>
                        </p>
                    <?php else: ?>
                        <p><span class="badge bg-danger">Chưa check-in</span></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $pendingLeaves ?></h3>
                    <p>Đơn nghỉ phép chờ duyệt</p>
                    <small class="text-muted"><?= $myLeaves ? $myLeaves->num_rows : 0 ?> tổng cộng</small>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fa-solid fa-money-bill"></i>
                </div>
                <div class="stat-info">
                    <h3>Lương mới nhất</h3>
                    <?php if($latestPayroll): ?>
                        <p><?= number_format($latestPayroll['total_salary']) ?> VNĐ</p>
                        <small class="text-muted">Tháng <?= sprintf('%02d/%d', $latestPayroll['payroll_month'], $latestPayroll['payroll_year']) ?></small>
                    <?php else: ?>
                        <p>Chưa có</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="/hrm-system/public/index.php?controller=Attendance&action=quickCheckIn" class="btn btn-outline-primary w-100 py-3">
                    <i class="fa-solid fa-clock fa-2x d-block mb-2"></i>
                    Chấm công
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="/hrm-system/public/index.php?controller=Leave&action=myLeaves" class="btn btn-outline-info w-100 py-3">
                    <i class="fa-solid fa-calendar-check fa-2x d-block mb-2"></i>
                    Nghỉ phép
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="/hrm-system/public/index.php?controller=Payroll&action=myPayroll" class="btn btn-outline-success w-100 py-3">
                    <i class="fa-solid fa-money-bill fa-2x d-block mb-2"></i>
                    Xem lương
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="/hrm-system/public/index.php?controller=Employee&action=edit&id=<?= $employee['id'] ?>" class="btn btn-outline-secondary w-100 py-3">
                    <i class="fa-solid fa-user-edit fa-2x d-block mb-2"></i>
                    Hồ sơ cá nhân
                </a>
            </div>
        </div>

    </div>

</div>

</body>
</html>