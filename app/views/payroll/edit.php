<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa bảng lương</title>

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
            Sửa bảng lương

        </h1>

        <a href="/hrm-system/public/index.php?controller=Payroll&action=index"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="employee-card">

        <form method="POST"
            action="/hrm-system/public/index.php?controller=Payroll&action=update">

            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Nhân viên</label>
                    <select name="employee_id"
                        class="form-control"
                        required>
                        <option value="">-- Chọn nhân viên --</option>
                        <?php if(isset($employees) && $employees->num_rows > 0): ?>
                            <?php while($emp = $employees->fetch_assoc()): ?>
                                <option value="<?= $emp['id'] ?>" <?= $row['employee_id'] == $emp['id'] ? 'selected' : '' ?>><?= $emp['employee_code'] ?> - <?= $emp['full_name'] ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Tháng/Năm</label>
                    <div class="row">
                        <div class="col-6">
                            <select name="payroll_month" class="form-control" required>
                                <option value="">Tháng</option>
                                <?php for($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= $row['payroll_month'] == $m ? 'selected' : '' ?>><?= $m ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="payroll_year" class="form-control" required>
                                <option value="">Năm</option>
                                <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                                    <option value="<?= $y ?>" <?= $row['payroll_year'] == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Ngày công chuẩn</label>
                    <input type="number"
                        name="standard_working_day"
                        class="form-control"
                        value="<?= $row['standard_working_day'] ?>"
                        min="0"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Ngày công thực tế</label>
                    <input type="number"
                        name="actual_working_day"
                        class="form-control"
                        step="0.5"
                        min="0"
                        value="<?= $row['actual_working_day'] ?? 0 ?>">

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Lương cơ bản</label>
                    <input type="number"
                        name="basic_salary"
                        class="form-control"
                        step="1000"
                        min="0"
                        value="<?= $row['basic_salary'] ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Phụ cấp</label>
                    <input type="number"
                        name="allowance"
                        class="form-control"
                        step="1000"
                        min="0"
                        value="<?= $row['allowance'] ?? 0 ?>">

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Thưởng</label>
                    <input type="number"
                        name="bonus"
                        class="form-control"
                        step="1000"
                        min="0"
                        value="<?= $row['bonus'] ?? 0 ?>">

                </div>

                <div class="col-md-6">

                    <label class="form-label">Khấu trừ</label>
                    <input type="number"
                        name="deduction"
                        class="form-control"
                        step="1000"
                        min="0"
                        value="<?= $row['deduction'] ?? 0 ?>">

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Tổng lương</label>
                    <input type="number"
                        name="total_salary"
                        class="form-control"
                        step="1000"
                        min="0"
                        value="<?= $row['total_salary'] ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Trạng thái thanh toán</label>
                    <select name="payment_status"
                        class="form-control">
                        <option value="Pending" <?= $row['payment_status'] == 'Pending' ? 'selected' : '' ?>>Chờ thanh toán</option>
                        <option value="Paid" <?= $row['payment_status'] == 'Paid' ? 'selected' : '' ?>>Đã thanh toán</option>
                    </select>

                </div>

            </div>

            <div class="d-flex justify-content-center mt-4">

                <button type="submit"
                    class="btn-add px-4">

                    <i class="fa-solid fa-save"></i>
                    Cập nhật

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>