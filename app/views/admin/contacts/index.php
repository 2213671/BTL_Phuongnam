<div class="col-12">
    <div class="card">

        <div class="card-header">
            <h2 class="card-title h5">Danh sách liên hệ từ khách hàng</h2>
        </div>

        
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th class="w-1">ID</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Nội dung / Lời nhắn</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contacts)): ?>
                        <?php foreach($contacts as $contact): ?>
                        <tr>
                            <td><span class="text-secondary">#<?= $contact['id'] ?></span></td>
                            
                            <td>
                    <div class="font-weight-medium">
                        <?= htmlspecialchars($contact['fullname'] ?? $contact['name'] ?? 'Khách ẩn danh') ?>
                    </div>
                </td>

                            <td>
                                <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-reset">
                                    <?= htmlspecialchars($contact['email']) ?>
                                </a>
                            </td>

                            <td>
                                <?= htmlspecialchars($contact['phone'] ?? '') ?>
                            </td>

                            <td class="text-muted text-wrap" style="max-width: 300px;">
                                <?= htmlspecialchars($contact['message'] ?? 'Không có nội dung') ?>
                            </td>

                            <td class="text-muted">
                                <?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?>
                            </td>

                            <td>
                                <?php $st = $contact['status'] ?? 'New'; ?>
                                <span class="badge <?= ($st === 'Processed') ? 'bg-success' : 'bg-secondary' ?>"><?= htmlspecialchars($st) ?></span>
                                <?php if (!empty($contact['read_at'])): ?>
                                    <div class="small text-muted"><?= date('d/m/Y H:i', strtotime($contact['read_at'])) ?></div>
                                <?php endif; ?>
                                <?php if ($st !== 'Processed'): ?>
                                    <form action="<?= BASE_URL ?>admin/contacts" method="POST" class="mt-1">
                                        <input type="hidden" name="contact_id" value="<?= (int) $contact['id'] ?>">
                                        <input type="hidden" name="contact_mark" value="processed">
                                        <button type="submit" class="btn btn-sm btn-outline-success">Đánh dấu đã xử lý</button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?= BASE_URL ?>admin/contacts" method="POST" class="mt-1">
                                        <input type="hidden" name="contact_id" value="<?= (int) $contact['id'] ?>">
                                        <input type="hidden" name="contact_mark" value="new">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Mở lại</button>
                                    </form>
                                <?php endif; ?>
                            </td>

                            <td class="text-end">
                                <form action="<?= BASE_URL ?>admin/deleteContact" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa liên hệ này?');">
                                    <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox fa-3x text-muted"></i>
                                </div>
                                <p class="empty-title">Chưa có liên hệ nào</p>
                                <p class="text-muted">Danh sách liên hệ từ khách hàng sẽ hiển thị tại đây.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $paginationBaseUrl = BASE_URL . 'admin/contacts'; require APP_ROOT . '/views/admin/partials/pagination.php'; ?>
