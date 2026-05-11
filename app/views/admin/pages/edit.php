<?php
$currPage = $currPage ?? 'about';
$about_edit = $about_edit ?? pn_about_default_blocks();
$page_content_errors = $page_content_errors ?? [];
$about_flash_error = $about_flash_error ?? null;
?>
<?php if (!empty($about_flash_error)): ?>
    <div class="alert alert-danger mb-3" role="alert"><?= htmlspecialchars($about_flash_error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($page_content_errors)): ?>
<div class="alert alert-danger mb-3" role="alert">
    <ul class="mb-0">
        <?php foreach ($page_content_errors as $err): ?>
            <li><?= htmlspecialchars((string) $err, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <h2 class="card-title h5 mb-3">Chỉnh sửa trang Giới thiệu</h2>

        <form method="post">
            <h3 class="h6 mt-2 mb-3">Đoạn dẫn</h3>
            <div class="mb-3">
                <textarea class="form-control" name="intro_lead" rows="3"><?= htmlspecialchars((string) ($about_edit['intro_lead'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <h3 class="h6 mt-4 mb-3">Tiêu đề &amp; mô tả chính</h3>
            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" name="hero_title" maxlength="300"
                       value="<?= htmlspecialchars((string) ($about_edit['hero_title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="hero_text" rows="4"><?= htmlspecialchars((string) ($about_edit['hero_text'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <h3 class="h6 mt-4 mb-3">Sứ mệnh &amp; Tầm nhìn</h3>
            <div class="mb-3">
                <label class="form-label">Sứ mệnh</label>
                <textarea class="form-control" name="mission_text" rows="4"><?= htmlspecialchars((string) ($about_edit['mission_text'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tầm nhìn</label>
                <textarea class="form-control" name="vision_text" rows="4"><?= htmlspecialchars((string) ($about_edit['vision_text'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <h3 class="h6 mt-4 mb-3">Giá trị cốt lõi</h3>
            <div class="row g-3">
                <?php foreach (($about_edit['value_cards'] ?? []) as $vi => $card): ?>
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <div class="fw-semibold small text-muted mb-2"><?= (int) $vi + 1 ?></div>
                            <input type="text" class="form-control form-control-sm mb-2" name="value_title[]"
                                   maxlength="220"
                                   value="<?= htmlspecialchars((string) ($card['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                            <textarea class="form-control form-control-sm" name="value_text[]" rows="3"><?= htmlspecialchars((string) ($card['text'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <h3 class="h6 mt-4 mb-3">Dịch vụ</h3>
            <div class="row g-3">
                <?php foreach (($about_edit['service_cards'] ?? []) as $si => $svc): ?>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="fw-semibold small text-muted mb-2"><?= (int) $si + 1 ?></div>
                            <input type="text" class="form-control form-control-sm mb-2" name="service_title[]"
                                   maxlength="220"
                                   value="<?= htmlspecialchars((string) ($svc['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                            <textarea class="form-control form-control-sm" name="service_text[]" rows="3"><?= htmlspecialchars((string) ($svc['text'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="form-footer mt-4 d-flex flex-wrap gap-2 align-items-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu</button>
                <a href="<?= htmlspecialchars(BASE_URL . 'home/about', ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline-secondary" target="_blank" rel="noopener">Xem trang</a>
            </div>
        </form>

        <hr class="my-4">

        <form method="post" onsubmit="return confirm('Khôi phục nội dung mặc định cho trang Giới thiệu?');">
            <input type="hidden" name="restore_about_defaults" value="1">
            <button type="submit" class="btn btn-outline-warning btn-sm"><i class="fas fa-undo me-1"></i> Khôi phục mặc định</button>
        </form>
    </div>
</div>
