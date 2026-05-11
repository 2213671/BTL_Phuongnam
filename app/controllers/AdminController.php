<?php
class AdminController extends Controller {

    private $adminModel;
    private $productModel;
    private $categoryModel;
    private $role;

    private const ORDER_STATUSES = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

    private const QA_CATEGORIES = ['Chung', 'Thanh toán', 'Vận chuyển', 'Bảo hành'];

    private const ADMIN_PAGE_KEYS = ['about'];

    private const ABOUT_BODY_MAX = 12000;

    private const ABOUT_CARD_TITLE_MAX = 200;

    private const ABOUT_CARD_TEXT_MAX = 4000;

    private const ADMIN_ONLY_METHODS = [
        'staff', 'createstaff', 'editstaff', 'deletestaff',
        'products', 'createproduct', 'editproduct', 'deleteproduct',
        'news', 'createnews', 'editnews', 'deletenews',
        'categories', 'createcategory', 'updatecategory', 'deletecategory',
        'settings', 'contacts', 'deletecontact', 'pagecontent', 'qa', 'createqa', 'deleteqa',
        'customers', 'customerdetail', 'deletecustomer',
        'comments', 'deletecomment',
        'productreviews', 'deleteproductreview'
    ];

    private const ADMIN_STAFF_METHODS = [
        'index', 'orders', 'orderdetail', 'updateorderstatus',
        'confirmorderpayment', 'getorderdetailajax'
    ];

    public function __construct() {
        $this->adminModel = $this->model('Admin');
        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
        $this->role = strtolower($_SESSION['users_role'] ?? '');
        $this->authorizeRequestedMethod();
    }

    private function requestedMethod(): string {
        $url = trim($_GET['url'] ?? '', '/');
        $segments = $url === '' ? [] : explode('/', $url);
        return strtolower($segments[1] ?? 'index');
    }

    private function authorizeRequestedMethod(): void {
        if (!$this->isAdminOrStaff()) {
            $this->redirect('home');
        }

        $method = $this->requestedMethod();
        if (in_array($method, self::ADMIN_ONLY_METHODS, true) && !$this->isAdmin()) {
            $this->redirect('admin');
        }
        if (in_array($method, self::ADMIN_STAFF_METHODS, true) && !$this->isAdminOrStaff()) {
            $this->redirect('home');
        }
    }

    private function isAdmin(): bool {
        return $this->role === 'admin';
    }

    private function isAdminOrStaff(): bool {
        return in_array($this->role, ['admin', 'staff'], true);
    }

    private function buildPagination(int $total, int $perPage, int $currentPage): array {
        $perPage = max(1, $perPage);
        $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 0;
        $safePage = $totalPages > 0 ? max(1, min($currentPage, $totalPages)) : 1;
        return [
            'current_page' => $safePage,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages
        ];
    }

    private function validateStaffInput(array $input, bool $isEdit = false): array {
        $errors = [];
        $data = [
            'fullname' => trim($input['fullname'] ?? ''),
            'email' => trim($input['email'] ?? ''),
            'phone' => trim($input['phone'] ?? ''),
            'role' => strtolower(trim($input['role'] ?? 'staff')),
            'note' => trim($input['note'] ?? ''),
            'password' => $input['password'] ?? ''
        ];

        if ($data['fullname'] === '') $errors[] = 'Họ tên là bắt buộc.';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
        if ($data['phone'] !== '' && !preg_match('/^[0-9+\-\s]{8,20}$/', $data['phone'])) $errors[] = 'Số điện thoại không hợp lệ.';
        if ($data['role'] !== 'staff') $errors[] = 'Chỉ cho phép vai trò staff.';
        if (!$isEdit && strlen($data['password']) < 6) $errors[] = 'Mật khẩu tối thiểu 6 ký tự.';
        if ($isEdit && $data['password'] !== '' && strlen($data['password']) < 6) $errors[] = 'Mật khẩu mới tối thiểu 6 ký tự.';

        return [$errors, $data];
    }

    private function validateNewsInput(array $input): array {
        $errors = [];
        $title = trim($input['title'] ?? '');
        $content = trim($input['content'] ?? '');
        $summary = trim($input['summary'] ?? '');
        $category = trim($input['category'] ?? '');

        if ($title === '') $errors[] = 'Tiêu đề là bắt buộc.';
        if (mb_strlen($title) > 255) $errors[] = 'Tiêu đề không được vượt quá 255 ký tự.';
        if ($content === '') $errors[] = 'Nội dung là bắt buộc.';
        if (strlen($content) > 2000000) $errors[] = 'Nội dung HTML quá lớn.';
        if ($summary !== '' && mb_strlen($summary) > 1000) $errors[] = 'Tóm tắt quá dài.';
        if ($category !== '' && mb_strlen($category) > 100) $errors[] = 'Danh mục không hợp lệ.';

        $slugRaw = trim($input['slug'] ?? '');
        if ($slugRaw !== '' && mb_strlen($slugRaw) > 255) $errors[] = 'Slug quá dài.';
        $metaDesc = trim($input['meta_description'] ?? '');
        if ($metaDesc !== '' && mb_strlen($metaDesc) > 320) $errors[] = 'Meta description không quá 320 ký tự.';
        $metaKw = trim($input['meta_keywords'] ?? '');
        if ($metaKw !== '' && mb_strlen($metaKw) > 500) $errors[] = 'Meta keywords không quá 500 ký tự.';

        return $errors;
    }

