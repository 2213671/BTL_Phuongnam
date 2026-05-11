<?php // views/auth/login.php
if (!session_id()) session_start();
include __DIR__ . '/../components/header.php';
$errors = $data['errors'] ?? [];
$old = $data['old'] ?? [];
$redirect = $data['redirect'] ?? '';
?>
<div class="container mx-auto p-6 max-w-md">
  <h1>Đăng nhập</h1>

  <?php if (!empty($errors)): ?>
    <div style="color: #b91c1c; background:#fee2e2; padding:10px; border-radius:6px; margin-bottom:12px;">
      <?php foreach ($errors as $err): ?>
        <div><?=htmlspecialchars($err)?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>auth/login">
    <?php if ($redirect !== ''): ?>
      <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect, ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <div style="margin-bottom:10px;">
      <label>Email hoặc Số điện thoại</label><br>
      <input name="emailOrPhone" value="<?=htmlspecialchars($old['emailOrPhone'] ?? '')?>" required style="width:100%; padding:8px; border-radius:6px;">
    </div>

    <div style="margin-bottom:10px;">
      <label>Mật khẩu</label><br>
      <input name="password" type="password" required style="width:100%; padding:8px; border-radius:6px;">
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
      <label><input type="checkbox" name="remember"> Ghi nhớ</label>
      <a href="<?= BASE_URL ?>auth/forgot">Quên mật khẩu?</a>
    </div>

    <button type="submit" style="width:100%; padding:10px; background:#f97316; color:#fff; border:none; border-radius:8px;">Đăng nhập</button>
  </form>

  <p style="margin-top:12px;">Bạn chưa có tài khoản? <a href="<?= BASE_URL ?>auth/register" style="color:#f97316;">Đăng ký</a></p>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>
