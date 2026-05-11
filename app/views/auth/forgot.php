<?php
// app/views/auth/forgot.php
if (!session_id()) session_start();
include __DIR__ . '/../components/header.php';

// dữ liệu từ controller
$errors = $data['errors'] ?? [];
$success = $data['success'] ?? null;
$sent = $data['sent'] ?? false;         // nếu controller gán sent => true thì sẽ show OTP form
$email = $data['email'] ?? ($data['old']['email'] ?? '');
$message = $data['message'] ?? '';
?>
<div class="container py-4" style="max-width:600px;">
    <h2>Quên mật khẩu</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!$sent): ?>
        <!-- Step 1: gửi OTP -->
        <form method="post" action="<?= defined('BASE_URL') ? BASE_URL . 'auth/forgot' : '/auth/forgot' ?>">
            <input type="hidden" name="action" value="send">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
            </div>
            <button class="btn btn-primary">Gửi mã OTP</button>
        </form>
    <?php else: ?>
        <!-- Step 2: nhập OTP + mật khẩu mới -->
        <form method="post" action="<?= defined('BASE_URL') ? BASE_URL . 'auth/forgot' : '/auth/forgot' ?>">
            <input type="hidden" name="action" value="verify">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Mã OTP</label>
                <input type="text" name="otp" class="form-control" required maxlength="6" pattern="\d{6}">
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="confirmPassword" class="form-control" required>
            </div>
            <button class="btn btn-primary">Xác nhận & Đổi mật khẩu</button>
        </form>
    <?php endif; ?>

    <p class="mt-3"><a href="<?= defined('BASE_URL') ? BASE_URL . 'auth/login' : '/auth/login' ?>">Quay lại đăng nhập</a></p>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
