<?php 
require_once APP_ROOT . '/views/components/header.php'; 

// Helper function để render comment tree
function renderCommentTree($comments, $depth = 0, $articleAuthorId = null) {
    if (empty($comments)) return '';
    
    $html = '';
    foreach ($comments as $comment) {
        $aid = $articleAuthorId !== null ? (int) $articleAuthorId : 0;
        $cid = (int) ($comment['user_id'] ?? 0);
        $isArticleAuthor = $aid > 0 && $cid > 0 && $cid === $aid;
        $avatarLetter = !empty($comment['fullname']) ? mb_substr($comment['fullname'], 0, 1, 'UTF-8') : 'U';
        $replyClass = $depth > 0 ? 'comment-reply' : '';
        
        $html .= '<div class="comment-item ' . $replyClass . '" data-comment-id="' . $comment['id'] . '">';
        $html .= '<div class="comment-avatar">';
        $avPath = trim((string) ($comment['user_avatar'] ?? ''));
        if ($avPath !== '' && function_exists('pn_is_local_media_path') && pn_is_local_media_path($avPath)) {
            $html .= '<img src="' . htmlspecialchars(media_url($avPath)) . '" alt="" width="48" height="48" loading="lazy" style="width:48px;height:48px;border-radius:50%;object-fit:cover">';
        } else {
            $html .= '<div class="avatar-placeholder" style="width: 48px; height: 48px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6c757d; font-weight: bold; font-size: 1.2rem;">';
            $html .= htmlspecialchars($avatarLetter);
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '<div class="comment-content">';
        $html .= '<div class="comment-header">';
        $html .= '<span class="comment-author">' . htmlspecialchars($comment['fullname'] ?? 'Anonymous') . '</span>';
        if ($isArticleAuthor) {
            $html .= '<span class="comment-badge">Tác giả</span>';
        }
        $html .= '<span class="comment-date">' . date('d/m/Y H:i', strtotime($comment['created_at'])) . '</span>';
        $html .= '</div>';
        $html .= '<div class="comment-text">' . nl2br(htmlspecialchars($comment['content'])) . '</div>';
        $html .= '<div class="comment-actions">';
        $html .= '<button class="comment-action-btn like-btn" data-comment-id="' . $comment['id'] . '"><i class="fas fa-thumbs-up"></i> Thích <span class="like-count">0</span></button>';
        $html .= '<button class="comment-action-btn reply-btn" data-comment-id="' . $comment['id'] . '" data-comment-author="' . htmlspecialchars($comment['fullname'] ?? 'Anonymous') . '"><i class="fas fa-reply"></i> Trả lời</button>';
        $html .= '</div>';
        
        if (!empty($comment['replies'])) {
            $html .= '<div class="comment-replies" style="margin-top: 15px; padding-left: 30px;">';
            $html .= renderCommentTree($comment['replies'], $depth + 1, $articleAuthorId);
            $html .= '</div>';
        }
        
        $html .= '</div></div>';
    }
    
    return $html;
}

// Đếm tổng số bình luận (bao gồm replies)
function countTotalComments($comments) {
    if (empty($comments)) return 0;
    $count = count($comments);
    foreach ($comments as $comment) {
        if (!empty($comment['replies'])) {
            $count += countTotalComments($comment['replies']);
        }
    }
    return $count;
}
?>

<style>
    .breadcrumb-section {
        background-color: var(--phuongnam-light-gray);
        padding: 15px 0;
        margin-bottom: 30px;
    }

    .breadcrumb {
        background: none;
        margin-bottom: 0;
        padding: 0;
    }

    .breadcrumb-item a {
        color: var(--phuongnam-gray);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: var(--phuongnam-red);
    }

    .breadcrumb-item.active {
        color: var(--phuongnam-dark);
    }

    .page-title {
        color: var(--phuongnam-red);
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background-color: var(--phuongnam-orange);
    }

    .article-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--phuongnam-light-gray);
    }

    .article-category {
        background-color: var(--phuongnam-red);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 15px;
    }

    .article-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--phuongnam-dark);
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        color: var(--phuongnam-gray);
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .article-author {
        display: flex;
        align-items: center;
    }

    .article-author i {
        margin-right: 8px;
    }

    .article-date {
        display: flex;
        align-items: center;
    }

    .article-date i {
        margin-right: 8px;
    }

    .article-stats {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .article-stats i {
        margin-right: 5px;
    }

    .article-image {
        width: 100%;
        height: 400px;
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--phuongnam-dark);
        margin-bottom: 40px;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-content h2 {
        color: var(--phuongnam-red);
        margin: 2rem 0 1rem 0;
        font-size: 1.8rem;
    }

    .article-content h3 {
        color: var(--phuongnam-dark);
        margin: 1.5rem 0 1rem 0;
        font-size: 1.5rem;
    }

    .article-content ul,
    .article-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .article-content li {
        margin-bottom: 0.5rem;
    }

    .social-share {
        display: flex;
        gap: 15px;
        margin: 30px 0;
        padding: 20px 0;
        border-top: 1px solid var(--phuongnam-light-gray);
        border-bottom: 1px solid var(--phuongnam-light-gray);
    }

    .social-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 30px;
        text-decoration: none;
        color: white;
        font-weight: 500;
        transition: transform 0.3s;
    }

    .social-btn:hover {
        transform: translateY(-2px);
    }

    .social-btn.facebook {
        background-color: #3b5998;
    }

    .social-btn.twitter {
        background-color: #1da1f2;
    }

    .social-btn.linkedin {
        background-color: #0077b5;
    }

    .social-btn.whatsapp {
        background-color: #25d366;
    }

    .related-articles {
        margin-top: 50px;
    }

    .section-title {
        color: var(--phuongnam-red);
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background-color: var(--phuongnam-orange);
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    .related-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: inherit;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .related-image {
        height: 180px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-content {
        padding: 15px;
    }

    .related-title {
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 1rem;
        color: var(--phuongnam-dark);
    }

    .related-title:hover {
        color: var(--phuongnam-red);
    }

    .related-meta {
        display: flex;
        justify-content: space-between;
        color: var(--phuongnam-gray);
        font-size: 0.85rem;
    }

    .related-date {
        font-size: 0.8rem;
    }

    .article-navigation {
        display: flex;
        justify-content: space-between;
        margin: 40px 0;
        padding: 20px 0;
        border-top: 1px solid var(--phuongnam-light-gray);
        border-bottom: 1px solid var(--phuongnam-light-gray);
    }

    .nav-link {
        display: block;
        padding: 10px 20px;
        background-color: var(--phuongnam-light-gray);
        border-radius: 4px;
        text-decoration: none;
        color: var(--phuongnam-dark);
        transition: background-color 0.3s;
        max-width: 45%;
    }

    .nav-link:hover {
        background-color: var(--phuongnam-red);
        color: white;
    }

    .nav-next {
        margin-left: auto;
        text-align: right;
    }

    /* Comment Section Styles */
    .comments-section {
        margin: 50px 0;
        padding: 40px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .comments-section .section-title {
        margin-bottom: 30px;
    }

    .comments-section .section-title i {
        margin-right: 10px;
        color: var(--phuongnam-orange);
    }

    .comment-form-container {
        background: white;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 40px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .comment-form-title {
        color: var(--phuongnam-dark);
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }

    .comment-form .form-control {
        border: 1px solid #ddd;
        padding: 12px 15px;
        border-radius: 4px;
        transition: border-color 0.3s;
    }

    .comment-form .form-control:focus {
        border-color: var(--phuongnam-orange);
        box-shadow: 0 0 0 0.2rem rgba(247, 148, 30, 0.25);
    }

    .comment-submit-btn {
        background-color: var(--phuongnam-red);
        border: none;
        padding: 12px 30px;
        font-weight: 500;
        transition: background-color 0.3s, transform 0.2s;
    }

    .comment-submit-btn:hover {
        background-color: #a51b1f;
        transform: translateY(-2px);
    }

    .comment-submit-btn i {
        margin-right: 8px;
    }

    .comments-list {
        margin-top: 40px;
    }

    .comments-list-title {
        color: var(--phuongnam-dark);
        font-weight: 600;
        margin-bottom: 25px;
        font-size: 1.2rem;
    }

    .comment-item {
        display: flex;
        gap: 15px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .comment-avatar {
        flex-shrink: 0;
    }

    .comment-content {
        flex: 1;
    }

    .comment-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .comment-author {
        font-weight: 600;
        color: var(--phuongnam-dark);
    }

    .comment-badge {
        background-color: var(--phuongnam-orange);
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .comment-date {
        color: var(--phuongnam-gray);
        font-size: 0.85rem;
    }

    .comment-text {
        color: var(--phuongnam-dark);
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .comment-actions {
        display: flex;
        gap: 15px;
    }

    .comment-action-btn {
        background: none;
        border: none;
        color: var(--phuongnam-gray);
        font-size: 0.9rem;
        cursor: pointer;
        transition: color 0.3s;
        padding: 5px 0;
    }

    .comment-action-btn:hover {
        color: var(--phuongnam-red);
    }

    .comment-action-btn i {
        margin-right: 5px;
    }

    .comment-action-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .comment-reply {
        margin-top: 15px;
        margin-left: 50px;
        border-left: 3px solid var(--phuongnam-light-gray);
        padding-left: 20px;
    }

    .comment-reply .comment-item {
        background-color: #f8f9fa;
    }

    .comment-replies {
        margin-top: 15px;
        padding-left: 30px;
        border-left: 2px solid #e9ecef;
    }

    .avatar-placeholder {
        width: 48px;
        height: 48px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .alert {
        border-radius: 8px;
        padding: 12px 20px;
        font-size: 0.9rem;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    #loadMoreComments {
        padding: 10px 30px;
        border: 2px solid var(--phuongnam-gray);
        color: var(--phuongnam-gray);
        font-weight: 500;
        transition: all 0.3s;
    }

    #loadMoreComments:hover {
        background-color: var(--phuongnam-red);
        border-color: var(--phuongnam-red);
        color: white;
    }

    @media (max-width: 767.98px) {
        .article-title {
            font-size: 1.8rem;
        }
        
        .article-meta {
            flex-direction: column;
            gap: 10px;
        }
        
        .article-image {
            height: 250px;
        }
        
        .social-share {
            flex-direction: column;
        }
        
        .article-navigation {
            flex-direction: column;
            gap: 15px;
        }
        
        .nav-link {
            max-width: 100%;
            text-align: center;
        }
        
        .nav-next {
            margin-left: 0;
            text-align: center;
        }

        .comments-section {
            padding: 20px;
        }

        .comment-form-container {
            padding: 20px;
        }

        .comment-item {
            flex-direction: column;
            gap: 10px;
        }

        .comment-reply {
            margin-left: 20px;
            padding-left: 15px;
        }
        
        .comment-replies {
            padding-left: 15px;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>news">Tin tức</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($article['title'] ?? '') ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <article class="article">
        <header class="article-header">
            <div class="article-category"><?= ucfirst(str_replace('-', ' ', $article['category'] ?? '')) ?></div>
            <h1 class="article-title"><?= htmlspecialchars($article['title'] ?? '') ?></h1>
            <div class="article-meta">
                <div class="article-author">
                    <i class="fas fa-user"></i>
                    <span><?= htmlspecialchars($article['author_name'] ?? 'Admin') ?></span>
                </div>
                <div class="article-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span><?= date('d/m/Y', strtotime($article['published_date'] ?? $article['created_at'] ?? 'now')) ?></span>
                </div>
                <div class="article-stats">
                    <span><i class="fas fa-eye"></i> <?= $article['views'] ?? 0 ?> lượt xem</span>
                </div>
            </div>
            <div class="article-image">
                <img src="<?= e(pn_public_image_src($article['image_url'] ?? '')) ?>" alt="<?= htmlspecialchars($article['title'] ?? '') ?>">
            </div>
        </header>
        
        <div class="article-content">
            <?php
            $contentValue = isset($article['content']) ? (string) $article['content'] : '';

            if ($contentValue !== '') {
                $normalized = str_replace('\\n', "\n", $contentValue);
                // Đã lưu HTML (admin): hiển thị trực tiếp sau làm sạch — không bọc thêm <p> theo dòng.
                if (preg_match('/<[a-z][\\s\\S]*>/i', $normalized)) {
                    echo '<div class="article-body-html">' . pn_sanitize_html_local_media_only($normalized) . '</div>';
                } else {
                    $escaped = htmlspecialchars($normalized, ENT_QUOTES, 'UTF-8');
                    $paragraphs = explode("\n", $escaped);
                    foreach ($paragraphs as $paragraph) {
                        $paragraph = trim($paragraph);
                        if ($paragraph !== '') {
                            echo '<p>' . nl2br($paragraph) . '</p>';
                        }
                    }
                }
            } else {
                echo '<p><em>Nội dung bài viết đang được cập nhật...</em></p>';
            }
            ?>
        </div>
        
        <div class="social-share">
            <a href="#" class="social-btn facebook">
                <i class="fab fa-facebook-f"></i>
                Chia sẻ
            </a>
            <a href="#" class="social-btn twitter">
                <i class="fab fa-twitter"></i>
                Tweet
            </a>
            <a href="#" class="social-btn linkedin">
                <i class="fab fa-linkedin-in"></i>
                LinkedIn
            </a>
            <a href="#" class="social-btn whatsapp">
                <i class="fab fa-whatsapp"></i>
                WhatsApp
            </a>
        </div>
        
        <!-- Comment Section -->
        <div class="comments-section">
            <h2 class="section-title">
                <i class="fas fa-comments"></i> Bình luận (<?= countTotalComments($comments ?? []) ?>)
            </h2>
            
            <!-- Comment Form -->
            <div class="comment-form-container">
                <h4 class="comment-form-title">Để lại bình luận của bạn</h4>
                <?php
                $cp = $commentPrefill ?? null;
                $cpName = is_array($cp) ? trim((string) ($cp['fullname'] ?? '')) : '';
                $cpEmail = is_array($cp) ? trim((string) ($cp['email'] ?? '')) : '';
                ?>
                <form class="comment-form" id="commentForm" data-news-id="<?= $article['id'] ?? '' ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Họ và tên *" required value="<?= htmlspecialchars($cpName, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email *" required value="<?= htmlspecialchars($cpEmail, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    </div>
                    <input type="hidden" name="parent_id" id="parentId" value="">
                    <div class="mb-3">
                        <textarea class="form-control" name="comment" rows="5" placeholder="Nội dung bình luận *" required></textarea>
                    </div>
                    <div id="replyToInfo" class="mb-3" style="display: none;">
                        <span class="text-muted">Đang trả lời: <strong id="replyToName"></strong></span>
                        <button type="button" class="btn btn-sm btn-link" id="cancelReply">Hủy</button>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="saveInfo">
                        <label class="form-check-label" for="saveInfo">
                            Lưu tên và email để sử dụng cho lần bình luận tiếp theo
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary comment-submit-btn">
                        <i class="fas fa-paper-plane"></i> Gửi bình luận
                    </button>
                </form>
            </div>
            
            <!-- Comments List -->
            <div class="comments-list" id="commentsList">
                <h4 class="comments-list-title">Các bình luận</h4>
                
                <?php if (empty($comments)): ?>
                    <div class="text-center text-muted py-4" id="noCommentsMsg">
                        <i class="fas fa-comment-slash fa-2x mb-2 d-block"></i>
                        Chưa có bình luận nào. Hãy là người đầu tiên bình luận!
                    </div>
                <?php else: ?>
                    <?= renderCommentTree($comments ?? [], 0, (int) ($article['author_id'] ?? 0)) ?>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (!empty($relatedArticles)): ?>
        <div class="related-articles">
            <h2 class="section-title">Bài viết liên quan</h2>
            <div class="related-grid">
                <?php foreach ($relatedArticles as $related): ?>
                    <a href="<?= BASE_URL ?>news/detail/<?= $related['id'] ?? '' ?>" class="related-card">
                        <div class="related-image">
                            <img src="<?= e(pn_public_image_src($related['image_url'] ?? '')) ?>" alt="<?= htmlspecialchars($related['title'] ?? '') ?>">
                        </div>
                        <div class="related-content">
                            <h3 class="related-title"><?= htmlspecialchars($related['title'] ?? '') ?></h3>
                            <div class="related-meta">
                                <div class="related-author"><?= htmlspecialchars($related['author_name'] ?? 'Admin') ?></div>
                                <div class="related-date"><?= date('d/m', strtotime($related['published_date'] ?? 'now')) ?></div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </article>
</div>

<script>
// Helper function to format date
function formatCommentDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
    
    if (diffDays === 0) {
        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
        if (diffHours === 0) {
            const diffMins = Math.floor(diffMs / (1000 * 60));
            if (diffMins < 1) return 'Vừa xong';
            return `${diffMins} phút trước`;
        }
        return `${diffHours} giờ trước`;
    } else if (diffDays === 1) {
        return 'Hôm qua';
    } else if (diffDays < 7) {
        return `${diffDays} ngày trước`;
    } else {
        return date.toLocaleDateString('vi-VN');
    }
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Show alert message
function showAlert(message, type, container) {
    const existingAlert = container.querySelector('.comment-alert');
    if (existingAlert) existingAlert.remove();
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} comment-alert mt-3`;
    alertDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${escapeHtml(message)}`;
    container.parentNode.insertBefore(alertDiv, container.nextSibling);
    
    setTimeout(() => {
        if (alertDiv.parentNode) alertDiv.remove();
    }, 5000);
}

// Format existing comment dates
function formatExistingDates() {
    document.querySelectorAll('.comment-date').forEach(function(el) {
        const dateStr = el.textContent;
        if (dateStr && !dateStr.includes('trước') && !dateStr.includes('hôm') && !dateStr.includes('/')) {
            const date = new Date(dateStr);
            if (!isNaN(date.getTime())) {
                el.textContent = formatCommentDate(dateStr);
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('commentForm');
    const saveInfoCheckbox = document.getElementById('saveInfo');
    const newsId = commentForm ? commentForm.dataset.newsId : null;
    const replyToInfo = document.getElementById('replyToInfo');
    const parentIdInput = document.getElementById('parentId');
    const replyToNameSpan = document.getElementById('replyToName');
    const cancelReplyBtn = document.getElementById('cancelReply');
    
    if (!commentForm) return;
    
    // Load saved user info from localStorage
    const savedName = localStorage.getItem('commentUserName');
    const savedEmail = localStorage.getItem('commentUserEmail');
    
    if (savedName) {
        commentForm.querySelector('input[name="name"]').value = savedName;
        if (saveInfoCheckbox) saveInfoCheckbox.checked = true;
    }
    
    if (savedEmail) {
        commentForm.querySelector('input[name="email"]').value = savedEmail;
    }
    
    // Cancel reply
    if (cancelReplyBtn) {
        cancelReplyBtn.addEventListener('click', function() {
            if (parentIdInput) parentIdInput.value = '';
            if (replyToInfo) replyToInfo.style.display = 'none';
            if (replyToNameSpan) replyToNameSpan.textContent = '';
            commentForm.querySelector('textarea[name="comment"]').focus();
        });
    }
    
    // Handle reply button clicks (dynamic delegation)
    document.addEventListener('click', function(e) {
        const replyBtn = e.target.closest('.reply-btn');
        if (replyBtn) {
            e.preventDefault();
            const commentId = replyBtn.dataset.commentId;
            const commentAuthor = replyBtn.dataset.commentAuthor;
            
            if (parentIdInput) parentIdInput.value = commentId;
            if (replyToNameSpan) replyToNameSpan.textContent = commentAuthor;
            if (replyToInfo) replyToInfo.style.display = 'block';
            commentForm.querySelector('textarea[name="comment"]').focus();
            commentForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
    
    // Handle like button clicks
    document.addEventListener('click', function(e) {
        const likeBtn = e.target.closest('.like-btn');
        if (likeBtn) {
            e.preventDefault();
            const likeCountSpan = likeBtn.querySelector('.like-count');
            if (likeCountSpan) {
                let count = parseInt(likeCountSpan.textContent) || 0;
                likeCountSpan.textContent = count + 1;
                likeBtn.style.color = 'var(--phuongnam-orange)';
                likeBtn.disabled = true;
            }
        }
    });
    
    // Handle form submission
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            news_id: parseInt(newsId),
            name: commentForm.querySelector('input[name="name"]').value.trim(),
            email: commentForm.querySelector('input[name="email"]').value.trim(),
            content: commentForm.querySelector('textarea[name="comment"]').value.trim(),
            parent_id: parentIdInput ? (parentIdInput.value ? parseInt(parentIdInput.value) : null) : null
        };
        
        // Validation
        if (!formData.name || !formData.email || !formData.content) {
            showAlert('Vui lòng điền đầy đủ thông tin!', 'danger', commentForm);
            return;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(formData.email)) {
            showAlert('Email không hợp lệ!', 'danger', commentForm);
            return;
        }
        
        // Save user info if checkbox is checked
        if (saveInfoCheckbox && saveInfoCheckbox.checked) {
            localStorage.setItem('commentUserName', formData.name);
            localStorage.setItem('commentUserEmail', formData.email);
        } else {
            localStorage.removeItem('commentUserName');
            localStorage.removeItem('commentUserEmail');
        }
        
        // Send AJAX request
        const submitBtn = commentForm.querySelector('.comment-submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
        submitBtn.disabled = true;
        
        fetch('<?= BASE_URL ?>news/addComment', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success', commentForm);
                
                // Reset form
                commentForm.querySelector('textarea[name="comment"]').value = '';
                if (parentIdInput) parentIdInput.value = '';
                if (replyToInfo) replyToInfo.style.display = 'none';
                if (replyToNameSpan) replyToNameSpan.textContent = '';
                
                // Reload page to show new comment
                setTimeout(() => location.reload(), 1500);
            } else {
                const errorMsg = data.errors ? data.errors.join(', ') : 'Có lỗi xảy ra';
                showAlert(errorMsg, 'danger', commentForm);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Có lỗi xảy ra khi gửi bình luận', 'danger', commentForm);
        })
        .finally(() => {
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1000);
        });
    });
    
    // Format existing dates
    formatExistingDates();
});
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>