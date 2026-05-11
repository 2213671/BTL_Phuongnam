<div class="card-header-actions">
    <h2 class="card-title">Đánh giá sản phẩm</h2>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Khách</th>
                    <th>Sao</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $rv): ?>
                        <tr>
                            <td>#<?= (int) ($rv['review_id'] ?? 0) ?></td>
                            <td>
                                <div class="fw-bold"><?= e($rv['product_title'] ?? '—') ?></div>
                                <span class="text-muted small">SP #<?= (int) ($rv['product_id'] ?? 0) ?></span>
                            </td>
                            <td>
                                <?= e($rv['customer_name'] ?? '') ?>
                                <div class="small text-muted"><?= e($rv['customer_email'] ?? '') ?></div>
                            </td>
                            <td><?= (int) ($rv['rating'] ?? 0) ?> / 5</td>
                            <td style="max-width:280px;" class="text-wrap text-muted"><?= e(mb_substr((string) ($rv['review_text'] ?? ''), 0, 200)) ?><?= mb_strlen((string) ($rv['review_text'] ?? '')) > 200 ? '…' : '' ?></td>
                            <td class="text-muted"><?= !empty($rv['review_date']) ? date('d/m/Y H:i', strtotime($rv['review_date'])) : '—' ?></td>
                            <td class="text-end">
                                <form action="<?= e(BASE_URL) ?>admin/deleteproductreview" method="post" style="display:inline" onsubmit="return confirm('Xóa đánh giá này?');">
                                    <input type="hidden" name="review_id" value="<?= (int) ($rv['review_id'] ?? 0) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Chưa có đánh giá.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $paginationBaseUrl = BASE_URL . 'admin/productreviews'; require APP_ROOT . '/views/admin/partials/pagination.php'; ?>
