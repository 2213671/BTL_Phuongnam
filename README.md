# Nhà sách Phương Nam — Website bán sách trực tuyến

Web bán sách PHP thuần, kiến trúc MVC tự code: router đọc tham số `url`, controller xử lý, model gọi MySQL qua PDO, view render HTML. Không dùng Laravel hay Symfony. Phù hợp bài tập lớn môn Lập trình Web và demo đầy đủ luồng khách — đặt hàng — quản trị.

---

## Yêu cầu chạy được

| Thành phần | Ghi chú |
|------------|---------|
| PHP | 8.0 trở lên. File dump SQL trong repo ghi môi trường export là PHP 8.2. |
| MySQL / MariaDB | Charset `utf8mb4`. |
| Apache | Bật `mod_rewrite`. |
| Extension PHP | `pdo_mysql`, `json`, `mbstring`, `session`. Nội dung HTML tin/trang có dùng `dom` (`DOMDocument`) khi sanitize. |

---

## Tính năng theo đối tượng

### Khách chưa đăng nhập

- **Landing** (`landing`), **trang chủ** (`home`), **giới thiệu** (`home/about` hoặc `about`), **bảng giá** (`home/pricing`), **FAQ** (`home/qa` hoặc `qa` với `QaController`), **liên hệ** (`contact`).
- **Sản phẩm**: danh sách có lọc danh mục và tìm kiếm; **chi tiết** có thông tin sách, ảnh, đánh giá; thêm đánh giá qua `product/addReview/{id}` (POST).
- **Tin tức**: danh sách, chi tiết, gửi bình luận (`news/addComment`).
- **Tài khoản**: đăng ký, đăng nhập, đăng xuất; **quên mật khẩu** (`auth/forgot`) gửi OTP qua email — cần SMTP cấu hình hoặc `mail()` hoạt động; code hỗ trợ PHPMailer nếu đã cài class qua Composer trong môi trường.

### Khách hàng (`role` = `customer` trong bảng `users`)

- **Giỏ hàng** (`cart`): thêm, đổi số lượng, xóa; có API JSON; đồng bộ giỏ lưu trên trình duyệt khi đăng nhập (`cart/syncFromLocal`).
- **Đặt hàng** (`OrderController::submitOrder`): AJAX, thu thập người nhận, SĐT, địa chỉ, phương thức thanh toán, phí ship, danh sách sản phẩm.
- **Tài khoản** (`customer`): xem/sửa hồ sơ, upload avatar, đổi mật khẩu.
- **Địa chỉ** (`address/*`): lấy danh sách, thêm, sửa, xóa, đặt mặc định — chủ yếu JSON/AJAX.
- **Đơn hàng** (`order`): danh sách, chi tiết, hủy đơn khi luồng cho phép.
- **Wishlist**, **thông báo** (đánh dấu đã đọc / đọc hết).

### Admin (`role` = `admin`)

