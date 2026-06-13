<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hợp đồng</title>

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

        <a href="/hrm-system/public/index.php?controller=Contract&action=index"
            class="active-menu">

            <i class="fa-solid fa-file-contract"></i>
            Hợp đồng

        </a>

        <a href="/hrm-system/public/index.php?controller=Leave&action=index">

            <i class="fa-solid fa-calendar-check"></i>
            Nghỉ phép

        </a>

        <a href="/hrm-system/public/index.php?controller=Payroll&action=index">

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

            <i class="fa-solid fa-file-contract"></i>
            Thêm hợp đồng

        </h1>

        <a href="/hrm-system/public/index.php?controller=Contract&action=index"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="employee-card">

        <form method="POST"
            action="/hrm-system/public/index.php?controller=Contract&action=store">

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Nhân viên</label>
                    <select name="employee_id"
                        class="form-control"
                        required>
                        <option value="">-- Chọn nhân viên --</option>
                        <?php if(isset($employees) && $employees->num_rows > 0): ?>
                            <?php while($emp = $employees->fetch_assoc()): ?>
                                <option value="<?= $emp['id'] ?>"><?= $emp['employee_code'] ?> - <?= $emp['full_name'] ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Mã hợp đồng</label>
                    <input type="text"
                        name="contract_code"
                        class="form-control"
                        required>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Loại hợp đồng</label>
                    <select name="contract_type"
                        class="form-control"
                        required>
                        <option value="Probation">Thử việc</option>
                        <option value="Official">Chính thức</option>
                        <option value="Seasonal">Theo mùa vụ</option>
                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Trạng thái</label>
                    <select name="status"
                        class="form-control">
                        <option value="Active">Đang hiệu lực</option>
                        <option value="Expired">Hết hạn</option>
                        <option value="Terminated">Đã chấm dứt</option>
                    </select>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date"
                        name="start_date"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date"
                        name="end_date"
                        class="form-control"
                        required>

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
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Phụ cấp</label>
                    <input type="number"
                        name="allowance"
                        class="form-control"
                        step="1000"
                        min="0"
                        value="0">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">Nội dung hợp đồng</label>
                <textarea name="content"
                    class="form-control"
                    rows="4"></textarea>

            </div>

            <div class="d-flex justify-content-center mt-4">

                <button type="submit"
                    class="btn-add px-4">

                    <i class="fa-solid fa-save"></i>
                    Lưu hợp đồng

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>