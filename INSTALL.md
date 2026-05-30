# Hướng dẫn cài đặt HRM System

## Bước 1: Chuẩn bị môi trường

1. Cài đặt XAMPP (hoặc WAMP/LAMP)
2. Khởi động Apache và MySQL từ XAMPP Control Panel

## Bước 2: Cài đặt database

### Cách 1: Sử dụng phpMyAdmin (Khuyến nghị)

1. Mở trình duyệt, truy cập: `http://localhost/phpmyadmin`
2. Đăng nhập (thường không cần password)
3. Tạo database mới:
   - Click vào "New" ở sidebar bên trái
   - Nhập tên database: `hrm_system`
   - Chọn Collation: `utf8mb4_unicode_ci`
   - Click "Create"

4. Import database:
   - Chọn database `hrm_system` vừa tạo
   - Click vào tab "Import" ở menu trên
   - Click "Choose File" và chọn file `database/setup.sql`
   - Click "Go" để import

### Cách 2: Sử dụng command line

```bash
# Mở Command Prompt/Terminal
cd c:\xampp\mysql\bin

# Đăng nhập vào MySQL
mysql -u root -p
# (Nhấn Enter nếu không có password)

# Tạo database
CREATE DATABASE hrm_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hrm_system;

# Import file setup
SOURCE c:/xampp/htdocs/hrm-system/database/setup.sql;

# Thoát
exit;
```

## Bước 3: Cấu hình ứng dụng

File cấu hình `app/config/config.php` đã được tạo sẵn với cấu hình mặc định:

```php
define('BASE_URL', '/hrm-system/public/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'hrm_system');
define('DB_USER', 'root');
define('DB_PASS', '');
```

Nếu bạn thay đổi cấu hình XAMPP (ví dụ: có password cho MySQL), hãy chỉnh sửa file này.

## Bước 4: Truy cập ứng dụng

1. Mở trình duyệt
2. Truy cập: `http://localhost/hrm-system/public/`
3. Bạn sẽ thấy trang đăng nhập

## Bước 5: Đăng nhập

Sử dụng tài khoản admin mặc định:

- **Email**: `admin@hrm.com`
- **Mật khẩu**: `admin123`

## Kiểm tra cài đặt

Sau khi đăng nhập thành công, bạn sẽ thấy:

1. **Admin Dashboard** với:
   - Sidebar menu bên trái
   - Danh sách nhân viên (có 3 nhân viên mẫu)
   - Các chức năng: Thêm, Sửa, Xóa nhân viên

2. **Các tính năng có sẵn**:
   - ✅ Đăng nhập/Đăng xuất
   - ✅ Quản lý nhân viên
   - ✅ Tìm kiếm nhân viên
   - ✅ Phân trang

## Khắc phục sự cố

### Lỗi "Connection failed"

**Nguyên nhân**: Không kết nối được database

**Giải pháp**:
1. Kiểm tra MySQL đã chạy chưa (XAMPP Control Panel)
2. Kiểm tra thông tin trong `app/config/config.php`
3. Đảm bảo database `hrm_system` đã được tạo

### Lỗi "Controller not found"

**Nguyên nhân**: URL không đúng hoặc thiếu file controller

**Giải pháp**:
1. Kiểm tra URL: `http://localhost/hrm-system/public/`
2. Đảm bảo thư mục `hrm-system` nằm trong `c:\xampp\htdocs`

### Lỗi "Base URL not defined"

**Nguyên nhân**: Thiếu file cấu hình

**Giải pháp**:
1. Kiểm tra file `app/config/config.php` có tồn tại
2. Đảm bảo hằng số `BASE_URL` được định nghĩa

### Trang trắng/500 Error

**Nguyên nhân**: Lỗi PHP

**Giải pháp**:
1. Kiểm tra `storage/logs/` để xem lỗi
2. Bật error display trong `public/index.php`:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

### Không thấy nhân viên mẫu

**Nguyên nhân**: File setup.sql chưa được import

**Giải pháp**:
1. Import lại file `database/setup.sql`
2. Hoặc chạy lại lệnh SQL trong file đó

## Bảo mật sau cài đặt

1. **Đổi mật khẩu admin ngay lập tức**:
   - Đăng nhập bằng tài khoản admin
   - Vào phần Profile hoặc User Management
   - Đổi mật khẩu mới

2. **Xóa file không cần thiết**:
   - Xóa file `test.php` (nếu không dùng)
   - Xóa file `INSTALL.md` sau khi đọc

3. **Sao lưu database**:
   - Export database từ phpMyAdmin
   - Lưu file .sql ở nơi an toàn

## Hỗ trợ

Nếu gặp vấn đề không thể tự giải quyết:

1. Kiểm tra log files trong `storage/logs/`
2. Kiểm tra Apache error log: `c:\xampp\apache\logs\error.log`
3. Kiểm tra MySQL log: `c:\xampp\mysql\data\*.err`

## Cập nhật

Khi có phiên bản mới:

1. Sao lưu database hiện tại
2. Sao lưu code hiện tại
3. Cập nhật file mới
4. Chạy migration (nếu có)
5. Kiểm tra lại cấu hình

---

**Chúc bạn cài đặt thành công!** 🎉