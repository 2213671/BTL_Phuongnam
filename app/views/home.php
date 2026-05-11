<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<!-- Hero Section -->
<div class="container">
    <div class="hero-section" style="background-image: linear-gradient(rgba(0, 102, 179, 0.7), rgba(0, 153, 204, 0.7)), url('<?= e(asset_url(MEDIA_HOME_HERO_BG)) ?>');">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Nhà sách Phương Nam — Tri thức cho cuộc sống</h1>
                <p class="hero-subtitle">Sách trong nước và ngoại văn; đặt online, nhận tại nhà hoặc tại cửa hàng.</p>
                <a href="<?= e(site_url('home/about')) ?>" class="btn-hero">Khám phá ngay <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <?php if (!empty($featuredNews) && is_array($featuredNews)): ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        .pn-featured-swiper .swiper-slide {
            height: auto;
            display: flex;
            box-sizing: border-box;
        }
        .pn-slider-card {
            display: flex;
            gap: 1rem;
            align-items: stretch;
            width: 100%;
            height: 240px;
            box-sizing: border-box;
            padding: 1rem;
            border-radius: 8px;
            background: #fff;
            border: 1px solid rgba(0,0,0,.06);
            overflow: hidden;
        }
        .pn-slider-card > div:last-child {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .pn-slider-card h3 {
            flex-shrink: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .pn-slider-card .text-muted {
            flex: 1;
            min-height: 0;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }
    </style>
    <div class="mb-4">
        <h2 class="section-title">Tin &amp; khuyến mãi nổi bật</h2>
        <div class="swiper pn-featured-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($featuredNews as $article): ?>
                    <?php
                    $snip = trim((string) ($article['summary'] ?? ''));
                    if ($snip === '') {
                        $plain = preg_replace('/\s+/', ' ', strip_tags(str_replace(["\r", "\n"], ' ', (string) ($article['content'] ?? ''))));
                        $snip = function_exists('mb_substr') ? mb_substr($plain, 0, 130, 'UTF-8') : substr($plain, 0, 130);
                        $snip .= '…';
                    } elseif (function_exists('mb_strlen') && mb_strlen($snip, 'UTF-8') > 140) {
                        $snip = mb_substr($snip, 0, 137, 'UTF-8') . '…';
                    }
                    ?>
                    <div class="swiper-slide">
                        <div class="pn-slider-card shadow-sm">
                            <a href="<?= e(site_url('news/detail/' . (int) ($article['id'] ?? 0))) ?>" style="flex-shrink:0;">
                                <img src="<?= e(pn_public_image_src($article['image_url'] ?? '')) ?>" alt="<?= e($article['title'] ?? '') ?>" width="200" height="140" loading="lazy" style="width:200px;height:140px;object-fit:cover;border-radius:8px;">
                            </a>
                            <div>
                                <h3 style="font-size:1.15rem;font-weight:700;margin-bottom:10px;">
                                    <a href="<?= e(site_url('news/detail/' . (int) ($article['id'] ?? 0))) ?>" style="color:inherit;text-decoration:none;"><?= e($article['title'] ?? '') ?></a>
                                </h3>
                                <p class="text-muted small mb-0"><?= e($snip) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev" role="button" tabindex="0" aria-label="Slide trước"></div>
            <div class="swiper-button-next" role="button" tabindex="0" aria-label="Slide sau"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper === 'undefined') return;
        var el = document.querySelector('.pn-featured-swiper');
        if (!el) return;
        new Swiper('.pn-featured-swiper', {
            loop: true,
            autoplay: { delay: 4800, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
        });
    });
    </script>
    <?php endif; ?>

    <!-- Categories -->
    <div class="category-section">
        <div class="container">
            <h2 class="section-title">Thể loại sách</h2>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <a href="<?= e(site_url('product?category=7')) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <div class="category-name">Tâm lý</div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <a href="<?= e(site_url('product?category=2')) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="category-name">Văn học</div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <a href="<?= e(site_url('product?category=3')) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="category-name">Kinh tế</div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <a href="<?= e(site_url('product?category=1')) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="category-name">Kỹ năng</div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <a href="<?= e(site_url('product?category=6')) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-child"></i>
                        </div>
                        <div class="category-name">Thiếu nhi</div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <a href="<?= e(site_url('product?category=1')) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="category-name">Giáo dục</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotion Banner -->
    <div class="row banner-section">
        <div class="col-lg-8 mb-4">
            <a href="<?= e(site_url('product')) ?>" class="banner-item" style="background: linear-gradient(135deg, var(--phuongnam-red) 0%, var(--phuongnam-orange) 100%);">
                <div class="banner-content">
                    <h3 class="banner-title">Khuyến mãi theo đợt</h3>
                    <p class="banner-subtitle">Xem chi tiết trên trang sản phẩm và tin tức</p>
                    <span class="banner-cta">Xem ngay</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4 mb-4">
            <a href="<?= e(site_url('product')) ?>" class="banner-item" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="banner-content">
                    <h3 class="banner-title">Phí ship</h3>
                    <p class="banner-subtitle">Miễn hoặc giảm tuỳ khu vực — xem khi thanh toán</p>
                    <span class="banner-cta">Đặt hàng</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4 mb-4">
            <a href="<?= e(site_url('news')) ?>" class="banner-item" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="banner-content">
                    <h3 class="banner-title">Tin đọc sách</h3>
                    <p class="banner-subtitle">Mẹo chọn sách, bảo quản</p>
                    <span class="banner-cta">Khám phá</span>
                </div>
            </a>
        </div>
        <div class="col-lg-8 mb-4">
            <a href="<?= e(site_url('news')) ?>" class="banner-item" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="banner-content">
                    <h3 class="banner-title">Hỗ trợ đặt hàng</h3>
                    <p class="banner-subtitle">Liên hệ hotline cửa hàng hoặc chat khi cần</p>
                    <span class="banner-cta">Tìm hiểu thêm</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Best Sellers (theo đơn completed trong DB) -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="section-title">Sản phẩm bán chạy</h2>
            <p class="text-center text-muted small mb-4">Danh sách cập nhật theo đơn đã giao thành công.</p>
        </div>
        <?php if (!empty($bestsellerProducts) && is_array($bestsellerProducts)): ?>
            <?php foreach ($bestsellerProducts as $p): ?>
                <div class="col-md-3 col-sm-6">
                    <a href="<?= e(site_url('product/detail/' . (int) ($p['product_id'] ?? 0))) ?>" class="product-card">
                        <div class="product-image">
                            <img src="<?= e(media_url($p['image_url'] ?? '')) ?>" alt="<?= e($p['title'] ?? '') ?>" loading="lazy" width="200" height="200">
                        </div>
                        <div class="product-info">
                            <p class="product-title"><?= e($p['title'] ?? '') ?></p>
                            <div class="product-author"><?= e($p['author'] ?? '') ?></div>
                            <div class="product-price">
                                <?= number_format((float) ($p['price'] ?? 0), 0, ',', '.') ?>đ
                                <?php if (!empty($p['old_price']) && (float) $p['old_price'] > (float) ($p['price'] ?? 0)): ?>
                                    <span class="product-old-price"><?= number_format((float) $p['old_price'], 0, ',', '.') ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted py-4">Chưa có dữ liệu đơn hàng để hiển thị mục này.</div>
        <?php endif; ?>
    </div>

    <!-- New Arrivals (ngày xuất bản mới nhất) -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="section-title">Sản phẩm mới</h2>
        </div>
        <?php if (!empty($newProducts) && is_array($newProducts)): ?>
            <?php foreach ($newProducts as $p): ?>
                <div class="col-md-3 col-sm-6">
                    <a href="<?= e(site_url('product/detail/' . (int) ($p['product_id'] ?? 0))) ?>" class="product-card">
                        <div class="product-image">
                            <img src="<?= e(media_url($p['image_url'] ?? '')) ?>" alt="<?= e($p['title'] ?? '') ?>" loading="lazy" width="200" height="200">
                        </div>
                        <div class="product-info">
                            <p class="product-title"><?= e($p['title'] ?? '') ?></p>
                            <div class="product-author"><?= e($p['author'] ?? '') ?></div>
                            <div class="product-price">
                                <?= number_format((float) ($p['price'] ?? 0), 0, ',', '.') ?>đ
                                <?php if (!empty($p['old_price']) && (float) $p['old_price'] > (float) ($p['price'] ?? 0)): ?>
                                    <span class="product-old-price"><?= number_format((float) $p['old_price'], 0, ',', '.') ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted py-4">Chưa có sản phẩm.</div>
        <?php endif; ?>
    </div>

    <!-- Promotion Section -->
    <div class="promotion-section">
        <div class="container">
            <h2 class="promotion-title">Đặt hàng & đổi trả</h2>
            <p class="promotion-subtitle">Đăng nhập để lưu giỏ hàng và xem lại đơn; đổi trả trong 7 ngày với sách lỗi in ấn.</p>
            <a href="<?= isset($_SESSION['users_id']) ? e(site_url('product')) : e(site_url('auth/login')) ?>" class="btn-hero"><?= isset($_SESSION['users_id']) ? 'Xem sản phẩm' : 'Đăng nhập / đăng ký' ?></a>

            <div class="counter">
                <div class="counter-item">
                    <div class="counter-number"><i class="fas fa-store"></i></div>
                    <div class="counter-label">Nhiều đầu mục sách</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number"><i class="fas fa-truck"></i></div>
                    <div class="counter-label">Giao nội thành & liên tỉnh</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number"><i class="fas fa-undo"></i></div>
                    <div class="counter-label">Đổi trả theo quy định</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number"><i class="fas fa-phone"></i></div>
                    <div class="counter-label">Hotline cửa hàng</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Articles -->
    <style>
        .home-featured-row > [class*="col-"] { display: flex; }
        .featured-news-card {
            width: 100%;
            min-height: 440px;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,.08);
        }
        .featured-news-card .card-img-top {
            height: 200px;
            width: 100%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .featured-news-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }
        .featured-news-card .card-text {
            flex: 1;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            margin-bottom: 0.75rem;
        }
        .featured-news-card .btn { align-self: flex-start; margin-top: auto; }
    </style>
    <div class="row mb-5 home-featured-row">
        <div class="col-md-12">
            <h2 class="section-title">Bài viết nổi bật</h2>
        </div>
        <?php if (!empty($featuredNews) && is_array($featuredNews)): ?>
            <?php foreach ($featuredNews as $article): ?>
                <?php
                $snippet = trim((string) ($article['summary'] ?? ''));
                if ($snippet === '') {
                    $plain = preg_replace('/\s+/', ' ', strip_tags(str_replace(["\r", "\n"], ' ', (string) ($article['content'] ?? ''))));
                    $snippet = function_exists('mb_substr')
                        ? mb_substr($plain, 0, 118, 'UTF-8')
                        : substr($plain, 0, 118);
                    $snippet .= '…';
                } elseif (function_exists('mb_strlen') && mb_strlen($snippet, 'UTF-8') > 140) {
                    $snippet = mb_substr($snippet, 0, 137, 'UTF-8') . '…';
                } elseif (!function_exists('mb_strlen') && strlen($snippet) > 140) {
                    $snippet = substr($snippet, 0, 137) . '…';
                }
                ?>
                <div class="col-md-4">
                    <div class="card featured-news-card">
                        <img src="<?= e(pn_public_image_src($article['image_url'] ?? '')) ?>" class="card-img-top" alt="<?= htmlspecialchars($article['title']) ?>">
                        <div class="card-body">
                            <p class="card-title fw-semibold mb-2"><?= htmlspecialchars($article['title']) ?></p>
                            <p class="card-text"><?= htmlspecialchars($snippet) ?></p>
                            <a href="<?= e(site_url('news/detail/' . $article['id'])) ?>" class="btn" style="background-color: var(--phuongnam-red); color: white; border: none;">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12 text-center">
                <p style="color: var(--phuongnam-gray); padding: 30px 0;">Chưa có bài viết nào</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
