<!-- Order Detail Modal -->
<div id="orderDetailModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h3><i class="fas fa-receipt"></i> Chi tiết đơn hàng</h3>
            <button class="modal-close" onclick="closeOrderDetailModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="orderDetailContent">
            <div class="loading-spinner">
                <i class="fas fa-circle-notch"></i>
                <div class="loading-text">Đang tải thông tin đơn hàng...</div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal Functions
function openOrderDetailModal(orderId) {
    const modal = document.getElementById('orderDetailModal');
    const content = document.getElementById('orderDetailContent');

    // Show modal with loading state
    modal.classList.add('active');
    content.innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-circle-notch"></i>
            <div class="loading-text">Đang tải thông tin đơn hàng...</div>
        </div>
    `;

    // Fetch order details (for now, show sample data)
    // TODO: Replace with actual AJAX call to fetch order details
    setTimeout(() => {
        loadOrderDetails(orderId);
    }, 500);
}

function closeOrderDetailModal() {
    const modal = document.getElementById('orderDetailModal');
    modal.classList.remove('active');
}

async function loadOrderDetails(orderId) {
    const content = document.getElementById('orderDetailContent');

    try {
        const response = await fetch(`<?= BASE_URL ?>admin/getOrderDetailAjax?order_id=${orderId}`);
        const result = await response.json();

        if (!result.success) {
            content.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #ef4444;">
                    <i class="fas fa-exclamation-circle" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <div>${result.message || 'Lỗi khi tải thông tin đơn hàng'}</div>
                </div>
            `;
            return;
        }

        const order = result.order;
        const items = result.items;

        // Format date
        const orderDate = new Date(order.created_date);
        const formattedDate = orderDate.toLocaleDateString('vi-VN');

        // Build items HTML
        let itemsHtml = '';
        items.forEach(item => {
            const imageUrl = item.image_url ? `<?= BASE_URL ?>${item.image_url}` : `<?= e(media_url('media/products/default-book.jpg')) ?>`;
            itemsHtml += `
                <div class="order-item-card">
                    <img src="${imageUrl}" alt="${item.title}" class="item-image">
                    <div class="item-details">
                        <div class="item-name">${item.title}</div>
                        <div class="item-meta">
                            <span><i class="fas fa-shopping-cart"></i> Số lượng: ${item.quantity}</span> •
                            <span><i class="fas fa-tag"></i> Đơn giá: ${Number(item.price).toLocaleString('vi-VN')}đ</span>
                        </div>
                    </div>
                    <div class="item-price">${Number(item.subtotal).toLocaleString('vi-VN')}đ</div>
                </div>
            `;
        });

        content.innerHTML = `
            <div class="order-info-grid">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-hashtag"></i> Mã đơn hàng</div>
                    <div class="info-value">#${order.order_id}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-calendar"></i> Ngày đặt</div>
                    <div class="info-value">${formattedDate}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-user"></i> Người nhận</div>
                    <div class="info-value">${order.recipient_name}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-phone"></i> Số điện thoại</div>
                    <div class="info-value">${order.recipient_phone}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-credit-card"></i> Thanh toán</div>
                    <div class="info-value">${order.payment_method}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-info-circle"></i> Trạng thái</div>
                    <div class="info-value">
                        <span class="badge ${order.status} status-badge-large">${order.status_text}</span>
                    </div>
                </div>
            </div>

            <div class="shipping-address">
                <div class="address-title"><i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng</div>
                <div class="address-content">${order.shipping_address}</div>
            </div>

            ${order.note ? `
                <div class="shipping-address" style="border-left-color: #f59e0b; margin-top: 15px;">
                    <div class="address-title"><i class="fas fa-sticky-note"></i> Ghi chú</div>
                    <div class="address-content">${order.note}</div>
                </div>
            ` : ''}

            <div class="order-items-section">
                <div class="section-title">
                    <i class="fas fa-box"></i> Sản phẩm đã đặt
                </div>
                ${itemsHtml}
            </div>

            <div class="order-summary">
                <div class="summary-row">
                    <span class="label"><i class="fas fa-list"></i> Tạm tính:</span>
                    <span class="value">${Number(order.subtotal).toLocaleString('vi-VN')}đ</span>
                </div>
                <div class="summary-row">
                    <span class="label"><i class="fas fa-truck"></i> Phí vận chuyển:</span>
                    <span class="value">${Number(order.shipping_fee).toLocaleString('vi-VN')}đ</span>
                </div>
                <div class="summary-row total">
                    <span class="label"><i class="fas fa-receipt"></i> TỔNG CỘNG:</span>
                    <span class="value">${Number(order.total).toLocaleString('vi-VN')}đ</span>
                </div>
            </div>
        `;
    } catch (error) {
        console.error('Error loading order details:', error);
        content.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #ef4444;">
                <i class="fas fa-exclamation-circle" style="font-size: 48px; margin-bottom: 15px;"></i>
                <div>Lỗi khi tải thông tin đơn hàng. Vui lòng thử lại!</div>
            </div>
        `;
    }
}

// Close modal when clicking outside
document.getElementById('orderDetailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrderDetailModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeOrderDetailModal();
    }
});
</script>
