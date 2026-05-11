<!doctype html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title><?= $title ?? 'Admin Dashboard' ?> - Nhà sách Phương Nam</title>
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --sidebar-width: 260px;
      --sidebar-collapsed-width: 70px;
      --primary-color: #c92127;
      --primary-dark: #a01b20;
      --secondary-color: #f7941d;
      --bg-color: #f5f5f5;
      --text-color: #333;
      --text-light: #666;
      --border-color: #e0e0e0;
      --sidebar-bg: #1e293b;
      --sidebar-text: #cbd5e1;
      --sidebar-hover: #334155;
      --sidebar-active: #c92127;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-color);
      color: var(--text-color);
      overflow-x: hidden;
    }

    /* ========== SIDEBAR ========== */
    .admin-sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: var(--sidebar-width);
      height: 100vh;
      background: var(--sidebar-bg);
      color: var(--sidebar-text);
      transition: var(--transition);
      z-index: 1000;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .admin-sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }

    /* Logo Area */
    .sidebar-header {
      padding: 20px;
      background: var(--primary-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      min-height: 70px;
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      color: white;
      text-decoration: none;
      overflow: hidden;
    }

    .sidebar-logo i {
      font-size: 24px;
      min-width: 30px;
      text-align: center;
    }

    .sidebar-logo-text {
      font-size: 18px;
      font-weight: 700;
      white-space: nowrap;
      opacity: 1;
      transition: var(--transition);
    }

    .admin-sidebar.collapsed .sidebar-logo-text {
      opacity: 0;
      width: 0;
    }

    .sidebar-toggle {
      background: none;
      border: none;
      color: white;
      font-size: 20px;
      cursor: pointer;
      padding: 8px;
      border-radius: 4px;
      transition: var(--transition);
    }

    .sidebar-toggle:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    /* Navigation */
    .sidebar-nav {
      flex: 1;
      overflow-y: auto;
      padding: 20px 0;
    }

    .sidebar-nav::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
      background: var(--sidebar-hover);
      border-radius: 3px;
    }

    .nav-section {
      margin-bottom: 30px;
    }

    .nav-section-title {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text-light);
      padding: 0 20px;
      margin-bottom: 10px;
      font-weight: 600;
      opacity: 1;
      transition: var(--transition);
    }

    .admin-sidebar.collapsed .nav-section-title {
      opacity: 0;
      height: 0;
      margin: 0;
      padding: 0;
    }

    .nav-item {
      list-style: none;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 12px 20px;
      color: var(--sidebar-text);
      text-decoration: none;
      transition: var(--transition);
      position: relative;
    }

    .nav-link:hover {
      background: var(--sidebar-hover);
      color: white;
    }

    .nav-link.active {
      background: var(--sidebar-active);
      color: white;
    }

    .nav-link.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: white;
    }

    .nav-link i {
      font-size: 18px;
      min-width: 30px;
      text-align: center;
    }

    .nav-link-text {
      font-size: 14px;
      font-weight: 500;
      white-space: nowrap;
      opacity: 1;
      transition: var(--transition);
    }

    .admin-sidebar.collapsed .nav-link-text {
      opacity: 0;
      width: 0;
    }

    .admin-sidebar.collapsed .nav-link {
      justify-content: center;
      padding: 12px;
    }

    /* Logout at bottom */
    .sidebar-footer {
      padding: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout-link {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 12px 20px;
      color: #ef4444;
      text-decoration: none;
      transition: var(--transition);
      border-radius: 8px;
      font-weight: 500;
    }

    .logout-link:hover {
      background: rgba(239, 68, 68, 0.1);
      color: #dc2626;
    }

    .logout-link i {
      font-size: 18px;
      min-width: 30px;
      text-align: center;
    }

    .admin-sidebar.collapsed .logout-link {
      justify-content: center;
      padding: 12px;
    }

    /* ========== MAIN CONTENT ========== */
    .admin-main {
      margin-left: var(--sidebar-width);
      transition: var(--transition);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .admin-sidebar.collapsed~.admin-main {
      margin-left: var(--sidebar-collapsed-width);
    }

    /* Top Header */
    .admin-header {
      background: white;
      border-bottom: 1px solid var(--border-color);
      padding: 15px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .page-title-header {
      font-size: 20px;
      font-weight: 600;
      color: var(--text-color);
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 8px 16px;
      background: var(--bg-color);
      border-radius: 8px;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--primary-color);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }

    .user-details {
      display: flex;
      flex-direction: column;
    }

    .user-name {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-color);
    }

    .user-role {
      font-size: 12px;
      color: var(--text-light);
    }

    /* Content Area */
    .admin-content {
      flex: 1;
      padding: 30px;
    }

    /* Breadcrumb */
    .breadcrumb-custom {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
      font-size: 14px;
    }

    .breadcrumb-custom a {
      color: var(--text-light);
      text-decoration: none;
      transition: var(--transition);
    }

    .breadcrumb-custom a:hover {
      color: var(--primary-color);
    }

    .breadcrumb-custom .active {
      color: var(--text-color);
      font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }

      .admin-sidebar.mobile-show {
        transform: translateX(0);
      }

      .admin-main {
        margin-left: 0 !important;
      }

      .user-details {
        display: none;
      }
    }

    /* Badge for notifications */
    .nav-badge {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      background: var(--secondary-color);
      color: white;
      font-size: 11px;
      padding: 2px 6px;
      border-radius: 10px;
      font-weight: 600;
    }

    .admin-sidebar.collapsed .nav-badge {
      display: none;
    }
  </style>
