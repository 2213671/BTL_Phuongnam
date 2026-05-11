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
                        <i class="fas fa-box"></i>
                        Đơn hàng của tôi
                    </h2>
                    
                    <!-- Order Filters -->
                    <div class="order-filters">
                        <button class="filter-btn active" data-status="all">
                            <i class="fas fa-list me-2"></i>Tất cả
                        </button>
                        <button class="filter-btn" data-status="processing">
                            <i class="fas fa-clock me-2"></i>Đang xử lý
                        </button>
                        <button class="filter-btn" data-status="shipping">
                            <i class="fas fa-shipping-fast me-2"></i>Đang giao
                        </button>
                        <button class="filter-btn" data-status="completed">
                            <i class="fas fa-check-circle me-2"></i>Hoàn thành
                        </button>
                        <button class="filter-btn" data-status="cancelled">
                            <i class="fas fa-times-circle me-2"></i>Đã hủy
                        </button>
                    </div>
                    
                    <!-- Orders List -->
                    <div class="orders-list">
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <div class="order-card" data-status="<?= $order['status'] ?>">
                                    <!-- Order Header -->
                                    <div class="order-header">
                                        <div>
                                            <span class="order-id">
                                                <i class="fas fa-hashtag"></i>
                                                <?= htmlspecialchars($order['order_id']) ?>
                                            </span>
                                            <span class="text-muted ms-3">
                                                <i class="far fa-calendar-alt"></i>
                                                <?= date('d/m/Y', strtotime($order['order_date'])) ?>
                                            </span>
                                        </div>
                                        <span class="order-status status-<?= $order['status'] ?>">
                                            <?= htmlspecialchars($order['status_text']) ?>
                                        </span>
                                    </div>
                                    
                                    <!-- Order Body -->
                                    <div class="order-body">
                                        <?php foreach ($order['items'] as $item): ?>
                                            <div class="order-item">
                                                <a href="<?= BASE_URL ?>product/detail/<?= $item['product_id'] ?>" class="order-item-image">
                                                    <img src="<?= e(media_url($item['image'] ?? '')) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                                </a>
                                                <div class="order-item-info">
                                                    <a href="<?= BASE_URL ?>product/detail/<?= $item['product_id'] ?>" class="order-item-name">
                                                        <?= htmlspecialchars($item['product_name']) ?>
                                                    </a>
                                                    <div class="order-item-qty">
                                                        Số lượng: <?= $item['quantity'] ?>
                                                    </div>
                                                </div>
                                                <div class="order-item-price">
                                                    <?= number_format($item['subtotal']) ?>đ
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <!-- Order Summary (dọc bên phải) -->
                                        <div class="order-summary-inline">
                                            <div class="summary-row summary-total">
                                                <span class="summary-label">Tổng cộng:</span>
                                                <span class="summary-value"><?= number_format($order['total']) ?>đ</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Footer -->
                                    <div class="order-footer">
                                        <div class="order-info-text">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Đơn hàng #<?= $order['order_id'] ?></span>
                                        </div>
                                        <?php if (in_array($order['status'], ['pending', 'processing'])): ?>
                                            <button class="btn-order btn-cancel" onclick="confirmCancelOrder(<?= $order['order_id'] ?>)">
                                                <i class="fas fa-times-circle"></i> Hủy đơn hàng
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h4>Chưa có đơn hàng nào</h4>
                                <p>Bạn chưa có đơn hàng nào. Hãy khám phá và mua sắm ngay!</p>
                                <a href="<?= BASE_URL ?>product" class="btn btn-order btn-reorder mt-3">
                                    <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter orders by status
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const status = this.dataset.status;
        const orders = document.querySelectorAll('.order-card');

        orders.forEach(order => {
            if (status === 'all' || order.dataset.status === status) {
                order.style.display = 'block';
            } else {
                order.style.display = 'none';
            }
        });
    });
});

// Confirm cancel order
async function confirmCancelOrder(orderId) {
    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
        return;
    }

    try {
        const formData = new FormData();
        formData.append('order_id', orderId);

        const response = await fetch('<?= BASE_URL ?>order/cancelOrder', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message || 'Đã hủy đơn hàng thành công!');
            location.reload(); // Reload page để cập nhật trạng thái
        } else {
            alert(result.message || 'Không thể hủy đơn hàng!');
        }
    } catch (error) {
        console.error('Error canceling order:', error);
        alert('Lỗi khi hủy đơn hàng. Vui lòng thử lại!');
    }
}
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
