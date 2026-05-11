<?php
/** @var array $pagination — kết quả AdminController::buildPagination */
/** @var string $paginationBaseUrl — ví dụ BASE_URL . 'admin/news' */
/** @var bool $paginationShowSummary — hiển thị dòng "Trang x / y" (mặc định true) */
if (empty($pagination) || (int) ($pagination['total_pages'] ?? 0) <= 1) {
    return;
}
$current = (int) ($pagination['current_page'] ?? 1);
$total = (int) ($pagination['total_pages'] ?? 1);
$totalRows = (int) ($pagination['total'] ?? 0);
$perPage = (int) ($pagination['per_page'] ?? 10);
$pages = pagination_visible_pages($current, $total, 2);
$baseUrl = $paginationBaseUrl ?? (BASE_URL . 'admin/news');
$showSummary = !isset($paginationShowSummary) || $paginationShowSummary;
?>
<nav class="mt-3 d-flex flex-wrap <?= $showSummary ? 'justify-content-between' : 'justify-content-end' ?> align-items-center gap-2" aria-label="Phân trang">
    <?php if ($showSummary): ?>
    <span class="text-muted small">
        Trang <?= $current ?> / <?= $total ?>
        <?php if ($totalRows > 0): ?>
            — <?= $totalRows ?> mục<?= $perPage > 0 ? ' (' . $perPage . '/trang)' : '' ?>
        <?php endif; ?>
    </span>
    <?php endif; ?>
    <ul class="pagination mb-0 flex-wrap">
        <?php if ($current > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?= e(rtrim($baseUrl, '?&')) ?>?page=<?= $current - 1 ?>" aria-label="Trang trước">‹</a>
            </li>
        <?php endif; ?>
        <?php foreach ($pages as $p): ?>
            <?php if ($p === -1): ?>
                <li class="page-item disabled"><span class="page-link">…</span></li>
            <?php else: ?>
                <li class="page-item <?= $p === $current ? 'active' : '' ?>">
                    <a class="page-link" href="<?= e(rtrim($baseUrl, '?&')) ?>?page=<?= (int) $p ?>"><?= (int) $p ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($current < $total): ?>
            <li class="page-item">
                <a class="page-link" href="<?= e(rtrim($baseUrl, '?&')) ?>?page=<?= $current + 1 ?>" aria-label="Trang sau">›</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
