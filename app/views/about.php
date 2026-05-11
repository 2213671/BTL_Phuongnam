<?php
require_once APP_ROOT . '/views/components/header.php';

$about_blocks = $about_blocks ?? pn_about_default_blocks();
$valueLeft = array_slice($about_blocks['value_cards'], 0, 3);
$valueRight = array_slice($about_blocks['value_cards'], 3, 3);
?>

<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container about-page">
    <?php if (trim((string) ($about_blocks['intro_lead'] ?? '')) !== ''): ?>
        <div class="about-intro-lead mb-4 p-3 rounded border bg-light">
            <p class="mb-0"><?= nl2br(e(trim((string) $about_blocks['intro_lead']))) ?></p>
        </div>
    <?php endif; ?>

    <div class="about-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2"><?= e((string) ($about_blocks['hero_title'] ?? '')) ?></h1>
                    <p class="mb-0"><?= nl2br(e((string) ($about_blocks['hero_text'] ?? ''))) ?></p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-book-reader" style="font-size: 120px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">20+</div>
                        <div class="stat-label">Năm kinh nghiệm</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Cửa hàng</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Khách hàng</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">100K+</div>
                        <div class="stat-label">Đầu sách</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="page-title">Sứ mệnh &amp; Tầm nhìn</h2>
        </div>
        <div class="col-md-6">
            <div class="info-card">
                <div class="icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="h4">Sứ mệnh</h3>
                <p class="mb-0"><?= nl2br(e((string) ($about_blocks['mission_text'] ?? ''))) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-card">
                <div class="icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3 class="h4">Tầm nhìn</h3>
                <p class="mb-0"><?= nl2br(e((string) ($about_blocks['vision_text'] ?? ''))) ?></p>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="page-title">Giá trị cốt lõi</h2>
        </div>
        <div class="col-md-6">
            <?php foreach ($valueLeft as $card): ?>
                <div class="value-card">
                    <h3 class="h5 mb-2"><i class="fas fa-check-circle"></i> <?= e((string) ($card['title'] ?? '')) ?></h3>
                    <p class="mb-0"><?= nl2br(e((string) ($card['text'] ?? ''))) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-6">
            <?php foreach ($valueRight as $card): ?>
                <div class="value-card">
                    <h3 class="h5 mb-2"><i class="fas fa-check-circle"></i> <?= e((string) ($card['title'] ?? '')) ?></h3>
                    <p class="mb-0"><?= nl2br(e((string) ($card['text'] ?? ''))) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="page-title">Lịch sử phát triển</h2>
        </div>
        <div class="col-md-12">
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon">1976</div>
                    <div class="timeline-content">
                        <h3 class="h5 mb-2">Thành lập công ty</h3>
                        <p>Công ty Phát hành Sách TP.HCM được thành lập, đánh dấu bước khởi đầu cho hành trình phát triển.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">2000</div>
                    <div class="timeline-content">
                        <h3 class="h5 mb-2">Chuyển đổi mô hình</h3>
                        <p>Chuyển đổi thành Công ty Cổ phần, mở rộng quy mô kinh doanh và nâng cao năng lực cạnh tranh.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">2010</div>
                    <div class="timeline-content">
                        <h3 class="h5 mb-2">Phát triển thương mại điện tử</h3>
                        <p>Ra mắt website bán hàng trực tuyến, tiên phong trong lĩnh vực bán sách online tại Việt Nam.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">2020</div>
                    <div class="timeline-content">
                        <h3 class="h5 mb-2">Mở rộng hệ thống</h3>
                        <p>Phát triển hệ thống cửa hàng trên toàn quốc, đạt mốc 100+ cửa hàng và trung tâm phân phối.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">2024</div>
                    <div class="timeline-content">
                        <h3 class="h5 mb-2">Chuyển đổi số toàn diện</h3>
                        <p>Ứng dụng công nghệ AI và Big Data, nâng cao trải nghiệm khách hàng và tối ưu hóa vận hành.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="page-title">Dịch vụ của chúng tôi</h2>
        </div>
        <?php
        $svcIcons = ['fas fa-shipping-fast', 'fas fa-undo-alt', 'fas fa-headset'];
        foreach (($about_blocks['service_cards'] ?? []) as $si => $svc):
            $ic = $svcIcons[(int) $si] ?? 'fas fa-circle';
            ?>
            <div class="col-md-4">
                <div class="info-card text-center">
                    <div class="icon">
                        <i class="<?= e($ic) ?>" aria-hidden="true"></i>
                    </div>
                    <h3 class="h4"><?= e((string) ($svc['title'] ?? '')) ?></h3>
                    <p class="mb-0"><?= nl2br(e((string) ($svc['text'] ?? ''))) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
