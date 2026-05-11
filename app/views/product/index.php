<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <h1 class="page-title">Danh sách sản phẩm</h1>

    <!-- Search Section -->
    <div class="search-section">
        <form method="GET" action="<?= BASE_URL ?>product" class="search-form">
            <?php if (!empty($selectedCategory) && $selectedCategory !== 'all'): ?>
                <input type="hidden" name="category" value="<?= e((string) $selectedCategory) ?>">
            <?php endif; ?>
            <?php if (($selectedSort ?? '') !== ''): ?>
                <input type="hidden" name="sort" value="<?= e((string) $selectedSort) ?>">
            <?php endif; ?>
            <div class="search-input">
                <input type="text" 
                       name="search" 
                       placeholder="Tìm kiếm sách, tác giả, thể loại..." 
                       value="<?= htmlspecialchars($search ?? '') ?>">
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
            <h2 class="h6 mb-0 fw-semibold text-body">Danh mục sản phẩm</h2>
        </div>
        <div class="category-filter">
            <?php
            $prodFilterBase = [
                'search' => $search ?? '',
                'sort' => $selectedSort ?? '',
            ];
            $prodFilterBase = array_filter($prodFilterBase, static fn($v) => $v !== '' && $v !== null);
            $allProdQs = listing_http_build_query($prodFilterBase);
            ?>
            <a href="<?= $allProdQs !== '' ? '?' . e($allProdQs) : '?' ?>" class="category-btn <?= ($selectedCategory == 'all' || $selectedCategory == '') ? 'active' : '' ?>">Tất cả</a>
            <?php foreach ($categories as $cat): ?>
                <?php
                $qs = listing_http_build_query(array_merge($prodFilterBase, ['category' => $cat['category_id']]));
                ?>
                <a href="?<?= e($qs) ?>" class="category-btn <?= (string) $selectedCategory === (string) $cat['category_id'] ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat['category_name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Sort and Results Info -->
    <div class="sort-section">
        <div class="results-info">
            <strong><?= (int) $totalProducts ?></strong> sản phẩm
            <?php if (!empty($products) && ($totalPages ?? 0) > 0): ?>
                <span class="text-muted"> — Trang <?= (int) ($currentPage ?? 1) ?> / <?= (int) ($totalPages ?? 1) ?></span>
            <?php endif; ?>
            <?php if (!empty($search)):
            ?>
                cho từ khóa "<strong><?= htmlspecialchars($search) ?></strong>"
            <?php endif;
            ?>
            <?php if (!empty($selectedCategory) && $selectedCategory != 'all'): 
            ?>
                <?php 
                    $categoryName = '';
                    foreach ($categories as $cat) {
                        if ($cat['category_id'] == $selectedCategory) {
                            $categoryName = $cat['category_name'];
                            break;
                        }
                    }
                ?>
                trong danh mục <strong><?= htmlspecialchars($categoryName) ?></strong>
            <?php endif;
            ?>
        </div>
        <div class="sort-options">
            <select name="sort" id="sortSelect" onchange="handleSortChange(this.value)">
                <option value="">Sắp xếp theo</option>
                <option value="price-asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-asc') ? 'selected' : '' ?>>Giá: Thấp đến cao</option>
                <option value="price-desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-desc') ? 'selected' : '' ?>>Giá: Cao đến thấp</option>
                <option value="name-asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name-asc') ? 'selected' : '' ?>>Tên: A-Z</option>
                <option value="name-desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name-desc') ? 'selected' : '' ?>>Tên: Z-A</option>
                <!-- <option value="rating" <?= (isset($_GET['sort']) && $_GET['sort'] == 'rating') ? 'selected' : '' ?>>Đánh giá</option> -->
            </select>
        </div>
    </div>

    <!-- Product Grid -->
    <?php if (!empty($products)): 
    ?>
        <div class="product-grid">
            <?php foreach ($products as $product):
                // Check if product has an old price and if it's greater than the current price
                $isDiscounted = isset($product['old_price']) && $product['old_price'] > $product['price'];
                $discountPercentage = $isDiscounted ? round(100 - ($product['price'] / $product['old_price']) * 100) : 0;
                // Check if product is in wishlist
                $isInWishlist = in_array($product['product_id'], $wishlistIds);
            ?>
                <div class="product-card">
                    <?php if ($isDiscounted):
                        // Display discount badge if the product is discounted
                    ?>
                        <div class="product-badge">Giảm <?= $discountPercentage ?>%</div>
                    <?php endif;
                    ?>
                    <button type="button" class="btn-wishlist <?= $isInWishlist ? 'active' : '' ?>"
                            data-product-id="<?= $product['product_id'] ?>"
                            onclick="event.stopPropagation(); toggleWishlist(this);"
                            title="<?= $isInWishlist ? 'Xóa khỏi yêu thích' : 'Thêm vào yêu thích' ?>">
                        <i class="<?= $isInWishlist ? 'fas' : 'far' ?> fa-heart"></i>
                    </button>
                    <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?>" class="product-card-link">
                        <div class="product-image">
                            <img src="<?= e(media_url($product['image_url'] ?? '')) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
                        </div>
                        <div class="product-info">
                            <p class="product-title"><?= htmlspecialchars($product['title']) ?></p>
                            <div class="product-author"><?= e($product['author'] ?? '') ?></div>
                            <div class="product-price">
                                <?= number_format($product['price']) ?>đ
                                <?php if ($isDiscounted): 
                                    // Display old price if the product is discounted
                                ?>
                                    <span class="product-old-price"><?= number_format($product['old_price']) ?>đ</span>
                                <?php endif;
                                ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach;
            ?>
        </div>

        <!-- Pagination -->
        <?php if (($totalPages ?? 0) > 1):
            $prodNavBase = [
                'search' => $search ?? '',
                'sort' => $selectedSort ?? '',
            ];
            if (!empty($selectedCategory) && $selectedCategory !== 'all') {
                $prodNavBase['category'] = $selectedCategory;
            }
            $prodNavBase = array_filter($prodNavBase, static fn($v) => $v !== '' && $v !== null);
            $visibleProdPages = pagination_visible_pages((int) $currentPage, (int) $totalPages, 2);
            ?>
            <nav class="pagination" aria-label="Phân trang sản phẩm">
                <div class="pagination-meta">
                    Trang <strong><?= (int) $currentPage ?></strong> / <strong><?= (int) $totalPages ?></strong>
                    — <?= (int) $totalProducts ?> sản phẩm
                </div>
                <ul class="pagination-list">
                    <?php if ((int) $currentPage > 1):
                        $pq = listing_http_build_query(array_merge($prodNavBase, ['page' => (int) $currentPage - 1]));
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?= e($pq) ?>" aria-label="Trang trước">‹ Trước</a>
                        </li>
                    <?php endif; ?>
                    <?php foreach ($visibleProdPages as $pi): ?>
                        <?php if ($pi === -1): ?>
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        <?php else:
                            $pq = listing_http_build_query(array_merge($prodNavBase, ['page' => $pi]));
                            ?>
                            <li class="page-item <?= ($pi === (int) $currentPage) ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= e($pq) ?>"><?= (int) $pi ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ((int) $currentPage < (int) $totalPages):
                        $pq = listing_http_build_query(array_merge($prodNavBase, ['page' => (int) $currentPage + 1]));
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?= e($pq) ?>" aria-label="Trang sau">Sau ›</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php else:
        // Display a message if no products are found
    ?>
        <div class="no-results">
            <i class="fas fa-search"></i>
            <p class="no-results-title">Không tìm thấy sản phẩm nào</p>
            <p>Vui lòng thử lại với từ khóa khác</p>
        </div>
    <?php endif;
    ?>
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

    // Toggle wishlist
    function toggleWishlist(btn) {
        const productId = btn.dataset.productId;
        const icon = btn.querySelector('i');
        const isActive = btn.classList.contains('active');

        // Optimistic UI update
        btn.disabled = true;

        const endpoint = isActive ? 'customer/removeWishlist' : 'customer/addWishlist';

        fetch('<?= BASE_URL ?>' + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + encodeURIComponent(productId)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Toggle state
                btn.classList.toggle('active');

                if (btn.classList.contains('active')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    btn.title = 'Xóa khỏi yêu thích';
                    showToast('Đã thêm vào danh sách yêu thích!', 'success');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    btn.title = 'Thêm vào yêu thích';
                    showToast('Đã xóa khỏi danh sách yêu thích!', 'info');
                }
            } else {
                showToast(data.message || 'Có lỗi xảy ra!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Không thể kết nối đến server!', 'error');
        })
        .finally(() => {
            btn.disabled = false;
        });
    }

    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'}`;
        toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease-out;';

        const iconMap = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };

        toast.innerHTML = `
            <i class="fas ${iconMap[type]} me-2"></i>
            ${message}
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add CSS animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