    private function validateProductInput(array $input): array {
        $errors = [];
        $title = trim($input['title'] ?? '');
        $price = (float) ($input['price'] ?? 0);
        $oldPrice = $input['old_price'] !== '' ? (float) $input['old_price'] : null;
        $stock = (int) ($input['stock_quantity'] ?? -1);
        $year = $input['year'] !== '' ? (int) $input['year'] : null;
        $pages = $input['pages'] !== '' ? (int) $input['pages'] : null;
        $weight = $input['weight'] !== '' ? (float) $input['weight'] : null;
        $desc = trim((string) ($input['description'] ?? ''));

        if ($title === '') $errors[] = 'Tên sản phẩm là bắt buộc.';
        if (strlen($desc) > 65000) $errors[] = 'Mô tả quá dài.';
        if ($price < 0) $errors[] = 'Giá bán không hợp lệ.';
        if ($oldPrice !== null && $oldPrice < 0) $errors[] = 'Giá gốc không hợp lệ.';
        if ($oldPrice !== null && $oldPrice < $price) $errors[] = 'Giá gốc phải lớn hơn hoặc bằng giá bán.';
        if ($stock < 0) $errors[] = 'Tồn kho không hợp lệ.';
        if ($year !== null && ($year < 1500 || $year > 2100)) $errors[] = 'Năm xuất bản không hợp lệ.';
        if ($pages !== null && $pages < 1) $errors[] = 'Số trang phải lớn hơn 0.';
        if ($weight !== null && $weight < 0) $errors[] = 'Khối lượng không hợp lệ.';

        return $errors;
    }

    /** Ô số trong form POST: rỗng → NULL, tránh gửi '' vào cột INT. */
    private function optionalPostInt(array $post, string $key): ?int {
        if (!array_key_exists($key, $post)) {
            return null;
        }
        $v = $post[$key];
        if ($v === null || $v === '') {
            return null;
        }

        return (int) $v;
    }

    /** Chuỗi rỗng → NULL (cho VARCHAR/DATE trong SQL). */
    private function nullableTrim($v): ?string {
        if ($v === null) {
            return null;
        }
        $s = trim((string) $v);

        return $s === '' ? null : $s;
    }

    /** Ngày HTML rỗng → NULL, tránh đưa '' vào cột DATE. */
    private function nullableDate($v): ?string {
        $s = trim((string) ($v ?? ''));

        return $s === '' ? null : $s;
    }

    /** @return string[] */
    private function validateSettingsInput(array $post): array {
        $errors = [];
        $hotline = trim((string) ($post['hotline'] ?? ''));
        $phone = trim((string) ($post['phone'] ?? ''));
        $email = trim((string) ($post['email'] ?? ''));
        $address = trim((string) ($post['address'] ?? ''));
        $fanpage = trim((string) ($post['fanpage'] ?? ''));
        $instagram_url = trim((string) ($post['instagram_url'] ?? ''));
        $youtube_url = trim((string) ($post['youtube_url'] ?? ''));
        $tiktok_url = trim((string) ($post['tiktok_url'] ?? ''));
        $business_hours = trim((string) ($post['business_hours'] ?? ''));

        foreach (['Hotline hiển thị chân trang' => $hotline, 'Số điện thoại phụ' => $phone] as $label => $val) {
            if (mb_strlen($val) > 60) {
                $errors[] = $label . ' không quá 60 ký tự.';
            }
            if ($val !== '' && !preg_match('/^[0-9+\-\s().\/]{6,60}$/u', $val)) {
                $errors[] = 'Định dạng ' . $label . ' không hợp lệ.';
            }
        }
        if ($email === '') {
            $errors[] = 'Email liên hệ là bắt buộc.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        } elseif (mb_strlen($email) > 120) {
            $errors[] = 'Email không quá 120 ký tự.';
        }
        if (mb_strlen($address) > 500) {
            $errors[] = 'Địa chỉ không quá 500 ký tự.';
        }
        if (mb_strlen($business_hours) > 500) {
            $errors[] = 'Giờ làm việc không quá 500 ký tự.';
        }

        foreach (
            [
                'Link Facebook / Fanpage' => $fanpage,
                'Link Instagram' => $instagram_url,
                'Link YouTube' => $youtube_url,
                'Link TikTok' => $tiktok_url,
            ] as $label => $urlRaw
        ) {
            if ($urlRaw === '') {
                continue;
            }
            if (mb_strlen($urlRaw) > 500) {
                $errors[] = $label . ' quá dài.';
                continue;
            }
            $test = $urlRaw;
            if (!preg_match('#^https?://#i', $test)) {
                $test = 'https://' . $test;
            }
            if (!filter_var($test, FILTER_VALIDATE_URL)) {
                $errors[] = $label . ' không hợp lệ.';
            }
        }

        return $errors;
    }

    private function normalizePostedWebUrl(string $raw): string {
        $raw = trim($raw);
        if ($raw === '') {
            return '';
        }
        if (!preg_match('#^https?://#i', $raw)) {
            $raw = 'https://' . $raw;
        }

        return filter_var($raw, FILTER_VALIDATE_URL) ? $raw : '';
    }

    /** @return string[] */
    private function validateCategoryInput(array $post): array {
        $errors = [];
        $name = trim((string) ($post['category_name'] ?? ''));
        $desc = trim((string) ($post['description'] ?? ''));
        if ($name === '') {
            $errors[] = 'Tên danh mục là bắt buộc.';
        }
        if (mb_strlen($name) > 120) {
            $errors[] = 'Tên danh mục không quá 120 ký tự.';
        }
        if (mb_strlen($desc) > 2000) {
            $errors[] = 'Mô tả không quá 2000 ký tự.';
        }

        return $errors;
    }

    /** @return string[] */
    private function validateQaInput(array $post): array {
        $errors = [];
        $question = trim((string) ($post['question'] ?? ''));
        $answer = trim((string) ($post['answer'] ?? ''));
        $category = (string) ($post['category'] ?? 'Chung');

        if ($question === '') {
            $errors[] = 'Câu hỏi là bắt buộc.';
        } elseif (mb_strlen($question) > 500) {
            $errors[] = 'Câu hỏi không quá 500 ký tự.';
        }
        if ($answer === '') {
            $errors[] = 'Nội dung trả lời là bắt buộc.';
        } elseif (mb_strlen($answer) > 50000) {
            $errors[] = 'Nội dung trả lời quá dài.';
        }
        if (!in_array($category, self::QA_CATEGORIES, true)) {
            $errors[] = 'Danh mục không hợp lệ.';
        }

        return $errors;
    }

