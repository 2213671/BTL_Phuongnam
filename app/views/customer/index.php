<?php require_once APP_ROOT . '/views/components/header.php'; ?>
<?php
$profileEmailRaw = trim((string) ($user['email'] ?? ''));
$profileEmailShow = $profileEmailRaw;
if ($profileEmailRaw !== '' && preg_match('/@phone\.customer\.local$/i', $profileEmailRaw)) {
    $profileEmailShow = '';
}
$profileEmailRequiredAttr = $profileEmailShow !== '';
?>

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
                        <i class="fas fa-user"></i>
                        Thông tin tài khoản
                    </h2>
                    
                    <!-- Account Info Card -->
                    <div class="info-card">
                        <div class="info-card-title">
                            <i class="fas fa-info-circle"></i>
                            Thông tin cơ bản
                        </div>
                        <p class="mb-0 text-muted">
                            Quản lý thông tin hồ sơ để bảo mật tài khoản của bạn
                        </p>
                    </div>

                    <div class="info-card mb-4">
                        <div class="info-card-title">
                            <i class="fas fa-image"></i>
                            Ảnh đại diện
                        </div>
                        <p class="small text-muted mb-3">JPEG, PNG hoặc WebP — hiển thị trên menu và bình luận tin.</p>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <?php
                            $myAv = trim((string) ($user['avatar'] ?? ''));
                            $showImg = $myAv !== '' && function_exists('pn_is_local_media_path') && pn_is_local_media_path($myAv);
                            ?>
                            <div id="avatarPreviewBox">
                                <?php if ($showImg): ?>
                                    <img src="<?= e(media_url($myAv)) ?>" alt="" width="80" height="80" class="rounded-circle border" style="object-fit:cover;" id="avatarImgPreview">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white fw-bold border" style="width:80px;height:80px;font-size:1.5rem;" id="avatarImgPreview">
                                        <?= !empty($user['fullname']) ? e(mb_substr($user['fullname'], 0, 1, 'UTF-8')) : 'U' ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <form id="avatarUploadForm" class="d-flex flex-wrap gap-2 align-items-center">
                                <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="form-control" style="max-width:260px;" required>
                                <button type="submit" class="btn-save"><i class="fas fa-upload me-2"></i>Tải ảnh lên</button>
                            </form>
                        </div>
                    </div>

                    <div class="info-card mb-4">
                        <div class="info-card-title">
                            <i class="fas fa-key"></i>
                            Đổi mật khẩu
                        </div>
                        <form class="profile-form" id="passwordChangeForm">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                    <input type="password" name="current_password" class="form-control" required autocomplete="current-password" minlength="1">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                    <input type="password" name="new_password" id="newPwd1" class="form-control" required autocomplete="new-password" minlength="6">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="confirm_password" id="newPwd2" class="form-control" required autocomplete="new-password" minlength="6">
                                </div>
                            </div>
                            <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Cập nhật mật khẩu</button>
                        </form>
                    </div>
                    
                    <!-- Profile Form -->
                    <form class="profile-form" id="profileForm">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="fullname" class="form-label">
                                    <i class="fas fa-user me-2 text-muted"></i>Họ và tên *
                                </label>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                       value="<?= htmlspecialchars($user['fullname'] ?? '') ?>"
                                       placeholder="Nhập họ và tên đầy đủ"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2 text-muted"></i>Email<?= $profileEmailRequiredAttr ? ' *' : '' ?>
                                </label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?= htmlspecialchars($profileEmailShow) ?>"
                                       placeholder="example@email.com"
                                       <?= $profileEmailRequiredAttr ? 'required' : '' ?>>
                                <?php if (!$profileEmailRequiredAttr): ?>
                                    <small class="text-muted">Tài khoản đăng ký bằng SĐT — có thể bổ sung email thật tại đây.</small>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-2 text-muted"></i>Số điện thoại
                                </label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       value="<?= htmlspecialchars(trim((string) ($user['phone'] ?? ''))) ?>"
                                       placeholder="Nhập số điện thoại">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">
                                    <i class="fas fa-user-tag me-2 text-muted"></i>Vai trò
                                </label>
                                <input type="text" class="form-control" id="role"
                                       value="<?= htmlspecialchars($user['role'] ?? 'Customer') ?>"
                                       readonly disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar me-2 text-muted"></i>Thành viên từ
                                </label>
                                <input type="text" class="form-control"
                                       value="<?= !empty($user['created_date']) ? date('d/m/Y', strtotime($user['created_date'])) : 'N/A' ?>"
                                       readonly disabled>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex gap-3">
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                            <button type="button" class="btn btn-cancel" onclick="window.location.reload()">
                                <i class="fas fa-times me-2"></i>Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('avatarUploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>...';
    fetch('<?= BASE_URL ?>customer/uploadAvatar', { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(r => r.json())
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = orig;
            if (res.success && res.avatar_url) {
                showToast('Đã cập nhật ảnh đại diện');
                var box = document.getElementById('avatarPreviewBox');
                if (box) box.innerHTML = '<img src="'+res.avatar_url+'" alt="" width="80" height="80" class="rounded-circle border" style="object-fit:cover;" id="avatarImgPreview">';
                setTimeout(function(){ location.reload(); }, 600);
            } else if (res.need_login) {
                window.location.href = '<?= BASE_URL ?>auth/login';
            } else {
                showToast(res.message || 'Lỗi ảnh', 'danger');
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.innerHTML = orig;
            showToast('Lỗi kết nối', 'danger');
        });
});

