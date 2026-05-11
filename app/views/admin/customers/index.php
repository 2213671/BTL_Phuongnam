<div class="admin-card">
    <div class="card-header-actions">
        <h2 class="card-title">Danh sách khách hàng</h2>
    </div>

    <!-- Search & Filter -->
    <div style="padding: 20px 25px; border-bottom: 1px solid #e0e0e0; background: #f9fafb;">
        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input type="text"
                       id="searchCustomer"
                       placeholder="🔍 Tìm kiếm theo ID, tên, email hoặc SĐT..."
                       style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
            </div>
            <button onclick="resetCustomerFilters()"
                    style="padding: 10px 20px; background: #64748b; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">
                <i class="fas fa-redo"></i> Reset
            </button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Tổng đơn hàng</th>
                    <th>Tổng chi tiêu</th>
                    <th>Trạng thái TK</th>
                    <th>Ngày tham gia</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php foreach($customers as $customer): ?>
                    <tr>
                        <td class="fw-bold"><?= $customer['user_id'] ?></td>
                        <td>
                            <div class="customer-info">
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($customer['fullname']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($customer['email']) ?></td>
                        <td><?= htmlspecialchars($customer['phone'] ?? 'N/A') ?></td>
                        <td><?= $customer['total_orders'] ?? 0 ?> đơn</td>
                        <td class="text-danger fw-bold">
                            <?= number_format($customer['total_spent'] ?? 0) ?>đ
                        </td>
                        <td>
                            <?php $ast = strtolower((string) ($customer['account_status'] ?? 'active')); ?>
                            <?php if ($ast === 'locked'): ?>
                                <span class="badge" style="background:#fee2e2;color:#991b1b;">Đã khóa</span>
                            <?php else: ?>
                                <span class="badge" style="background:#d1fae5;color:#065f46;">Hoạt động</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $customer['created_date'] ? date('d/m/Y', strtotime($customer['created_date'])) : 'N/A' ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/customerDetail/<?= $customer['user_id'] ?>"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> 
                            </a>
                            <!-- <a href="<?= BASE_URL ?>admin/deleteCustomer?id=<?= $customer['user_id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc muốn xóa khách hàng này? Tất cả đơn hàng liên quan sẽ bị ảnh hưởng!')">
                                <i class="fas fa-trash"></i> Xóa
                            </a> -->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (empty($customers)): ?>
                    <tr class="no-results-row">
                        <td colspan="11" class="text-center" style="padding: 40px;">Chưa có khách hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $paginationBaseUrl = BASE_URL . 'admin/customers'; require APP_ROOT . '/views/admin/partials/pagination.php'; ?>

<script>
// Search and Filter functionality for Customers
const searchCustomerInput = document.getElementById('searchCustomer');
const tbody = document.querySelector('tbody');
const customerRows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.classList.contains('no-results-row'));

function filterCustomers() {
    const searchTerm = searchCustomerInput.value.toLowerCase();
    let visibleCount = 0;

    customerRows.forEach(row => {
        // Get row data
        const customerId = row.cells[0]?.textContent.toLowerCase() || '';
        const customerName = row.cells[1]?.textContent.toLowerCase() || '';
        const email = row.cells[2]?.textContent.toLowerCase() || '';
        const phone = row.cells[3]?.textContent.toLowerCase() || '';
        // Check search term (ID, name, email, or phone)
        const matchesSearch = !searchTerm ||
                              customerId.includes(searchTerm) ||
                              customerName.includes(searchTerm) ||
                              email.includes(searchTerm) ||
                              phone.includes(searchTerm);

        // Show/hide row
        if (matchesSearch) {
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
            noResultsRow.innerHTML = '<td colspan="10" class="text-center" style="padding: 40px;">Không có kết quả phù hợp</td>';
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

function resetCustomerFilters() {
    searchCustomerInput.value = '';
    filterCustomers();
}

// Add event listeners
searchCustomerInput.addEventListener('input', filterCustomers);
</script>
