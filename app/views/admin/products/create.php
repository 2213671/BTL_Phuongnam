<div class="card-header-actions">
    <h2 class="card-title">Thêm sản phẩm mới</h2>
    <a href="<?= BASE_URL ?>admin/products" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="admin-card">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="<?= BASE_URL ?>admin/createProduct" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Cột trái: Thông tin cơ bản -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label required">Tên sách</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" rows="5"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tác giả</label>
                                    <input type="text" name="author" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nhà xuất bản</label>
                                    <input type="text" name="publisher" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Giá bán</label>
                                    <input type="number" name="price" class="form-control" required min="0" step="1000">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Giá gốc</label>
                                    <input type="number" name="old_price" class="form-control" min="0" step="1000">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Số lượng</label>
                                    <input type="number" name="stock_quantity" class="form-control" required min="0" value="0">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Ngày xuất bản</label>
                                    <input type="date" name="published_date" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Năm</label>
                                    <input type="number" name="year" class="form-control" min="1900" max="2100">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Số trang</label>
                                    <input type="number" name="pages" class="form-control" min="1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngôn ngữ</label>
                                    <input type="text" name="language" class="form-control" placeholder="Tiếng Việt">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nhà cung cấp</label>
                                    <input type="text" name="supplier" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Loại sản phẩm</label>
                                    <input type="text" name="product_type" class="form-control" placeholder="Sách giấy">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kích thước</label>
                                    <input type="text" name="dimensions" class="form-control" placeholder="13 x 20.5 cm">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Khối lượng (gram)</label>
                                    <input type="number" name="weight" class="form-control" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kích cỡ (size)</label>
                                <input type="text" name="size" class="form-control">
                            </div>
                        </div>

                        <!-- Cột phải: Ảnh và danh mục -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach($categories as $cat): ?>
                                            <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ảnh sản phẩm</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="form-hint">Chọn ảnh JPG, PNG (tối đa 2MB)</small>
                            </div>

                            <div class="mb-3">
                                <img id="preview" src="<?= e(asset_url('media/products/default-book.jpg')) ?>"
                                     alt="Xem trước ảnh sản phẩm"
                                     class="img-thumbnail" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu sản phẩm
                        </button>
                    </div>
                </form>
</div>

<script>
// Preview ảnh khi chọn file
document.querySelector('input[name="image"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
