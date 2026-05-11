<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<?php
$contactPhoneShow = trim((string) ($settings['hotline'] ?? ''));
if ($contactPhoneShow === '') {
    $contactPhoneShow = trim((string) ($settings['phone'] ?? ''));
}
if ($contactPhoneShow === '') {
    $contactPhoneShow = 'Chưa cập nhật';
}
$contactBh = trim((string) ($settings['business_hours'] ?? ''));
$hrefContactFb = pn_footer_safe_href($settings['fanpage'] ?? '');
$hrefContactIg = pn_footer_safe_href($settings['instagram_url'] ?? '');
$hrefContactYt = pn_footer_safe_href($settings['youtube_url'] ?? '');
$hrefContactTk = pn_footer_safe_href($settings['tiktok_url'] ?? '');
?>

<div class="contact-page">

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="contact-hero">
        <h1 class="h2 mb-3"><i class="fas fa-phone-alt" aria-hidden="true"></i> Liên hệ với chúng tôi</h1>
        <p>Nhà sách Phương Nam - Nơi chia sẻ tri thức, lan tỏa yêu thương</p>
    </div>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-md-5">
            <div class="contact-info">
                <h2 class="page-title mb-4">Thông tin liên hệ</h2>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <p class="contact-item-title">Địa chỉ</p>
                        <p>Địa chỉ: <?= htmlspecialchars($settings['address'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-details">
                        <p class="contact-item-title">Điện thoại</p>
                        <p>Hotline: <?= htmlspecialchars($contactPhoneShow, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <p class="contact-item-title">Email</p>
                        <p>Email: <?= htmlspecialchars($settings['email'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <p class="contact-item-title">Thời gian làm việc</p>
                        <?php if ($contactBh !== ''): ?>
                            <p class="mb-0"><?= nl2br(e($contactBh)) ?></p>
                        <?php else: ?>
                            <table class="hours-table">
                                <tr>
                                    <td>Thứ 2 - Thứ 6</td>
                                    <td>8:00 - 21:00</td>
                                </tr>
                                <tr>
                                    <td>Thứ 7 - Chủ nhật</td>
                                    <td>8:00 - 22:00</td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="social-contacts">
                    <a href="<?= $hrefContactFb ?>" class="social-btn" title="Facebook"<?= $hrefContactFb !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="<?= $hrefContactIg ?>" class="social-btn" title="Instagram"<?= $hrefContactIg !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="<?= $hrefContactYt ?>" class="social-btn" title="YouTube"<?= $hrefContactYt !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="<?= $hrefContactTk ?>" class="social-btn" title="TikTok"<?= $hrefContactTk !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Contact Form -->
        <div class="col-md-7">
            <div class="contact-form">
                <h2 class="page-title mb-4">Gửi yêu cầu liên hệ</h2>
                
                <?php if (isset($success)): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>contact/submit" id="contactForm" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger" aria-hidden="true">*</span><span class="visually-hidden"> (bắt buộc)</span></label>
                                <input type="text"
                                       class="form-control <?= isset($errors['name']) ? 'error' : '' ?>"
                                       id="name"
                                       name="name"
                                       value="<?= htmlspecialchars($old_data['name'] ?? '') ?? '' ?>"
                                       placeholder="Nhập họ tên của bạn"
                                       required
                                       aria-describedby="name-error">
                                <?php if (isset($errors['name'])): ?>
                                    <div class="error-message" id="name-error"><?= $errors['name'] ?></div>
                                <?php else: ?>
                                    <div class="error-message" id="name-error" style="display:none;"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger" aria-hidden="true">*</span><span class="visually-hidden"> (bắt buộc)</span></label>
                                <input type="email"
                                       class="form-control <?= isset($errors['email']) ? 'error' : '' ?>"
                                       id="email"
                                       name="email"
                                       value="<?= htmlspecialchars($old_data['email'] ?? '') ?? '' ?>"
                                       placeholder="Nhập địa chỉ email"
                                       required
                                       aria-describedby="email-error">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="error-message" id="email-error"><?= $errors['email'] ?></div>
                                <?php else: ?>
                                    <div class="error-message" id="email-error" style="display:none;"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger" aria-hidden="true">*</span><span class="visually-hidden"> (bắt buộc)</span></label>
                        <input type="tel"
                               class="form-control <?= isset($errors['phone']) ? 'error' : '' ?>"
                               id="phone"
                               name="phone"
                               value="<?= htmlspecialchars($old_data['phone'] ?? '') ?? '' ?>"
                               placeholder="Nhập số điện thoại"
                               required
                               aria-describedby="phone-error">
                        <?php if (isset($errors['phone'])): ?>
                            <div class="error-message" id="phone-error"><?= $errors['phone'] ?></div>
                        <?php else: ?>
                            <div class="error-message" id="phone-error" style="display:none;"></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">Tiêu đề <span class="text-danger" aria-hidden="true">*</span><span class="visually-hidden"> (bắt buộc)</span></label>
                        <input type="text"
                               class="form-control <?= isset($errors['subject']) ? 'error' : '' ?>"
                               id="subject"
                               name="subject"
                               value="<?= htmlspecialchars($old_data['subject'] ?? '') ?? '' ?>"
                               placeholder="Nhập tiêu đề"
                               required
                               aria-describedby="subject-error">
                        <?php if (isset($errors['subject'])): ?>
                            <div class="error-message" id="subject-error"><?= $errors['subject'] ?></div>
                        <?php else: ?>
                            <div class="error-message" id="subject-error" style="display:none;"></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Nội dung <span class="text-danger" aria-hidden="true">*</span><span class="visually-hidden"> (bắt buộc)</span></label>
                        <textarea class="form-control <?= isset($errors['message']) ? 'error' : '' ?>"
                                  id="message"
                                  name="message"
                                  rows="5"
                                  placeholder="Nhập nội dung tin nhắn của bạn"
                                  required
                                  aria-describedby="message-error"><?= htmlspecialchars($old_data['message'] ?? '') ?? '' ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <div class="error-message" id="message-error"><?= $errors['message'] ?></div>
                        <?php else: ?>
                            <div class="error-message" id="message-error" style="display:none;"></div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Gửi yêu cầu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    // Enhanced real-time form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        if (!form) return;

        // Add input event listeners for real-time validation
        const fields = ['name', 'email', 'phone', 'subject', 'message'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', function() {
                    validateField(fieldId);
                });

                field.addEventListener('input', function() {
                    if (this.classList.contains('error')) {
                        validateField(fieldId);
                    }
                });
            }
        });

        // Form submission handler
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate all fields
            let isValid = true;
            for (const fieldId of fields) {
                if (!validateField(fieldId)) {
                    isValid = false;
                }
            }

            if (isValid) {
                // If all validations pass, submit the form
                e.target.submit();
            } else {
                // Focus on the first invalid field
                const firstErrorField = form.querySelector('.form-control.error');
                if (firstErrorField) {
                    firstErrorField.focus();
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        function validateField(fieldId) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById(fieldId + '-error');
            let isValid = true;
            let errorMessage = '';

            const value = field.value.trim();

            // Clear previous error
            field.classList.remove('error');
            if (errorElement) {
                errorElement.style.display = 'none';
                errorElement.textContent = '';
            }

            // Required validation
            if (!value) {
                errorMessage = getRequiredMessage(fieldId);
                isValid = false;
            } else {
                // Additional field-specific validation
                switch(fieldId) {
                    case 'email':
                        if (!isValidEmail(value)) {
                            errorMessage = 'Email không hợp lệ';
                            isValid = false;
                        }
                        break;
                    case 'phone':
                        if (!isValidPhone(value)) {
                            errorMessage = 'Số điện thoại không hợp lệ';
                            isValid = false;
                        }
                        break;
                }
            }

            if (!isValid && errorElement) {
                field.classList.add('error');
                errorElement.textContent = errorMessage;
                errorElement.style.display = 'block';
            }

            return isValid;
        }

        function getRequiredMessage(fieldId) {
            const messages = {
                'name': 'Vui lòng nhập họ tên',
                'email': 'Vui lòng nhập email',
                'phone': 'Vui lòng nhập số điện thoại',
                'subject': 'Vui lòng nhập tiêu đề',
                'message': 'Vui lòng nhập nội dung'
            };
            return messages[fieldId] || 'Trường này là bắt buộc';
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhone(phone) {
            const phoneRegex = /^[0-9]{10,11}$/;
            return phoneRegex.test(phone);
        }
    });
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
