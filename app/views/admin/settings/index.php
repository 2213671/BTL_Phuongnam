<?php if (!empty($settings_errors ?? [])): ?>
<div class="alert alert-danger mb-3" role="alert">
    <ul class="mb-0">
        <?php foreach ($settings_errors as $err): ?>
            <li><?= htmlspecialchars((string) $err, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="row row-cards">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title h5">Chân trang &amp; liên hệ</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Hotline</label>
                        <input type="text" class="form-control" name="hotline" value="<?= htmlspecialchars((string) ($settings['hotline'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" placeholder="VD: 1900 636 123">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Điện thoại phụ</label>
                        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars((string) ($settings['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" placeholder="VD: 028 3832 3456">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars((string) ($settings['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" placeholder="contact@...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="<?= htmlspecialchars((string) ($settings['address'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giờ làm việc</label>
                        <textarea class="form-control" name="business_hours" rows="3"><?= htmlspecialchars((string) ($settings['business_hours'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <hr class="my-4">
                    <h3 class="h6 mb-3">Mạng xã hội</h3>

                    <div class="mb-3">
                        <label class="form-label">Facebook</label>
                        <input type="url" class="form-control" name="fanpage" value="<?= htmlspecialchars((string) ($settings['fanpage'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="url" class="form-control" name="instagram_url" value="<?= htmlspecialchars((string) ($settings['instagram_url'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">YouTube</label>
                        <input type="url" class="form-control" name="youtube_url" value="<?= htmlspecialchars((string) ($settings['youtube_url'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">TikTok</label>
                        <input type="url" class="form-control" name="tiktok_url" value="<?= htmlspecialchars((string) ($settings['tiktok_url'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Lưu
                        </button>
                        <a href="<?= BASE_URL ?>admin" class="btn btn-link">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
