# Nhà sách Phương Nam — Website bán sách trực tuyến

Website bán sách, PHP thuần theo MVC tự viết (không Laravel/Symfony). Dùng cho bài tập lớn / demo luồng cửa hàng sách.

**Môi trường:** PHP 8.0 trở lên (dump SQL trong repo ghi PHP 8.2), MySQL hoặc MariaDB, Apache bật `mod_rewrite`, extension `pdo_mysql`.

---

## Tính năng

### Khách (chưa đăng nhập)

- Landing, trang chủ, giới thiệu (`home/about` hoặc `about`), bảng giá, FAQ, liên hệ
- Danh sách sách: lọc danh mục, ô tìm kiếm
- Chi tiết sách, đánh giá trên trang chi tiết
- Tin tức: danh sách, chi tiết, bình luận bài tin
- Đăng ký, đăng nhập, quên mật khẩu (gửi mail phụ thuộc cấu hình SMTP trong môi trường)

### Khách hàng — `customer`

- Giỏ: thêm, đổi số lượng, xóa; khi đăng nhập đồng bộ với giỏ lưu cục bộ trên trình duyệt
- Đặt hàng qua AJAX: người nhận, địa chỉ, phương thức thanh toán (COD và các lựa chọn form gửi lên), phí ship
- Hồ sơ, đổi mật khẩu, avatar
- Địa chỉ giao hàng qua AJAX
- Đơn hàng: danh sách, chi tiết, hủy khi trạng thái cho phép
- Wishlist, thông báo

### Admin — `admin`

