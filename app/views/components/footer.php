<?php
$pn = pn_site_settings();
$footerAddr = trim((string) ($pn['address'] ?? ''));
if ($footerAddr === '') {
    $footerAddr = '60-62 Lê Lợi, Q.1, TP.HCM';
}
$footerHotline = trim((string) ($pn['hotline'] ?? ''));
$footerPhoneAlt = trim((string) ($pn['phone'] ?? ''));
$footerPhoneShow = $footerHotline !== '' ? $footerHotline : ($footerPhoneAlt !== '' ? $footerPhoneAlt : '1900-6656');
$footerEmail = trim((string) ($pn['email'] ?? ''));
if ($footerEmail === '') {
    $footerEmail = 'info@phuongnam.com';
}
$footerHours = trim((string) ($pn['business_hours'] ?? ''));
$hrefFooterFb = pn_footer_safe_href($pn['fanpage'] ?? '');
$hrefFooterIg = pn_footer_safe_href($pn['instagram_url'] ?? '');
$hrefFooterYt = pn_footer_safe_href($pn['youtube_url'] ?? '');
$hrefFooterTk = pn_footer_safe_href($pn['tiktok_url'] ?? '');
?>
    <!-- Footer -->
    <footer class="footer mt-5" aria-label="Chân trang và đường liên kết">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <p id="about-heading" class="footer-column-title">Về PHƯƠNG NAM</p>
                        <ul class="list-unstyled" aria-labelledby="about-heading">
                            <li><a href="<?= BASE_URL ?>home/about" title="Giới thiệu về Phương Nam">Giới thiệu về Phương Nam</a></li>
                            <li><a href="#" title="Thông tin tuyển dụng">Tuyển dụng</a></li>
                            <li><a href="#" title="Chính sách bảo mật thông tin">Chính sách bảo mật</a></li>
                            <li><a href="#" title="Điều khoản sử dụng dịch vụ">Điều khoản sử dụng</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <p id="support-heading" class="footer-column-title">Hỗ trợ khách hàng</p>
                        <ul class="list-unstyled" aria-labelledby="support-heading">
                            <li><a href="<?= BASE_URL ?>home/qa?category=all" title="Câu hỏi thường gặp">Câu hỏi thường gặp</a></li>
                            <li><a href="<?= BASE_URL ?>home/qa?category=return" title="Chính sách đổi trả sản phẩm">Chính sách đổi trả</a></li>
                            <li><a href="<?= BASE_URL ?>home/qa?category=payment" title="Phương thức thanh toán">Phương thức thanh toán</a></li>
                            <li><a href="<?= BASE_URL ?>home/qa?category=order" title="Hướng dẫn mua hàng">Hướng dẫn mua hàng</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <p id="contact-heading" class="footer-column-title">Liên hệ</p>
                        <ul class="list-unstyled" aria-labelledby="contact-heading">
                            <li><span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <span><?= e($footerAddr) ?></span></span></li>
                            <li><span><i class="fas fa-phone" aria-hidden="true"></i> <span><?= e($footerPhoneShow) ?></span></span></li>
                            <li><span><i class="fas fa-envelope" aria-hidden="true"></i> <span><?= e($footerEmail) ?></span></span></li>
                        </ul>
                        <?php if ($footerHours !== ''): ?>
                            <p class="small text-muted mt-2 mb-0 footer-business-hours"><?= nl2br(e($footerHours)) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <p id="social-heading" class="footer-column-title">Kết nối với chúng tôi</p>
                        <div class="social-links" role="group" aria-labelledby="social-heading">
                            <a href="<?= $hrefFooterFb ?>" class="social-icon" aria-label="Facebook"<?= $hrefFooterFb !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                            </a>
                            <a href="<?= $hrefFooterIg ?>" class="social-icon" aria-label="Instagram"<?= $hrefFooterIg !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="<?= $hrefFooterYt ?>" class="social-icon" aria-label="YouTube"<?= $hrefFooterYt !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                <i class="fab fa-youtube" aria-hidden="true"></i>
                            </a>
                            <a href="<?= $hrefFooterTk ?>" class="social-icon" aria-label="TikTok"<?= $hrefFooterTk !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                <i class="fab fa-tiktok" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="mt-3">
                            <p id="payment-heading" class="footer-payment-heading">Phương thức thanh toán</p>
                            <div class="payment-methods" role="group" aria-labelledby="payment-heading">
                                <i class="fab fa-cc-visa" aria-label="Visa" role="img"></i>
                                <i class="fab fa-cc-mastercard" aria-label="MasterCard" role="img"></i>
                                <i class="fas fa-money-bill-wave" aria-label="Tiền mặt" role="img"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="mb-0">&copy; 2024 <?= APP_NAME ?>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global site scripts -->
    <script>
        // Global image lazy loading and performance improvements
        document.addEventListener('DOMContentLoaded', function() {
            // Add lazy loading to all images that don't have it
            const images = document.querySelectorAll('img:not([loading])');
            images.forEach(img => {
                img.setAttribute('loading', 'lazy');
            });

            // Add performance observer for Core Web Vitals simulation
            if ('requestIdleCallback' in window) {
                requestIdleCallback(function() {
                    // Defer non-critical tasks
                    const links = document.querySelectorAll('a');
                    links.forEach(link => {
                        if (link.hostname !== window.location.hostname && !link.getAttribute('target')) {
                            link.setAttribute('target', '_blank');
                            link.setAttribute('rel', 'noopener');
                        }
                    });
                });
            }
        });
    </script>
    <script>
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-wishlist');
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();

    const pid = btn.getAttribute('data-product-id');
    if (!pid) return;

    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch('<?= BASE_URL ?>customer/addWishlist', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'product_id=' + encodeURIComponent(pid)
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = orig;
        if (res.success) {
            // Visual feedback
            btn.classList.remove('btn-outline-danger');
            btn.classList.add('text-danger');
            btn.innerHTML = '<i class="fas fa-heart"></i>';
            showToast('Đã thêm vào yêu thích');
        } else if (res.need_login) {
            // nếu server yêu cầu login
            window.location.href = '<?= BASE_URL ?>auth/login';
        } else if (res.guest) {
            btn.classList.add('text-danger');
            btn.innerHTML = '<i class="fas fa-heart"></i>';
            showToast('Đã thêm tạm vào yêu thích (guest)');
        } else {
            showToast(res.message || 'Thêm thất bại', 'danger');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = orig;
        showToast('Lỗi kết nối', 'danger');
    });
});
</script>
</body>
</html>
