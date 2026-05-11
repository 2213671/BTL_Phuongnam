<div class="card-header-actions">
    <h2 class="card-title">Chi tiết khách hàng</h2>
    <a href="<?= BASE_URL ?>admin/customers" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<?php if (!empty($customer_flash_errors ?? [])): ?>
<div class="alert alert-danger mb-3" role="alert">
    <ul class="mb-0">
        <?php foreach ($customer_flash_errors as $err): ?>
            <li><?= htmlspecialchars((string) $err, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<?php if (!empty($customer_flash_success ?? '')): ?>
<div class="alert alert-success mb-3" role="alert"><?= htmlspecialchars((string) $customer_flash_success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<!-- Thông tin khách hàng -->
<div class="admin-card">
    <div class="card-body">
        <div class="customer-header">
            <div class="customer-avatar-large" style="overflow:hidden;padding:0;">
                <?php
                $cad = trim((string) ($customer['avatar'] ?? ''));
                if ($cad !== '' && function_exists('pn_is_local_media_path') && pn_is_local_media_path($cad)): ?>
                    <img src="<?= e(media_url($cad)) ?>" alt="" style="width:80px;height:80px;object-fit:cover;display:block;">
                <?php else: ?>
                    <?= strtoupper(substr($customer['fullname'], 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div class="customer-header-info">
                <h2><?= htmlspecialchars($customer['fullname']) ?></h2>
                <div>
                    <?php
                    $memberType = strtolower($customer['member_type'] ?? 'bronze');
                    $memberClass = match($memberType) {
                        'gold' => 'gold',
                        'silver' => 'silver',
                        'diamond' => 'diamond',
                        default => 'bronze'
                    };
                    $memberText = match($memberType) {
                        'gold' => 'Thành viên Vàng',
                        'silver' => 'Thành viên Bạc',
                        'diamond' => 'Thành viên Kim cương',
                        default => 'Thành viên Đồng'
                    };
                    ?>
                    <span class="badge <?= $memberClass ?>"><?= $memberText ?></span>
                </div>
            </div>
        </div>

        <!-- Thống kê -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value" style="color: #3b82f6;"><?= $stats['total_orders'] ?? 0 ?></div>
                <div class="stat-label">Tổng đơn hàng</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #10b981;"><?= $stats['completed_orders'] ?? 0 ?></div>
                <div class="stat-label">Đơn hoàn thành</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #f59e0b;"><?= $stats['pending_orders'] ?? 0 ?></div>
                <div class="stat-label">Đơn chờ xử lý</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #c92127;"><?= number_format($stats['total_spent'] ?? 0) ?>đ</div>
                <div class="stat-label">Tổng chi tiêu</div>
            </div>
        </div>

        <?php $acctSt = strtolower((string) ($customer['account_status'] ?? 'active')); ?>
        <div style="margin-bottom:24px;padding:20px;background:#fffbeb;border-radius:12px;border:1px solid #fcd34d;">
            <h3 style="font-size:15px;font-weight:600;margin-bottom:12px;"><i class="fas fa-user-shield"></i> Quản trị tài khoản</h3>
            <p class="mb-2">Trạng thái đăng nhập:
                <?php if ($acctSt === 'locked'): ?>
                    <strong class="text-danger">Đã khóa</strong>
                <?php else: ?>
                    <strong class="text-success">Đang hoạt động</strong>
                <?php endif; ?>
            </p>
            <div class="d-flex flex-wrap gap-2 align-items-end mb-3">
                <form method="post" action="<?= BASE_URL ?>admin/customerDetail/<?= (int) $customer['user_id'] ?>" class="d-inline">
                    <input type="hidden" name="customer_admin_action" value="toggle_lock">
                    <input type="hidden" name="next_status" value="<?= $acctSt === 'locked' ? 'active' : 'locked' ?>">
                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Thay đổi trạng thái khóa tài khoản?');">
                        <?= $acctSt === 'locked' ? 'Mở khóa đăng nhập' : 'Khóa đăng nhập' ?>
                    </button>
                </form>
            </div>
            <form method="post" action="<?= BASE_URL ?>admin/customerDetail/<?= (int) $customer['user_id'] ?>" class="row g-2 align-items-end" style="max-width:520px;">
                <input type="hidden" name="customer_admin_action" value="reset_password">
                <div class="col-md-7">
                    <label class="form-label small mb-0">Đặt lại mật khẩu khách (tối thiểu 6 ký tự)</label>
                    <input type="password" name="new_password" class="form-control form-control-sm" minlength="6" autocomplete="new-password" required placeholder="Mật khẩu mới">
                </div>
                <div class="col-md-5">
                    <button type="submit" class="btn btn-primary btn-sm w-100" onclick="return confirm('Reset mật khẩu cho khách này?');">Reset mật khẩu</button>
                </div>
            </form>
        </div>

        <!-- Thông tin chi tiết -->
        <div class="info-grid">
            <div>
                <h3 style="font-size: 14px; font-weight: 600; color: #666; text-transform: uppercase; margin-bottom: 15px;">Thông tin liên hệ</h3>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?= htmlspecialchars($customer['email']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-value"><?= htmlspecialchars($customer['phone'] ?? 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Địa chỉ:</span>
                    <span class="info-value"><?= htmlspecialchars($customer['note'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div>
                <h3 style="font-size: 14px; font-weight: 600; color: #666; text-transform: uppercase; margin-bottom: 15px;">Thông tin tài khoản</h3>
                <div class="info-row">
                    <span class="info-label">ID:</span>
                    <span class="info-value">#<?= $customer['user_id'] ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Điểm tích lũy:</span>
                    <span class="info-value" style="color: #f59e0b;">In progress</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ngày tham gia:</span>
                    <span class="info-value"><?= date('d/m/Y', strtotime($customer['created_date'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lịch sử đơn hàng -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Lịch sử đơn hàng</h3>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Ngày đặt</th>
                    <th>Số sản phẩm</th>
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
                        <td><?= date('d/m/Y H:i', strtotime($order['created_date'])) ?></td>
                        <td><?= $order['total_items'] ?? 0 ?> sản phẩm</td>
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
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Khách hàng chưa có đơn hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
