<?php
// Lấy current page từ URL
$currentPage = $_GET['page'] ?? 'index';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

// Xác định active menu item
$isProfile = strpos($requestUri, 'customer/index') !== false || (strpos($requestUri, 'customer') !== false && strpos($requestUri, 'customer/') === false);
$isOrders = strpos($requestUri, 'customer/orders') !== false;
$isNotifications = strpos($requestUri, 'customer/notifications') !== false;
$isWishlist = strpos($requestUri, 'customer/wishlist') !== false;
?>

<div class="customer-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-username"><?= htmlspecialchars($_SESSION['users_username'] ?? 'Người dùng') ?></div>
            <div class="sidebar-email">Tài khoản của tôi</div>
        </div>
    </div>
    
    <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
            <a href="<?= BASE_URL ?>customer" class="sidebar-menu-link <?= $isProfile ? 'active' : '' ?>">
                <i class="fas fa-user"></i>
                <span>Thông tin tài khoản</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= BASE_URL ?>customer/orders" class="sidebar-menu-link <?= $isOrders ? 'active' : '' ?>">
                <i class="fas fa-box"></i>
                <span>Đơn hàng của tôi</span>
            </a>
        </li>
        <!-- <li class="sidebar-menu-item">
            <a href="<?= BASE_URL ?>customer/notifications" class="sidebar-menu-link <?= $isNotifications ? 'active' : '' ?>">
                <i class="fas fa-bell"></i>
                <span>Thông báo</span>
            </a>
        </li> -->
        <li class="sidebar-menu-item">
            <a href="<?= BASE_URL ?>customer/wishlist" class="sidebar-menu-link <?= $isWishlist ? 'active' : '' ?>">
                <i class="fas fa-heart"></i>
                <span>Sản phẩm yêu thích</span>
            </a>
        </li>
    </ul>
</div>
