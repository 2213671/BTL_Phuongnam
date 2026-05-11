<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Sửa bài viết</h2>
                <div class="text-muted mt-1">Chỉnh sửa thông tin bài viết #<?= $article['id'] ?? '' ?></div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= BASE_URL ?>admin/news" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="pn-admin-news-editor">
    <div class="container-xl">
        <?php if (empty($article)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Không tìm thấy bài viết này!
            </div>
            <a href="<?= BASE_URL ?>admin/news" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" class="card">
                <div class="card-header">
                    <h2 class="card-title h5">
                        <i class="fas fa-edit me-2"></i>Thông tin bài viết
                    </h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Tiêu đề bài viết <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="title" required
                               value="<?= htmlspecialchars($article['title'] ?? '') ?>"
                               placeholder="Nhập tiêu đề bài viết...">
                        <div class="help-text">Tiêu đề nên ngắn gọn, súc tích và thu hút</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug URL (SEO)</label>
                        <input type="text" class="form-control" name="slug"
                               value="<?= htmlspecialchars($article['slug'] ?? '') ?>"
                               placeholder="Để trống để tạo tự động từ tiêu đề">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta description</label>
                        <textarea class="form-control" name="meta_description" rows="2" maxlength="320"><?= htmlspecialchars($article['meta_description'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta keywords</label>
                        <input type="text" class="form-control" name="meta_keywords" maxlength="500"
                               value="<?= htmlspecialchars($article['meta_keywords'] ?? '') ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Danh mục <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="category" required>
                                <option value="">-- Chọn danh mục --</option>
                                <option value="kien-thuc" <?= ($article['category'] ?? '') == 'kien-thuc' ? 'selected' : '' ?>>Kiến thức</option>
                                <option value="sach-hay" <?= ($article['category'] ?? '') == 'sach-hay' ? 'selected' : '' ?>>Sách hay</option>
                                <option value="van-hoa" <?= ($article['category'] ?? '') == 'van-hoa' ? 'selected' : '' ?>>Văn hóa đọc</option>
                                <option value="giao-duc" <?= ($article['category'] ?? '') == 'giao-duc' ? 'selected' : '' ?>>Giáo dục</option>
                                <option value="cong-nghe" <?= ($article['category'] ?? '') == 'cong-nghe' ? 'selected' : '' ?>>Công nghệ</option>
                                <option value="ky-nang" <?= ($article['category'] ?? '') == 'ky-nang' ? 'selected' : '' ?>>Kỹ năng sống</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày đăng</label>
                            <input type="date" class="form-control" name="published_date"
                                   value="<?= $article['published_date'] ?? date('Y-m-d') ?>">
                            <div class="help-text">Ngày xuất bản bài viết</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh đại diện</label>

                        <?php if (!empty($article['image_url'])): ?>
                            <div class="mb-2">
                                <div class="help-text mb-1">Ảnh hiện tại:</div>
                                <img src="<?= e(pn_public_image_src($article['image_url'] ?? '')) ?>"
                                     class="current-image"
                                     alt="Current image">
                            </div>
                        <?php endif; ?>

                        <input type="file" class="form-control" name="image" accept="image/*"
                               onchange="previewImage(this)">
                        <div class="help-text">
                            <?= !empty($article['image_url']) ? 'Chọn ảnh mới để thay đổi (bỏ trống nếu giữ nguyên). ' : '' ?>
                            Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB
                        </div>
                        <img id="imagePreview" class="image-preview" alt="Preview">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Tóm tắt ngắn <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="summary" rows="3" required
                                  placeholder="Nhập tóm tắt ngắn gọn về bài viết..."><?= htmlspecialchars($article['summary'] ?? '') ?></textarea>
                        <div class="help-text">Tóm tắt hiển thị trong danh sách bài viết (khoảng 150-200 ký tự)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Nội dung chi tiết <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="news_wysiwyg_edit" name="content" rows="12"
                                  placeholder="Nhập nội dung chi tiết bài viết..."><?= htmlspecialchars($article['content'] ?? '') ?></textarea>
                        <div class="help-text">
                            Bạn có thể sử dụng HTML để định dạng nội dung.
                            Ví dụ: &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;h2&gt;, &lt;h3&gt;
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong>
                        Bài viết được tạo lúc: <?= !empty($article['created_at']) ? date('d/m/Y H:i', strtotime($article['created_at'])) : 'N/A' ?>
                        <?php if (!empty($article['updated_at'])): ?>
                            | Cập nhật lần cuối: <?= date('d/m/Y H:i', strtotime($article['updated_at'])) ?>
                        <?php endif; ?>
                        | Lượt xem: <?= $article['views'] ?? 0 ?>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="<?= BASE_URL ?>admin/news" class="btn btn-link">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#news_wysiwyg_edit',
        height: 420,
        menubar: false,
        plugins: 'lists link table code help wordcount',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link table | code removeformat',
        branding: false,
        promotion: false,
        invalid_elements: 'iframe,object,embed',
        paste_preprocess: function (_plugin, args) {
            try {
                var d = document.createElement('div');
                d.innerHTML = args.content;
                d.querySelectorAll('img[src]').forEach(function (img) {
                    var s = (img.getAttribute('src') || '').trim();
                    if (/^https?:\/\//i.test(s)) {
                        img.remove();
                    }
                });
                args.content = d.innerHTML;
            } catch (e) { /* noop */ }
        }
    });
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
