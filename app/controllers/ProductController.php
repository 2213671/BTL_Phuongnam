<?php
/**
 * PRODUCT CONTROLLER
 * Trang Danh sách sản phẩm và Chi tiết sản phẩm
 */

class ProductController extends Controller
{
    private $productModel;
    private $categoryModel;
    private $productReviewModel;

    /** Slug trên trang chủ → category_id (bảng category). */
    private function resolveCategoryFilter(string $raw): string
    {
        $raw = trim($raw);
        if ($raw === '' || strtolower($raw) === 'all') {
            return '';
        }
        if (ctype_digit((string) $raw)) {
            return $raw;
        }
        $slugMap = [
            'tam-ly' => '7',
            'van-hoc' => '2',
            'kinh-te' => '3',
            'ky-nang' => '1',
            'thieu-nhi' => '6',
            'giao-duc' => '1',
        ];
        $key = strtolower($raw);

        return $slugMap[$key] ?? '';
    }

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
        $this->productReviewModel = $this->model('ProductReviewModel');
    }

    /**
     * Trang danh sách sản phẩm
     */
    public function index()
    {
        // Lấy các tham số từ URL
        $search = trim($_GET['search'] ?? '');
        $categoryRaw = (string) ($_GET['category'] ?? '');
        $category_id = $this->resolveCategoryFilter($categoryRaw);
        $sort = $_GET['sort'] ?? ''; // Thêm sort parameter
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max(1, $page);
        $limit = 10;

        $countOptions = [
            'search' => $search,
            'category_id' => $category_id,
            'sort' => $sort,
        ];
        $totalProducts = $this->productModel->countFilteredProducts($countOptions);
        $totalPages = $totalProducts > 0 ? (int) ceil($totalProducts / $limit) : 0;
        if ($totalPages > 0) {
            $page = min($page, $totalPages);
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        // Xây dựng mảng options cho truy vấn
        $options = [
            'search' => $search,
            'category_id' => $category_id,
            'sort' => $sort,
            'limit' => $limit,
            'offset' => $offset
        ];

        // Lấy dữ liệu từ model
        $products = $this->productModel->getFilteredProducts($options);
        $categories = $this->categoryModel->getAllCategories();

        // Lấy danh sách wishlist của user (nếu đã đăng nhập)
        $wishlistIds = [];
        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $wishlistModel = $this->model('WishlistModel');
            $wishlistIds = $wishlistModel->getProductIds($_SESSION['users_id']);
        } elseif (isset($_SESSION['guest_wishlist']) && is_array($_SESSION['guest_wishlist'])) {
            $wishlistIds = $_SESSION['guest_wishlist'];
        }

        $data = [
            'title' => 'Danh sách sản phẩm - ' . APP_NAME,
            'description' => 'Khám phá danh mục sách đa dạng tại Nhà sách Phương Nam với giá tốt và nhiều ưu đãi.',
            'keywords' => 'sach, nha sach, mua sach online, sach hay, phuong nam',
            'ogTitle' => 'Danh sách sản phẩm sách - Nhà sách Phương Nam',
            'ogDescription' => 'Danh sách sách mới và bán chạy tại Nhà sách Phương Nam.',
            'page' => 'product',
            'product_list_page' => true,
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'selectedCategory' => $category_id,
            'selectedSort' => $sort,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'wishlistIds' => $wishlistIds
        ];

        $this->view('product/index', $data);
    }

    /**
     * Trang chi tiết sản phẩm
     */
    public function detail($id)
    {
        $product = $this->productModel->getProductDetailsById($id);

        if (!$product) {
            // Nếu không tìm thấy sản phẩm, chuyển hướng về trang danh sách
            $this->redirect('product');
        }

        // Lấy sản phẩm liên quan (cùng danh mục)
        $relatedProducts = [];
        if (!empty($product['category_id'])) {
            $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $id, 4);
        }

        $pid = (int) $id;
        $reviews = $this->productReviewModel->getReviewsForProduct($pid);
        $avgRating = $this->productReviewModel->getAverageRating($pid);

        $data = [
            'title' => $product['title'] . ' - ' . APP_NAME,
            'description' => !empty($product['description']) ? mb_substr(strip_tags($product['description']), 0, 160) : 'Chi tiết sản phẩm tại Nhà sách Phương Nam.',
            'keywords' => strtolower(($product['title'] ?? '') . ', sach, chi tiet san pham, phuong nam'),
            'ogTitle' => $product['title'] . ' - Nhà sách Phương Nam',
            'ogDescription' => !empty($product['description']) ? mb_substr(strip_tags($product['description']), 0, 160) : 'Xem chi tiết sản phẩm tại Nhà sách Phương Nam.',
            'page' => 'product',
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'avg_rating' => $avgRating,
            'review_count' => count($reviews),
        ];

        $this->view('product/detail', $data);
    }

    public function addReview($productId) {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        $uid = (int) ($_SESSION['users_id'] ?? 0);
        if ($uid <= 0) {
            echo json_encode(['success' => false, 'need_login' => true, 'message' => 'Vui lòng đăng nhập.']);
            return;
        }
        $this->model('UserModel')->ensureCustomerMembership($uid);
        $pid = (int) $productId;
        if ($pid <= 0 || !$this->productModel->getProductDetailsById($pid)) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            return;
        }
        $rating = (int) ($_POST['rating'] ?? 0);
        $text = trim((string) ($_POST['review_text'] ?? ''));
        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Chọn số sao từ 1 đến 5.']);
            return;
        }
        if (mb_strlen($text) < 5) {
            echo json_encode(['success' => false, 'message' => 'Nội dung đánh giá tối thiểu 5 ký tự.']);
            return;
        }
        $ok = $this->productReviewModel->upsertReview($pid, $uid, $rating, $text);
        echo json_encode($ok
            ? ['success' => true, 'message' => 'Đã lưu đánh giá của bạn.']
            : ['success' => false, 'message' => 'Không lưu được đánh giá.']
        );
    }
}
