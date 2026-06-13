<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa bảng lương</title>

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

            <i class="fa-solid fa-trash"></i>
            Xóa bảng lương

        </h1>

        <a href="/hrm-system/public/index.php?controller=Payroll&action=index"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="employee-card">

        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <strong>Cảnh báo:</strong> Bạn đang sắp xóa bảng lương tháng <strong><?= sprintf('%02d/%d', $row['payroll_month'], $row['payroll_year']) ?></strong> của nhân viên <strong><?= $row['full_name'] ?></strong>. Hành động này không thể hoàn tác!
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Thông tin bảng lương</h5>
                <p><strong>Nhân viên:</strong> <?= $row['employee_code'] ?> - <?= $row['full_name'] ?></p>
                <p><strong>Tháng/Năm:</strong> <?= sprintf('%02d/%d', $row['payroll_month'], $row['payroll_year']) ?></p>
                <p><strong>Ngày công chuẩn:</strong> <?= $row['standard_working_day'] ?></p>
                <p><strong>Ngày công thực tế:</strong> <?= $row['actual_working_day'] ?? 0 ?></p>
                <p><strong>Lương cơ bản:</strong> <?= number_format($row['basic_salary']) ?> VNĐ</p>
                <p><strong>Phụ cấp:</strong> <?= number_format($row['allowance']) ?> VNĐ</p>
                <p><strong>Thưởng:</strong> <?= number_format($row['bonus']) ?> VNĐ</p>
                <p><strong>Khấu trừ:</strong> <?= number_format($row['deduction']) ?> VNĐ</p>
                <p><strong>Tổng lương:</strong> <?= number_format($row['total_salary']) ?> VNĐ</p>
                <p><strong>Trạng thái:</strong> 
                    <?php 
                        $statusText = '';
                        switch($row['payment_status']) {
                            case 'Pending': $statusText = 'Chờ thanh toán'; break;
                            case 'Paid': $statusText = 'Đã thanh toán'; break;
                            default: $statusText = $row['payment_status'];
                        }
                        echo $statusText;
                    ?>
                </p>
            </div>
        </div>

        <form method="POST"
            action="/hrm-system/public/index.php?controller=Payroll&action=destroy">

            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <div class="d-flex justify-content-center gap-3 mt-4">

                <a href="/hrm-system/public/index.php?controller=Payroll&action=index"
                    class="btn btn-secondary px-4">
                    <i class="fa-solid fa-times"></i>
                    Hủy
                </a>

                <button type="submit"
                    class="btn btn-danger px-4"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa bảng lương này?');">
                    <i class="fa-solid fa-trash"></i>
                    Xác nhận xóa
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>