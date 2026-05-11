<?php
/**
 * File cấu hình chính của ứng dụng
 * Chứa tất cả các thiết lập và hằng số toàn cục
 */

// =================================
// CẤU HÌNH DATABASE
// =================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'phuongnam_db');
//use port 3307
define('DB_PORT', 3306);

// =================================
// CẤU HÌNH ỨNG DỤNG
// =================================
define('APP_NAME', 'Nhà sách Phương Nam');

// Đường dẫn tuyệt đối (khai báo trước để suy ra BASE_URL đúng với tên thư mục thật)
define('APP_ROOT', dirname(dirname(__FILE__))); // .../app/
define('ROOT', dirname(APP_ROOT)); // thư mục gốc dự án
define('PUBLIC_PATH', ROOT . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

/** Tên thư mục dự án trên disk (vd: BTL_Phuongnam) — dùng cho log/tài liệu */
define('PROJECT_NAME', basename(ROOT));

/**
 * URL gốc trỏ tới thư mục public (index.php, media/, css/, js/).
 * Tự nhận diện theo SCRIPT_NAME để khớp mọi cách chạy: htdocs/subfolder/public,
 * DocumentRoot trỏ thẳng vào public, hoặc đổi tên thư mục không cần sửa tay.
 */
if (!defined('BASE_URL')) {
    $detectedBase = null;
    if (PHP_SAPI !== 'cli' && !empty($_SERVER['HTTP_HOST']) && !empty($_SERVER['SCRIPT_NAME'])) {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        $scheme = $https ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $script = str_replace('\\', '/', (string) $_SERVER['SCRIPT_NAME']);
        $dir = dirname($script);
        if ($dir === '/' || $dir === '.') {
            $path = '/';
        } else {
            $path = rtrim($dir, '/') . '/';
        }
        $detectedBase = $scheme . '://' . $host . $path;
    }
    if ($detectedBase === null) {
        $folder = basename(ROOT);
        $detectedBase = 'http://localhost/' . $folder . '/public/';
    }
    define('BASE_URL', $detectedBase);
}

/** Ảnh nền hero trang chủ — chỉ dùng khối banner đầu; không dùng làm ảnh tin. */
if (!defined('MEDIA_HOME_HERO_BG')) {
    define('MEDIA_HOME_HERO_BG', 'media/home/library.jpg');
}
/** Ảnh thay thế khi bài tin không có ảnh hoặc DB trỏ nhầm vào media/home. */
if (!defined('MEDIA_NEWS_PLACEHOLDER')) {
    define('MEDIA_NEWS_PLACEHOLDER', 'media/news/article-placeholder.jpg');
}

/** URL route trong app (luôn gắn với BASE_URL động). */
if (!function_exists('site_url')) {
    function site_url(string $path = ''): string {
        return rtrim(BASE_URL, '/') . '/' . ltrim(str_replace('\\', '/', $path), '/');
    }
}

/** URL tới file tĩnh trong public/ (media, css, js, …) */
if (!function_exists('asset_url')) {
    function asset_url(string $path = ''): string {
        $base = rtrim(BASE_URL, '/') . '/';
        if ($path === '') {
            return $base;
        }
        return $base . ltrim(str_replace('\\', '/', $path), '/');
    }
}

/**
 * Chuẩn hoá đường dẫn ảnh trong DB (legacy images/...) → public/media/...
 */
if (!function_exists('normalize_media_relative_path')) {
    function normalize_media_relative_path(string $path): string {
        $path = ltrim(str_replace('\\', '/', trim($path)), '/');
        if ($path === '') {
            return 'media/products/default-book.jpg';
        }
        $map = [
            'images/news-page/' => 'media/news/',
            'images/product-page/' => 'media/products/',
            'images/home-page/' => 'media/home/',
            'images/uploads/' => 'media/uploads/',
            'images/reviews/' => 'media/reviews/',
        ];
        foreach ($map as $old => $new) {
            if (strpos($path, $old) === 0) {
                return $new . substr($path, strlen($old));
            }
        }
        if (strpos($path, 'media/') === 0) {
            return $path;
        }
        // Legacy: chỉ có news-page/... trong một số bản cũ
        if (strpos($path, 'news-page/') === 0) {
            return 'media/news/' . substr($path, strlen('news-page/'));
        }
        return 'media/uploads/' . $path;
    }
}

/** URL đầy đủ tới ảnh/video trong public/media (hoặc URL tuyệt đối http(s)). */
if (!function_exists('media_url')) {
    function media_url(string $path): string {
        $path = trim($path);
        if ($path === '') {
            return asset_url('media/products/default-book.jpg');
        }
        if (preg_match('#^https?://#i', $path)) {
            return asset_url('media/products/default-book.jpg');
        }
        return asset_url(normalize_media_relative_path($path));
    }
}

/** Escape HTML khi echo (public layout và admin). */
if (!function_exists('e')) {
    function e($v): string {
        return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Ảnh đại diện tin tức: không dùng media/home (ảnh hero/banner), kể cả khi DB ghi nhầm.
 */
if (!function_exists('pn_public_image_src')) {
    function pn_public_image_src($path, $defaultRelative = null): string {
        $path = trim((string) $path);
        $fallback = $defaultRelative ?? MEDIA_NEWS_PLACEHOLDER;
        if ($path === '') {
            return asset_url($fallback);
        }
        if (preg_match('#^https?://#i', $path)) {
            return asset_url($fallback);
        }
        $norm = normalize_media_relative_path($path);
        if ($norm === 'media/news/default.jpg') {
            return asset_url($fallback);
        }
        if (strpos($norm, 'media/home/') === 0) {
            return asset_url($fallback);
        }
        return asset_url($norm);
    }
}

/** Slug ASCII cho URL SEO (tin tức). */
if (!function_exists('pn_slugify')) {
    function pn_slugify(string $text): string {
        $text = mb_strtolower(trim($text), 'UTF-8');
        $map = [
            'à'=>'a','á'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a','ă'=>'a','ằ'=>'a','ắ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a',
            'â'=>'a','ầ'=>'a','ấ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a','è'=>'e','é'=>'e','ẻ'=>'e','ẽ'=>'e','ẹ'=>'e',
            'ê'=>'e','ề'=>'e','ế'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e','ì'=>'i','í'=>'i','ỉ'=>'i','ĩ'=>'i','ị'=>'i',
            'ò'=>'o','ó'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o','ô'=>'o','ồ'=>'o','ố'=>'o','ổ'=>'o','ỗ'=>'o','ộ'=>'o',
            'ơ'=>'o','ờ'=>'o','ớ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o','ù'=>'u','ú'=>'u','ủ'=>'u','ũ'=>'u','ụ'=>'u',
            'ư'=>'u','ừ'=>'u','ứ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u','ỳ'=>'y','ý'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y','đ'=>'d',
        ];
        $text = strtr($text, $map);
        $text = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text;
        $text = strtolower((string) $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim((string) $text, '-');
        return $text !== '' ? $text : 'bai-viet';
    }
}

/** Ảnh trong DB phải là đường dẫn cục bộ (media/...), không hotlink. */
if (!function_exists('pn_is_local_media_path')) {
    function pn_is_local_media_path(?string $path): bool {
        if ($path === null || trim($path) === '') {
            return true;
        }
        $path = trim($path);
        if (preg_match('#^[a-z][a-z0-9+.-]*://#i', $path)) {
            return false;
        }
        $norm = ltrim(str_replace('\\', '/', $path), '/');
        return strpos($norm, 'media/') === 0 && strpos($norm, '..') === false;
    }
}

/**
 * Cho phép src ảnh trong HTML admin: đường dẫn tới media/ cục bộ hoặc cùng host với BASE_URL.
 */
if (!function_exists('pn_admin_allowed_media_src')) {
    function pn_admin_allowed_media_src(string $src): bool {
        $src = trim(html_entity_decode($src, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($src === '') {
            return false;
        }
        if (stripos($src, 'data:') === 0) {
            return false;
        }
        if (preg_match('#^[a-z][a-z0-9+.-]*://#i', $src)) {
            $path = (string) (parse_url($src, PHP_URL_PATH) ?? '');
            $host = (string) (parse_url($src, PHP_URL_HOST) ?? '');
            $baseHost = '';
            if (defined('BASE_URL')) {
                $baseHost = (string) (parse_url(BASE_URL, PHP_URL_HOST) ?? '');
            }
            if ($host !== '' && $baseHost !== '' && strcasecmp($host, $baseHost) !== 0) {
                return false;
            }
            $path = str_replace('\\', '/', $path);

            return strpos($path, '/media/') !== false;
        }
        $norm = str_replace('\\', '/', $src);
        if (strpos($norm, '..') !== false) {
            return false;
        }
        $norm = ltrim($norm, '/');

        return strpos($norm, 'media/') === 0 || strpos($norm, '/media/') !== false;
    }
}

/**
 * Loại ảnh hotlink / URL ngoài khỏi HTML (tin tức, trang tĩnh). Giữ ảnh trỏ tới media/ hợp lệ.
 */
if (!function_exists('pn_sanitize_html_local_media_only')) {
    function pn_sanitize_html_local_media_only(?string $html): string {
        if ($html === null || $html === '') {
            return '';
        }
        if (!class_exists('DOMDocument')) {
            return $html;
        }

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $meta = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        @$doc->loadHTML($meta . $html);
        $xpath = new DOMXPath($doc);

        $toRemove = [];
        foreach ($xpath->query('//img[@src]') as $img) {
            if (!$img instanceof DOMElement) {
                continue;
            }
            if (!pn_admin_allowed_media_src($img->getAttribute('src'))) {
                $toRemove[] = $img;
            }
        }
        foreach ($toRemove as $img) {
            $img->parentNode?->removeChild($img);
        }

        foreach ($xpath->query('//img[@srcset]') as $img) {
            if (!$img instanceof DOMElement) {
                continue;
            }
            $srcset = $img->getAttribute('srcset');
            $parts = preg_split('/\s*,\s*/', $srcset) ?: [];
            $kept = [];
            foreach ($parts as $part) {
                $part = trim($part);
                if ($part === '') {
                    continue;
                }
                $url = preg_replace('/\s+\d+(?:\.\d+)?[xw]\s*$/i', '', $part);
                $url = trim((string) $url);
                if ($url !== '' && pn_admin_allowed_media_src($url)) {
                    $kept[] = $part;
                }
            }
            if ($kept === []) {
                $img->removeAttribute('srcset');
            } else {
                $img->setAttribute('srcset', implode(', ', $kept));
            }
        }

        foreach ($xpath->query('//*[@style]') as $el) {
            if (!$el instanceof DOMElement) {
                continue;
            }
            $st = $el->getAttribute('style');
            if ($st !== '' && preg_match('#url\s*\(\s*[\'"]?\s*https?://#i', $st)) {
                $el->removeAttribute('style');
            }
        }

        $body = $doc->getElementsByTagName('body')->item(0);
        if (!$body) {
            libxml_clear_errors();

            return $html;
        }

        $out = '';
        foreach ($body->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }
        libxml_clear_errors();

        return $out;
    }
}

/**
 * Chuỗi query GET cho danh sách (tin/sản phẩm): bỏ tham số rỗng.
 *
 * @param array<string, string|int|float|null> $params
 */
if (!function_exists('listing_http_build_query')) {
    function listing_http_build_query(array $params): string {
        $filtered = [];
        foreach ($params as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $filtered[$key] = $value;
        }
        return http_build_query($filtered, '', '&', PHP_QUERY_RFC3986);
    }
}

/**
 * Các số trang hiển thị quanh trang hiện tại; dùng -1 để render dấu "…".
 *
 * @return int[]
 */
if (!function_exists('pagination_visible_pages')) {
    function pagination_visible_pages(int $current, int $total, int $radius = 2): array {
        if ($total <= 1) {
            return [];
        }
        $current = max(1, min($current, $total));
        $set = [];
        $set[1] = true;
        $set[$total] = true;
        for ($i = $current - $radius; $i <= $current + $radius; $i++) {
            if ($i >= 1 && $i <= $total) {
                $set[$i] = true;
            }
        }
        ksort($set);
        $keys = array_keys($set);
        $out = [];
        $prev = 0;
        foreach ($keys as $p) {
            if ($prev && $p - $prev > 1) {
                $out[] = -1;
            }
            $out[] = $p;
            $prev = $p;
        }
        return $out;
    }
}

if (!function_exists('pn_site_settings')) {
    function pn_site_settings(): array {
        static $cache = null;
        if ($cache !== null) {
            return $cache;
        }
        if (!class_exists('Admin', false)) {
            require_once APP_ROOT . '/models/Admin.php';
        }
        $cache = (new Admin())->getSettings();

        return $cache;
    }
}

if (!function_exists('pn_footer_safe_href')) {
    function pn_footer_safe_href(?string $url): string {
        $u = trim((string) $url);
        if ($u === '' || $u === '#') {
            return '#';
        }
        if (!preg_match('#^https?://#i', $u)) {
            $u = 'https://' . $u;
        }
        if (filter_var($u, FILTER_VALIDATE_URL)) {
            return htmlspecialchars($u, ENT_QUOTES, 'UTF-8');
        }

        return '#';
    }
}

require_once APP_ROOT . '/helpers/about_page_blocks.php';

// =================================
// CẤU HÌNH MÔI TRƯỜNG
// =================================
define('ENVIRONMENT', 'development'); // development hoặc production

// Bật/tắt hiển thị lỗi
if(ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// =================================
// CẤU HÌNH KHÁC
// =================================
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Múi giờ VN
define('CHARSET', 'UTF-8');
