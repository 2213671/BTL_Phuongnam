<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Quản lý Nhân viên</h2>
        <a href="<?= BASE_URL ?>admin/createStaff" class="add-staff-btn">
            <i class="fas fa-plus"></i> Thêm nhân viên mới
        </a>
    </div>

    <?php if (empty($staff)): ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h4>Chưa có nhân viên nào</h4>
            <p>Hãy thêm nhân viên đầu tiên để bắt đầu quản lý.</p>
            <a href="<?= BASE_URL ?>admin/createStaff" class="add-staff-btn">
                <i class="fas fa-plus"></i> Thêm nhân viên mới
            </a>
        </div>
    <?php else: ?>
        <div class="staff-table">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staff as $member): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($member['user_id']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($member['fullname']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($member['email']) ?></td>
                            <td><?= htmlspecialchars($member['phone'] ?? 'Chưa cập nhật') ?></td>
                            <td>
                                <span class="role-badge role-<?= $member['role'] ?>">
                                    <?= $member['role'] === 'admin' ? 'Quản trị viên' : 'Nhân viên' ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($member['created_date'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= BASE_URL ?>admin/editStaff/<?= $member['user_id'] ?>" 
                                       class="btn-action btn-edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($member['role'] !== 'admin' || $_SESSION['users_id'] != $member['user_id']): ?>
                                        <a href="<?= BASE_URL ?>admin/deleteStaff?id=<?= $member['user_id'] ?>" 
                                           class="btn-action btn-delete" 
                                           onclick="return confirm('Bạn có chắc muốn xóa nhân viên này?')" 
                                           title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <p class="text-muted mb-2">Hiển thị: <strong><?= count($staff) ?></strong> nhân viên trên trang này</p>
            <?php $paginationBaseUrl = BASE_URL . 'admin/staff'; $paginationShowSummary = false; require APP_ROOT . '/views/admin/partials/pagination.php'; unset($paginationShowSummary); ?>
        </div>
    <?php endif; ?>
</div>