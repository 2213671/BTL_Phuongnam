<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<style>
    .breadcrumb-section {
        background-color: var(--phuongnam-light-gray);
        padding: 15px 0;
        margin-bottom: 30px;
    }

    .breadcrumb {
        background: none;
        margin-bottom: 0;
        padding: 0;
    }

    .breadcrumb-item a {
        color: var(--phuongnam-gray);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: var(--phuongnam-red);
    }

    .breadcrumb-item.active {
        color: var(--phuongnam-dark);
    }

    .page-title {
        color: var(--phuongnam-red);
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background-color: var(--phuongnam-orange);
    }

    .product-detail {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        margin-bottom: 50px;
    }

    .product-image-section {
        flex: 1;
        min-width: 300px;
    }

    .product-image {
        width: 100%;
        max-width: 400px;
        height: 500px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-info-section {
        flex: 1;
        min-width: 300px;
    }

    .product-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--phuongnam-dark);
        margin-bottom: 15px;
    }

    .product-author {
        color: var(--phuongnam-gray);
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .current-price {
        color: var(--phuongnam-red);
        font-size: 1.8rem;
        font-weight: 700;
    }

    .old-price {
        color: #999;
        text-decoration: line-through;
        font-size: 1.3rem;
    }

    .discount-percent {
        background-color: var(--phuongnam-red);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 600;
    }

    .product-rating {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .stars {
        color: #ffc107;
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .rating-count {
        color: var(--phuongnam-gray);
    }

    .product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 25px;
        padding: 20px 0;
        border-top: 1px solid var(--phuongnam-light-gray);
        border-bottom: 1px solid var(--phuongnam-light-gray);
    }

    .meta-item {
        display: flex;
        flex-direction: column;
    }

    .meta-label {
        color: var(--phuongnam-gray);
        font-size: 0.9rem;
    }

    .meta-value {
        font-weight: 600;
        color: var(--phuongnam-dark);
    }

    .product-description {
        margin-bottom: 30px;
    }

    .product-description h4 {
        color: var(--phuongnam-red);
        font-weight: 600;
        margin-bottom: 15px;
    }

    .product-description p {
        line-height: 1.8;
        color: var(--phuongnam-dark);
        margin-bottom: 15px;
    }

    .cart-section {
        background-color: var(--phuongnam-light-gray);
        padding: 25px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .quantity-btn {
        width: 36px;
        height: 36px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-input {
        width: 60px;
        height: 36px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .btn-add-to-cart {
        width: 100%;
        background-color: var(--phuongnam-red);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-bottom: 10px;
    }

    .btn-add-to-cart:hover {
        background-color: #a81b20;
    }

    .btn-buy-now {
        width: 100%;
        background-color: var(--phuongnam-orange);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-buy-now:hover {
        background-color: #e6850e;
    }

    .alert {
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        display: none;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .related-products {
        margin-top: 50px;
    }

    .section-title {
        color: var(--phuongnam-red);
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background-color: var(--phuongnam-orange);
    }

    .related-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .related-product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: inherit;
    }

    .related-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .related-product-image {
        height: 180px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .related-product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .related-product-info {
        padding: 15px;
    }

    .related-product-title {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.5em;
        line-height: 1.2em;
    }

    .related-product-author {
        color: var(--phuongnam-gray);
        font-size: 0.8rem;
        margin-bottom: 8px;
    }

    .related-product-price {
        color: var(--phuongnam-red);
        font-weight: 700;
        font-size: 0.9rem;
    }

    .stock-status {
        color: var(--phuongnam-red);
        font-weight: 600;
        margin-top: 10px;
    }

    .stock-status.available {
        color: #28a745;
    }

    @media (max-width: 767.98px) {
        .product-detail {
            flex-direction: column;
        }
        
        .product-title {
            font-size: 1.4rem;
        }
        
        .current-price {
            font-size: 1.4rem;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>product">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['title']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="product-detail">
        <div class="product-image-section">
            <div class="product-image">
                <img src="<?= e(media_url($product['image_url'] ?? '')) ?>" alt="<?= htmlspecialchars($product['title']) ?>" loading="lazy" width="400" height="500">
            </div>
        </div>
        
        <div class="product-info-section">
            <h1 class="product-title"><?= htmlspecialchars($product['title']) ?></h1>
            <div class="product-author">Tác giả: <?= e($product['author'] ?? 'Đang cập nhật') ?></div>
            
            <div class="product-price">
                <span class="current-price"><?= number_format($product['price']) ?>đ</span>
                <?php if (isset($product['old_price']) && $product['old_price'] > $product['price']): ?>
                    <span class="old-price"><?= number_format($product['old_price']) ?>đ</span>
                    <span class="discount-percent">-<?= round(100 - ($product['price'] / $product['old_price']) * 100) ?>%</span>
                <?php endif; ?>
            </div>
            
            <?php
            $avgR = isset($avg_rating) ? (float) $avg_rating : null;
            $revN = (int) ($review_count ?? 0);
            ?>
            <div class="product-rating">
                <div class="stars" aria-label="<?= $avgR !== null ? 'Điểm trung bình ' . $avgR . '/5' : 'Chưa có đánh giá' ?>">
                    <?php
                    $filled = $avgR !== null ? (int) round($avgR) : 0;
                    $filled = max(0, min(5, $filled));
                    for ($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= $filled ? 'fas' : 'far' ?> fa-star"></i>
                    <?php endfor; ?>
                </div>
                <span class="rating-count"><?= $avgR !== null ? e(number_format($avgR, 1)) . '/5 · ' : '' ?><?= $revN ?> đánh giá</span>
            </div>
            
            <div class="product-meta">
                <div class="meta-item">
                    <span class="meta-label">Nhà xuất bản</span>
                    <span class="meta-value"><?= htmlspecialchars($product['publisher']) ?></span>
                </div>
                <?php if (isset($product['published_date']) && !empty($product['published_date'])): ?>
                <div class="meta-item">
                    <span class="meta-label">Ngày xuất bản</span>
                    <span class="meta-value"><?= date('d/m/Y', strtotime($product['published_date'])) ?></span>
                </div>
                <?php endif; ?>
                <?php if (isset($product['pages']) && !empty($product['pages'])): ?>
                <div class="meta-item">
                    <span class="meta-label">Số trang</span>
                    <span class="meta-value"><?= htmlspecialchars($product['pages']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (isset($product['dimensions']) && !empty($product['dimensions'])): ?>
                <div class="meta-item">
                    <span class="meta-label">Kích thước</span>
                    <span class="meta-value"><?= htmlspecialchars($product['dimensions']) ?></span>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="stock-status <?= ($product['stock_quantity'] > 0) ? 'available' : '' ?>">
                <?php if ($product['stock_quantity'] > 0): ?>
                    <i class="fas fa-check-circle"></i> Còn hàng (<?= $product['stock_quantity'] ?> sản phẩm)
                <?php else: ?>
                    <i class="fas fa-times-circle"></i> Hết hàng
                <?php endif; ?>
            </div>
            
            <div class="product-description">
                <h4>Giới thiệu sản phẩm</h4>
                <div class="product-description-body"><?= nl2br(e((string) ($product['description'] ?? ''))) ?></div>
            </div>
            
            <div class="cart-section">
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                    <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="<?= $product['stock_quantity'] ?>">
                    <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                </div>
                
                <button class="btn-add-to-cart" onclick="addToCart(<?= $product['product_id'] ?>)" <?= ($product['stock_quantity'] <= 0) ? 'disabled' : '' ?> >
                    <?= ($product['stock_quantity'] <= 0) ? 'Hết hàng' : 'Thêm vào giỏ hàng' ?>
                </button>
                
                <button class="btn-buy-now" onclick="buyNow(<?= $product['product_id'] ?>)" <?= ($product['stock_quantity'] <= 0) ? 'disabled' : '' ?> >
                    <?= ($product['stock_quantity'] <= 0) ? 'Hết hàng' : 'Mua ngay' ?>
                </button>
            </div>
        </div>
    </div>

    <div class="product-reviews-block mb-5" style="max-width:900px;">
        <h2 class="section-title">Đánh giá từ khách hàng</h2>
        <?php
        $reviewUid = (int) ($_SESSION['users_id'] ?? 0);
        $canPostReview = $reviewUid > 0;
        ?>
        <?php if ($canPostReview): ?>
            <form id="reviewForm" class="card card-body mb-4 shadow-sm" style="border-radius:8px;">
                <input type="hidden" name="product_id" value="<?= (int) ($product['product_id'] ?? 0) ?>">
                <div class="mb-3">
                    <label class="form-label">Số sao <span class="text-danger">*</span></label>
                    <select name="rating" class="form-select" required style="max-width:220px;">
                        <?php for ($s = 5; $s >= 1; $s--): ?>
                            <option value="<?= $s ?>"><?= $s ?> sao</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea name="review_text" class="form-control" rows="3" required minlength="5" maxlength="2000" placeholder="Chia sẻ trải nghiệm (tối thiểu 5 ký tự)"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                <small class="text-muted d-block mt-2">Mỗi tài khoản một đánh giá cho sản phẩm — gửi lại sẽ cập nhật bài trước.</small>
            </form>
        <?php else: ?>
            <p class="text-muted mb-4"><a href="<?= e(site_url('auth/login?redirect=product/detail/' . (int) ($product['product_id'] ?? 0))) ?>">Đăng nhập</a> để gửi đánh giá sản phẩm.</p>
        <?php endif; ?>

        <?php if (!empty($reviews) && is_array($reviews)): ?>
            <?php foreach ($reviews as $rv): ?>
                <div class="border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <strong><?= e($rv['fullname'] ?? 'Khách') ?></strong>
                        <span class="text-warning"><?= str_repeat('★', (int) ($rv['rating'] ?? 0)) ?></span>
                    </div>
                    <div class="small text-muted"><?= !empty($rv['review_date']) ? date('d/m/Y H:i', strtotime($rv['review_date'])) : '' ?></div>
                    <?php if (!empty($rv['review_text'])): ?>
                        <p class="mb-0 mt-2"><?= nl2br(e($rv['review_text'])) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Chưa có đánh giá nào.</p>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($relatedProducts)): ?>
    <div class="related-products">
        <h2 class="section-title">Sản phẩm liên quan</h2>
        <div class="related-products-grid">
            <?php foreach ($relatedProducts as $related): ?>
                <a href="<?= BASE_URL ?>product/detail/<?= $related['product_id'] ?>" class="related-product-card">
                    <div class="related-product-image">
                        <img src="<?= e(media_url($related['image_url'] ?? '')) ?>" alt="<?= htmlspecialchars($related['title']) ?>" loading="lazy" width="180" height="180">
                    </div>
                    <div class="related-product-info">
                        <h3 class="related-product-title"><?= htmlspecialchars($related['title']) ?></h3>
                        <div class="related-product-author"><?= e($related['author'] ?? '') ?></div>
                        <div class="related-product-price">
                            <?= number_format($related['price']) ?>đ
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<div id="messageAlert" class="alert"></div>

<script>
    // Quantity control functions
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) || 0;
        const maxQuantity = parseInt(input.max) || 99; // Lấy max từ thuộc tính max của input
        if (value < maxQuantity) {
            input.value = value + 1;
        }
    }
    
    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) || 1;
        if (value > 1) {
            input.value = value - 1;
        }
    }

    function pnGuestCartAppend(productId, quantity) {
        const key = 'local_cart';
        productId = Number(productId);
        quantity = Number(quantity) || 1;
        let cart = [];
        try {
            const raw = localStorage.getItem(key);
            if (raw) {
                cart = JSON.parse(raw);
            }
            if (!Array.isArray(cart)) {
                cart = [];
            }
        } catch (e) {
            cart = [];
        }
        const existing = cart.find(function (item) {
            return Number(item.product_id) === productId;
        });
        if (existing) {
            existing.quantity = Number(existing.quantity) + quantity;
        } else {
            cart.push({ product_id: productId, quantity: quantity });
        }
        try {
            localStorage.setItem(key, JSON.stringify(cart));
        } catch (e) {}
        try {
            document.cookie =
                'local_cart=' +
                JSON.stringify(cart) +
                '; path=/; max-age=' +
                String(3600 * 24 * 7);
        } catch (e) {}
        return cart.reduce(function (sum, item) {
            return sum + (Number(item.quantity) || 0);
        }, 0);
    }

    async function addToCart(productId) {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;

        try {
            const response = await fetch('<?= BASE_URL ?>cart/add', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, 'success');

                if (result.storage === 'local') {
                    let localCount;
                    if (window.cartManager) {
                        window.cartManager.addToLocalCart(productId, quantity);
                        localCount = window.cartManager.getLocalCartCount();
                    } else {
                        localCount = pnGuestCartAppend(productId, quantity);
                    }
                    updateCartBadge(localCount);
                } else {
                    updateCartBadge(Number(result.cartCount) || 0);
                }
            } else {
                showMessage(result.message || 'Lỗi khi thêm sản phẩm vào giỏ hàng', 'error');
            }
        } catch (error) {
            console.error('Add to cart error:', error);
            showMessage('Lỗi kết nối khi thêm sản phẩm vào giỏ hàng', 'error');
        }
    }

    // Helper: Update cart badge
    function updateCartBadge(count) {
        const badges = document.querySelectorAll('.cart-badge, .cart-count');
        badges.forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        });
    }
    
    // Buy now function (redirects to cart page with product)
    function buyNow(productId) {
        const quantity = document.getElementById('quantity').value;
        window.location.href = `<?= BASE_URL ?>cart?product_id=${productId}&quantity=${quantity}`;
    }
    
    // Show message function
    function showMessage(message, type) {
        const alertDiv = document.getElementById('messageAlert');
        alertDiv.textContent = message;
        alertDiv.className = `alert alert-${type}`;
        alertDiv.style.display = 'block';
        
        // Hide message after 3 seconds
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 3000);
    }

    (function () {
        const rf = document.getElementById('reviewForm');
        if (!rf) return;
        rf.addEventListener('submit', async function (e) {
            e.preventDefault();
            const fd = new FormData(rf);
            fd.delete('product_id');
            const body = new URLSearchParams(fd);
            try {
                const res = await fetch('<?= e(BASE_URL) ?>product/addReview/<?= (int) ($product['product_id'] ?? 0) ?>', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body
                });
                const j = await res.json();
                if (j.need_login) {
                    window.location.href = '<?= e(BASE_URL) ?>auth/login?redirect=<?= urlencode('product/detail/' . (int) ($product['product_id'] ?? 0)) ?>';
                    return;
                }
                showMessage(j.message || (j.success ? 'Đã lưu' : 'Lỗi'), j.success ? 'success' : 'error');
                if (j.success) setTimeout(function () { location.reload(); }, 900);
            } catch (err) {
                showMessage('Lỗi kết nối', 'error');
            }
        });
    })();
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
