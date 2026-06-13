<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phòng ban</title>

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

            <i class="fa-solid fa-building"></i>
            Danh sách phòng ban

        </h1>

        <a href="<?= BASE_URL ?>index.php?controller=Department&action=create"
           class="btn-add">

            <i class="fa-solid fa-plus"></i>
            Thêm phòng ban

        </a>

    </div>

    <div class="employee-card">
        <form method="GET"
            action="/hrm-system/public/index.php"
            class="mb-4 d-flex">

            <input type="hidden"
                name="controller"
                value="Department">

            <input type="hidden"
                name="action"
                value="search">

            <input type="text"
                name="keyword"
                class="form-control me-2"
                placeholder="Tìm phòng ban...">

            <button class="btn btn-primary">

                <i class="fa-solid fa-magnifying-glass"></i>

            </button>

        </form>

        <div class="table-responsive-custom">
        <table class="table align-middle">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Mã phòng</th>
                    <th>Tên phòng ban</th>
                    <th>Trưởng phòng</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Hành động</th>

                </tr>

            </thead>

            <tbody>

            <?php if(isset($departments) && $departments->num_rows > 0): ?>

                <?php while($row = $departments->fetch_assoc()) : ?>

                    <tr>

                        <td><?= $row['id'] ?></td>

                        <td><?= $row['department_code'] ?? 'Chưa có' ?></td>

                        <td>
                            <strong><?= $row['department_name'] ?></strong>
                        </td>

                        <td><?= $row['manager_name'] ?? 'Chưa có' ?></td>

                        <td><?= $row['phone'] ?? 'Chưa có' ?></td>

                        <td><?= $row['email'] ?? 'Chưa có' ?></td>

                        <td>

                            <a href="/hrm-system/public/index.php?controller=Department&action=edit&id=<?= $row['id'] ?>"
                            class="action-btn btn-edit text-decoration-none">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <?php if($_SESSION['user']['role'] == 'admin'): ?>

                            <a href="/hrm-system/public/index.php?controller=Department&action=delete&id=<?= $row['id'] ?>"
                            class="action-btn btn-delete text-decoration-none">

                                <i class="fa-solid fa-trash"></i>

                            </a>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="7">

                        <div class="empty-box">

                            <i class="fa-solid fa-building"></i>

                            <h4>
                                Chưa có phòng ban nào
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

                <a href="?controller=Department&action=index&page=<?= $i ?>"
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