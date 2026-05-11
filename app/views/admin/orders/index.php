<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-value"><?= $stats['total_orders'] ?? 0 ?></div>
        <div class="stat-label">Tổng đơn hàng</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-value"><?= $stats['pending_orders'] ?? 0 ?></div>
        <div class="stat-label">Chờ xử lý</div>
    </div>
    <div class="stat-card info">
        <div class="stat-value"><?= $stats['processing_orders'] ?? 0 ?></div>
        <div class="stat-label">Đang xử lý</div>
    </div>
    <div class="stat-card success">
        <div class="stat-value"><?= $stats['completed_orders'] ?? 0 ?></div>
        <div class="stat-label">Hoàn thành</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-value"><?= $stats['cancelled_orders'] ?? 0 ?></div>
        <div class="stat-label">Đã hủy</div>
    </div>
    <div class="stat-card primary">
        <div class="stat-value"><?= number_format($stats['total_revenue'] ?? 0) ?>đ</div>
        <div class="stat-label">Tổng doanh thu</div>
    </div>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <div class="card-header-actions">
        <h2 class="card-title">Danh sách đơn hàng</h2>
    </div>

    <!-- Search & Filter -->
    <div style="padding: 20px 25px; border-bottom: 1px solid #e0e0e0; background: #f9fafb;">
        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input type="text"
                       id="searchOrder"
                       placeholder="🔍 Tìm kiếm theo Mã ĐH, tên khách hàng, email hoặc SĐT..."
                       style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
            </div>
            <div style="min-width: 180px;">
                <select id="filterStatus"
                        style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending">Chờ xử lý</option>
                    <option value="processing">Đang xử lý</option>
                    <option value="shipped">Đang giao</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>
            <div style="min-width: 180px;">
                <select id="filterPayment"
                        style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    <option value="">Tất cả thanh toán</option>
                    <?php
                    $paymentMethods = [];
                    foreach($orders as $o) {
                        if (!empty($o['payment_method']) && !in_array($o['payment_method'], $paymentMethods)) {
                            $paymentMethods[] = $o['payment_method'];
                        }
                    }
                    foreach($paymentMethods as $method):
                    ?>
                        <option value="<?= htmlspecialchars($method) ?>"><?= htmlspecialchars($method) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button onclick="resetOrderFilters()"
                    style="padding: 10px 20px; background: #64748b; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">
                <i class="fas fa-redo"></i> Reset
            </button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Liên hệ</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phí ship</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td class="fw-bold">#<?= $order['order_id'] ?></td>
                        <td><?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?></td>
                        <td>
                            <div><?= htmlspecialchars($order['customer_phone'] ?? 'N/A') ?></div>
                            <div class="text-muted" style="font-size: 12px;"><?= htmlspecialchars($order['customer_email'] ?? '') ?></div>
                        </td>
                        <td><?= date('d/m/Y', strtotime($order['created_date'])) ?></td>
                        <td class="text-danger fw-bold"><?= number_format($order['total']) ?>đ</td>
                        <td><?= number_format($order['shipping_fee']) ?>đ</td>
                        <td>
                            <span class="badge" style="background: #e0e7ff; color: #3730a3;">
                                <?= htmlspecialchars($order['payment_method'] ?? 'N/A') ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            $statusClass = match($order['status']) {
                                'pending' => 'pending',
                                'processing' => 'processing',
                                'shipped' => 'shipped',
                                'completed' => 'completed',
                                'cancelled' => 'cancelled',
                                default => 'pending'
                            };
                            $statusText = match($order['status']) {
                                'pending' => 'Chờ xử lý',
                                'processing' => 'Đang xử lý',
                                'shipped' => 'Đang giao',
                                'completed' => 'Hoàn thành',
                                'cancelled' => 'Đã hủy',
                                default => $order['status']
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/orderDetail/<?= $order['order_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Chi tiết
                            </a>
                            <a href="<?= BASE_URL ?>admin/deleteOrder?id=<?= $order['order_id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (empty($orders)): ?>
                    <tr class="no-results-row">
                        <td colspan="9" class="text-center" style="padding: 40px;">Chưa có đơn hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $paginationBaseUrl = BASE_URL . 'admin/orders'; require APP_ROOT . '/views/admin/partials/pagination.php'; ?>

<script>
// Search and Filter functionality for Orders
const searchOrderInput = document.getElementById('searchOrder');
const statusFilter = document.getElementById('filterStatus');
const paymentFilter = document.getElementById('filterPayment');
const tbody = document.querySelector('tbody');
const orderRows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.classList.contains('no-results-row'));

function filterOrders() {
    const searchTerm = searchOrderInput.value.toLowerCase();
    const selectedStatus = statusFilter.value.toLowerCase();
    const selectedPayment = paymentFilter.value.toLowerCase();

    let visibleCount = 0;

    orderRows.forEach(row => {
        // Get row data
        const orderId = row.cells[0]?.textContent.toLowerCase() || '';
        const customerName = row.cells[1]?.textContent.toLowerCase() || '';
        const contactInfo = row.cells[2]?.textContent.toLowerCase() || '';
        const paymentMethod = row.cells[6]?.textContent.toLowerCase() || '';
        const statusBadge = row.cells[7]?.querySelector('.badge');
        const statusClass = statusBadge?.classList[1] || '';

        // Check search term (order ID, customer name, email, or phone)
        const matchesSearch = !searchTerm ||
                              orderId.includes(searchTerm) ||
                              customerName.includes(searchTerm) ||
                              contactInfo.includes(searchTerm);

        // Check status filter
        const matchesStatus = !selectedStatus || statusClass === selectedStatus;

        // Check payment filter
        const matchesPayment = !selectedPayment || paymentMethod.includes(selectedPayment);

        // Show/hide row
        if (matchesSearch && matchesStatus && matchesPayment) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Update or create "no results" message
    let noResultsRow = tbody.querySelector('.no-results-row');

    if (visibleCount === 0) {
        // Create no results row only if it doesn't exist
        if (!noResultsRow) {
            noResultsRow = document.createElement('tr');
            noResultsRow.className = 'no-results-row';
            noResultsRow.innerHTML = '<td colspan="9" class="text-center" style="padding: 40px;">Không có kết quả phù hợp</td>';
            tbody.appendChild(noResultsRow);
        }
        noResultsRow.style.display = '';
    } else {
        // Hide no results row if it exists
        if (noResultsRow) {
            noResultsRow.style.display = 'none';
        }
    }
}

function resetOrderFilters() {
    searchOrderInput.value = '';
    statusFilter.value = '';
    paymentFilter.value = '';
    filterOrders();
}

// Add event listeners
searchOrderInput.addEventListener('input', filterOrders);
statusFilter.addEventListener('change', filterOrders);
paymentFilter.addEventListener('change', filterOrders);
</script>
