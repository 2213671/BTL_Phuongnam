<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<!-- Checkout Popup CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>css/checkout-popup.css">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

    .cart-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
        margin-bottom: 50px;
    }

    .cart-items {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .cart-header {
        background-color: var(--phuongnam-light-gray);
        padding: 15px 20px;
        font-weight: 600;
        border-bottom: 2px solid var(--phuongnam-red);
    }

    .cart-item {
        display: grid;
        grid-template-columns: 40px 100px 2fr 120px 100px 80px;
        gap: 20px;
        padding: 20px;
        border-bottom: 1px solid var(--phuongnam-light-gray);
        align-items: center;
        transition: background-color 0.3s;
    }

    .item-checkbox {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--phuongnam-red);
    }

    .cart-item:hover {
        background-color: #fafafa;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 100px;
        height: 130px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        overflow: hidden;
    }

    .item-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .item-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }


.item-title-link {
    text-decoration: none; 
    color: inherit; 
    display: block; 
}

.item-title-link:hover {
    color: #007bff; 
}

    .item-title {
        font-weight: 600;
        color: var(--phuongnam-dark);
        font-size: 1rem;
        line-height: 1.4;
    }

    .item-author {
        color: var(--phuongnam-gray);
        font-size: 0.9rem;
    }

    .item-price {
        color: var(--phuongnam-red);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .item-old-price {
        color: #999;
        text-decoration: line-through;
        font-size: 0.9rem;
        margin-left: 8px;
    }

    .item-controls {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-btn {
        width: 32px;
        height: 32px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .quantity-btn:hover {
        background-color: var(--phuongnam-red);
        color: white;
        border-color: var(--phuongnam-red);
    }

    .quantity-input {
        width: 60px;
        height: 32px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-weight: 600;
    }

    .item-subtotal {
        font-weight: 700;
        color: var(--phuongnam-red);
        font-size: 1.1rem;
        text-align: right;
    }

    .remove-btn {
        background: none;
        border: none;
        color: var(--phuongnam-gray);
        cursor: pointer;
        font-size: 0.9rem;
        transition: color 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .remove-btn:hover {
        color: var(--phuongnam-red);
    }

    .cart-summary {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    .summary-title {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--phuongnam-dark);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--phuongnam-light-gray);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: var(--phuongnam-dark);
    }

    .summary-label {
        color: var(--phuongnam-gray);
    }

    .summary-value {
        font-weight: 600;
    }

    .summary-discount {
        color: var(--phuongnam-red);
    }

    .summary-total {
        border-top: 2px solid var(--phuongnam-light-gray);
        padding-top: 15px;
        margin-top: 15px;
        font-size: 1.3rem;
    }

    .summary-total .summary-label {
        color: var(--phuongnam-dark);
        font-weight: 700;
    }

    .summary-total .summary-value {
        color: var(--phuongnam-red);
        font-weight: 700;
    }

    .checkout-btn {
        width: 100%;
        background-color: var(--phuongnam-red);
        color: white;
        border: none;
        padding: 15px 20px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .checkout-btn:hover {
        background-color: #a81b20;
    }

    .continue-shopping {
        width: 100%;
        background-color: white;
        color: var(--phuongnam-red);
        border: 2px solid var(--phuongnam-red);
        padding: 12px 20px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .continue-shopping:hover {
        background-color: var(--phuongnam-red);
        color: white;
    }

    .empty-cart {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .empty-cart i {
        font-size: 80px;
        color: var(--phuongnam-light-gray);
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        color: var(--phuongnam-dark);
        margin-bottom: 10px;
    }

    .empty-cart p {
        color: var(--phuongnam-gray);
        margin-bottom: 30px;
    }

    .shop-now-btn {
        display: inline-block;
        background-color: var(--phuongnam-red);
        color: white;
        padding: 12px 30px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .shop-now-btn:hover {
        background-color: #a81b20;
        color: white;
    }

    @media (max-width: 991.98px) {
        .cart-container {
            grid-template-columns: 1fr;
        }

        .cart-summary {
            position: static;
        }
    }

    @media (max-width: 767.98px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: 15px;
        }

        .item-image {
            width: 80px;
            height: 100px;
        }

        .item-controls {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <h1 class="page-title">Giỏ hàng của bạn</h1>

    <?php if (!empty($cartItems)): ?>
        <div class="cart-container">
            <div class="cart-items" id="cart-items-list">
                <div class="cart-header">
                    Sản phẩm (<span id="cart-count-display"><?= count($cartItems) ?></span>) -
                    Đã chọn: <span id="selected-count"><?= count($cartItems) ?></span>
                </div>

                <?php foreach ($cartItems as $item):
                    // Dùng biến local để tránh lặp lại $_SESSION['users_id'] trong JS
                    $isLoggedInJS = json_encode($isLoggedIn);
                ?>
                    <div class="cart-item" data-product-id="<?= $item['product_id'] ?>" id="cart-item-<?= $item['product_id'] ?>">
                        <div class="item-checkbox">
                            <input type="checkbox"
                                   class="product-checkbox"
                                   data-product-id="<?= $item['product_id'] ?>"
                                   data-price="<?= $item['price'] ?>"
                                   data-quantity="<?= $item['quantity'] ?>"
                                   onchange="updateCheckoutSummary()"
                                   checked>
                        </div>
                        <div class="item-image">
                            <img src="<?= e(media_url($item['image_url'] ?? '')) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        </div>

                        <div class="item-info">
                            <a href="<?= BASE_URL . 'product/detail/' . $item['product_id'] ?>" class="item-title-link">
                                <div class="item-title"><?= htmlspecialchars($item['title']) ?></div>
                            </a>
                            <div class="item-author"><?= e($item['author'] ?? '') ?></div>
                            <div class="item-price" data-price="<?= $item['price'] ?>">
                                <?= number_format($item['price']) ?>
                            </div>
                        </div>

                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="decreaseQuantity(<?= $item['product_id'] ?>, <?= $isLoggedInJS ?>)">-</button>
                            <input type="number"
                                id="quantity-<?= $item['product_id'] ?>"
                                class="quantity-input"
                                value="<?= $item['quantity'] ?>"
                                min="1"
                                max="99"
                                onchange="updateQuantity(<?= $item['product_id'] ?>, this.value, <?= $isLoggedInJS ?>)">
                            <button class="quantity-btn" onclick="increaseQuantity(<?= $item['product_id'] ?>, <?= $isLoggedInJS ?>)">+</button>
                        </div>

                        <div class="item-subtotal" id="subtotal-<?= $item['product_id'] ?>" data-subtotal="<?= $item['subtotal'] ?>">
                            <?= number_format($item['subtotal']) ?>đ
                        </div>

                        <button class="remove-btn" onclick="removeFromCart(<?= $item['product_id'] ?>, <?= $isLoggedInJS ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary" id="cart-summary">
                <div class="summary-title">Thông tin đơn hàng</div>

                <div class="summary-row">
                    <span class="summary-label">Tạm tính:</span>
                    <span class="summary-value" id="summary-subtotal"><?= number_format($summary['subtotal']) ?>đ</span>
                </div>

                <?php if ($summary['discount'] > 0): ?>
                    <div class="summary-row">
                        <span class="summary-label">Giảm giá:</span>
                        <span class="summary-value summary-discount" id="summary-discount">-<?= number_format($summary['discount']) ?>đ</span>
                    </div>
                <?php endif; ?>

                <div class="summary-row">
                    <span class="summary-label">Phí vận chuyển:</span>
                    <span class="summary-value" id="summary-shipping"><?= number_format($summary['shipping']) ?>đ</span>
                </div>

                <div class="summary-row summary-total">
                    <span class="summary-label">Tổng cộng:</span>
                    <span class="summary-value" id="summary-total"><?= number_format($summary['total']) ?>đ</span>
                </div>

                <button class="checkout-btn" onclick="handleCheckout()">
                    <i class="fas fa-check-circle"></i> Tiến hành thanh toán
                </button>

                <a href="<?= BASE_URL ?>product" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua hàng
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-cart" id="empty-cart-message">
            <i class="fas fa-shopping-cart"></i>
            <h3>Giỏ hàng của bạn đang trống</h3>
            <p>Hãy khám phá và thêm sản phẩm yêu thích vào giỏ hàng nhé!</p>
            <a href="<?= BASE_URL ?>product" class="shop-now-btn">
                <i class="fas fa-shopping-bag"></i> Mua sắm ngay
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Checkout Popup -->
<div id="checkoutPopup" class="checkout-modal" style="display: none;">
    <div class="checkout-modal-content">
        <div class="checkout-modal-header">
            <h2>Xác nhận đơn hàng</h2>
            <button class="close-popup" onclick="closeCheckoutPopup()">&times;</button>
        </div>

        <div class="checkout-modal-body">
            <!-- Bước 1: Thông tin người nhận -->
            <div class="checkout-section">
                <h3>Thông tin Giao hàng</h3>
                <div class="address-selector" style="margin-bottom: 15px;">
                    <select id="saved_addresses" onchange="loadSavedAddress()" style="width: 100%; padding: 10px; border-radius: 4px;">
                        <option value="">-- Chọn thông tin đã lưu --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tên người nhận <span class="required">*</span></label>
                    <input type="text" id="recipient_name" required placeholder="Nhập tên người nhận">
                </div>
                <div class="form-group">
                    <label>Số điện thoại <span class="required">*</span></label>
                    <input type="tel" id="recipient_phone" required placeholder="Nhập số điện thoại">
                </div>
                

                <div id="address_form">
                    <div class="form-group">
                        <label>Tỉnh/Thành phố <span class="required">*</span></label>
                        <select id="province" class="select2-search" required>
                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phường/Xã <span class="required">*</span></label>
                        <select id="ward" class="select2-search" required>
                            <option value="">-- Chọn Phường/Xã --</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label>Số nhà, tên đường <span class="required">*</span></label>
                        <input type="text" id="street_address" required placeholder="Ví dụ: 123 Nguyễn Trãi">
                    </div>
                    <button onclick="saveNewAddress()" class="btn-primary">Lưu thông tin</button>
                </div>
            </div>

            <!-- Danh sách sản phẩm đã chọn -->
            <div class="checkout-section">
                <h3>Sản phẩm đã chọn</h3>
                <div id="checkout_products_list"></div>
            </div>

            <!-- Thêm ghi chú -->
            <div class="checkout-section">
                <h3>Ghi chú</h3>
                <textarea id="order_note" placeholder="Nhập ghi chú cho đơn hàng (nếu có)" rows="5" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;"></textarea>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="checkout-section">
                <h3>Phương thức thanh toán</h3>
                <div class="payment-methods">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="COD" checked>
                        <span>Thanh toán khi nhận hàng (COD)</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="E-wallet">
                        <span>Ví điện tử (Momo, ZaloPay)</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="Credit Card">
                        <span>Thẻ tín dụng/Ghi nợ</span>
                    </label>
                </div>
            </div>

            <!-- Tổng tiền -->
            <div class="checkout-total">
                <div class="total-row">
                    <span>Tạm tính:</span>
                    <span id="checkout_subtotal">0đ</span>
                </div>
                <div class="total-row">
                    <span>Phí vận chuyển:</span>
                    <span id="checkout_shipping">30,000đ</span>
                </div>
                <div class="total-row total-final">
                    <span>Tổng cộng:</span>
                    <span id="checkout_total">0đ</span>
                </div>
            </div>
        </div>

        <div class="checkout-modal-footer">
            <button onclick="closeCheckoutPopup()" class="btn-cancel">Hủy</button>
            <button onclick="submitOrder()" class="btn-submit">Đặt hàng <span id="final_total"></span></button>
        </div>
    </div>
</div>

<script>
    // Hàm format tiền tệ
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount).replace('₫', 'đ');
    }

    // --- LOGIC LOCAL STORAGE (Cho trường hợp chưa đăng nhập) ---
    const LOCAL_CART_KEY = 'local_cart';

    // Lấy giỏ hàng từ Local Storage
    function getLocalCart() {
        const cartJson = localStorage.getItem(LOCAL_CART_KEY);
        return cartJson ? JSON.parse(cartJson) : [];
    }

    // Lưu giỏ hàng vào Local Storage
    function saveLocalCart(cart) {
        localStorage.setItem(LOCAL_CART_KEY, JSON.stringify(cart));
        // Cập nhật cookie để Controller có thể đọc (cho lần load trang tiếp theo)
        document.cookie = `local_cart=${JSON.stringify(cart)}; path=/; max-age=${3600*24*7}`; // 7 ngày
    }

    // Cập nhật Local Cart (chỉ dùng khi chưa đăng nhập)
    function updateLocalCart(productId, quantity) {
        let cart = getLocalCart();
        const index = cart.findIndex(item => item.product_id == productId);

        if (quantity <= 0) {
            // Xóa sản phẩm nếu quantity <= 0
            if (index !== -1) {
                cart.splice(index, 1);
            }
        } else if (index !== -1) {
            // Cập nhật số lượng
            cart[index].quantity = quantity;
        }

        saveLocalCart(cart);
    }

    // Xóa sản phẩm khỏi Local Cart (chỉ dùng khi chưa đăng nhập)
    function removeLocalCartItem(productId) {
        let cart = getLocalCart();
        cart = cart.filter(item => item.product_id != productId);
        saveLocalCart(cart);
    }


    // --- LOGIC CẬP NHẬT GIO HÀNG (AJAX & UI) ---

    // Tính toán lại tổng tiền trên UI
    function recalculateSummary() {
        let subtotal = 0;
        const cartItemsList = document.querySelectorAll('.cart-item');

        cartItemsList.forEach(item => {
            const subtotalElement = item.querySelector('.item-subtotal');
            if (subtotalElement) {
                subtotal += parseInt(subtotalElement.dataset.subtotal) || 0;
            }
        });

        // Áp dụng logic tính tổng của Controller (giả định)
        const discount = 0; // Thay đổi nếu có logic giảm giá
        const shipping = subtotal > 0 ? 30000 : 0;
        const total = subtotal - discount + shipping;

        // Cập nhật UI Summary
        document.getElementById('summary-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('summary-shipping').textContent = formatCurrency(shipping);
        document.getElementById('summary-total').textContent = formatCurrency(total);
        document.getElementById('cart-count-display').textContent = cartItemsList.length;

        // Xử lý giỏ hàng rỗng
        if (cartItemsList.length === 0) {
            const container = document.querySelector('.cart-container');
            if (container) container.remove();

            const emptyMessage = document.getElementById('empty-cart-message');
            if (!emptyMessage) {
                // Nếu chưa có message thì thêm vào (hoặc reload)
                // Tốt nhất là hiện message đã có trong View
                location.reload(); // Hoặc render lại empty cart HTML
            }
        }
    }


    // Tăng số lượng
    function increaseQuantity(productId, isLoggedIn) {
        const input = document.getElementById(`quantity-${productId}`);
        let value = parseInt(input.value) || 0;
        if (value < 99) {
            input.value = value + 1;
            updateQuantity(productId, input.value, isLoggedIn);
        }
    }

    // Giảm số lượng
    function decreaseQuantity(productId, isLoggedIn) {
        const input = document.getElementById(`quantity-${productId}`);
        let value = parseInt(input.value) || 1;
        if (value > 1) {
            input.value = value - 1;
            updateQuantity(productId, input.value, isLoggedIn);
        }
    }

    // Cập nhật số lượng sản phẩm
    async function updateQuantity(productId, quantity, isLoggedIn) {
        quantity = parseInt(quantity);
        if (quantity < 1 || quantity > 99) return;

        const itemElement = document.getElementById(`cart-item-${productId}`);
        const priceElement = itemElement.querySelector('.item-price');
        const subtotalElement = document.getElementById(`subtotal-${productId}`);
        const price = parseInt(priceElement.dataset.price);

        // Cập nhật UI tạm thời
        const newSubtotal = price * quantity;
        subtotalElement.dataset.subtotal = newSubtotal;
        subtotalElement.textContent = formatCurrency(newSubtotal);
        recalculateSummary();

        // 1. Xử lý Local Storage (chưa đăng nhập)
        if (!isLoggedIn) {
            updateLocalCart(productId, quantity);
            if (window.cartManager && typeof window.cartManager.getLocalCartCount === 'function') {
                window.cartManager.updateCartCount(window.cartManager.getLocalCartCount());
            }
            return;
        }

        // 2. Xử lý Database (đã đăng nhập)
        try {
            const response = await fetch('<?= BASE_URL ?>cart/updateQuantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            });

            const result = await response.json();

            if (!result.success) {
                alert(result.message || 'Lỗi khi cập nhật số lượng');
                location.reload(); // Nếu lỗi thì reload để đồng bộ
                return;
            }
            if (typeof result.cartCount === 'number' && typeof window.updateCartBadge === 'function') {
                window.updateCartBadge(result.cartCount);
            }
        } catch (error) {
            console.error('Lỗi kết nối khi cập nhật số lượng:', error);
            alert('Lỗi kết nối khi cập nhật số lượng');
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    async function removeFromCart(productId, isLoggedIn) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            return;
        }

        const itemElement = document.getElementById(`cart-item-${productId}`);
        itemElement.remove();
        recalculateSummary(); // Cập nhật lại tổng tiền ngay lập tức

        // 1. Xử lý Local Storage (chưa đăng nhập)
        if (!isLoggedIn) {
            removeLocalCartItem(productId);
            if (window.cartManager && typeof window.cartManager.getLocalCartCount === 'function') {
                window.cartManager.updateCartCount(window.cartManager.getLocalCartCount());
            }
            return;
        }

        // 2. Xử lý Database (đã đăng nhập)
        try {
            const response = await fetch('<?= BASE_URL ?>cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}`
            });

            const result = await response.json();

            if (!result.success) {
                alert(result.message || 'Lỗi khi xóa sản phẩm');
                location.reload();
                return;
            }
            if (typeof result.cartCount === 'number' && typeof window.updateCartBadge === 'function') {
                window.updateCartBadge(result.cartCount);
            }
        } catch (error) {
            console.error('Lỗi kết nối khi xóa sản phẩm:', error);
            alert('Lỗi kết nối khi xóa sản phẩm');
        }
    }

    // Cập nhật summary dựa trên sản phẩm đã chọn
    function updateCheckoutSummary() {
        const checkboxes = document.querySelectorAll('.product-checkbox:checked');
        let subtotal = 0;
        let selectedCount = 0;

        checkboxes.forEach(checkbox => {
            const price = parseInt(checkbox.dataset.price);
            const quantityInput = document.getElementById(`quantity-${checkbox.dataset.productId}`);
            const quantity = parseInt(quantityInput.value);
            subtotal += price * quantity;
            selectedCount++;
        });

        const shipping = selectedCount > 0 ? 30000 : 0;
        const total = subtotal + shipping;

        // Cập nhật UI
        document.getElementById('selected-count').textContent = selectedCount;
        document.getElementById('summary-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('summary-shipping').textContent = formatCurrency(shipping);
        document.getElementById('summary-total').textContent = formatCurrency(total);
    }

    // Cập nhật lại khi thay đổi số lượng
    const originalUpdateQuantity = updateQuantity;
    updateQuantity = async function(productId, quantity, isLoggedIn) {
        await originalUpdateQuantity(productId, quantity, isLoggedIn);
        updateCheckoutSummary(); // Cập nhật lại tính toán sau khi đổi số lượng
    };

    // Xử lý thanh toán
    function handleCheckout() {
        if (!window.isLoggedIn) {
            const base = typeof BASE_URL !== 'undefined' ? BASE_URL : '';
            window.location.href = base + 'auth/login?redirect=' + encodeURIComponent('cart');
            return;
        }

        const checkboxes = document.querySelectorAll('.product-checkbox:checked');

        if (checkboxes.length === 0) {
            alert('Vui lòng chọn ít nhất 1 sản phẩm để thanh toán!');
            return;
        }

        // Lấy danh sách sản phẩm đã chọn
        const selectedProducts = [];
        checkboxes.forEach(checkbox => {
            const productId = checkbox.dataset.productId;
            const quantityInput = document.getElementById(`quantity-${productId}`);
            selectedProducts.push({
                product_id: productId,
                quantity: parseInt(quantityInput.value),
                price: parseInt(checkbox.dataset.price)
            });
        });

        // Lưu vào sessionStorage để dùng trong popup
        sessionStorage.setItem('checkout_products', JSON.stringify(selectedProducts));

        // Mở popup thanh toán
        openCheckoutPopup();
    }

    // Load khi trang vừa mở
    document.addEventListener('DOMContentLoaded', function() {
        updateCheckoutSummary();
    });
</script>

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Include Checkout Popup Script -->
<script src="<?= BASE_URL ?>js/checkout-popup.js"></script>

<script>
// Initialize Select2 when popup opens
$(document).ready(function() {
    // Will be initialized when popup opens
});
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
