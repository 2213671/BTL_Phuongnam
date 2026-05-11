<?php // views/auth/register.php
if (!session_id()) session_start();
include __DIR__ . '/../components/header.php';
$errors = $data['errors'] ?? [];
$old = $data['old'] ?? [];
?>
<div class="container mx-auto p-6 max-w-md">
  <h1>Đăng ký</h1>

  <?php if (!empty($errors)): ?>
    <div style="color: #b91c1c; background:#fee2e2; padding:10px; border-radius:6px; margin-bottom:12px;">
      <?php foreach ($errors as $err): ?>
        <div><?=htmlspecialchars($err)?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>auth/register">
    <div style="margin-bottom:10px;">
      <label>Họ và tên</label><br>
      <input name="fullname" value="<?=htmlspecialchars($old['fullname'] ?? '')?>" required style="width:100%; padding:8px; border-radius:6px;">
    </div>

    <div style="margin-bottom:10px;">
      <label>Email hoặc Số điện thoại</label><br>
      <input name="emailOrPhone" value="<?=htmlspecialchars($old['emailOrPhone'] ?? '')?>" required style="width:100%; padding:8px; border-radius:6px;">
    </div>

    <div style="margin-bottom:10px;">
      <label>Mật khẩu</label><br>
      <input name="password" type="password" required style="width:100%; padding:8px; border-radius:6px;">
    </div>

    <div style="margin-bottom:10px;">
      <label>Xác nhận mật khẩu</label><br>
      <input name="confirmPassword" type="password" required style="width:100%; padding:8px; border-radius:6px;">
    </div>

    <button type="submit" style="width:100%; padding:10px; background:#f97316; color:#fff; border:none; border-radius:8px;">Đăng ký</button>
  </form>

  <p style="margin-top:12px;">Bạn đã có tài khoản? <a href="<?= BASE_URL ?>auth/login" style="color:#f97316;">Đăng nhập</a></p>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>
