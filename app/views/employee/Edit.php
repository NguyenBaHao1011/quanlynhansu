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

        <a href="#">

            <i class="fa-solid fa-building"></i>
            Phòng ban

        </a>

        <a href="#">

            <i class="fa-solid fa-chart-line"></i>
            Báo cáo

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
            action="/hrm-system/public/index.php?controller=Employee&action=update">

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
                        name="fullname"
                        class="form-control"
                        value="<?= $row['fullname'] ?>"
                        required>

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

            <div class="row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Giới tính</label>
                    <select name="gender"
                        class="form-control">
                        <option value="Nam" <?= $row['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="Nữ" <?= $row['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                        <option value="Khác" <?= $row['gender'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">Ngày sinh</label>
                    <input type="date"
                        name="birthday"
                        class="form-control"
                        value="<?= $row['birthday'] ?>">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">Địa chỉ</label>
                <textarea name="address"
                    class="form-control"
                    rows="2"><?= $row['address'] ?></textarea>

            </div>

            <div class="row mb-3">

                <div class="col-md-4">

                    <label class="form-label">Phòng ban</label>
                    <input type="text"
                        name="department"
                        class="form-control"
                        value="<?= $row['department'] ?>"
                        required>

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

                    <label class="form-label">Lương</label>
                    <input type="number"
                        name="salary"
                        class="form-control"
                        value="<?= $row['salary'] ?>"
                        required>

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