<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nghỉ phép</title>

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

        <a href="/hrm-system/public/index.php?controller=Leave&action=index"
            class="active-menu">

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

            <i class="fa-solid fa-calendar-check"></i>
            Sửa nghỉ phép

        </h1>

        <a href="/hrm-system/public/index.php?controller=Leave&action=index"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="employee-card">

        <form method="POST"
            action="/hrm-system/public/index.php?controller=Leave&action=update">

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

                    <label class="form-label">Loại nghỉ phép</label>
                    <select name="leave_type"
                        class="form-control"
                        required>
                        <option value="Annual" <?= $row['leave_type'] == 'Annual' ? 'selected' : '' ?>>Nghỉ phép năm</option>
                        <option value="Sick" <?= $row['leave_type'] == 'Sick' ? 'selected' : '' ?>>Nghỉ ốm</option>
                        <option value="Unpaid" <?= $row['leave_type'] == 'Unpaid' ? 'selected' : '' ?>>Nghỉ không lương</option>
                        <option value="Maternity" <?= $row['leave_type'] == 'Maternity' ? 'selected' : '' ?>>Nghỉ thai sản</option>
                    </select>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Từ ngày</label>
                    <input type="date"
                        name="start_date"
                        class="form-control"
                        value="<?= $row['start_date'] ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Đến ngày</label>
                    <input type="date"
                        name="end_date"
                        class="form-control"
                        value="<?= $row['end_date'] ?>"
                        required>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">Lý do</label>
                <textarea name="reason"
                    class="form-control"
                    rows="3"
                    required><?= $row['reason'] ?></textarea>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Trạng thái</label>
                    <select name="status"
                        class="form-control">
                        <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                        <option value="Approved" <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Đã duyệt</option>
                        <option value="Rejected" <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Từ chối</option>
                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Người duyệt</label>
                    <select name="approved_by"
                        class="form-control">
                        <option value="">-- Chọn người duyệt --</option>
                        <?php if(isset($users) && $users->num_rows > 0): ?>
                            <?php while($usr = $users->fetch_assoc()): ?>
                                <option value="<?= $usr['id'] ?>" <?= $row['approved_by'] == $usr['id'] ? 'selected' : '' ?>><?= $usr['full_name'] ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
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