    public function index() {
        $stats = $this->adminModel->getDashboardStats();
        $revenue = $this->adminModel->getMonthlyRevenueLastSixMonths();

        $data = [
            'title' => 'Dashboard',
            'page' => 'dashboard',
            'stats' => $stats,
            'revenueData' => $revenue,
            'contentFile' => APP_ROOT . '/views/admin/dashboard/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    // --- TASK #1: CẤU HÌNH & LIÊN HỆ ---

    public function settings() {
        $settings = $this->adminModel->getSettings();

        if ($this->isPost()) {
            $errors = $this->validateSettingsInput($_POST);
            if (!empty($errors)) {
                $data = [
                    'title' => 'Cài đặt Website',
                    'page' => 'settings',
                    'settings' => array_merge($settings, [
                        'hotline' => trim((string) ($_POST['hotline'] ?? '')),
                        'phone' => trim((string) ($_POST['phone'] ?? '')),
                        'email' => trim((string) ($_POST['email'] ?? '')),
                        'address' => trim((string) ($_POST['address'] ?? '')),
                        'fanpage' => trim((string) ($_POST['fanpage'] ?? '')),
                        'instagram_url' => trim((string) ($_POST['instagram_url'] ?? '')),
                        'youtube_url' => trim((string) ($_POST['youtube_url'] ?? '')),
                        'tiktok_url' => trim((string) ($_POST['tiktok_url'] ?? '')),
                        'business_hours' => trim((string) ($_POST['business_hours'] ?? '')),
                    ]),
                    'settings_errors' => $errors,
                    'contentFile' => APP_ROOT . '/views/admin/settings/index.php',
                ];
                $this->view('admin/admin', $data);

                return;
            }

            $this->adminModel->setSettingValue('hotline', trim((string) ($_POST['hotline'] ?? '')));
            $this->adminModel->setSettingValue('phone', trim((string) ($_POST['phone'] ?? '')));
            $this->adminModel->setSettingValue('email', trim((string) ($_POST['email'] ?? '')));
            $this->adminModel->setSettingValue('address', trim((string) ($_POST['address'] ?? '')));
            $this->adminModel->setSettingValue('fanpage', $this->normalizePostedWebUrl((string) ($_POST['fanpage'] ?? '')));
            $this->adminModel->setSettingValue('instagram_url', $this->normalizePostedWebUrl((string) ($_POST['instagram_url'] ?? '')));
            $this->adminModel->setSettingValue('youtube_url', $this->normalizePostedWebUrl((string) ($_POST['youtube_url'] ?? '')));
            $this->adminModel->setSettingValue('tiktok_url', $this->normalizePostedWebUrl((string) ($_POST['tiktok_url'] ?? '')));
            $this->adminModel->setSettingValue('business_hours', trim((string) ($_POST['business_hours'] ?? '')));
            $this->redirect('admin/settings');
        }

        $data = [
            'title' => 'Cài đặt Website',
            'page' => 'settings',
            'settings' => $settings,
            'contentFile' => APP_ROOT . '/views/admin/settings/index.php',
        ];

        $this->view('admin/admin', $data);
    }

    public function contacts() {
        if ($this->isPost()) {
            $cid = (int) ($_POST['contact_id'] ?? 0);
            $mark = strtolower(trim((string) ($_POST['contact_mark'] ?? '')));
            if ($cid > 0 && ($mark === 'processed' || $mark === 'new')) {
                $this->adminModel->updateContactStatus($cid, $mark === 'processed' ? 'Processed' : 'New');
            }
            $this->redirect('admin/contacts');
            return;
        }
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedContacts($page, 10);
        $data = [
            'title' => 'Quản lý Liên hệ',
            'page' => 'contacts',
            'contacts' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/contacts/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteContact() {
        if ($this->isPost()) {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id > 0) {
                $this->adminModel->deleteContact($id);
            }
            $this->redirect('admin/contacts');
        }
    }

    public function pageContent() {
        $page = $_GET['page'] ?? 'about';
        if (!in_array($page, self::ADMIN_PAGE_KEYS, true)) {
            $page = 'about';
        }

        if ($this->isPost()) {
            if (!empty($_POST['restore_about_defaults']) && $page === 'about') {
                $json = json_encode(pn_about_default_blocks(), JSON_UNESCAPED_UNICODE);
                $this->adminModel->updatePageContent('about', $json !== false ? $json : '{}');
                $this->redirect('admin/pageContent?page=about');

                return;
            }

            $blocks = $this->sanitizeAboutBlocksPost($_POST);
            $errors = $this->validateAboutBlocks($blocks);
            if (!empty($errors)) {
                $data = [
                    'title' => 'Trang Giới thiệu',
                    'page' => 'pages',
                    'currPage' => $page,
                    'about_edit' => $blocks,
                    'page_content_errors' => $errors,
                    'contentFile' => APP_ROOT . '/views/admin/pages/edit.php',
                ];
                $this->view('admin/admin', $data);

                return;
            }

            $json = json_encode($blocks, JSON_UNESCAPED_UNICODE);
            $this->adminModel->updatePageContent($page, $json !== false ? $json : '{}');
            $this->redirect('admin/pageContent?page=' . rawurlencode($page));
        }

        $aboutFlash = $_SESSION['admin_about_flash_error'] ?? null;
        unset($_SESSION['admin_about_flash_error']);

        $data = [
            'title' => 'Trang Giới thiệu',
            'page' => 'pages',
            'currPage' => $page,
            'about_edit' => pn_about_parse_blocks($this->adminModel->getPageContent($page)),
            'about_flash_error' => is_string($aboutFlash) ? $aboutFlash : null,
            'contentFile' => APP_ROOT . '/views/admin/pages/edit.php',
        ];
        $this->view('admin/admin', $data);
    }

    private function sanitizeAboutBlocksPost(array $post): array {
        $d = pn_about_default_blocks();
        $txt = function ($key) use ($post, $d) {
            $v = trim(strip_tags((string) ($post[$key] ?? '')));

            return $v !== '' ? $v : (string) ($d[$key] ?? '');
        };

        $blocks = [
            'hero_title' => $txt('hero_title'),
            'hero_text' => $txt('hero_text'),
            'intro_lead' => trim(strip_tags((string) ($post['intro_lead'] ?? ''))),
            'mission_text' => $txt('mission_text'),
            'vision_text' => $txt('vision_text'),
            'value_cards' => [],
            'service_cards' => [],
        ];

        $titles = isset($post['value_title']) && is_array($post['value_title']) ? $post['value_title'] : [];
        $texts = isset($post['value_text']) && is_array($post['value_text']) ? $post['value_text'] : [];
        foreach ($d['value_cards'] as $i => $def) {
            $t = trim(strip_tags((string) ($titles[$i] ?? '')));
            $x = trim(strip_tags((string) ($texts[$i] ?? '')));
            $blocks['value_cards'][] = [
                'title' => $t !== '' ? $t : $def['title'],
                'text' => $x !== '' ? $x : $def['text'],
            ];
        }

        $st = isset($post['service_title']) && is_array($post['service_title']) ? $post['service_title'] : [];
        $sx = isset($post['service_text']) && is_array($post['service_text']) ? $post['service_text'] : [];
        foreach ($d['service_cards'] as $i => $def) {
            $t = trim(strip_tags((string) ($st[$i] ?? '')));
            $x = trim(strip_tags((string) ($sx[$i] ?? '')));
            $blocks['service_cards'][] = [
                'title' => $t !== '' ? $t : $def['title'],
                'text' => $x !== '' ? $x : $def['text'],
            ];
        }

        return $blocks;
    }

    private function validateAboutBlocks(array $blocks): array {
        $errors = [];
        foreach (['hero_title', 'hero_text', 'mission_text', 'vision_text'] as $k) {
            $len = mb_strlen((string) ($blocks[$k] ?? ''));
            if ($len > self::ABOUT_BODY_MAX) {
                $errors[] = 'Trường "' . $k . '" quá dài.';
            }
        }
        $introLen = mb_strlen((string) ($blocks['intro_lead'] ?? ''));
        if ($introLen > self::ABOUT_BODY_MAX) {
            $errors[] = 'Đoạn dẫn quá dài.';
        }

        foreach (($blocks['value_cards'] ?? []) as $i => $row) {
            if (mb_strlen((string) ($row['title'] ?? '')) > self::ABOUT_CARD_TITLE_MAX) {
                $errors[] = 'Tiêu đề giá trị cốt lõi #' . ($i + 1) . ' quá dài.';
            }
            if (mb_strlen((string) ($row['text'] ?? '')) > self::ABOUT_CARD_TEXT_MAX) {
                $errors[] = 'Nội dung giá trị cốt lõi #' . ($i + 1) . ' quá dài.';
            }
        }
        foreach (($blocks['service_cards'] ?? []) as $i => $row) {
            if (mb_strlen((string) ($row['title'] ?? '')) > self::ABOUT_CARD_TITLE_MAX) {
                $errors[] = 'Tiêu đề dịch vụ #' . ($i + 1) . ' quá dài.';
            }
            if (mb_strlen((string) ($row['text'] ?? '')) > self::ABOUT_CARD_TEXT_MAX) {
                $errors[] = 'Nội dung dịch vụ #' . ($i + 1) . ' quá dài.';
            }
        }

        $enc = json_encode($blocks, JSON_UNESCAPED_UNICODE);
        if ($enc !== false && strlen($enc) > 512000) {
            $errors[] = 'Tổng dữ liệu lưu quá lớn.';
        }

        return $errors;
    }

    // --- TASK #2: QA ---

    public function qa() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedQA($page, 10);
        $data = [
            'title' => 'Quản lý Hỏi/Đáp',
            'page' => 'qa',
            'qaList' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/qa/index.php'
        ];
        $this->view('admin/admin', $data);
    }



    public function createQa() {
        if ($this->isPost()) {
            $errors = $this->validateQaInput($_POST);
            if (!empty($errors)) {
                $data = [
                    'title' => 'Thêm câu hỏi Hỏi/Đáp',
                    'page' => 'qa',
                    'qa_errors' => $errors,
                    'qa_old' => $_POST,
                    'contentFile' => APP_ROOT . '/views/admin/qa/create.php',
                ];
                $this->view('admin/admin', $data);

                return;
            }

            $q = strip_tags(trim((string) ($_POST['question'] ?? '')));
            $a = strip_tags(trim((string) ($_POST['answer'] ?? '')));
            $c = (string) ($_POST['category'] ?? 'Chung');
            $this->adminModel->createQA($q, $a, $c);
            $this->redirect('admin/qa');
        }

        $data = [
            'title' => 'Thêm câu hỏi Hỏi/Đáp',
            'page' => 'qa',
            'contentFile' => APP_ROOT . '/views/admin/qa/create.php',
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteQa() {
        // Lưu ý: Thực tế nên dùng POST để xóa an toàn hơn
        $id = $_GET['id'] ?? 0;
        $this->adminModel->deleteQA($id);
        $this->redirect('admin/qa');
    }
    // --- HELPER: UPLOAD ẢNH ---
    private function uploadImage($file) {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        $probe = @getimagesize($file['tmp_name']);
        if (!$probe || !isset($probe[2])) {
            return null;
        }
        $allowedTypes = [IMAGETYPE_JPEG => true, IMAGETYPE_PNG => true, IMAGETYPE_WEBP => true];
        if (!isset($allowedTypes[$probe[2]])) {
            return null;
        }
        $uploadDir = PUBLIC_PATH . 'media' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $safeBase = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file['name']));
        $fileName = time() . '_' . $safeBase;
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $rel = 'media/uploads/' . $fileName;
            return (function_exists('pn_is_local_media_path') && pn_is_local_media_path($rel)) ? $rel : null;
        }
        return null;
    }

    // ================= NEWS CONTROLLER LOGIC =================
    public function news() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedArticles($page, 10);
        $data = [
            'title' => 'Quản lý Tin tức',
            'page' => 'news',
            'articles' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/news/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function createNews() {
        if ($this->isPost()) {
            $errors = $this->validateNewsInput($_POST);
            if (!empty($errors)) {
                $data = [
                    'title' => 'Thêm bài viết mới',
                    'page' => 'news',
                    'errors' => $errors,
                    'old' => $_POST,
                    'contentFile' => APP_ROOT . '/views/admin/news/create.php'
                ];
                $this->view('admin/admin', $data);
                return;
            }
            $imagePath = $this->uploadImage($_FILES['image'] ?? null);
            $img = $imagePath ?? MEDIA_NEWS_PLACEHOLDER;
            if (!pn_is_local_media_path($img)) {
                $img = MEDIA_NEWS_PLACEHOLDER;
            }
            $slugInput = trim($_POST['slug'] ?? '');
            $slug = $slugInput !== '' ? pn_slugify($slugInput) : pn_slugify($_POST['title'] ?? 'bai-viet');
            $slug = $this->adminModel->ensureUniqueNewsSlug($slug);
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => pn_sanitize_html_local_media_only((string) ($_POST['content'] ?? '')),
                'category' => $_POST['category'],
                'image_url' => $img,
                'published_date' => $_POST['published_date'] ?? date('Y-m-d'),
                'author_id' => $_SESSION['users_id'] ?? null,
                'slug' => $slug,
                'meta_description' => trim($_POST['meta_description'] ?? '') ?: null,
                'meta_keywords' => trim($_POST['meta_keywords'] ?? '') ?: null,
            ];
            $this->adminModel->addArticle($data);
            $this->redirect('admin/news');
        }

        $data = [
            'title' => 'Thêm bài viết mới',
            'page' => 'news',
            'contentFile' => APP_ROOT . '/views/admin/news/create.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function editNews() {
        $id = $_GET['id'] ?? 0;
        if ($this->isPost()) {
            $errors = $this->validateNewsInput($_POST);
            if (!empty($errors)) {
                $data = [
                    'title' => 'Sửa bài viết',
                    'page' => 'news',
                    'errors' => $errors,
                    'article' => $this->adminModel->getArticleById($id),
                    'contentFile' => APP_ROOT . '/views/admin/news/edit.php'
                ];
                $this->view('admin/admin', $data);
                return;
            }
            $imagePath = $this->uploadImage($_FILES['image'] ?? null);
            $slugInput = trim($_POST['slug'] ?? '');
            $slug = $slugInput !== '' ? pn_slugify($slugInput) : pn_slugify($_POST['title'] ?? 'bai-viet');
            $slug = $this->adminModel->ensureUniqueNewsSlug($slug, (int) $id);
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => pn_sanitize_html_local_media_only((string) ($_POST['content'] ?? '')),
                'category' => $_POST['category'],
                'slug' => $slug,
                'meta_description' => trim($_POST['meta_description'] ?? '') ?: null,
                'meta_keywords' => trim($_POST['meta_keywords'] ?? '') ?: null,
            ];
            if ($imagePath && pn_is_local_media_path($imagePath)) {
                $data['image_url'] = $imagePath;
            }

            $this->adminModel->updateArticle($id, $data);
            $this->redirect('admin/news');
        }

        $data = [
            'title' => 'Sửa bài viết',
            'page' => 'news',
            'article' => $this->adminModel->getArticleById($id),
            'contentFile' => APP_ROOT . '/views/admin/news/edit.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteNews() {
        $id = $_GET['id'] ?? 0;
        $this->adminModel->deleteArticle($id);
        $this->redirect('admin/news');
    }

    // ================= PRODUCT CONTROLLER LOGIC =================
    public function products() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 10;
        $all = $this->productModel->getAllProductsForAdmin();
        $total = count($all);
        $pagination = $this->buildPagination($total, $perPage, $page);
        $page = $pagination['current_page'];
        $offset = ($page - 1) * $perPage;
        $items = array_slice($all, $offset, $perPage);
        $data = [
            'title' => 'Quản lý sản phẩm',
            'page' => 'products',
            'products' => $items,
            'pagination' => $pagination,
            'contentFile' => APP_ROOT . '/views/admin/products/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function createProduct() {
        if ($this->isPost()) {
            $errors = $this->validateProductInput($_POST);
            if (!empty($errors)) {
                $data = [
                    'title' => 'Thêm sản phẩm mới',
                    'page' => 'products',
                    'errors' => $errors,
                    'categories' => $this->categoryModel->getAllCategories(),
                    'contentFile' => APP_ROOT . '/views/admin/products/create.php'
                ];
                $this->view('admin/admin', $data);
                return;
            }
            // Chuẩn bị dữ liệu sản phẩm (mô tả textarea: lưu nguyên văn, hiển thị escape phía storefront)
            $productData = [
                ':title' => $_POST['title'] ?? '',
                ':price' => $_POST['price'] ?? 0,
                ':old_price' => $_POST['old_price'] !== '' && $_POST['old_price'] !== null ? (float) $_POST['old_price'] : null,
                ':description' => trim((string) ($_POST['description'] ?? '')),
                ':stock_quantity' => $_POST['stock_quantity'] ?? 0,
                ':publisher' => $this->nullableTrim($_POST['publisher'] ?? null),
                ':published_date' => $this->nullableDate($_POST['published_date'] ?? null),
                ':supplier' => $_POST['supplier'] ?? null,
                ':year' => $this->optionalPostInt($_POST, 'year'),
                ':language' => $_POST['language'] ?? null,
                ':pages' => $this->optionalPostInt($_POST, 'pages'),
                ':product_type' => $_POST['product_type'] ?? null,
                ':weight' => $_POST['weight'] !== '' && $_POST['weight'] !== null ? (float) $_POST['weight'] : null,
                ':dimensions' => $_POST['dimensions'] ?? null,
                ':size' => $_POST['size'] ?? null
            ];

            // Tạo sản phẩm và lấy ID
            $productId = $this->productModel->createProduct($productData);

            // Thêm ảnh nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->uploadImage($_FILES['image']);
                if ($imagePath) {
                    $this->productModel->addProductImage($productId, $imagePath);
                }
            }

            $authorName = trim((string) ($_POST['author'] ?? ''));
            if ($authorName !== '') {
                $this->productModel->addProductAuthor($productId, $authorName);
            }

            // Thêm danh mục nếu có
            if (!empty($_POST['category_id'])) {
                $this->productModel->addProductCategory($productId, $_POST['category_id']);
            }

            $this->redirect('admin/products');
        }

        // Load categories cho form
        $data = [
            'title' => 'Thêm sản phẩm mới',
            'page' => 'products',
            'categories' => $this->categoryModel->getAllCategories(),
            'contentFile' => APP_ROOT . '/views/admin/products/create.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function editProduct($id) {
        if ($this->isPost()) {
            $errors = $this->validateProductInput($_POST);
            if (!empty($errors)) {
                $product = $this->productModel->getProductDetailsById($id);
                $data = [
                    'title' => 'Sửa sản phẩm: ' . ($product['title'] ?? ''),
                    'page' => 'products',
                    'errors' => $errors,
                    'product' => $product,
                    'categories' => $this->categoryModel->getAllCategories(),
                    'contentFile' => APP_ROOT . '/views/admin/products/edit.php'
                ];
                $this->view('admin/admin', $data);
                return;
            }
            // Cập nhật thông tin sản phẩm
            $productData = [
                ':title' => $_POST['title'] ?? '',
                ':price' => $_POST['price'] ?? 0,
                ':old_price' => $_POST['old_price'] !== '' && $_POST['old_price'] !== null ? (float) $_POST['old_price'] : null,
                ':description' => trim((string) ($_POST['description'] ?? '')),
                ':stock_quantity' => $_POST['stock_quantity'] ?? 0,
                ':publisher' => $this->nullableTrim($_POST['publisher'] ?? null),
                ':published_date' => $this->nullableDate($_POST['published_date'] ?? null),
                ':supplier' => $_POST['supplier'] ?? null,
                ':year' => $this->optionalPostInt($_POST, 'year'),
                ':language' => $_POST['language'] ?? null,
                ':pages' => $this->optionalPostInt($_POST, 'pages'),
                ':product_type' => $_POST['product_type'] ?? null,
                ':weight' => $_POST['weight'] !== '' && $_POST['weight'] !== null ? (float) $_POST['weight'] : null,
                ':dimensions' => $_POST['dimensions'] ?? null,
                ':size' => $_POST['size'] ?? null
            ];

            $this->productModel->updateProduct($id, $productData);

            // Cập nhật ảnh nếu có upload mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->uploadImage($_FILES['image']);
                if ($imagePath) {
                    // Xóa ảnh cũ và thêm ảnh mới
                    $this->productModel->deleteProductImages($id);
                    $this->productModel->addProductImage($id, $imagePath);
                }
            }

            $this->productModel->deleteProductAuthors($id);
            $authorName = trim((string) ($_POST['author'] ?? ''));
            if ($authorName !== '') {
                $this->productModel->addProductAuthor($id, $authorName);
            }

            // Cập nhật danh mục
            if (!empty($_POST['category_id'])) {
                $this->productModel->deleteProductCategories($id);
                $this->productModel->addProductCategory($id, $_POST['category_id']);
            }

            $this->redirect('admin/products');
        }

        // Load dữ liệu để hiển thị form
        $product = $this->productModel->getProductDetailsById($id);
        $data = [
            'title' => 'Sửa sản phẩm: ' . ($product['title'] ?? ''),
            'page' => 'products',
            'product' => $product,
            'categories' => $this->categoryModel->getAllCategories(),
            'contentFile' => APP_ROOT . '/views/admin/products/edit.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteProduct() {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            // Xóa sản phẩm (các bảng liên quan sẽ tự động xóa nhờ ON DELETE CASCADE)
            $this->productModel->deleteProduct($id);
        }
        $this->redirect('admin/products');
    }

    // ================= ORDER CONTROLLER LOGIC =================
    public function orders() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedOrders($page, 10);
        $data = [
            'title' => 'Quản lý Đơn hàng',
            'page' => 'orders',
            'orders' => $result['items'],
            'stats' => $this->adminModel->getOrderStats(),
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/orders/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function orderDetail($orderId) {
        $order = $this->adminModel->getOrderById($orderId);
        if (!$order) {
            $this->redirect('admin/orders');
            return;
        }

        $orderFlashErr = $_SESSION['admin_order_flash_error'] ?? null;
        unset($_SESSION['admin_order_flash_error']);

        $data = [
            'title' => 'Chi tiết đơn hàng #' . $orderId,
            'page' => 'orders',
            'order' => $order,
            'items' => $this->adminModel->getOrderItems($orderId),
            'order_flash_error' => is_string($orderFlashErr) ? $orderFlashErr : null,
            'contentFile' => APP_ROOT . '/views/admin/orders/detail.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function updateOrderStatus() {
        if ($this->isPost()) {
            $orderId = (int) ($_POST['order_id'] ?? 0);
            $status = strtolower(trim((string) ($_POST['status'] ?? '')));

            if ($orderId > 0 && in_array($status, self::ORDER_STATUSES, true)) {
                $res = $this->adminModel->updateOrderStatusWithStock($orderId, $status);
                if (empty($res['ok'])) {
                    $_SESSION['admin_order_flash_error'] = $res['message'] ?? 'Không thể cập nhật trạng thái đơn hàng.';
                }
            }

            if (isset($_POST['return_to_detail'])) {
                $this->redirect('admin/orderDetail/' . $orderId);
            } else {
                $this->redirect('admin/orders');
            }
        }
    }

    public function confirmOrderPayment() {
        if ($this->isPost()) {
            $orderId = (int) ($_POST['order_id'] ?? 0);
            if ($orderId > 0) {
                $res = $this->adminModel->confirmOrderPaymentWithStock($orderId);
                if (empty($res['ok'])) {
                    $_SESSION['admin_order_flash_error'] = $res['message'] ?? 'Không thể xác nhận thanh toán.';
                }
            }
            $this->redirect('admin/orderDetail/' . $orderId);
        }
    }

    public function deleteOrder() {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $this->adminModel->deleteOrder($id);
        }
        $this->redirect('admin/orders');
    }

    /**
     * API endpoint để lấy chi tiết đơn hàng (AJAX)
     */
    public function getOrderDetailAjax() {
        header('Content-Type: application/json');

        $orderId = $_GET['order_id'] ?? 0;

        if (!$orderId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu order_id']);
            return;
        }

        $order = $this->adminModel->getOrderById($orderId);

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
            return;
        }

        $items = $this->adminModel->getOrderItems($orderId);

        // Map status text
        $statusMap = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy'
        ];

        echo json_encode([
            'success' => true,
            'order' => [
                'order_id' => $order['order_id'],
                'created_date' => $order['created_date'],
                'recipient_name' => $order['recipient_name'],
                'recipient_phone' => $order['recipient_phone'],
                'shipping_address' => $order['shipping_address'],
                'payment_method' => $order['payment_method'],
                'status' => $order['status'],
                'status_text' => $statusMap[$order['status']] ?? $order['status'],
                'subtotal' => $order['subtotal'],
                'shipping_fee' => $order['shipping_fee'],
                'total' => $order['total'],
                'note' => $order['note']
            ],
            'items' => $items
        ]);
    }

