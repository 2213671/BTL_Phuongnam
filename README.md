# Nhà sách Phương Nam — Website bán sách trực tuyến

Website thương mại điện tử bán sách, xây dựng theo kiến trúc **MVC thuần PHP** (không Laravel/Symfony), phục vụ mục đích học tập và demo nghiệp vụ cửa hàng sách.

**Yêu cầu môi trường (tham khảo):** PHP 8.0+ (dự án đã chạy thử trên PHP 8.2), MySQL hoặc MariaDB, Apache có bật `mod_rewrite`, extension `pdo_mysql`.

---

## Tính năng chính

### Khách truy cập (chưa đăng nhập)

- Trang **landing**, **trang chủ**, **giới thiệu**, **bảng giá**, **hỏi đáp** (FAQ), **liên hệ**
- **Danh sách sản phẩm**: lọc theo danh mục, tìm kiếm
- **Chi tiết sản phẩm**, **đánh giá sản phẩm** (theo luồng site)
- **Tin tức**: danh sách, chi tiết, bình luận tin (theo cấu hình)
- **Đăng ký**, **đăng nhập**, **quên mật khẩu** (nếu đã cấu hình gửi mail trong môi trường của bạn)

### Khách hàng (`role`: customer)

- **Giỏ hàng** (thêm / cập nhật số lượng / xóa; đồng bộ giỏ cục bộ khi đăng nhập)
- **Đặt hàng** (AJAX): thông tin nhận hàng, phương thức thanh toán (ví dụ COD), phí vận chuyển
- **Tài khoản**: hồ sơ, đổi mật khẩu, avatar
- **Địa chỉ** giao hàng (CRUD qua AJAX)
- **Đơn hàng** của tôi: xem, chi tiết, hủy đơn (theo trạng thái)
- **Yêu thích** (wishlist), **thông báo**

### Quản trị — Admin (`role`: admin)

