<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
$loggedUserId = (int) ($_SESSION['users_id'] ?? 0);
if ($loggedUserId > 0) {
    require_once APP_ROOT . '/models/CartModel.php';
    $cartModel = new CartModel();
    $cartCount = max(0, $cartModel->getCartCount($loggedUserId));
} else {
    $localCartRaw = $_COOKIE['local_cart'] ?? '';
    if ($localCartRaw !== '') {
        $localCartItems = json_decode($localCartRaw, true);
        if (is_array($localCartItems)) {
            foreach ($localCartItems as $item) {
                $cartCount += (int) ($item['quantity'] ?? 0);
            }
            $cartCount = max(0, $cartCount);
        }
    }
}

$navUser = null;
if ($loggedUserId > 0) {
    $navUser = [
        'id' => $loggedUserId,
        'name' => $_SESSION['users_username'] ?? 'User',
        'email' => $_SESSION['users_email'] ?? '',
        'role' => $_SESSION['users_role'] ?? 'user',
        'avatar' => $_SESSION['users_avatar'] ?? '',
    ];
}

$base = defined('BASE_URL') ? rtrim(BASE_URL, '/') . '/' : '/';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title & Description -->
    <title><?= e($title ?? 'Nhà sách Phương Nam - Website Bán Sách Trực Tuyến') ?></title>
    <meta name="description" content="<?= e($description ?? 'Nhà sách Phương Nam - Website bán sách trực tuyến uy tín với hàng ngàn đầu sách đa dạng. Mua sách online giá tốt, giao hàng nhanh chóng, ưu đãi hấp dẫn.') ?>">
    <meta name="keywords" content="<?= e($keywords ?? 'mua sách online, bán sách trực tuyến, nhà sách phương nam, sách giáo khoa, văn học, self-help, tiểu thuyết, sách thiếu nhi') ?>">
    <meta name="author" content="Nhóm L01_6 - HCMUT">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($ogUrl ?? BASE_URL) ?>">
    <meta property="og:title" content="<?= e($ogTitle ?? $title ?? 'Nhà sách Phương Nam - Website Bán Sách Trực Tuyến') ?>">
    <meta property="og:description" content="<?= e($ogDescription ?? $description ?? 'Website bán sách trực tuyến uy tín với hàng ngàn đầu sách đa dạng') ?>">
    <meta property="og:image" content="<?= e($ogImage ?? asset_url('media/home/og-default.jpg')) ?>">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:site_name" content="Nhà sách Phương Nam">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= e($ogUrl ?? BASE_URL) ?>">
    <meta name="twitter:title" content="<?= e($ogTitle ?? $title ?? 'Nhà sách Phương Nam') ?>">
    <meta name="twitter:description" content="<?= e($ogDescription ?? $description ?? 'Website bán sách trực tuyến') ?>">
    <meta name="twitter:image" content="<?= e($ogImage ?? asset_url('media/home/og-default.jpg')) ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?= e($canonical ?? BASE_URL . ltrim($_SERVER['REQUEST_URI'] ?? '', '/')) ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= $base ?>css/site-layout.css">
    <link rel="stylesheet" href="<?= $base ?>css/footer.css">
<?php
    $pnNavPage = $page ?? '';
    if ($pnNavPage === 'home'): ?>
    <link rel="stylesheet" href="<?= $base ?>css/home-page.css">
<?php elseif ($pnNavPage === 'product' && !empty($product_list_page)): ?>
    <link rel="stylesheet" href="<?= $base ?>css/product-list.css">
<?php elseif ($pnNavPage === 'about'): ?>
    <link rel="stylesheet" href="<?= $base ?>css/about-page.css">
<?php elseif ($pnNavPage === 'qa'): ?>
    <link rel="stylesheet" href="<?= $base ?>css/qa-page.css">
<?php elseif ($pnNavPage === 'pricing'): ?>
    <link rel="stylesheet" href="<?= $base ?>css/pricing-page.css">
<?php elseif ($pnNavPage === 'news' && !empty($news_list_page)): ?>
    <link rel="stylesheet" href="<?= $base ?>css/news-list.css">
<?php elseif ($pnNavPage === 'contact'): ?>
    <link rel="stylesheet" href="<?= $base ?>css/contact-page.css">
<?php elseif ($pnNavPage === 'customer'): ?>
    <link rel="stylesheet" href="<?= $base ?>css/customer-account.css">
