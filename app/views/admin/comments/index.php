<div class="card">
    <div class="card-header">
        <h2 class="card-title h5">Quản lý bình luận</h2>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bài viết</th>
                    <th>Người dùng</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td>#<?= (int) $comment['id'] ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>news/detail/<?= (int) $comment['news_id'] ?>" target="_blank">
                                    <?= htmlspecialchars($comment['news_title']) ?>
                                </a>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($comment['user_name']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($comment['user_email']) ?></small>
                            </td>
                            <td style="max-width: 380px;" class="text-wrap"><?= htmlspecialchars($comment['content']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                            <td>
                                <form method="POST" action="<?= BASE_URL ?>admin/deleteComment" onsubmit="return confirm('Xóa bình luận này?');">
                                    <input type="hidden" name="id" value="<?= (int) $comment['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4">Chưa có bình luận</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (!empty($pagination) && (int) ($pagination['total_pages'] ?? 0) > 1): ?>
    <div class="card-footer py-2">
        <?php $paginationBaseUrl = BASE_URL . 'admin/comments'; require APP_ROOT . '/views/admin/partials/pagination.php'; ?>
    </div>
    <?php endif; ?>
</div>