Giao diện shell trong `app/views/admin/admin.php`, nền **[SRTdash](https://github.com/puikinsh/srtdash-admin-dashboard)** + file `public/css/admin-dashboard.css`, `admin-partials.css`.

- Dashboard, **đơn hàng** (danh sách, chi tiết, đổi trạng thái, xác nhận thanh toán, xóa đơn, AJAX xem nhanh).
- **Sản phẩm** (CRUD), **danh mục** (thêm/sửa/xóa), **tin tức** (CRUD), **bình luận tin**, **đánh giá sản phẩm**.
- **Khách hàng** (danh sách, chi tiết, xóa tài khoản theo luồng đã code).
- **Liên hệ** từ form site, **FAQ** quản trị (`admin/qa`, tạo, xóa).
- **Nội dung trang Giới thiệu** (`admin/pageContent` với query `page=about`).
- **Nhân viên** (`staff`, `createStaff`, `editStaff/{id}`, `deleteStaff`).
- **Cài đặt** site (`settings`).

### Staff (`role` = `staff`)

Trong `AdminController`, nhóm method `ADMIN_STAFF_METHODS` cho phép dashboard/đơn hàng và các API liên quan đơn. URL thuộc nhóm chỉ admin thì bị chặn và redirect về `admin`.

---

## Công nghệ sử dụng

- **Ngôn ngữ:** PHP.
- **CSDL:** MySQL/MariaDB, truy vấn qua lớp `DB` (`query`, `single`, `all`).
- **Front site:** HTML, CSS tách theo trang trong `public/css`, JS trong `public/js` (giỏ, checkout, v.v.).
- **Front admin:** Bootstrap + asset SRTdash; font Google (Lato, Poppins) trong `admin.php`.
- **Phiên:** `session_start()` tại `public/index.php`; biến session đăng nhập gồm `users_id`, `users_username`, `users_role`, `users_email`, `users_avatar`, …

---

## Luồng request MVC

1. Trình duyệt gọi URL dưới `public/`.
2. `public/.htaccess` chuyển request không phải file tĩnh sang `index.php?url=...`.
3. `public/index.php` → `app/router.php` nạp `config.php`, `App`, `Controller`, `DB`.
4. `App` tách `url` thành `[controller, method, ...params]`: file controller `app/controllers/{Controller}Controller.php`, method camelCase khớp segment thứ hai (PHP gọi method không phân biệt hoa thường).
5. Controller gọi model, gán dữ liệu, `view('đường/dẫn/view', $data)` hoặc `redirect()`.

Controller hoặc method không tồn tại: `App` redirect tới `landing`.

---

## Cài đặt

### 1. Đặt source

Clone hoặc copy cả thư mục project vào `htdocs` (ví dụ `C:\xampp\htdocs\BTL_Phuongnam`).

### 2. Database

- Tạo database UTF-8, mặc định tên **`phuongnam_db`** (hoặc tên khác).
- Import **`db/phuongnam_db.sql`**. Thư mục `db/backup/` chứa bản dump phụ nếu có.

### 3. Kết nối MySQL trong code

Các model kế thừa **`app/core/DB.php`**. Class này chứa **host, user, password, tên database, port** dùng khi tạo PDO. Cần sửa cho khớp máy bạn.

File **`app/config/config.php`** có các `define('DB_*', ...)` và `ENVIRONMENT` dùng cho cấu hình chung, helper, báo lỗi (`development` bật hiển thị lỗi). **Kết nối thực tế mà model dùng vẫn là constructor trong `DB.php`** — hai chỗ nên giữ cùng một bộ thông tin để tránh nhầm.

### 4. BASE_URL và múi giờ

`BASE_URL` được suy ra trong `config.php` từ `SCRIPT_NAME` và scheme (`HTTPS` / `X-Forwarded-Proto`). Múi giờ mặc định `Asia/Ho_Chi_Minh`.

### 5. Theme admin SRTdash

CSS/JS admin nằm tại `public/srtdash-admin-dashboard/srtdash/`. Clone một lần trong thư mục `public`:

```bash
git clone --depth 1 https://github.com/puikinsh/srtdash-admin-dashboard.git srtdash-admin-dashboard
```

Kiểm tra có `public/srtdash-admin-dashboard/srtdash/assets/css/bootstrap.min.css`.

### 6. Apache

Bật `mod_rewrite`. Cách phổ biến: DocumentRoot trỏ vào `public/`, hoặc URL `http://localhost/<tên_thư_mục>/public/...`.

### 7. Chạy thử

Mở ví dụ `http://localhost/BTL_Phuongnam/public/home`. Robots: `public/robots.txt`.

---

## Tài khoản sau khi import SQL

Mật khẩu demo chung (hash giống nhau trong file, ghi trong `note` của user admin): **`DemoBTLSieuTot123`**

| Vai trò | Email |
|---------|--------|
| Admin | admin@phuongnam.com.vn |
| Staff | staff@phuongnam.com.vn |
| Khách demo | khachhang.demo@phuongnam.com.vn |

Trong dump còn nhiều tài khoản `customer` khác dùng cùng hash mật khẩu demo.

---

## Cấu trúc thư mục

```
BTL_Phuongnam/
├── app/
│   ├── config/config.php       # define, BASE_URL, helper, ENVIRONMENT
│   ├── controllers/            # *Controller.php — toàn bộ route xử lý
│   ├── core/
│   │   ├── App.php             # Router, redirect landing khi lỗi
│   │   ├── Controller.php    # model(), view(), redirect(), isPost/isGet
│   │   └── DB.php              # PDO — chỉnh thông tin DB tại đây
│   ├── helpers/                # ví dụ about_page_blocks.php
│   ├── models/                 # User, Order, ProductModel, …
│   ├── views/
│   │   ├── components/         # header.php, footer.php
│   │   ├── auth/, cart/, contact.php, home.php, landing.php, …
│   │   ├── customer/
│   │   ├── product/, news/
│   │   └── admin/              # admin.php + dashboard, orders, products, …
│   └── router.php
├── db/
│   ├── phuongnam_db.sql
│   └── backup/
├── public/
│   ├── index.php
│   ├── .htaccess               # rewrite url + chuyển images/ cũ → media/
│   ├── css/, js/
│   ├── media/                  # ảnh sách, tin, upload — đọc media/README.txt
│   ├── robots.txt
│   └── srtdash-admin-dashboard/
├── tools/
│   ├── build_admin_partials_css.py
│   └── strip_admin_inline_styles.py
└── README.md
```

---

## Controllers và URL gợi ý

Quy ước: `BASE_URL` + `{controller}/{method}/{tham số...}`. Chữ trong URL thường viết thường; PHP vẫn gọi đúng method.

| Controller | Method chính | Ghi chú |
|------------|----------------|--------|
| LandingController | index | `landing` |
| HomeController | index, about, qa, pricing | `home`, `home/about`, `home/qa`, `home/pricing` |
| AboutController | index | `about` — cùng nội dung giới thiệu với `home/about` |
| ProductController | index, detail($id), addReview($id) | `product`, `product/detail/1`, POST `product/addReview/1` |
| NewsController | index, detail($id), addComment | `news`, `news/detail/1`, `news/addComment` |
| CartController | index, add, updateQuantity, remove, syncFromLocal | `cart`, … |
| AuthController | login, register, logout, forgot | `auth/login`, … |
| ContactController | index, submit | `contact`, `contact/submit` |
| CustomerController | index, orders, wishlist, notifications, updateProfile, uploadAvatar, changePassword, … | cần đăng nhập customer |
| AddressController | getAddresses, addAddress, updateAddress, deleteAddress, setDefaultAddress | `address/...` |
| OrderController | index, detail($id), submitOrder, cancelOrder | `order`, `order/detail/5`, POST submit/hủy |
| QaController | index | `qa` — có thể kèm `?category=` |
| AdminController | index, orders, orderDetail($id), products, createProduct, editProduct($id), … | tiền tố `admin/`; chi tiết bảng dưới |

### Admin — bảng URL thường dùng

| Mục | URL |
|-----|-----|
| Dashboard | admin hoặc admin/index |
| Đơn hàng | admin/orders, admin/orderDetail/{id} |
| POST đơn | admin/updateOrderStatus, admin/confirmOrderPayment, admin/deleteOrder |
| AJAX đơn | admin/getOrderDetailAjax |
| Sản phẩm | admin/products, admin/createProduct, admin/editProduct/{id}, admin/deleteProduct |
| Danh mục | admin/categories, admin/createCategory, admin/updateCategory, admin/deleteCategory |
| Tin | admin/news, admin/createNews, admin/editNews, admin/deleteNews |
| Bình luận tin | admin/comments, admin/deleteComment |
| Đánh giá SP | admin/productreviews, admin/deleteproductreview |
| Khách | admin/customers, admin/customerDetail/{id}, admin/deleteCustomer |
| Liên hệ | admin/contacts, admin/deleteContact |
| FAQ | admin/qa, admin/createQa, admin/deleteQa |
| Trang Giới thiệu | admin/pageContent?page=about |
| Nhân viên | admin/staff, admin/createStaff, admin/editStaff/{id}, admin/deleteStaff |
| Cài đặt | admin/settings |

---

## Models (`app/models/`)

Admin, AdminModel, CartModel, CategoryModel, CommentModel, ContactModel, NewsModel, NotificationModel, Order, OrderModel, ProductModel, ProductReviewModel, QaModel, User, UserAddress, UserModel, WishlistModel.

Một số chỗ dùng trực tiếp `new DB()` (ví dụ `Order.php`, `UserAddress.php`).

---

## Cơ sở dữ liệu — các bảng trong `phuongnam_db.sql`

| Bảng | Vai trò ngắn |
|------|----------------|
| users | Tài khoản: admin, staff, customer; mật khẩu hash; avatar |
| customer | Hạng thành viên, điểm (`member_type`, `total_fpoint`) gắn `user_id` |
| category | Danh mục sách |
| product | Sách: giá, tồn, mô tả, … |
| product_image | Nhiều ảnh / ảnh đại diện (`image_url` → đường dẫn `media/...`) |
| author_of_product | Tác giả gắn sản phẩm |
| category_product | Sản phẩm — danh mục nhiều-nhiều |
| cart_items | Giỏ theo `user_id` đã đăng nhập |
| orders | Đơn: trạng thái enum, tổng tiền, ship, thanh toán |
| order_product | Chi tiết từng dòng trong đơn |
| payment | Thông tin thanh toán (theo thiết kế bảng) |
| news | Tin tức |
| comments | Bình luận tin |
| productreview | Đánh giá sản phẩm |
| qa | Câu hỏi — trả lời FAQ |
| contacts | Form liên hệ |
| pages | Nội dung trang tĩnh (about, …) |
| settings | Cấu hình site |
| wishlist | Yêu thích |
| user_addresses | Địa chỉ giao hàng |
| user_phone | Số điện thoại phụ (nếu dùng) |
| voucher, order_voucher | Mã giảm giá / gán đơn |

Trạng thái đơn trong CSDL: `pending`, `processing`, `shipped`, `completed`, `cancelled` — khớp `ORDER_STATUSES` trong `AdminController`.

**Ghi chú schema:** `NotificationModel` đọc bảng `notifications` (cột `id`, `type`, `title`, `content`, `is_read`, `created_at`, `user_id`). Trong các file `.sql` thư mục `db/` của repo không có lệnh `CREATE TABLE` cho bảng này; nếu chức năng thông báo báo lỗi CSDL thì cần bổ sung bảng cho khớp model hoặc cập nhật file dump.

---

## Ảnh và đường dẫn media

- File tĩnh và upload nằm dưới **`public/media/`** (cấu trúc con: `products`, `news`, `home`, `uploads`, `reviews`, …).
- Trong DB nên lưu dạng **`media/...`** không có `/` đầu dòng.
- `public/.htaccess` rewrite các URL cũ `images/news-page/...` sang `media/news/...` tương ứng.
- Chi tiết quy ước: **`public/media/README.txt`**. Trong `config.php` có `normalize_media_relative_path`, `media_url`, `asset_url`, và hàm sanitize HTML cho ảnh ngoài.

---

## Helper quan trọng trong `config.php`

`site_url`, `asset_url`, `media_url`, `normalize_media_relative_path`, `e`, `pn_slugify`, `pn_site_settings`, `pn_sanitize_html_local_media_only`, `listing_http_build_query`, `pagination_visible_pages`, … Dùng chung cho layout khách và admin.

---

## Bảo mật

- Truy vấn qua PDO prepared statements trong lớp `DB`.
- Mật khẩu lưu bcrypt (`password_hash` / `password_verify` trong luồng auth).
- Escape khi in ra HTML (`htmlspecialchars`, helper `e()`).
- Phân quyền theo `users_role` trong constructor `AdminController`, `CustomerController`, …
- Nội dung HTML tin/trang: lọc ảnh và URL ngoài (`pn_sanitize_html_local_media_only`, …).

---

## Xử lý sự cố

| Hiện tượng | Hướng xử lý |
|------------|-------------|
| Admin không có CSS, sidebar vỡ | Chưa clone SRTdash; thư mục `public/srtdash-admin-dashboard/srtdash` thiếu file. Clone lại, xóa cache trình duyệt. |
| Mọi URL đều về landing | Sai tên controller/method; hoặc chưa bật rewrite / sai DocumentRoot. |
| Lỗi SQL / không kết nối | Sửa **`app/core/DB.php`** và đảm bảo MySQL chạy đúng port; import đủ `phuongnam_db.sql`. |
| Đăng nhập được nhưng không thấy dữ liệu | Database trống hoặc sai tên DB trong `DB.php`. |
| Ảnh sách/tin 404 | Đường dẫn trong DB không khớp file thật dưới `public/media/`. |
| Quên mật khẩu không gửi mail | SMTP / PHPMailer / `mail()` chưa cấu hình; xem `AuthController::sendMailPHPMailer` và phần `smtp` trong config nếu đã bổ sung mảng cấu hình. |

---

## License

Mã nguồn phục vụ mục đích học tập.
