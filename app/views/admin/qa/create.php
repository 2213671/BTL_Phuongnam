<?php
$qaOld = $qa_old ?? [];
?>
<div class="container-fluid">
    <?php if (!empty($qa_errors ?? [])): ?>
        <div class="alert alert-danger mb-3" role="alert">
            <ul class="mb-0">
                <?php foreach ($qa_errors as $err): ?>
                    <li><?= htmlspecialchars((string) $err, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="row mb-3">
        <div class="col">
            <p class="text-muted mb-0">Tạo mới câu hỏi và câu trả lời mẫu</p>
        </div>
        <div class="col-auto">
            <a href="<?= BASE_URL ?>admin/qa" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form method="POST" class="card shadow-sm">
                <div class="card-header">
                    <h2 class="card-title h5 mb-0"><i class="fa-solid fa-pen-to-square me-2"></i> Thông tin câu hỏi</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Câu hỏi thường gặp <span class="text-danger">*</span></label>
                        <input type="text" name="question" class="form-control" placeholder="Ví dụ: Làm sao để đổi trả hàng?" required
                               value="<?= htmlspecialchars((string) ($qaOld['question'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                        <small class="text-muted">Câu hỏi ngắn gọn hiển thị trên trang.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category" class="form-select">
                            <?php
                            $qc = (string) ($qaOld['category'] ?? 'Chung');
                            $opts = ['Chung', 'Thanh toán', 'Vận chuyển', 'Bảo hành'];
                            foreach ($opts as $opt):
                                ?>
                            <option value="<?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>"<?= $qc === $opt ? ' selected' : '' ?>><?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung trả lời <span class="text-danger">*</span></label>
                        <textarea name="answer" class="form-control" rows="6" placeholder="Chi tiết câu trả lời..." required><?= htmlspecialchars((string) ($qaOld['answer'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-white">
                    <a href="<?= BASE_URL ?>admin/qa" class="btn btn-link text-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
