<div class="card-header-actions">
    <h2 class="card-title">Sửa sản phẩm: <?= htmlspecialchars($product['title']) ?></h2>
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
                <form action="<?= BASE_URL ?>admin/editProduct/<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Cột trái: Thông tin cơ bản -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label required">Tên sách</label>
                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($product['title']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tác giả</label>
                                    <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($product['author'] ?? '') ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nhà xuất bản</label>
                                    <input type="text" name="publisher" class="form-control" value="<?= htmlspecialchars($product['publisher'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Giá bán</label>
                                    <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required min="0" step="1000">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Giá gốc</label>
                                    <input type="number" name="old_price" class="form-control" value="<?= $product['old_price'] ?? '' ?>" min="0" step="1000">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Số lượng</label>
                                    <input type="number" name="stock_quantity" class="form-control" value="<?= $product['stock_quantity'] ?>" required min="0">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Ngày xuất bản</label>
                                    <input type="date" name="published_date" class="form-control" value="<?= $product['published_date'] ?? '' ?>">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Năm</label>
                                    <input type="number" name="year" class="form-control" value="<?= $product['year'] ?? '' ?>" min="1900" max="2100">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Số trang</label>
                                    <input type="number" name="pages" class="form-control" value="<?= $product['pages'] ?? '' ?>" min="1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngôn ngữ</label>
                                    <input type="text" name="language" class="form-control" value="<?= htmlspecialchars($product['language'] ?? '') ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nhà cung cấp</label>
                                    <input type="text" name="supplier" class="form-control" value="<?= htmlspecialchars($product['supplier'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Loại sản phẩm</label>
                                    <input type="text" name="product_type" class="form-control" value="<?= htmlspecialchars($product['product_type'] ?? '') ?>">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kích thước</label>
                                    <input type="text" name="dimensions" class="form-control" value="<?= htmlspecialchars($product['dimensions'] ?? '') ?>">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Khối lượng (gram)</label>
                                    <input type="number" name="weight" class="form-control" value="<?= $product['weight'] ?? '' ?>" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kích cỡ (size)</label>
                                <input type="text" name="size" class="form-control" value="<?= htmlspecialchars($product['size'] ?? '') ?>">
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
                                            <option value="<?= $cat['category_id'] ?>"
                                                <?= ($cat['category_id'] == ($product['category_id'] ?? '')) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['category_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ảnh sản phẩm</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="form-hint">Để trống nếu không muốn thay đổi ảnh</small>
                            </div>

                            <div class="mb-3">
                                <img id="preview"
                                     src="<?= e(media_url(!empty($product['image_url']) ? $product['image_url'] : 'media/products/default-book.jpg')) ?>"
                                     alt="<?= htmlspecialchars($product['title'] ?? 'Xem trước ảnh sản phẩm') ?>"
                                     class="img-thumbnail" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật sản phẩm
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