</head>

<body>
  <div class="page">
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
          <a href="<?= BASE_URL ?>admin">Nhà sách Phương Nam ADMIN</a>
        </h1>
        <div class="collapse navbar-collapse" id="sidebar-menu">
          <ul class="navbar-nav pt-lg-3">
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin">
                <span class="nav-link-icon"><i class="fas fa-home"></i></span>
                <span class="nav-link-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/settings">
                <span class="nav-link-icon"><i class="fas fa-cogs"></i></span>
                <span class="nav-link-title">Cấu hình chung</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/contacts">
                <span class="nav-link-icon"><i class="fas fa-envelope"></i></span>
                <span class="nav-link-title">Liên hệ</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/qa">
                <span class="nav-link-icon"><i class="fas fa-question-circle"></i></span>
                <span class="nav-link-title">Hỏi đáp</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/pageContent?page=about">
                <span class="nav-link-icon"><i class="fas fa-file-alt"></i></span>
                <span class="nav-link-title">Trang Giới thiệu</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/pageContent?page=products">
                <span class="nav-link-icon"><i class="fas fa-file-alt"></i></span>
                <span class="nav-link-title">Quản lý sản phẩm</span>
                <div class="col">
                  <h2 class="page-title">Quản lý Sản phẩm</h2>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin/pageContent?page=about">
                <span class="nav-link-icon"><i class="fas fa-file-alt"></i></span>
                <span class="nav-link-title">Trang Giới thiệu</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </aside>

    <div class="page-wrapper">
      <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
        <div class="container-xl">
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                <div class="d-none d-xl-block ps-2">
                  <div><?= $_SESSION['user_name'] ?? 'Admin' ?></div>
                  <div class="mt-1 small text-secondary">Administrator</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="<?= BASE_URL ?>" class="dropdown-item">Xem trang chủ</a>
                <a href="<?= BASE_URL ?>auth/logout" class="dropdown-item text-danger">Đăng xuất</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu"></div>
        </div>
      </header>

      <div class="page-body">
        <div class="container-xl"></div>


        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>admin/news">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fas fa-newspaper"></i></span>
            <span class="nav-link-title">Quản lý Tin tức</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>admin/products">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fas fa-box"></i></span>
            <span class="nav-link-title">Quản lý Sản phẩm</span>
          </a>
        </li>