Giao diện admin dựa trên [SRTdash](https://github.com/puikinsh/srtdash-admin-dashboard): asset trong `public/srtdash-admin-dashboard/srtdash/`, thêm `public/css/admin-dashboard.css` và `admin-partials.css`.

- Dashboard
- Đơn hàng: danh sách, chi tiết, đổi trạng thái, xác nhận thanh toán, popup AJAX xem đơn
- Sản phẩm, danh mục, tin tức, bình luận tin, đánh giá sản phẩm
- Khách hàng, form liên hệ, CRUD nội dung FAQ trong admin, khối nội dung trang Giới thiệu
- Tài khoản nhân viên, cài đặt site

### Nhân viên — `staff`

Được các thao tác đơn hàng như trong `AdminController` (`ADMIN_STAFF_METHODS`). Vào URL chỉ dành cho admin thì bị redirect về `admin`.

---

## Công nghệ và luồng request

| Phần | Nội dung |
|------|----------|
| Backend | PHP, vào từ `public/index.php`, tham số `url` do `.htaccess` gắn |
| Code | `app/core`: `App`, `Controller`, `DB`; `app/controllers`, `app/models`, `app/views` |
| CSDL | PDO, prepared statements; dump: `db/phuongnam_db.sql` |
| Giao diện site | CSS/JS trong `public/css`, `public/js`; khung trang `app/views/components` |
| Giao diện admin | SRTdash + Bootstrap trong theme; font Lato/Poppins khai báo trong `views/admin/admin.php` |
| Ảnh | `public/media/`; quy ước file trong `public/media/README.txt`. `.htaccess` rewrite `images/...` cũ → `media/...` |

`BASE_URL` trong `app/config/config.php` suy ra từ `SCRIPT_NAME` và `HTTPS` / `X-Forwarded-Proto`. Đổi tên thư mục dự án thường không cần sửa tay URL nếu vẫn vào đúng `public/index.php` hoặc vhost trỏ thẳng vào `public/`.

---

## Cài đặt

### 1. Source

Đặt project dưới `htdocs`, ví dụ `C:\xampp\htdocs\BTL_Phuongnam`.

### 2. Database

Tạo database UTF-8 tên `phuongnam_db` (hoặc tên khác rồi sửa `DB_NAME`). Import `db/phuongnam_db.sql` bằng phpMyAdmin hoặc CLI.

### 3. Config

File `app/config/config.php`: chỉnh `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `DB_PORT` cho khớp MySQL.

`ENVIRONMENT`: `development` bật `display_errors`; `production` tắt.

### 4. Theme admin SRTdash

Thư mục `public/srtdash-admin-dashboard/srtdash/` không luôn đi kèm bản zip nhỏ. Trong `public` chạy:

```bash
git clone --depth 1 https://github.com/puikinsh/srtdash-admin-dashboard.git srtdash-admin-dashboard
```

Kiểm tra có file `public/srtdash-admin-dashboard/srtdash/assets/css/bootstrap.min.css`.

### 5. Apache

Bật `mod_rewrite`. DocumentRoot trỏ `public/` hoặc URL dạng `http://localhost/<thư_mục>/public/...`.

`public/.htaccess`: request không khớp file thật → `index.php?url=...`.

### 6. Chạy

Ví dụ mở `http://localhost/BTL_Phuongnam/public/home`. Controller hoặc method không tồn tại thì `App.php` redirect sang `landing`.

---

## Tài khoản demo

Sau khi import `db/phuongnam_db.sql`, các user mẫu dùng chung mật khẩu **`DemoBTLSieuTot123`** (trùng hash trong file; cột `note` của admin trong SQL cũng ghi mật khẩu demo).

| Vai trò | Email đăng nhập |
|---------|-----------------|
| Admin | admin@phuongnam.com.vn |
| Staff | staff@phuongnam.com.vn |
| Khách | khachhang.demo@phuongnam.com.vn và các customer khác trong dump |

---

## Cấu trúc thư mục

```
BTL_Phuongnam/
├── app/
│   ├── config/config.php       # DB, BASE_URL, helper media/HTML
│   ├── controllers/            # *Controller.php
│   ├── core/                   # App.php, Controller.php, DB.php
│   ├── helpers/
│   ├── models/
│   ├── views/                  # Khách, admin, partials
│   └── router.php              # Nạp config + core
├── db/
│   ├── phuongnam_db.sql
│   └── backup/
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── css/, js/
│   ├── media/
│   └── srtdash-admin-dashboard/
├── tools/                      # Script Python (CSS admin, …)
└── README.md
```

**Controllers hiện có:** `About`, `Address`, `Admin`, `Auth`, `Cart`, `Contact`, `Customer`, `Home`, `Landing`, `News`, `Order`, `Product`, `Qa`.

---

## URL chính

Phần đường dẫn sau `public/` trong URL thân thiện (sau rewrite). Với XAMPP mặc định, base thường là `http://localhost/<project>/public/`.

| Trang | `url` |
|-------|-------|
| Landing | landing |
| Trang chủ | home |
| Giới thiệu | home/about hoặc about |
| Bảng giá | home/pricing |
| FAQ | home/qa |
| Liên hệ | contact |
| Sản phẩm | product |
| Chi tiết sách | product/detail/{id} |
| Tin | news |
| Chi tiết tin | news/detail/{id} |
| Giỏ | cart |
| Đăng nhập / đăng ký / quên MK | auth/login, auth/register, auth/forgot |
| Khách | customer, customer/orders, customer/wishlist, … |
| Đơn | order, order/detail/{id} — submit/hủy qua POST/AJAX theo `OrderController` |
| Admin | admin, admin/orders, admin/products, … |

`home/qa` có thể kèm `?category=` như các link footer.

---

## Trạng thái đơn (admin)

Chuỗi dùng trong code: `pending`, `processing`, `shipped`, `completed`, `cancelled` — hằng `ORDER_STATUSES` trong `AdminController`.

---

## Bảo mật đang có

- PDO prepared statements qua `DB`
- Mật khẩu: `password_hash` / `password_verify`
- Escape HTML: `htmlspecialchars`, helper `e()` trong config
- Phân quyền session: admin / staff / customer theo constructor các controller liên quan
- HTML tin và trang tĩnh: lọc ảnh/URL ngoài — `pn_sanitize_html_local_media_only` và hàm liên quan trong `app/config/config.php`

---

## Sự cố thường gặp

| Hiện tượng | Cách xử |
|------------|---------|
| Admin không có CSS, layout vỡ | Clone SRTdash vào `public/srtdash-admin-dashboard`, F5 cứng trình duyệt |
| 404 hoặc toàn redirect landing | `mod_rewrite`, nội dung `.htaccess`, URL có đi qua `public` đúng không |
| Lỗi kết nối DB | MySQL có chạy không, sai `DB_*` hoặc port, chưa import SQL |
| Ảnh 404 | DB lưu `media/...`; file thật nằm dưới `public/media/` |

---

## License

Mã nguồn phục vụ học tập.
