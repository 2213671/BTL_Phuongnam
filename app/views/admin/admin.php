<?php
/**
 * Shell admin theo template SRTdash (assignment_2.pdf — Ghi chú a).
 * Assets: public/srtdash-admin-dashboard/srtdash/
 */
if (!defined('BASE_URL')) {
    exit;
}

$srt = rtrim(BASE_URL, '/') . '/srtdash-admin-dashboard/srtdash/';
$pageKey = $page ?? '';
$mainTitle = htmlspecialchars($title ?? 'Admin', ENT_QUOTES, 'UTF-8');
$userDisplay = htmlspecialchars($_SESSION['users_username'] ?? 'Admin', ENT_QUOTES, 'UTF-8');
$roleLabel = (!empty($isAdmin) || (isset($_SESSION['users_role']) && strtolower($_SESSION['users_role']) === 'admin'))
    ? 'Administrator'
    : 'Staff';
$isAdminRole = isset($_SESSION['users_role']) && strtolower($_SESSION['users_role']) === 'admin';

function admin_nav_active(string $pageKey, string ...$keys): string {
    foreach ($keys as $k) {
        if ($pageKey === $k) {
            return ' class="active"';
        }
    }
    return '';
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title><?= $mainTitle ?> — Quản trị Phương Nam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= htmlspecialchars($srt . 'assets/images/icon/logo.png', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/bootstrap.min.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/fontawesome.min.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/themify-icons.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/metismenujs.min.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/swiper-bundle.min.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/typography.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/default-css.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/styles.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars($srt . 'assets/css/responsive.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(rtrim(BASE_URL, '/') . '/css/admin-dashboard.css', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(rtrim(BASE_URL, '/') . '/css/admin-partials.css', ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
<a href="#main-content" class="skip-link">Skip to main content</a>
<div id="preloader"><div class="loader"></div></div>

<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="<?= htmlspecialchars(BASE_URL . 'admin', ENT_QUOTES, 'UTF-8') ?>">
                    <picture>
                        <source srcset="<?= htmlspecialchars($srt . 'assets/images/icon/logo.avif', ENT_QUOTES, 'UTF-8') ?>" type="image/avif">
                        <img src="<?= htmlspecialchars($srt . 'assets/images/icon/logo.png', ENT_QUOTES, 'UTF-8') ?>" alt="Logo">
                    </picture>
                </a>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <li<?= admin_nav_active($pageKey, 'dashboard') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-dashboard"></i><span>Tổng quan</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'orders') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/orders', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-shopping-cart"></i><span>Đơn hàng</span></a></li>

                        <?php if ($isAdminRole): ?>
                        <li<?= admin_nav_active($pageKey, 'products') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/products', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-package"></i><span>Sản phẩm</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'categories') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/categories', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-layout-grid2-alt"></i><span>Danh mục</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'news') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/news', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-announcement"></i><span>Tin tức</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'comments') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/comments', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-comment-alt"></i><span>Bình luận tin</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'productreviews') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/productreviews', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-star"></i><span>Đánh giá SP</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'customers') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/customers', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-user"></i><span>Khách hàng</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'qa') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/qa', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-help-alt"></i><span>Hỏi đáp</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'contacts') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/contacts', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-email"></i><span>Liên hệ</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'pages') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/pageContent?page=about', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-layout-slider-alt"></i><span>Trang Giới thiệu</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'staff') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/staff', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-id-badge"></i><span>Nhân viên</span></a></li>
                        <li<?= admin_nav_active($pageKey, 'settings') ?>><a href="<?= htmlspecialchars(BASE_URL . 'admin/settings', ENT_QUOTES, 'UTF-8') ?>"><i class="ti-settings"></i><span>Cài đặt</span></a></li>
                        <?php endif; ?>

                        <li><a href="<?= htmlspecialchars(BASE_URL . 'home', ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener"><i class="ti-world"></i><span>Xem website</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header-area">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn float-start"><span></span><span></span><span></span></div>
                    <div class="search-box float-start d-none d-md-block">
                        <form action="<?= htmlspecialchars(BASE_URL . 'product', ENT_QUOTES, 'UTF-8') ?>" method="get">
                            <input type="text" name="search" placeholder="Tìm sản phẩm (site)...">
                            <i class="ti-search"></i>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4 clearfix">
                    <ul class="notification-area float-end">
                        <li id="full-view"><i class="ti-fullscreen"></i></li>
                        <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                        <li class="settings-btn"><i class="ti-settings"></i></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumbs-area clearfix">
                        <h1 class="page-title float-start"><?= $mainTitle ?></h1>
                        <ul class="breadcrumbs float-start">
                            <li><a href="<?= htmlspecialchars(BASE_URL . 'admin', ENT_QUOTES, 'UTF-8') ?>">Admin</a></li>
                            <li><span><?= $mainTitle ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 clearfix">
                    <div class="user-profile float-end">
                        <img class="avatar user-thumb" src="<?= htmlspecialchars($srt . 'assets/images/author/avatar.png', ENT_QUOTES, 'UTF-8') ?>" alt="">
                        <p class="user-name dropdown-toggle h5 mb-0" data-bs-toggle="dropdown"><?= $userDisplay ?> <i class="fa-solid fa-angle-down"></i></p>
                        <div class="dropdown-menu user-dropdown">
                            <span class="dropdown-item-text small text-muted"><?= htmlspecialchars($roleLabel, ENT_QUOTES, 'UTF-8') ?></span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= htmlspecialchars(BASE_URL . 'customer', ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-user"></i> Tài khoản</a>
                            <a class="dropdown-item user-dropdown-logout" href="<?= htmlspecialchars(BASE_URL . 'auth/logout', ENT_QUOTES, 'UTF-8') ?>" onclick="return confirm('Đăng xuất?');"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content-inner" id="main-content">
            <?php
            if (!empty($contentFile) && file_exists($contentFile)) {
                require_once $contentFile;
            } else {
                echo '<div class="alert alert-warning">Không tìm thấy nội dung trang.</div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <div class="footer-area">
            <p>Nhà sách Phương Nam — Bảng quản trị (template <a href="https://github.com/puikinsh/srtdash-admin-dashboard" target="_blank" rel="noopener">SRTdash</a>).</p>
        </div>
    </footer>
</div>

<div class="offset-area">
    <div class="offset-close"><i class="ti-close"></i></div>
    <div class="offset-content tab-content p-3">
        <p class="text-muted mb-0">Phím cài đặt nhanh — Bài tập lớn Lập trình Web.</p>
    </div>
</div>

<script src="<?= htmlspecialchars($srt . 'assets/js/bootstrap.bundle.min.js', ENT_QUOTES, 'UTF-8') ?>"></script>
<script src="<?= htmlspecialchars($srt . 'assets/js/swiper-bundle.min.js', ENT_QUOTES, 'UTF-8') ?>"></script>
<script src="<?= htmlspecialchars($srt . 'assets/js/metismenujs.min.js', ENT_QUOTES, 'UTF-8') ?>"></script>
<script src="<?= htmlspecialchars($srt . 'assets/js/scripts.js', ENT_QUOTES, 'UTF-8') ?>"></script>
</body>
</html>