<?php endif; ?>

    <style>
        :root {
            --phuongnam-red: #0066b3; /* Xanh chủ đạo Phương Nam */
            --phuongnam-orange: #0099cc; /* Xanh dương sáng */
            --phuongnam-dark: #2C2C2C;
            --phuongnam-gray: #666666;
            --phuongnam-light-gray: #F5F5F5;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: var(--phuongnam-dark);
        }

        /* Header Styles */
        .top-header {
            background-color: var(--phuongnam-red);
            color: white;
            padding: 8px 0;
            font-size: 13px;
        }

        .top-header a {
            color: white;
            text-decoration: none;
        }

        .top-header a:hover {
            text-decoration: underline;
        }

        .main-header {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            padding: 12px 0;
        }

        .logo {
            font-size: 26px;
            font-weight: 700;
            color: var(--phuongnam-red);
            text-decoration: none;
        }

        .logo:hover {
            color: var(--phuongnam-orange);
        }

        .search-box {
            position: relative;
        }

        .search-box input[type="search"] {
            border: 2px solid var(--phuongnam-red);
            border-radius: 4px;
            padding: 10px 50px 10px 15px;
        }

        .search-box button {
            position: absolute;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--phuongnam-red);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .search-box button:hover {
            background-color: #a81b20;
        }

        .nav-menu {
            background-color: var(--phuongnam-light-gray);
            padding: 10px 0;
        }

        .nav-menu .nav-link {
            color: var(--phuongnam-dark);
            font-weight: 500;
            padding: 8px 14px;
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 4px;
        }

        .nav-menu .nav-link:hover,
        .nav-menu .nav-link.active {
            color: var(--phuongnam-red);
            background-color: white;
        }

       .header-icons .dropdown-menu a {
    margin-left: 0;    
    font-size: 14px;     
    padding: 8px 16px;  
    width: 100%;         
}


.header-icons .dropdown-menu a:not(:hover) {
    color: var(--phuongnam-dark); 
}
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background-color: var(--phuongnam-red);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Account dropdown */
        .account-name {
            font-weight: 500;
            margin-left: 8px;
            color: var(--phuongnam-dark);
        }

        .header-wrapper {
    position: -webkit-sticky; 
    position: sticky;         
    top: 0;                   
    z-index: 1020;           
    background-color: white;  
    box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
}


        /* Responsive tweaks */
        @media (max-width: 767px) {
            .search-box input[type="search"] { padding-right: 44px; }
            .header-icons a { margin-left: 10px; }
        }
    </style>

<script>
    const BASE_URL = '<?= BASE_URL ?>';
    window.isLoggedIn = <?= $loggedUserId > 0 ? 'true' : 'false' ?>;
    window.needSyncCart = <?= isset($_SESSION['need_sync_cart']) ? 'true' : 'false' ?>;
    window.initialCartCount = <?= (int) ($cartCount ?? 0) ?>;

    <?php if (isset($_SESSION['need_sync_cart'])): ?>
        <?php unset($_SESSION['need_sync_cart']); ?>
    <?php endif; ?>
</script>

<?php
$_cartJsPath = defined('PUBLIC_PATH') ? PUBLIC_PATH . 'js/cart.js' : dirname(APP_ROOT) . '/public/js/cart.js';
$cartJsVersion = is_readable($_cartJsPath) ? (string) filemtime($_cartJsPath) : (string) time();
?>
<script src="<?= BASE_URL ?>js/cart.js?v=<?= htmlspecialchars($cartJsVersion, ENT_QUOTES, 'UTF-8') ?>"></script>


</head>
<body>

