<?php
// views/auth/reset.php
if (!session_id()) session_start();
include __DIR__ . '/../components/header.php';
$errors = $data['errors'] ?? [];
$invalid = $data['invalid'] ?? false;
$token = $data['token'] ?? '';
$email = $data['email'] ?? '';
?>
<div class="container py-4" style="max-width:600px;">
    <h2>Đặt lại mật khẩu</h2>

    <?php if ($invalid): ?>
        <div class="alert alert-danger">Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.</div>
    <?php else: ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= (defined('BASE_URL') ? BASE_URL : '/') . 'auth/reset/' . htmlspecialchars($token) ?>">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($email) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="confirmPassword" class="form-control" required>
            </div>

            <button class="btn btn-primary">Đặt lại mật khẩu</button>
        </form>
    <?php endif; ?>

</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
