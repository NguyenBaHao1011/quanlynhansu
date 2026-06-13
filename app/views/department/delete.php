<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa phòng ban</title>

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

        <a href="/hrm-system/public/index.php?controller=Department&action=index"
            class="active-menu">

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

            <i class="fa-solid fa-trash"></i>
            Xóa phòng ban

        </h1>

        <a href="/hrm-system/public/index.php?controller=Department&action=index"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="employee-card">

        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <strong>Cảnh báo:</strong> Bạn đang sắp xóa phòng ban <strong><?= $row['department_name'] ?></strong>. Hành động này không thể hoàn tác!
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Thông tin phòng ban</h5>
                <p><strong>Mã phòng:</strong> <?= $row['department_code'] ?></p>
                <p><strong>Tên phòng:</strong> <?= $row['department_name'] ?></p>
                <p><strong>Trưởng phòng:</strong> <?= $row['manager_name'] ?? 'Chưa có' ?></p>
                <p><strong>Số điện thoại:</strong> <?= $row['phone'] ?? 'Chưa có' ?></p>
                <p><strong>Email:</strong> <?= $row['email'] ?? 'Chưa có' ?></p>
            </div>
        </div>

        <form method="POST"
            action="/hrm-system/public/index.php?controller=Department&action=destroy">

            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <div class="d-flex justify-content-center gap-3 mt-4">

                <a href="/hrm-system/public/index.php?controller=Department&action=index"
                    class="btn btn-secondary px-4">
                    <i class="fa-solid fa-times"></i>
                    Hủy
                </a>

                <button type="submit"
                    class="btn btn-danger px-4"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa phòng ban này?');">
                    <i class="fa-solid fa-trash"></i>
                    Xác nhận xóa
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>