<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-container">
                <h2 class="mb-4 text-center">
                    <i class="fas fa-user-plus"></i> Thêm nhân viên mới
                </h2>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>admin/createStaff">
                    <div class="form-group">
                        <label for="fullname" class="form-label">
                            Họ và tên <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                        <div class="form-text">Email sẽ được sử dụng để đăng nhập hệ thống</div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            Mật khẩu <span class="required">*</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="6">
                        <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự</div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">
                            Số điện thoại
                        </label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">
                            Vai trò <span class="required">*</span>
                        </label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="staff" selected>Nhân viên</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="note" class="form-label">
                            Ghi chú
                        </label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Thông tin bổ sung về nhân viên..."><?= htmlspecialchars($old['note'] ?? '') ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Tạo tài khoản
                        </button>
                        <a href="<?= BASE_URL ?>admin/staff" class="btn-cancel text-center">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const email = document.getElementById('email');

    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Validate password length
        if (password.value.length < 6) {
            alert('Mật khẩu phải có ít nhất 6 ký tự');
            isValid = false;
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            alert('Email không hợp lệ');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>