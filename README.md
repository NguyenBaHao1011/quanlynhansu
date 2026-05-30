# HRM System - Human Resource Management

Hệ thống quản lý nhân sự (HRM) được xây dựng bằng PHP thuần theo mô hình MVC.

## Yêu cầu hệ thống

- PHP 7.4 trở lên
- MySQL 5.7 trở lên hoặc MariaDB
- Apache với mod_rewrite được bật
- XAMPP, WAMP, hoặc LAMP stack

## Cài đặt

### 1. Sao chép project

```bash
cd c:\xampp\htdocs
# Clone hoặc copy project vào thư mục hrm-system
```

### 2. Cấu hình database

1. Mở phpMyAdmin (thường tại `http://localhost/phpmyadmin`)
2. Tạo database mới tên là `hrm_system`
3. Chạy các file migration theo thứ tự:

```sql
-- Chạy file 001_create_users_table.sql
-- Chạy file 002_create_employees_table.sql
```

Hoặc import trực tiếp từ dòng lệnh:

```bash
mysql -u root -p hrm_system < database/migrations/001_create_users_table.sql
mysql -u root -p hrm_system < database/migrations/002_create_employees_table.sql
```

### 3. Cấu hình ứng dụng

File cấu hình đã được tạo tại `app/config/config.php`. Bạn có thể chỉnh sửa nếu cần:

- `BASE_URL`: URL cơ bản của ứng dụng
- `DB_HOST`: Host database (thường là localhost)
- `DB_NAME`: Tên database (hrm_system)
- `DB_USER`: Username database (thường là root)
- `DB_PASS`: Password database (thường để trống)

### 4. Truy cập ứng dụng

Mở trình duyệt và truy cập:

```
http://localhost/hrm-system/public/
```

## Tài khoản mặc định

Sau khi cài đặt, bạn có thể đăng nhập bằng tài khoản admin mặc định:

- **Email**: admin@hrm.com
- **Mật khẩu**: admin123

**Lưu ý**: Hãy đổi mật khẩu ngay sau khi đăng nhập lần đầu!

## Cấu trúc thư mục

```
hrm-system/
├── app/
│   ├── config/
│   │   ├── config.php          # Cấu hình ứng dụng
│   │   └── database.php        # Lớp kết nối database
│   ├── controllers/            # Các controller
│   ├── helpers/                # Các helper functions
│   ├── models/                 # Các model
│   └── views/                  # Các view
│       ├── admin/              # Giao diện admin
│       ├── auth/               # Giao diện authentication
│       ├── employee/           # Giao diện employee
│       └── layouts/            # Layout chung
├── database/
│   └── migrations/             # Database migrations
├── public/
│   ├── index.php               # Entry point
│   └── assets/                 # CSS, JS, images
├── storage/
│   ├── logs/                   # Log files
│   └── uploads/                # Uploaded files
└── .htaccess                   # Apache rewrite rules
```

## Các tính năng chính

### Authentication
- Đăng ký tài khoản
- Đăng nhập/Đăng xuất
- Phân quyền Admin/Employee

### Quản lý nhân viên (Admin)
- Xem danh sách nhân viên
- Thêm nhân viên mới
- Sửa thông tin nhân viên
- Xóa nhân viên
- Tìm kiếm nhân viên
- Phân trang

### Dashboard
- Admin Dashboard: Thống kê và quản lý
- Employee Dashboard: Thông tin cá nhân

## Bảo mật

### Các lỗi đã được sửa

1. **SQL Injection**: Sử dụng prepared statements cho tất cả queries
2. **XSS Protection**: Sanitize input và sử dụng htmlspecialchars
3. **Session Security**: Cấu hình session an toàn
4. **Input Validation**: Kiểm tra và validate input
5. **Error Handling**: Xử lý lỗi 404 cho controller/action không tồn tại

### Best Practices được áp dụng

- Sử dụng password_hash() cho mật khẩu
- Prepared statements cho database queries
- CSRF protection (cần thêm token trong forms)
- Session hijacking prevention

## Phát triển

### Thêm controller mới

1. Tạo file trong `app/controllers/TenController.php`
2. Tạo class `TenController` với các method action
3. Truy cập qua URL: `?controller=Ten&action=tenAction`

### Thêm model mới

1. Tạo file trong `app/models/TenModel.php`
2. Tạo class với các method truy vấn database
3. Sử dụng trong controller: `$model = new TenModel();`

### Thêm view mới

1. Tạo file trong `app/views/ten/view.php`
2. Include trong controller: `require_once "../app/views/ten/view.php";`

## Khắc phục sự cố

### Lỗi "Controller not found"

- Kiểm tra tên controller trong URL (viết hoa chữ cái đầu)
- Đảm bảo file controller tồn tại trong `app/controllers/`

### Lỗi kết nối database

- Kiểm tra thông tin trong `app/config/config.php`
- Đảm bảo database `hrm_system` đã được tạo
- Kiểm tra username/password trong `app/config/database.php`

### Lỗi "Base URL not defined"

- Đảm bảo file `app/config/config.php` tồn tại
- Kiểm tra hằng số `BASE_URL` được định nghĩa đúng

### Permission issues

- Đảm bảo thư mục `storage/logs/` và `storage/uploads/` có permission ghi

## License

MIT License

## Support

Nếu gặp vấn đề, vui lòng tạo issue hoặc liên hệ đội ngũ phát triển.