<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhân viên</title>

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

        <a href="/hrm-system/public/index.php?controller=Employee&action=index"
            class="active-menu">

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

            <i class="fa-solid fa-user-edit"></i>
            Sửa nhân viên

        </h1>

        <a href="/hrm-system/public/index.php?controller=Employee&action=index"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="employee-card">

        <form method="POST"
            action="/hrm-system/public/index.php?controller=Employee&action=update"
            enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Mã nhân viên</label>
                    <input type="text"
                        name="employee_code"
                        class="form-control"
                        value="<?= $row['employee_code'] ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Họ và tên</label>
                    <input type="text"
                        name="full_name"
                        class="form-control"
                        value="<?= $row['full_name'] ?>"
                        required>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Giới tính</label>
                    <select name="gender"
                        class="form-control">
                        <option value="Male" <?= $row['gender'] == 'Male' ? 'selected' : '' ?>>Nam</option>
                        <option value="Female" <?= $row['gender'] == 'Female' ? 'selected' : '' ?>>Nữ</option>
                        <option value="Other" <?= $row['gender'] == 'Other' ? 'selected' : '' ?>>Khác</option>
                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Ngày sinh</label>
                    <input type="date"
                        name="date_of_birth"
                        class="form-control"
                        value="<?= $row['date_of_birth'] ?>">

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Email</label>
                    <input type="email"
                        name="email"
                        class="form-control"
                        value="<?= $row['email'] ?>"
                        required>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Số điện thoại</label>
                    <input type="text"
                        name="phone"
                        class="form-control"
                        value="<?= $row['phone'] ?>">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">Địa chỉ</label>
                <textarea name="address"
                    class="form-control"
                    rows="2"><?= $row['address'] ?></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">Ảnh đại diện</label>
                <?php if(!empty($row['avatar'])): ?>
                    <div class="mb-2">
                        <img src="<?= $row['avatar'] ?>" alt="Avatar" style="max-width: 100px; max-height: 100px;">
                    </div>
                <?php endif; ?>
                <input type="file"
                    name="avatar"
                    class="form-control"
                    accept="image/*">
                <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>

            </div>

            <div class="row mb-3">

                <div class="col-md-4">

                    <label class="form-label">Phòng ban</label>
                    <select name="department_id"
                        class="form-control">
                        <option value="">-- Chọn phòng ban --</option>
                        <?php if(isset($departments) && $departments->num_rows > 0): ?>
                            <?php while($dept = $departments->fetch_assoc()): ?>
                                <option value="<?= $dept['id'] ?>" <?= $row['department_id'] == $dept['id'] ? 'selected' : '' ?>><?= $dept['department_name'] ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>

                </div>

                <div class="col-md-4">

                    <label class="form-label">Chức vụ</label>
                    <input type="text"
                        name="position"
                        class="form-control"
                        value="<?= $row['position'] ?>"
                        required>

                </div>

                <div class="col-md-4">

                    <label class="form-label">Ngày vào làm</label>
                    <input type="date"
                        name="hire_date"
                        class="form-control"
                        value="<?= $row['hire_date'] ?>"
                        required>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Trạng thái</label>
                    <select name="status"
                        class="form-control">
                        <option value="Working" <?= $row['status'] == 'Working' ? 'selected' : '' ?>>Đang làm việc</option>
                        <option value="Probation" <?= $row['status'] == 'Probation' ? 'selected' : '' ?>>Thử việc</option>
                        <option value="Resigned" <?= $row['status'] == 'Resigned' ? 'selected' : '' ?>>Đã nghỉ việc</option>
                        <option value="Maternity Leave" <?= $row['status'] == 'Maternity Leave' ? 'selected' : '' ?>>Nghỉ thai sản</option>
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