<div class="header-wrapper">
    <!-- Top Header -->
    <div class="top-header" role="banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-7 col-sm-6">
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <span class="visually-hidden">Hotline:</span>
                    <a href="tel:19006656" class="ms-1" style="color:inherit; text-decoration: none;">1900-6656</a>
                </div>
                <div class="col-5 col-sm-6 text-end">
                    <?php if ($navUser): ?>
                        <span class="me-2"><i class="fas fa-user"></i> <?= e($navUser['name'] ?? $navUser['email'] ?? 'Người dùng') ?></span>
                        <?php if (isset($navUser['role']) && in_array(strtolower((string) $navUser['role']), ['admin', 'staff'], true)): ?>
                            <a href="<?= $base ?>admin" class="me-2 text-danger fw-bold"><i class="fas fa-cog"></i> Quản trị</a>
                        <?php endif; ?>
                        <a href="<?= $base ?>auth/logout" class="me-2" style="color:inherit;"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Đăng xuất</a>
                    <?php else: ?>
                        <a href="<?= $base ?>auth/login" class="me-2"><i class="fas fa-user"></i> Đăng nhập</a>
                        <span class="mx-1">|</span>
                        <a href="<?= $base ?>auth/register" class="ms-2"><i class="fas fa-user-plus"></i> Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header" aria-label="Thanh tiêu đề và liên kết nhanh">
        <div class="container">
            <div class="row align-items-center g-3">
                
                <div class="col-9 col-md-3">
                    <a href="<?= $base ?>" class="logo" aria-label="Trang chủ Nhà sách Phương Nam">
                        <i class="fas fa-book-open" aria-hidden="true"></i> PHƯƠNG NAM
                    </a>
                </div>

                <div class="col-3 col-md-9 d-flex justify-content-end align-items-center"> 
                    <div class="header-icons d-inline-flex align-items-center">
                        
                        <?php $headerCartBadge = max(0, (int) ($cartCount ?? 0)); ?>
                        <a href="<?= $base ?>cart" title="Giỏ hàng" aria-label="Giỏ hàng" class="position-relative ms-3">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                            <span class="cart-badge" aria-live="polite" aria-atomic="true"><?= e($headerCartBadge) ?></span>
                        </a>

                        <?php if ($navUser): ?>
                            <div class="btn-group ms-3 d-none d-md-block"> <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-inline-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php
                                    $hdrAv = trim((string) ($navUser['avatar'] ?? ''));
                                    if ($hdrAv !== '' && function_exists('pn_is_local_media_path') && pn_is_local_media_path($hdrAv)): ?>
                                        <img src="<?= e(media_url($hdrAv)) ?>" alt="" width="24" height="24" class="rounded-circle" style="object-fit:cover;">
                                    <?php else: ?>
                                        <i class="fas fa-user-circle" aria-hidden="true"></i>
                                    <?php endif; ?>
                                    <span class="account-name"><?= e($navUser['name'] ?? $navUser['email']) ?></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?= $base ?>customer"><i class="fas fa-user me-2"></i>Thông tin tài khoản</a></li>
                                    <li><a class="dropdown-item" href="<?= $base ?>customer/orders"><i class="fas fa-box me-2"></i>Đơn hàng của tôi</a></li>
                                    <!-- <li><a class="dropdown-item" href="<?= $base ?>customer/notifications"><i class="fas fa-bell me-2"></i>Thông báo</a></li> -->
                                    <li><a class="dropdown-item" href="<?= $base ?>customer/wishlist"><i class="fas fa-heart me-2"></i>Sản phẩm yêu thích</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= $base ?>auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="nav-menu" aria-label="Danh mục chính">
        <div class="container">
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= $base ?>home" class="nav-link <?= ($page ?? '') == 'home' ? 'active' : '' ?>" aria-current="<?= ($page ?? '') == 'home' ? 'page' : 'false' ?>">
                    <i class="fas fa-home" aria-hidden="true"></i> Trang chủ
                </a>
                <a href="<?= $base ?>home/about" class="nav-link <?= ($page ?? '') == 'about' ? 'active' : '' ?>">
                    <i class="fas fa-info-circle" aria-hidden="true"></i> Giới thiệu
                </a>
                <a href="<?= $base ?>home/qa" class="nav-link <?= ($page ?? '') == 'qa' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle" aria-hidden="true"></i> Hỏi/Đáp
                </a>
                <a href="<?= $base ?>home/pricing" class="nav-link <?= ($page ?? '') == 'pricing' ? 'active' : '' ?>">
                    <i class="fas fa-tags" aria-hidden="true"></i> Bảng giá
                </a>
                <a href="<?= $base ?>product" class="nav-link <?= ($page ?? '') == 'product' ? 'active' : '' ?>">
                    <i class="fas fa-book" aria-hidden="true"></i> Sản phẩm
                </a>
                <a href="<?= $base ?>news" class="nav-link <?= ($page ?? '') == 'news' ? 'active' : '' ?>">
                    <i class="fas fa-newspaper" aria-hidden="true"></i> Tin tức
                </a>
                <a href="<?= $base ?>contact" class="nav-link <?= ($page ?? '') == 'contact' ? 'active' : '' ?>">
                    <i class="fas fa-phone" aria-hidden="true"></i> Liên hệ
                </a>
            </div>
        </div>
    </nav>
</div>
<?php /* Nội dung trang + footer (đóng body/html trong footer.php) */ ?>
