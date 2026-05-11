<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<div class="customer-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <?php require_once APP_ROOT . '/views/customer/sidebar.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="customer-content">
                    <h2 class="page-title">
                        <i class="fas fa-heart"></i>
                        Sản phẩm yêu thích
                        <?php if (!empty($wishlist)): ?>
                            <span class="text-muted" style="font-size: 1rem; font-weight: 400;">
                                (<?= count($wishlist) ?> sản phẩm)
                            </span>
                        <?php endif; ?>
                    </h2>
                    
                    <!-- Wishlist Grid -->
                    <?php if (!empty($wishlist)): ?>
                        <div class="wishlist-grid">
                            <?php foreach ($wishlist as $product): ?>
                                <div class="product-card"
                                     data-product-id="<?= $product['product_id'] ?>"
                                     onclick="window.location.href='<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?>'"
                                     style="cursor: pointer;">

                                    <div class="product-image">
                                        <img src="<?= e(media_url($product['image'] ?? '')) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                                        <?php if ($product['discount'] > 0): ?>
                                            <span class="product-badge">-<?= $product['discount'] ?>%</span>
                                        <?php endif; ?>
                                        <button class="btn-remove-wishlist"
                                                onclick="event.stopPropagation();"
                                                title="Xóa khỏi yêu thích">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-name">
                                            <?= htmlspecialchars($product['product_name']) ?>
                                        </h3>
                                        <div class="product-author">
                                            <?= e($product['author'] ?? '') ?>
                                        </div>

                                        <!-- Rating section - only show if data exists -->
                                        <?php if (isset($product['rating']) && isset($product['sold'])): ?>
                                        <div class="product-rating">
                                            <span class="rating-stars">
                                                <?php
                                                $rating = $product['rating'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= floor($rating)) {
                                                        echo '<i class="fas fa-star"></i>';
                                                    } elseif ($i - 0.5 <= $rating) {
                                                        echo '<i class="fas fa-star-half-alt"></i>';
                                                    } else {
                                                        echo '<i class="far fa-star"></i>';
                                                    }
                                                }
                                                ?>
                                            </span>
                                            <span class="rating-value"><?= $rating ?></span>
                                            <span class="rating-sold">| Đã bán <?= $product['sold'] ?></span>
                                        </div>
                                        <?php endif; ?>

                                        <div class="product-price">
                                            <span class="price-current">
                                                <?= number_format($product['price']) ?>đ
                                            </span>
                                            <?php if ($product['original_price'] > $product['price']): ?>
                                                <span class="price-original">
                                                    <?= number_format($product['original_price']) ?>đ
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="far fa-heart"></i>
                            <h4>Chưa có sản phẩm yêu thích</h4>
                            <p>Hãy thêm sản phẩm vào danh sách yêu thích để dễ dàng theo dõi và mua sắm sau!</p>
                            <a href="<?= BASE_URL ?>product" class="btn-browse">
                                <i class="fas fa-book me-2"></i>Khám phá sản phẩm
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Remove from wishlist (call API)
document.querySelectorAll('.btn-remove-wishlist').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();

        if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi danh sách yêu thích?')) return;

        const card = this.closest('.product-card');
        const pid = card?.dataset?.productId || card?.getAttribute('data-product-id');

        // animate optimistic
        card.style.opacity = '0.6';

        fetch('<?= BASE_URL ?>customer/removeWishlist', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'product_id=' + encodeURIComponent(pid)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                // remove with animation
                card.style.transition = 'all 0.25s';
                card.style.transform = 'scale(0.85)';
                card.style.opacity = '0';
                setTimeout(() => {
                    card.remove();
                    const remaining = document.querySelectorAll('.product-card').length;
                    if (remaining === 0) location.reload();
                    else {
                        const countEl = document.querySelector('.page-title span');
                        if (countEl) countEl.textContent = `(${remaining} sản phẩm)`;
                    }
                }, 250);
            } else if (res.need_login) {
                window.location.href = '<?= BASE_URL ?>auth/login';
            } else {
                card.style.opacity = '1';
                showToast(res.message || 'Xóa thất bại', 'danger');
            }
        })
        .catch(() => {
            card.style.opacity = '1';
            showToast('Lỗi kết nối', 'danger');
        });
    });
});

// Add to cart
document.querySelectorAll('.btn-add-cart').forEach(btn => {
    btn.addEventListener('click', function() {
        const productName = this.closest('.product-card').querySelector('.product-name').textContent.trim();
        
        // Simulate adding to cart
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm...';
        this.disabled = true;
        
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-check me-2"></i>Đã thêm!';
            
            // Show notification
            const notification = document.createElement('div');
            notification.className = 'alert alert-success position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                Đã thêm "${productName}" vào giỏ hàng!
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
                this.innerHTML = originalText;
                this.disabled = false;
            }, 2000);
        }, 800);
    });
});
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
