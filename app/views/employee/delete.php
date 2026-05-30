<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa nhân viên</title>

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

            <i class="fa-solid fa-trash"></i>
            Xóa nhân viên

        </h1>

        <a href="/hrm-system/public/index.php?controller=Employee&action=index"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="employee-card">

        <div class="text-center mb-4">

            <i class="fa-solid fa-exclamation-triangle"
               style="font-size: 64px; color: #dc3545;"></i>

            <h4 class="mt-3 text-danger">
                Bạn có chắc chắn muốn xóa nhân viên này?
            </h4>

            <p class="text-muted">
                Hành động này không thể hoàn tác.
            </p>

        </div>

        <table class="table table-bordered">

            <tr>
                <th style="width: 200px;">Mã nhân viên</th>
                <td><?= $row['employee_code'] ?></td>
            </tr>

            <tr>
                <th>Họ và tên</th>
                <td><?= $row['fullname'] ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= $row['email'] ?></td>
            </tr>

            <tr>
                <th>Số điện thoại</th>
                <td><?= $row['phone'] ?></td>
            </tr>

            <tr>
                <th>Phòng ban</th>
                <td><?= $row['department'] ?></td>
            </tr>

            <tr>
                <th>Chức vụ</th>
                <td><?= $row['position'] ?></td>
            </tr>

            <tr>
                <th>Lương</th>
                <td><?= number_format($row['salary']) ?> VNĐ</td>
            </tr>

        </table>

        <div class="d-flex justify-content-center gap-3 mt-4">

            <a href="/hrm-system/public/index.php?controller=Employee&action=index"
               class="btn btn-secondary px-4">

                <i class="fa-solid fa-times"></i>
                Hủy

            </a>

            <a href="/hrm-system/public/index.php?controller=Employee&action=destroy&id=<?= $row['id'] ?>"
               class="btn btn-danger px-4"
               onclick="return confirm('Xác nhận xóa nhân viên <?= $row['fullname'] ?>?')">

                <i class="fa-solid fa-trash"></i>
                Xóa nhân viên

            </a>

        </div>

    </div>

</div>

</body>
</html>