document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const p1 = document.getElementById('newPwd1').value;
    const p2 = document.getElementById('newPwd2').value;
    if (p1.length < 6 || p2.length < 6) {
        showToast('Mật khẩu mới tối thiểu 6 ký tự', 'danger');
        return;
    }
    if (p1 !== p2) {
        showToast('Mật khẩu xác nhận không khớp', 'danger');
        return;
    }
    const fd = new URLSearchParams(new FormData(this));
    const btn = this.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>...';
    fetch('<?= BASE_URL ?>customer/changePassword', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: fd.toString(),
        credentials: 'same-origin'
    })
        .then(r => r.json())
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = orig;
            if (res.success) {
                showToast(res.message || 'Đã đổi mật khẩu');
                document.getElementById('passwordChangeForm').reset();
            } else if (res.need_login) {
                window.location.href = '<?= BASE_URL ?>auth/login';
            } else {
                showToast(res.message || 'Lỗi', 'danger');
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.innerHTML = orig;
            showToast('Lỗi kết nối', 'danger');
        });
});

document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const data = new URLSearchParams(new FormData(form)).toString();
    const btn = form.querySelector('.btn-save');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...';

    fetch('<?= BASE_URL ?>customer/updateProfile', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: data
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = orig;
        if (res.success) {
            showToast('Cập nhật thành công');
            setTimeout(()=> location.reload(), 800);
        } else if (res.need_login) {
            window.location.href = '<?= BASE_URL ?>auth/login';
        } else {
            showToast(res.message || 'Lỗi', 'danger');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = orig;
        showToast('Lỗi kết nối', 'danger');
    });
});

/* small toast helper (if not present globally) */
function showToast(msg, type='success') {
    const colors = { success: '#10b981', danger:'#ef4444', info:'#3b82f6' };
    const el = document.createElement('div');
    el.style.cssText = `position:fixed;right:20px;top:20px;padding:12px 16px;border-radius:8px;color:#fff;z-index:99999;background:${colors[type]||colors.info};box-shadow:0 6px 20px rgba(0,0,0,0.12)`;
    el.textContent = msg;
    document.body.appendChild(el);
    setTimeout(()=> el.style.opacity = '0', 2000);
    setTimeout(()=> el.remove(), 2600);
}
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
