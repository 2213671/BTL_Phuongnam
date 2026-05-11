<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<div class="customer-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <?php require_once APP_ROOT . '/views/customer/sidebar.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="customer-content">
                    <h2 class="page-title">
                        <i class="fas fa-bell"></i>
                        Thông báo
                    </h2>
                    
                    <!-- Notification Actions -->
                    <div class="notification-actions">
                        <div>
                            <span class="text-muted">
                                Bạn có <strong class="text-danger" id="unreadCount">
                                    <?php 
                                    $unreadCount = 0;
                                    foreach ($notifications as $notif) {
                                        if (!$notif['is_read']) $unreadCount++;
                                    }
                                    echo $unreadCount;
                                    ?>
                                </strong> thông báo chưa đọc
                            </span>
                        </div>
                        <button class="btn-mark-all" id="markAllRead">
                            <i class="fas fa-check-double me-2"></i>Đánh dấu tất cả đã đọc
                        </button>
                    </div>
                    
                    <!-- Notifications List -->
                    <?php if (!empty($notifications)): ?>
                        <ul class="notification-list">
                            <?php foreach ($notifications as $notif): ?>
                                <li class="notification-item <?= !$notif['is_read'] ? 'unread' : '' ?>" 
                                    data-id="<?= $notif['id'] ?>">
                                    <div class="notification-icon type-<?= $notif['type'] ?>">
                                        <i class="fas <?= $notif['icon'] ?>"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-header">
                                            <h5 class="notification-title">
                                                <?= htmlspecialchars($notif['title']) ?>
                                            </h5>
                                            <span class="notification-time">
                                                <i class="far fa-clock me-1"></i>
                                                <?= htmlspecialchars($notif['time']) ?>
                                            </span>
                                        </div>
                                        <p class="notification-text">
                                            <?= htmlspecialchars($notif['content']) ?>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="far fa-bell-slash"></i>
                            <h4>Chưa có thông báo nào</h4>
                            <p>Bạn sẽ nhận được thông báo về đơn hàng, khuyến mãi và các tin tức mới nhất tại đây.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mark notification as read when clicked (UI only)
document.querySelectorAll('.notification-item').forEach(item => {
    item.addEventListener('click', function() {
        if (this.classList.contains('unread')) {
            this.classList.remove('unread');
            updateUnreadCount();
        }
    });
});

// mark single notification as read (AJAX)
document.querySelectorAll('.notification-item').forEach(item => {
    item.addEventListener('click', function() {
        const id = this.dataset.id;
        if (!id) return;
        // optimistic UI
        if (this.classList.contains('unread')) this.classList.remove('unread');

        fetch('<?= BASE_URL ?>customer/markNotificationRead', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id)
        }).then(r => r.json()).then(res => {
            if (!res.success) {
                // revert if failed
                item.classList.add('unread');
                showToast(res.message || 'Không thể đánh dấu', 'danger');
            } else {
                updateUnreadCount();
            }
        }).catch(() => {
            item.classList.add('unread');
            showToast('Lỗi kết nối', 'danger');
        });
    });
});

// mark all notifications as read (AJAX)
document.getElementById('markAllRead')?.addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

    fetch('<?= BASE_URL ?>customer/markAllNotificationsRead', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: '' // no body needed
    }).then(r => r.json()).then(res => {
        btn.disabled = false;
        if (res.success) {
            document.querySelectorAll('.notification-item.unread').forEach(i => i.classList.remove('unread'));
            updateUnreadCount();
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Đã đánh dấu!';
            setTimeout(() => btn.innerHTML = '<i class="fas fa-check-double me-2"></i>Đánh dấu tất cả đã đọc', 1200);
        } else {
            showToast(res.message || 'Không thể xử lý', 'danger');
            btn.innerHTML = '<i class="fas fa-check-double me-2"></i>Đánh dấu tất cả đã đọc';
        }
    }).catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-check-double me-2"></i>Đánh dấu tất cả đã đọc';
        showToast('Lỗi kết nối', 'danger');
    });
});

// Update unread notification count on UI
function updateUnreadCount() {
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    const countElement = document.getElementById('unreadCount');
    if (countElement) {
        countElement.textContent = unreadCount;
    }
}
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