Shell giao diện quản trị dùng template **[SRTdash](https://github.com/puikinsh/srtdash-admin-dashboard)** (CSS/JS trong `public/srtdash-admin-dashboard/srtdash/`), bổ sung `public/css/admin-dashboard.css` và `admin-partials.css`.

- **Tổng quan** (dashboard)
- **Đơn hàng**: danh sách, chi tiết, cập nhật trạng thái, xác nhận thanh toán, AJAX xem nhanh đơn
- **Sản phẩm**, **danh mục**, **tin tức**, **bình luận tin**, **đánh giá sản phẩm**
- **Khách hàng**, **liên hệ**, **Hỏi đáp** (nội dung FAQ admin), **nội dung trang Giới thiệu** (khối nội dung)
- **Nhân viên** (tài khoản staff), **cài đặt site**

### Nhân viên (`role`: staff)

Được phép các thao tác giới hạn (ví dụ xem / xử lý **đơn hàng**); các mục chỉ admin (sản phẩm, tin, cài đặt, …) sẽ bị chuyển hướng về trang admin chính nếu truy cập trái quyền.

---

## Công nghệ & kiến trúc

| Lớp | Chi tiết |
|-----|----------|
| Backend | PHP thuần, routing qua `public/index.php` + tham số `url` |
| Cấu trúc | `app/core` (App, Controller, DB), `app/controllers`, `app/models`, `app/views` |
| CSDL | PDO, prepared statements; file khởi tạo: `db/phuongnam_db.sql` |
| Front (site) | HTML/CSS/JS tách file trong `public/css`, `public/js`; layout khách qua `app/views/components` |
| Front (admin) | SRTdash + Bootstrap trong theme; font Google (Lato, Poppins) trong layout admin |
| Ảnh & tĩnh | `public/media/` (xem `public/media/README.txt`); rewrite từ đường dẫn `images/...` cũ sang `media/...` trong `public/.htaccess` |

**URL gốc (`BASE_URL`):** được suy ra tự động trong `app/config/config.php` từ `SCRIPT_NAME` (và scheme `http`/`https`), nên thường **không cần** sửa tay khi đổi tên thư mục dự án — chỉ cần truy cập đúng entry `public/index.php` (hoặc DocumentRoot trỏ vào `public/`).

---

## Cài đặt nhanh

### 1. Sao chép mã nguồn

Đặt thư mục dự án vào `htdocs` (ví dụ `C:\xampp\htdocs\BTL_Phuongnam`).

### 2. Cơ sở dữ liệu

1. Tạo database UTF-8, ví dụ: `phuongnam_db`.
2. Import file **`db/phuongnam_db.sql`** (phpMyAdmin hoặc CLI).

### 3. Cấu hình `app/config/config.php`

Chỉnh nếu môi trường của bạn khác mặc định:

- `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, **`DB_PORT`** (ví dụ XAMPP đôi khi dùng cổng MySQL khác 3306)

Biến `ENVIRONMENT`: `development` bật hiển thị lỗi PHP; `production` tắt.

### 4. Giao diện admin (bắt buộc)

Theme SRTdash **không** nằm trong một số bản sao repo nhỏ. Cần có thư mục:

`public/srtdash-admin-dashboard/srtdash/`

Cách lấy (một lần), từ thư mục `public`:

```bash
git clone --depth 1 https://github.com/puikinsh/srtdash-admin-dashboard.git srtdash-admin-dashboard
```

Sau đó kiểm tra tồn tại file ví dụ: `public/srtdash-admin-dashboard/srtdash/assets/css/bootstrap.min.css`.

### 5. Apache

- Bật module **`mod_rewrite`**.
- DocumentRoot trỏ vào **`public/`** *hoặc* truy cập dạng `http://localhost/<tên_thư_mục>/public/...` tùy cách bạn cấu hình virtual host.

File **`public/.htaccess`** chuyển request không phải file thật sang `index.php?url=...`.

### 6. Chạy thử

Mở trình duyệt tới URL ứng với thư mục `public` (ví dụ `http://localhost/BTL_Phuongnam/public/home`).

- Route không hợp lệ được xử lý trong `app/core/App.php` (chuyển về **`landing`**).

---

## Tài khoản demo (sau khi import `db/phuongnam_db.sql`)

Các user mẫu trong dump dùng chung một mật khẩu demo (ghi trong ghi chú cột `note` của bản ghi admin): **`DemoBTLSieuTot123`**

| Vai trò | Email (đăng nhập) |
|---------|-------------------|
| Admin | `admin@phuongnam.com.vn` |
| Staff | `staff@phuongnam.com.vn` |
| Khách hàng | `khachhang.demo@phuongnam.com.vn` (và các email customer khác trong dump) |

Đổi mật khẩu hoặc xóa user demo trước khi đưa lên môi trường thật.

---

## Cấu trúc thư mục (rút gọn)

```
BTL_Phuongnam/
├── app/
│   ├── config/config.php      # DB, BASE_URL, helper URL/media
│   ├── controllers/         # *Controller.php
│   ├── core/                  # App.php, Controller.php, DB.php
│   ├── helpers/
│   ├── models/
│   ├── views/                 # Giao diện khách + admin + partials
│   └── router.php             # Nạp config + core
├── db/
│   ├── phuongnam_db.sql       # Schema + dữ liệu mẫu
│   └── backup/                # Bản sao lưu tùy chọn
├── public/                    # Điểm vào web
│   ├── index.php
│   ├── .htaccess
│   ├── css/, js/
│   ├── media/                 # ảnh sách, tin, upload…
│   └── srtdash-admin-dashboard/  # Clone theme admin (xem trên)
├── tools/                     # Script Python hỗ trợ (CSS admin, v.v.)
└── README.md
```

---

## Bảng tham chiếu URL (mẫu)

Base: `{BASE_URL}` — luôn có dạng `.../public/` khi chạy trong `htdocs` kiểu XAMPP mặc định.

| Mô tả | Đường dẫn `url` (sau `public/`) |
|--------|-----------------------------------|
| Landing | `landing` |
| Trang chủ | `home` |
| Giới thiệu | `home/about` |
| Bảng giá | `home/pricing` |
| Hỏi đáp (FAQ) | `home/qa` (có thể dùng tham số `?category=...` trong liên kết footer) |
| Sản phẩm | `product` |
| Chi tiết SP | `product/detail/{id}` |
| Tin tức | `news`, `news/detail/{id}` |
| Giỏ hàng | `cart` |
| Đăng nhập / đăng ký | `auth/login`, `auth/register` |
| Khách hàng | `customer`, `customer/orders`, … |
| Đơn hàng (checkout flow) | `order/...` (theo `OrderController`) |
| Admin | `admin`, `admin/orders`, `admin/products`, … |

Chi tiết method và tham số nằm trong từng file `app/controllers/*Controller.php`.

---

## Trạng thái đơn hàng (admin)

Trong code admin, chuỗi trạng thái tham chiếu gồm: `pending`, `processing`, `shipped`, `completed`, `cancelled` (xem `AdminController`).

---

## Bảo mật & lưu ý

- Truy vấn nên dùng prepared statements qua lớp DB.
- Mật khẩu lưu dạng bcrypt (`password_hash`).
- Output HTML dùng `htmlspecialchars` / helper `e()` khi cần.
- Form quan trọng có thể bổ sung CSRF token trong các phiên bản sau.
- Nội dung HTML (tin, trang tĩnh) có logic lọc ảnh/URL ngoài — xem `pn_sanitize_html_local_media_only` và các hàm liên quan trong `app/config/config.php`.

---

## Xử lý sự cố thường gặp

| Hiện tượng | Hướng xử lý |
|------------|-------------|
| Admin mất CSS, layout vỡ | Thiếu theme SRTdash — clone vào `public/srtdash-admin-dashboard` (mục 4). Ctrl+F5 trình duyệt. |
| 404 hoặc nhảy landing | Kiểm tra `mod_rewrite`, file `.htaccess`, và URL có đi qua `public/index.php` không. |
| Lỗi kết nối CSDL | Kiểm tra MySQL chạy, `DB_*` và **cổng** trong `config.php`. |
| Ảnh không hiện | Đường dẫn trong DB dùng dạng `media/...`; ảnh phải nằm dưới `public/media/`. |

---

## License & mục đích sử dụng

Dự án phục vụ **học tập / bài tập lớn**. Không dùng làm sản phẩm thương mại nếu chưa được rà soát bảo mật, pháp lý và dữ liệu thật.

Nếu bạn công khai mã nguồn trên Git, hãy thay phần “liên hệ / nhóm thực hiện” bên dưới bằng thông tin thật của nhóm bạn.

---

## Liên hệ / tác giả

*(Cập nhật: tên nhóm, MSSV, email giảng viên hướng dẫn — theo báo cáo của bạn.)*
