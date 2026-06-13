<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách lương</title>

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

        <a href="#">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>

        <a href="/hrm-system/public/index.php?controller=Employee&action=index">

            <i class="fa-solid fa-users"></i>
            Nhân viên

        </a>

        <a href="/hrm-system/public/index.php?controller=Department&action=index">

            <i class="fa-solid fa-building"></i>
            Phòng ban

        </a>

        <a href="/hrm-system/public/index.php?controller=Attendance&action=index">

            <i class="fa-solid fa-chart-line"></i>
            Chấm công

        </a>

        <a href="/hrm-system/public/index.php?controller=Contract&action=index">

            <i class="fa-solid fa-file-contract"></i>
            Hợp đồng

        </a>

        <a href="/hrm-system/public/index.php?controller=Leave&action=index">

            <i class="fa-solid fa-calendar-check"></i>
            Nghỉ phép

        </a>

        <a href="/hrm-system/public/index.php?controller=Payroll&action=index"
            class="active-menu">

            <i class="fa-solid fa-money-bill"></i>
            Lương

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
            Danh sách bảng lương

        </h1>

        <div class="d-flex gap-2">
            <a href="<?= BASE_URL ?>index.php?controller=Payroll&action=create"
               class="btn-add">
                <i class="fa-solid fa-plus"></i>
                Thêm lương
            </a>
            <a href="<?= BASE_URL ?>index.php?controller=Payroll&action=calculate"
               class="btn btn-success">
                <i class="fa-solid fa-calculator"></i>
                Tính lương tự động
            </a>
        </div>

    </div>

    <div class="employee-card">
        <form method="GET"
            action="/hrm-system/public/index.php"
            class="mb-4 d-flex flex-wrap gap-2">

            <input type="hidden"
                name="controller"
                value="Payroll">

            <input type="hidden"
                name="action"
                value="search">

            <input type="text"
                name="keyword"
                class="form-control"
                placeholder="Tìm kiếm nhân viên..."
                style="min-width: 200px;">

            <select name="month" class="form-control" style="width: auto;">
                <option value="">Tháng</option>
                <?php for($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m ?>" <?= (isset($_GET['month']) && $_GET['month'] == $m) ? 'selected' : '' ?>><?= $m ?></option>
                <?php endfor; ?>
            </select>

            <select name="year" class="form-control" style="width: auto;">
                <option value="">Năm</option>
                <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                    <option value="<?= $y ?>" <?= (isset($_GET['year']) && $_GET['year'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>

            <button class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

        </form>

        <div class="table-responsive-custom">
        <table class="table align-middle">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Phòng ban</th>
                    <th>Tháng/Năm</th>
                    <th>Ngày công chuẩn</th>
                    <th>Ngày công thực tế</th>
                    <th>Lương cơ bản</th>
                    <th>Phụ cấp</th>
                    <th>Thưởng</th>
                    <th>Khấu trừ</th>
                    <th>Tổng lương</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>

                </tr>

            </thead>

            <tbody>

            <?php if(isset($payrolls) && $payrolls->num_rows > 0): ?>

                <?php while($row = $payrolls->fetch_assoc()) : ?>

                    <tr>

                        <td><?= $row['id'] ?></td>

                        <td><?= $row['employee_code'] ?></td>

                        <td>
                            <strong><?= $row['full_name'] ?></strong>
                        </td>

                        <td><?= $row['department_name'] ?? 'Chưa có' ?></td>

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

                        <td>

                            <a href="/hrm-system/public/index.php?controller=Payroll&action=edit&id=<?= $row['id'] ?>"
                            class="action-btn btn-edit text-decoration-none">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <?php if($_SESSION['user']['role'] == 'admin'): ?>

                            <a href="/hrm-system/public/index.php?controller=Payroll&action=delete&id=<?= $row['id'] ?>"
                            class="action-btn btn-delete text-decoration-none">

                                <i class="fa-solid fa-trash"></i>

                            </a>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="14">

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

        <?php if(isset($totalPage)): ?>
        <div class="d-flex justify-content-center mt-4">

            <?php for($i = 1; $i <= $totalPage; $i++): ?>

                <a href="?controller=Payroll&action=index&page=<?= $i ?><?= isset($_GET['month']) ? '&month=' . $_GET['month'] : '' ?><?= isset($_GET['year']) ? '&year=' . $_GET['year'] : '' ?>"
                class="pagination-btn mx-1">

                    <?= $i ?>

                </a>

            <?php endfor; ?>

        </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>