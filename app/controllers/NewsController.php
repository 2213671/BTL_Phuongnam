<?php
/**
 * NEWS CONTROLLER
 * Trang Danh sách bài viết và Chi tiết bài viết
 */

class NewsController extends Controller {

    private $newsModel;
    private $commentModel;
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->newsModel = $this->model('NewsModel');
        $this->commentModel = $this->model('CommentModel');
        $this->userModel = $this->model('UserModel');
    }

    /**
     * Trang danh sách bài viết
     */
    public function index() {
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $sort = trim($_GET['sort'] ?? '');
        $allowedSort = ['date-new', 'date-old', 'views', 'comments'];
        if ($sort !== '' && !in_array($sort, $allowedSort, true)) {
            $sort = '';
        }
        $sortForModel = $sort !== '' ? $sort : 'date-new';

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max(1, $page);
        $limit = 9;

        $totalArticles = $this->newsModel->countFilteredNews([
            'search' => $search,
            'category' => $category,
        ]);
        $totalPages = $totalArticles > 0 ? (int) ceil($totalArticles / $limit) : 0;
        if ($totalPages > 0) {
            $page = min($page, $totalPages);
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        $options = [
            'search' => $search,
            'category' => $category,
            'sort' => $sortForModel,
            'limit' => $limit,
            'offset' => $offset
        ];

        $articles = $this->newsModel->getFilteredNews($options);
        $categories = $this->newsModel->getAllCategories();

        $data = [
            'title' => 'Tin tức - ' . APP_NAME,
            'description' => 'Tin tuc moi nhat ve sach, van hoa doc va su kien tai Nha sach Phuong Nam.',
            'keywords' => 'tin tuc sach, su kien nha sach, van hoa doc',
            'ogTitle' => 'Tin tức sách - Nhà sách Phương Nam',
            'ogDescription' => 'Cap nhat tin tuc va bai viet moi nhat tai Nha sach Phuong Nam.',
            'page' => 'news',
            'news_list_page' => true,
            'articles' => $articles,
            'categories' => $categories,
            'search' => $search,
            'category' => $category,
            'sort' => $sort,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalArticles' => $totalArticles
        ];

        $this->view('news/index', $data);
    }

    /**
     * Trang chi tiết bài viết
     */
    public function detail($id) {
        $article = $this->newsModel->getNewsById($id);

        if (!$article) {
            header('Location: ' . BASE_URL . 'news');
            exit;
        }

        $this->newsModel->incrementViews($id);

        $relatedArticles = [];
        if (!empty($article['category'])) {
            $relatedArticles = $this->newsModel->getRelatedNews($article['category'], $id, 3);
        }

        // Lấy danh sách bình luận từ database
        $comments = $this->commentModel->getCommentsByNewsId($id);

        $commentPrefill = null;
        $sessUid = (int) ($_SESSION['users_id'] ?? 0);
        if ($sessUid > 0) {
            $cu = $this->userModel->getById($sessUid);
            if ($cu) {
                $commentPrefill = [
                    'fullname' => (string) ($cu['fullname'] ?? ''),
                    'email' => (string) ($cu['email'] ?? ''),
                ];
            }
        }

        $desc = trim((string) ($article['meta_description'] ?? ''));
        if ($desc === '') {
            $desc = !empty($article['summary']) ? mb_substr(strip_tags($article['summary']), 0, 160) : mb_substr(strip_tags($article['content']), 0, 160);
        }
        $kw = trim((string) ($article['meta_keywords'] ?? ''));
        if ($kw === '') {
            $kw = strtolower(($article['title'] ?? '') . ', tin tuc, nha sach phuong nam');
        }

        $data = [
            'title' => $article['title'] . ' - ' . APP_NAME,
            'description' => $desc,
            'keywords' => $kw,
            'ogTitle' => $article['title'] . ' - Nhà sách Phương Nam',
            'ogDescription' => !empty($article['summary']) ? mb_substr(strip_tags($article['summary']), 0, 160) : mb_substr(strip_tags($article['content']), 0, 160),
            'page' => 'news',
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'comments' => $comments,
            'commentPrefill' => $commentPrefill,
        ];

        $this->view('news/detail', $data);
    }

    /**
     * API: Thêm bình luận (AJAX)
     */
    public function addComment() {
        // Kiểm tra request method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method not allowed'], 405);
            return;
        }

        // Lấy dữ liệu từ request
        $input = json_decode(file_get_contents('php://input'), true);
        
        $newsId = $input['news_id'] ?? $_POST['news_id'] ?? null;
        $name = $input['name'] ?? $_POST['name'] ?? null;
        $email = $input['email'] ?? $_POST['email'] ?? null;
        $content = $input['content'] ?? $_POST['comment'] ?? null;
        $parentId = $input['parent_id'] ?? $_POST['parent_id'] ?? null;

        // Validate dữ liệu
        $errors = [];
        
        if (!$newsId) {
            $errors[] = 'Thiếu ID bài viết';
        }
        
        if (!$name || strlen($name) < 2) {
            $errors[] = 'Tên phải có ít nhất 2 ký tự';
        }
        
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ';
        }
        
        if (!$content || strlen($content) < 5) {
            $errors[] = 'Nội dung bình luận phải có ít nhất 5 ký tự';
        }

        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'errors' => $errors], 400);
            return;
        }

        // Kiểm tra bài viết tồn tại
        $article = $this->newsModel->getNewsById($newsId);
        if (!$article) {
            $this->jsonResponse(['success' => false, 'errors' => ['Bài viết không tồn tại']], 404);
            return;
        }

        $sessionUid = (int) ($_SESSION['users_id'] ?? 0);
        $userId = null;
        if ($sessionUid > 0) {
            $sessUser = $this->userModel->getById($sessionUid);
            if ($sessUser) {
                $userId = $sessionUid;
            }
        }
        if ($userId === null) {
            $userId = $this->getOrCreateUser($name, $email);
        }

        if (!$userId) {
            $this->jsonResponse(['success' => false, 'errors' => ['Không thể tạo người dùng']], 500);
            return;
        }

        // Thêm bình luận
        $result = $this->commentModel->addComment($newsId, $userId, $content, $parentId);

        if ($result) {
            // Lấy thông tin bình luận vừa thêm để trả về
            $newComment = $this->commentModel->getLatestComment($newsId, $userId);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Bình luận đã được gửi thành công!',
                'comment' => $newComment
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'errors' => ['Không thể lưu bình luận']], 500);
        }
    }

    /**
     * Tìm hoặc tạo user từ name và email
     */
    private function getOrCreateUser($name, $email) {
        // Tìm user theo email
        $user = $this->userModel->getByEmail($email);
        
        if ($user) {
            return $user['user_id'];
        }
        
        // Tạo user mới với role là 'customer'
        $data = [
            'fullname' => $name,
            'email' => $email,
            'phone' => null,
            'password' => bin2hex(random_bytes(8)),
            'role' => 'customer'
        ];
        
        $result = $this->userModel->createUser($data);
        
        if ($result) {
            $newUser = $this->userModel->getByEmail($email);
            return $newUser ? $newUser['user_id'] : null;
        }
        
        return null;
    }

    /**
     * Trả về JSON response
     */
    private function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}