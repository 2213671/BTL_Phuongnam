# Nhà sách Phương Nam

Web bán sách PHP thuần, MVC tự viết. Chạy được trên XAMPP với PHP 8.x và MariaDB/MySQL.

## Chạy project

1. Copy source vào `htdocs` (tên thư mục tùy bạn).
2. Tạo database `phuongnam_db` (utf8mb4), import `db/phuongnam_db.sql`.
3. Sửa `app/config/config.php`: `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `DB_PORT` cho khớp máy bạn.
4. Bật Apache, bật `mod_rewrite`. Mở site qua `public`, URL kiểu `http://localhost/<tên_thư_mục>/public/home`.

`BASE_URL` trong config tự lấy theo `SCRIPT_NAME`, không phải gõ tay theo tên thư mục.

## Admin — theme SRTdash

Giao diện admin load CSS/JS từ `public/srtdash-admin-dashboard/srtdash/`. Nếu chưa có thì clone vào `public`:

```
git clone --depth 1 https://github.com/puikinsh/srtdash-admin-dashboard.git srtdash-admin-dashboard
```

Thêm file override: `public/css/admin-dashboard.css`, `admin-partials.css`.

## Đăng nhập demo

Mật khẩu chung trong file SQL: `DemoBTLSieuTot123`

- Admin: `admin@phuongnam.com.vn`
- Staff: `staff@phuongnam.com.vn`
- Khách: `khachhang.demo@phuongnam.com.vn`

## Theo tài khoản

**Khách:** landing, trang chủ, giới thiệu, bảng giá, FAQ, liên hệ; danh sách và chi tiết sách; tin tức; đăng ký / đăng nhập / quên mật khẩu.

**Customer:** giỏ hàng, đặt hàng, địa chỉ, đơn hàng, wishlist, thông báo, sửa hồ sơ.

**Staff:** chủ yếu đơn hàng (xem, đổi trạng thái). Vào menu chỉ admin sẽ bị đá về dashboard admin.

**Admin:** dashboard, đơn hàng, sản phẩm, danh mục, tin, bình luận tin, đánh giá SP, khách, liên hệ, FAQ trong admin, khối trang Giới thiệu, nhân viên, cài đặt site.

Trạng thái đơn trong admin: `pending`, `processing`, `shipped`, `completed`, `cancelled`.

## Cấu trúc

- `app/config` — cấu hình
- `app/core` — `App`, `Controller`, `DB`
- `app/controllers`, `app/models`, `app/views`
- `public/index.php` — điểm vào; `public/.htaccess` rewrite sang `?url=...`
- `public/media` — ảnh (quy ước trong `public/media/README.txt`). Đường dẫn cũ `/images/...` được rewrite sang `/media/...`
- `db/phuongnam_db.sql` — schema + dữ liệu kèm file
- `tools/` — script Python phụ

## URL

Phần sau `public/`: `landing`, `home`, `home/about`, `home/pricing`, `home/qa`, `product`, `product/detail/{id}`, `news`, `news/detail/{id}`, `cart`, `auth/login`, `customer`, `admin`, `admin/orders`, …

Sai controller hoặc sai method thì `App.php` chuyển về `landing`.

## Lỗi hay gặp

- Admin trắng / không có style: chưa clone SRTdash vào `public/srtdash-admin-dashboard`.
- 404 toàn trang: `mod_rewrite` hoặc `.htaccess`.
- Không nối được DB: sai port/user/pass hoặc chưa import SQL.
- Không thấy ảnh: trong DB là đường dẫn kiểu `media/...`, file nằm dưới `public/media`.

## License

Code dùng cho mục đích học tập.
