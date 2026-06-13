<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn nghỉ phép của tôi</title>

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

        <a href="/hrm-system/public/index.php?controller=EmployeeDashboard&action=index">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>

        <a href="/hrm-system/public/index.php?controller=Attendance&action=quickCheckIn">
            <i class="fa-solid fa-clock"></i>
            Chấm công
        </a>

        <a href="/hrm-system/public/index.php?controller=Leave&action=myLeaves"
            class="active-menu">
            <i class="fa-solid fa-calendar-check"></i>
            Nghỉ phép của tôi
        </a>

        <a href="/hrm-system/public/index.php?controller=Payroll&action=myPayroll">
            <i class="fa-solid fa-money-bill"></i>
            Lương của tôi
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
            Đơn nghỉ phép của tôi

        </h1>

        <a href="<?= BASE_URL ?>index.php?controller=Leave&action=create"
           class="btn-add">

            <i class="fa-solid fa-plus"></i>
            Xin nghỉ phép

        </a>

    </div>

    <div class="employee-card">

        <div class="table-responsive-custom">
        <table class="table align-middle">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Loại</th>
                    <th>Từ ngày</th>
                    <th>Đến ngày</th>
                    <th>Lý do</th>
                    <th>Trạng thái</th>
                    <th>Người duyệt</th>
                    <th>Hành động</th>

                </tr>

            </thead>

            <tbody>

            <?php if(isset($leaves) && $leaves->num_rows > 0): ?>

                <?php while($row = $leaves->fetch_assoc()) : ?>

                    <tr>

                        <td><?= $row['id'] ?></td>

                        <td>
                            <span class="badge bg-info"><?= $row['leave_type'] ?></span>
                        </td>

                        <td><?= $row['start_date'] ?></td>

                        <td><?= $row['end_date'] ?></td>

                        <td><?= $row['reason'] ?></td>

                        <td>
                            <?php 
                                $statusClass = '';
                                $statusText = '';
                                switch($row['status']) {
                                    case 'Pending':
                                        $statusClass = 'bg-warning text-dark';
                                        $statusText = 'Chờ duyệt';
                                        break;
                                    case 'Approved':
                                        $statusClass = 'bg-success';
                                        $statusText = 'Đã duyệt';
                                        break;
                                    case 'Rejected':
                                        $statusClass = 'bg-danger';
                                        $statusText = 'Từ chối';
                                        break;
                                    default:
                                        $statusClass = 'bg-secondary';
                                        $statusText = $row['status'];
                                }
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>

                        <td><?= $row['approved_by_name'] ?? 'Chưa có' ?></td>

                        <td>

                            <?php if($row['status'] == 'Pending'): ?>
                            <a href="/hrm-system/public/index.php?controller=Leave&action=edit&id=<?= $row['id'] ?>"
                            class="action-btn btn-edit text-decoration-none">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="/hrm-system/public/index.php?controller=Leave&action=delete&id=<?= $row['id'] ?>"
                            class="action-btn btn-delete text-decoration-none"
                            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn này?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="8">

                        <div class="empty-box">

                            <i class="fa-solid fa-calendar-times"></i>

                            <h4>
                                Bạn chưa có đơn nghỉ phép nào
                            </h4>

                        </div>

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>
        </div>

    </div>

</div>

</body>
</html>