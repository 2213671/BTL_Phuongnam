<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tin tức</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <h1 class="page-title">Tin tức & Bài viết</h1>

    <!-- Search Section -->
    <div class="search-section">
        <form method="GET" action="<?= BASE_URL ?>news" class="search-form">
            <?php if (($category ?? '') !== '' && ($category ?? '') !== 'all'): ?>
                <input type="hidden" name="category" value="<?= e($category) ?>">
            <?php endif; ?>
            <?php if (($sort ?? '') !== ''): ?>
                <input type="hidden" name="sort" value="<?= e($sort) ?>">
            <?php endif; ?>
            <div class="search-input">
                <input type="text" 
                       name="search" 
                       placeholder="Tìm kiếm bài viết, tiêu đề, nội dung..." 
                       value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button type="submit" class="btn" style="background-color: var(--phuongnam-red); color: white; border: none; padding: 8px 20px; border-radius: 4px;">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </form>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <i class="fas fa-filter"></i>
            <h2 class="h6 mb-0 fw-semibold text-body">Danh mục bài viết</h2>
        </div>
        <div class="category-filter">
            <?php
            $newsCatLabels = [
                'kien-thuc' => 'Kiến thức',
                'van-hoa' => 'Văn hóa đọc',
                'giao-duc' => 'Giáo dục',
                'khuyen-mai' => 'Khuyến mãi',
                'doi-song' => 'Đời sống',
                'su-kien' => 'Sự kiện',
                'meo-hay' => 'Mẹo hay',
                'cong-nghe' => 'Công nghệ',
                'ky-nang' => 'Kỹ năng sống',
                'sach-hay' => 'Sách hay',
            ];
            $newsFilterBase = ['search' => $search ?? '', 'sort' => $sort ?? ''];
            $allNewsQs = listing_http_build_query(array_filter($newsFilterBase, static fn($v) => $v !== '' && $v !== null));
            ?>
            <a href="<?= $allNewsQs !== '' ? '?' . e($allNewsQs) : '?' ?>" class="category-btn <?= (($category ?? '') === '' || ($category ?? '') === 'all') ? 'active' : '' ?>">Tất cả</a>
            <?php foreach ($categories ?? [] as $crow): ?>
                <?php
                $slug = trim((string) ($crow['category'] ?? ''));
                if ($slug === '') {
                    continue;
                }
                $label = $newsCatLabels[$slug] ?? ucwords(str_replace('-', ' ', $slug));
                $qs = listing_http_build_query(array_merge(
                    array_filter($newsFilterBase, static fn($v) => $v !== '' && $v !== null),
                    ['category' => $slug]
                ));
                ?>
                <a href="?<?= e($qs) ?>" class="category-btn <?= ($category ?? '') === $slug ? 'active' : '' ?>"><?= e($label) ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Sort and Results Info -->
    <div class="sort-section">
        <div class="results-info">
            <strong><?= $totalArticles ?></strong> bài viết
            <?php if (!empty($search)): ?>
                cho từ khóa "<strong><?= htmlspecialchars($search) ?></strong>"
            <?php endif; ?>
            <?php if (!empty($category) && ($category ?? '') !== 'all'): ?>
                trong danh mục <strong><?= e($newsCatLabels[$category] ?? ucwords(str_replace('-', ' ', $category))) ?></strong>
            <?php endif; ?>
        </div>
        <div class="sort-options">
            <select name="sort" id="sortSelect" onchange="handleSortChange(this.value)">
                <option value="date-new" <?= (($sort ?? '') === '' || ($sort ?? '') === 'date-new') ? 'selected' : '' ?>>Ngày đăng: Mới nhất</option>
                <option value="date-old" <?= (($sort ?? '') === 'date-old') ? 'selected' : '' ?>>Ngày đăng: Cũ nhất</option>
                <option value="views" <?= (($sort ?? '') === 'views') ? 'selected' : '' ?>>Lượt xem</option>
                <option value="comments" <?= (($sort ?? '') === 'comments') ? 'selected' : '' ?>>Bình luận</option>
                <option value="title-asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'title-asc') ? 'selected' : '' ?>>Tiêu đề: A-Z</option>
                <option value="title-desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'title-desc') ? 'selected' : '' ?>>Tiêu đề: Z-A</option>
            </select>
        </div>
    </div>

    <!-- News Grid -->
    <?php if (!empty($articles)): ?>
        <div class="news-grid">
            <?php foreach ($articles as $article): ?>
                <a href="<?= BASE_URL ?>news/detail/<?= $article['id'] ?>" class="news-card">
                    <div class="news-image">
                        <img src="<?= e(pn_public_image_src($article['image_url'] ?? '')) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                    </div>
                    <div class="news-content">
                        <div class="news-category"><?= ucfirst(str_replace('-', ' ', ($article['category'] ?? 'Tin tức'))) ?></div>
                        <h3 class="news-title"><?= htmlspecialchars($article['title']) ?></h3>
                        <p class="news-summary"><?= htmlspecialchars($article['summary'] ?? '') ?></p>
                        <div class="news-meta">
                            <div class="news-author"><?= htmlspecialchars($article['author_name'] ?? 'Admin') ?></div>
                            <div class="news-date"><?= date('d/m/Y', strtotime($article['published_date'] ?? $article['created_at'])) ?></div>
                            <div class="news-stats">
                                <span title="Lượt xem"><i class="fas fa-eye"></i> <?= $article['views'] ?? 0 ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1):
            $newsNavBase = ['search' => $search ?? '', 'sort' => $sort ?? ''];
            if (($category ?? '') !== '' && ($category ?? '') !== 'all') {
                $newsNavBase['category'] = $category;
            }
            $newsNavBase = array_filter($newsNavBase, static fn($v) => $v !== '' && $v !== null);
            $visibleNewsPages = pagination_visible_pages((int) $currentPage, (int) $totalPages, 2);
            ?>
            <nav class="pagination" aria-label="Phân trang tin tức">
                <div class="pagination-meta">
                    Trang <strong><?= (int) $currentPage ?></strong> / <strong><?= (int) $totalPages ?></strong>
                    — <?= (int) $totalArticles ?> bài
                </div>
                <ul class="pagination-list">
                    <?php if ((int) $currentPage > 1):
                        $pq = listing_http_build_query(array_merge($newsNavBase, ['page' => (int) $currentPage - 1]));
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?= e($pq) ?>" aria-label="Trang trước">‹ Trước</a>
                        </li>
                    <?php endif; ?>
                    <?php foreach ($visibleNewsPages as $pi): ?>
                        <?php if ($pi === -1): ?>
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        <?php else:
                            $pq = listing_http_build_query(array_merge($newsNavBase, ['page' => $pi]));
                            ?>
                            <li class="page-item <?= ($pi === (int) $currentPage) ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= e($pq) ?>"><?= (int) $pi ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ((int) $currentPage < (int) $totalPages):
                        $pq = listing_http_build_query(array_merge($newsNavBase, ['page' => (int) $currentPage + 1]));
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?= e($pq) ?>" aria-label="Trang sau">Sau ›</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="no-results">
            <i class="fas fa-search"></i>
            <p class="news-no-results-title">Không tìm thấy bài viết nào</p>
            <p>Vui lòng thử lại với từ khóa khác</p>
        </div>
    <?php endif; ?>
</div>

<script>
    function handleSortChange(sortValue) {
        const urlParams = new URLSearchParams(window.location.search);
        if (sortValue) {
            urlParams.set('sort', sortValue);
        } else {
            urlParams.delete('sort');
        }
        urlParams.delete('page'); // Reset page when sorting
        window.location.search = urlParams.toString();
    }
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
