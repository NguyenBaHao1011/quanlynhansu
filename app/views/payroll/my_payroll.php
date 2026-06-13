<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng lương của tôi</title>

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

        <a href="/hrm-system/public/index.php?controller=EmployeeDashboard&action=index">
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

        <a href="/hrm-system/public/index.php?controller=Payroll&action=myPayroll"
            class="active-menu">
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

            <i class="fa-solid fa-money-bill"></i>
            Bảng lương của tôi

        </h1>

    </div>

    <div class="employee-card">

        <div class="mb-4">
            <label class="form-label">Chọn năm:</label>
            <form method="GET" action="/hrm-system/public/index.php" class="d-inline-flex gap-2">
                <input type="hidden" name="controller" value="Payroll">
                <input type="hidden" name="action" value="myPayroll">
                <select name="year" class="form-control" style="width: auto;" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                        <option value="<?= $y ?>" <?= (isset($_GET['year']) && $_GET['year'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </form>
        </div>

        <div class="table-responsive-custom">
        <table class="table align-middle">

            <thead>

                <tr>

                    <th>Tháng/Năm</th>
                    <th>Ngày công chuẩn</th>
                    <th>Ngày công thực tế</th>
                    <th>Lương cơ bản</th>
                    <th>Phụ cấp</th>
                    <th>Thưởng</th>
                    <th>Khấu trừ</th>
                    <th>Tổng lương</th>
                    <th>Trạng thái</th>

                </tr>

            </thead>

            <tbody>

            <?php if(isset($payrolls) && $payrolls->num_rows > 0): ?>

                <?php while($row = $payrolls->fetch_assoc()) : ?>

                    <tr>

                        <td><?= sprintf('%02d/%d', $row['payroll_month'], $row['payroll_year']) ?></td>

                        <td><?= $row['standard_working_day'] ?></td>

                        <td><?= $row['actual_working_day'] ?? 0 ?></td>

                        <td><?= number_format($row['basic_salary']) ?> VNĐ</td>

                        <td><?= number_format($row['allowance']) ?> VNĐ</td>

                        <td><?= number_format($row['bonus']) ?> VNĐ</td>

                        <td><?= number_format($row['deduction']) ?> VNĐ</td>

                        <td class="salary">
                            <strong><?= number_format($row['total_salary']) ?> VNĐ</strong>
                        </td>

                        <td>
                            <?php 
                                $statusClass = '';
                                $statusText = '';
                                switch($row['payment_status']) {
                                    case 'Pending':
                                        $statusClass = 'bg-warning text-dark';
                                        $statusText = 'Chờ thanh toán';
                                        break;
                                    case 'Paid':
                                        $statusClass = 'bg-success';
                                        $statusText = 'Đã thanh toán';
                                        break;
                                    default:
                                        $statusClass = 'bg-secondary';
                                        $statusText = $row['payment_status'];
                                }
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="9">

                        <div class="empty-box">

                            <i class="fa-solid fa-money-bill"></i>

                            <h4>
                                Chưa có bảng lương nào
                            </h4>

                        </div>

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>
        </div>

    </div>

</div>

</body>
</html>