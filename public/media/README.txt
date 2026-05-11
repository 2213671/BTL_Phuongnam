Banner trang chủ (hero “Tri thức cho cuộc sống”) chỉ dùng ảnh home/library.jpg.
Ảnh sách hiển thị khác chọn qua DB (product_image → media/products, tin tức → media/news).

Cấu trúc thư mục media (ảnh tĩnh & upload, phục vụ qua URL gốc public):

  news/       — ảnh đại diện bài tin (DB: media/news/...)
  products/   — ảnh bìa sách (DB: media/products/...)
  home/       — banner trang chủ, placeholder tin (DB: media/home/...)
  uploads/    — ảnh upload từ admin (DB: media/uploads/...)
  reviews/    — ảnh đánh giá (nếu có)

Quy ước trong DB: luôn lưu đường dẫn tương đối không có dấu / đầu, ví dụ: media/news/ten-anh.jpg

URL rewrite legacy: public/.htaccess chuyển /images/... cũ sang /media/...
