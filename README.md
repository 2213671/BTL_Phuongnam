# Nhà sách Phương Nam — Website bán sách trực tuyến

Chào mừng bạn đến với dự án website bán sách Phương Nam! Đây là một ứng dụng web PHP thuần, được xây dựng theo kiến trúc MVC tự code. Router xử lý tham số `url`, controller quản lý logic, model tương tác với MySQL qua PDO, và view render HTML. Không dùng framework như Laravel hay Symfony. Dự án này phù hợp cho bài tập lớn môn Lập trình Web và demo đầy đủ luồng mua sắm từ khách hàng đến quản trị viên.

---

## Yêu cầu để chạy

Để chạy được dự án này, bạn cần:

- **PHP**: Phiên bản 8.0 trở lên. File SQL dump trong repo được export từ PHP 8.2.
- **MySQL / MariaDB**: Với charset `utf8mb4`.
- **Apache**: Bật `mod_rewrite`.
- **Extension PHP**: `pdo_mysql`, `json`, `mbstring`, `session`. Nếu sanitize HTML cho tin/trang, cần `dom` (`DOMDocument`).

---

## Tính năng chính

### Cho khách chưa đăng nhập

- **Trang landing, chủ, giới thiệu, bảng giá, FAQ, liên hệ**: Các trang cơ bản để giới thiệu site.
- **Sản phẩm**: Xem danh sách (có lọc danh mục và tìm kiếm), chi tiết sách với ảnh và đánh giá. Có thể thêm đánh giá qua POST.
- **Tin tức**: Danh sách, chi tiết, và gửi bình luận.
- **Tài khoản**: Đăng ký, đăng nhập, đăng xuất; quên mật khẩu gửi OTP qua email — cần SMTP hoặc mail() hoạt động; hỗ trợ PHPMailer nếu cài.

### Cho khách hàng (role = customer)

- **Giỏ hàng**: Thêm, sửa số lượng, xóa. Có API JSON và đồng bộ khi đăng nhập.
- **Đặt hàng**: AJAX để submit đơn với thông tin người nhận, địa chỉ, thanh toán, phí ship.
- **Tài khoản**: Xem/sửa hồ sơ, upload avatar, đổi mật khẩu.
- **Địa chỉ**: Quản lý danh sách địa chỉ (thêm, sửa, xóa, đặt mặc định) — chủ yếu qua JSON/AJAX.
- **Đơn hàng**: Xem danh sách, chi tiết, hủy đơn nếu được phép.
- **Wishlist và thông báo**: Đánh dấu đã đọc.

### Cho admin (role = admin)

Giao diện admin dùng SRTdash + CSS tùy chỉnh.

- Dashboard, quản lý đơn hàng (danh sách, chi tiết, đổi trạng thái, xác nhận thanh toán, xóa).
- CRUD sản phẩm, danh mục, tin tức, bình luận, đánh giá.
- Quản lý khách hàng, liên hệ, FAQ, nội dung trang Giới thiệu.
- Quản lý nhân viên (staff).
- Cài đặt site.

### Cho staff (role = staff)

Staff có quyền truy cập dashboard và đơn hàng, nhưng không được vào các phần chỉ dành cho admin.

---

## Công nghệ dùng

- **Ngôn ngữ**: PHP thuần.
- **CSDL**: MySQL/MariaDB, truy vấn qua class DB (query, single, all).
- **Frontend site**: HTML + CSS riêng từng trang trong `public/css`, JS trong `public/js` (giỏ hàng, checkout, etc.).
- **Frontend admin**: Bootstrap + SRTdash; font Google (Lato, Poppins).
- **Session**: Dùng `session_start()` ở `public/index.php`; lưu user info như id, username, role, email, avatar.

---

## Cách MVC hoạt động

1. Trình duyệt gọi URL dưới `public/`.
2. `.htaccess` chuyển request không phải file tĩnh sang `index.php?url=...`.
3. `index.php` load router, config, App, Controller, DB.
4. App parse `url` thành [controller, method, params]: load controller tương ứng, gọi method (không phân biệt hoa thường).
5. Controller gọi model, gán data, view() hoặc redirect().

Nếu controller/method không tồn tại, redirect về landing.

---

## Hướng dẫn cài đặt

### 1. Đặt source code

Clone hoặc copy toàn bộ thư mục vào `htdocs` (vd: `C:\xampp\htdocs\BTL_Phuongnam`).

### 2. Database

- Tạo DB UTF-8, tên mặc định `phuongnam_db` (hoặc tùy chỉnh).
- Import `db/phuongnam_db.sql`. Có backup trong `db/backup/`.

### 3. Kết nối DB

Model kế thừa `app/core/DB.php`, chứa host, user, pass, db name, port cho PDO. Sửa cho khớp máy bạn.

`app/config/config.php` có define DB_* và ENVIRONMENT (development để hiện lỗi). Kết nối thực tế dùng DB.php — giữ đồng bộ.

### 4. BASE_URL và timezone

BASE_URL tự động từ SCRIPT_NAME và scheme. Timezone mặc định Asia/Ho_Chi_Minh.

### 5. Theme admin SRTdash

CSS/JS admin ở `public/srtdash-admin-dashboard/srtdash/`. Clone repo SRTdash vào `public`:

```bash
git clone --depth 1 https://github.com/puikinsh/srtdash-admin-dashboard.git srtdash-admin-dashboard
```

Kiểm tra có `public/srtdash-admin-dashboard/srtdash/assets/css/bootstrap.min.css`.

### 6. Apache

Bật `mod_rewrite`. DocumentRoot trỏ vào `public/`, hoặc URL `http://localhost/<tên_thư_mục>/public/...`.

### 7. Chạy thử

Mở `http://localhost/BTL_Phuongnam/public/home`. Robots: `public/robots.txt`.

---

## Tài khoản demo

Mật khẩu chung: `DemoBTLSieuTot123`

| Vai trò | Email |
|---------|--------|
| Admin | admin@phuongnam.com.vn |
| Staff | staff@phuongnam.com.vn |
| Khách demo | khachhang.demo@phuongnam.com.vn |

Có nhiều tài khoản customer khác dùng cùng mật khẩu.

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