    // ================= CUSTOMER CONTROLLER LOGIC =================
    public function customers() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedCustomers($page, 10);
        $data = [
            'title' => 'Quản lý Khách hàng',
            'page' => 'customers',
            'customers' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/customers/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function customerDetail($customerId) {
        $customerId = (int) $customerId;
        if ($this->isPost()) {
            $action = (string) ($_POST['customer_admin_action'] ?? '');
            if ($action === 'toggle_lock') {
                $nextRaw = (string) ($_POST['next_status'] ?? '');
                if (!in_array($nextRaw, ['locked', 'active'], true)) {
                    $_SESSION['admin_customer_flash_errors'] = ['Trạng thái không hợp lệ.'];
                } else {
                    $this->adminModel->setCustomerAccountStatus($customerId, $nextRaw);
                    $_SESSION['admin_customer_flash_success'] = $nextRaw === 'locked'
                        ? 'Đã khóa đăng nhập.'
                        : 'Đã mở khóa đăng nhập.';
                }
            } elseif ($action === 'reset_password') {
                $pw = (string) ($_POST['new_password'] ?? '');
                if (strlen($pw) < 6) {
                    $_SESSION['admin_customer_flash_errors'] = ['Mật khẩu phải có ít nhất 6 ký tự.'];
                } elseif (strlen($pw) > 128) {
                    $_SESSION['admin_customer_flash_errors'] = ['Mật khẩu không quá 128 ký tự.'];
                } else {
                    $userModel = $this->model('UserModel');
                    $userModel->updatePassword($customerId, $pw);
                    $_SESSION['admin_customer_flash_success'] = 'Đã đặt lại mật khẩu.';
                }
            } else {
                $_SESSION['admin_customer_flash_errors'] = ['Thao tác không hợp lệ.'];
            }
            $this->redirect('admin/customerDetail/' . $customerId);

            return;
        }

        $customer = $this->adminModel->getCustomerById($customerId);
        if (!$customer) {
            $this->redirect('admin/customers');
            return;
        }

        $custFlashErr = $_SESSION['admin_customer_flash_errors'] ?? null;
        $custFlashOk = $_SESSION['admin_customer_flash_success'] ?? null;
        unset($_SESSION['admin_customer_flash_errors'], $_SESSION['admin_customer_flash_success']);

        $data = [
            'title' => 'Chi tiết khách hàng: ' . $customer['fullname'],
            'page' => 'customers',
            'customer' => $customer,
            'orders' => $this->adminModel->getCustomerOrders($customerId),
            'stats' => $this->adminModel->getCustomerStats($customerId),
            'customer_flash_errors' => is_array($custFlashErr) ? $custFlashErr : null,
            'customer_flash_success' => is_string($custFlashOk) ? $custFlashOk : null,
            'contentFile' => APP_ROOT . '/views/admin/customers/detail.php',
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteCustomer() {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $this->adminModel->deleteCustomer($id);
        }
        $this->redirect('admin/customers');
    }

    // ================= CATEGORY CONTROLLER LOGIC =================
    public function categories() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedCategories($page, 15);

        $catErr = $_SESSION['admin_category_errors'] ?? null;
        $catOld = $_SESSION['admin_category_old'] ?? null;
        unset($_SESSION['admin_category_errors'], $_SESSION['admin_category_old']);

        $data = [
            'title' => 'Quản lý Danh mục',
            'page' => 'categories',
            'categories' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'category_errors' => is_array($catErr) ? $catErr : null,
            'category_old' => is_array($catOld) ? $catOld : null,
            'contentFile' => APP_ROOT . '/views/admin/categories/index.php',
        ];
        $this->view('admin/admin', $data);
    }

    public function productReviews() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $rm = $this->model('ProductReviewModel');
        $result = $rm->getPaginatedReviewsForAdmin($page, 12);
        $data = [
            'title' => 'Đánh giá sản phẩm',
            'page' => 'productreviews',
            'reviews' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/productreviews/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteProductReview() {
        if ($this->isPost()) {
            $rid = (int) ($_POST['review_id'] ?? 0);
            if ($rid > 0) {
                $this->model('ProductReviewModel')->deleteReview($rid);
            }
        }
        $this->redirect('admin/productreviews');
    }

    public function createCategory() {
        if ($this->isPost()) {
            $errors = $this->validateCategoryInput($_POST);
            if (!empty($errors)) {
                $_SESSION['admin_category_errors'] = $errors;
                $_SESSION['admin_category_old'] = [
                    'category_name' => trim((string) ($_POST['category_name'] ?? '')),
                    'description' => trim((string) ($_POST['description'] ?? '')),
                ];
                $this->redirect('admin/categories');

                return;
            }

            $categoryData = [
                'category_name' => trim((string) ($_POST['category_name'] ?? '')),
                'description' => trim((string) ($_POST['description'] ?? '')),
            ];

            $this->adminModel->createCategory($categoryData);
            $this->redirect('admin/categories');
        }
    }

    public function updateCategory() {
        if ($this->isPost()) {
            $categoryId = (int) ($_POST['category_id'] ?? 0);
            $errors = $this->validateCategoryInput($_POST);
            if (!empty($errors)) {
                $_SESSION['admin_category_errors'] = $errors;
                $_SESSION['admin_category_old'] = [
                    'category_id' => $categoryId,
                    'category_name' => trim((string) ($_POST['category_name'] ?? '')),
                    'description' => trim((string) ($_POST['description'] ?? '')),
                ];
                $this->redirect('admin/categories');

                return;
            }

            $categoryData = [
                'category_name' => trim((string) ($_POST['category_name'] ?? '')),
                'description' => trim((string) ($_POST['description'] ?? '')),
            ];

            if ($categoryId > 0) {
                $this->adminModel->updateCategory($categoryId, $categoryData);
            }
            $this->redirect('admin/categories');
        }
    }

    public function deleteCategory() {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $this->adminModel->deleteCategory($id);
        }
        $this->redirect('admin/categories');
    }

    public function staff() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedStaff($page, 10);
        $data = [
            'title' => 'Quản lý Nhân sự',
            'page' => 'staff',
            'staff' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/staff/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function createStaff() {
        if ($this->isPost()) {
            [$errors, $staffData] = $this->validateStaffInput($_POST, false);
            if ($this->adminModel->staffEmailExists($staffData['email'])) {
                $errors[] = 'Email đã tồn tại.';
            }

            if (!empty($errors)) {
                $data = [
                    'title' => 'Thêm nhân viên mới',
                    'page' => 'staff',
                    'errors' => $errors,
                    'old' => $_POST,
                    'contentFile' => APP_ROOT . '/views/admin/staff/create.php'
                ];
                $this->view('admin/admin', $data);
                return;
            }

            $this->adminModel->createStaff($staffData);
            $this->redirect('admin/staff');
        }

        $data = [
            'title' => 'Thêm nhân viên mới',
            'page' => 'staff',
            'contentFile' => APP_ROOT . '/views/admin/staff/create.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function editStaff($id) {
        $id = (int) $id;
        $staff = $this->adminModel->getStaffById($id);
        if (!$staff) {
            $this->redirect('admin/staff');
            return;
        }

        if ($this->isPost()) {
            [$errors, $staffData] = $this->validateStaffInput($_POST, true);
            if ($this->adminModel->staffEmailExists($staffData['email'], $id)) {
                $errors[] = 'Email đã tồn tại.';
            }
            if ($staffData['role'] !== 'staff') {
                $errors[] = 'Không được nâng quyền lên admin.';
            }
            if ($staff['role'] === 'admin') {
                $errors[] = 'Không chỉnh sửa vai trò tài khoản admin tại đây.';
            }

            if (!empty($errors)) {
                $data = [
                    'title' => 'Sửa thông tin nhân viên',
                    'page' => 'staff',
                    'errors' => $errors,
                    'staff' => $staff,
                    'contentFile' => APP_ROOT . '/views/admin/staff/edit.php'
                ];
                $this->view('admin/admin', $data);
                return;
            }

            $this->adminModel->updateStaff($id, $staffData);
            $this->redirect('admin/staff');
        }

        $data = [
            'title' => 'Sửa thông tin nhân viên',
            'page' => 'staff',
            'staff' => $staff,
            'contentFile' => APP_ROOT . '/views/admin/staff/edit.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteStaff() {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->adminModel->deleteStaff($id);
        }
        $this->redirect('admin/staff');
    }

    public function comments() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->adminModel->getPaginatedComments($page, 10);
        $data = [
            'title' => 'Quản lý bình luận',
            'page' => 'comments',
            'comments' => $result['items'],
            'pagination' => $this->buildPagination($result['total'], $result['per_page'], $result['page']),
            'contentFile' => APP_ROOT . '/views/admin/comments/index.php'
        ];
        $this->view('admin/admin', $data);
    }

    public function deleteComment() {
        if ($this->isPost()) {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id > 0) {
                $this->adminModel->deleteComment($id);
            }
        }
        $this->redirect('admin/comments');
    }
}
