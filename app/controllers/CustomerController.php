<?php
// app/controllers/CustomerController.php
class CustomerController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // Profile page
    public function index() {
        // Kiểm tra đăng nhập
        $uid = (int) ($_SESSION['users_id'] ?? 0);
        if ($uid <= 0) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        // Lấy thông tin user từ database
        $userModel = $this->model('UserModel');
        $user = $userModel->getById($uid);

        if (!$user) {
            // Nếu không tìm thấy user, logout
            session_destroy();
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        $_SESSION['users_avatar'] = !empty($user['avatar']) ? (string) $user['avatar'] : '';
        $_SESSION['users_username'] = $user['fullname'] ?? ($_SESSION['users_username'] ?? '');
        $_SESSION['users_email'] = $user['email'] ?? ($_SESSION['users_email'] ?? '');
        $_SESSION['user_name'] = $_SESSION['users_username'];

        $data = [
            'title' => 'Thông tin tài khoản - ' . APP_NAME,
            'page' => 'customer',
            'user' => $user
        ];

        $this->view('customer/index', $data);
    }

    // API cập nhật thông tin cá nhân
    public function updateProfile() {
        header('Content-Type: application/json');

        // Kiểm tra method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        // Kiểm tra đăng nhập
        $userId = (int) ($_SESSION['users_id'] ?? 0);
        if ($userId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            return;
        }

        // Lấy dữ liệu từ POST
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        // Validate
        if (empty($fullname)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập họ tên']);
            return;
        }

        $userModel = $this->model('UserModel');
        $existingRow = $userModel->getById($userId);
        $currentEmail = trim((string) ($existingRow['email'] ?? ''));
        // Form để trống email nhưng tài khoản chỉ có email nội bộ @phone.customer.local → giữ nguyên DB
        if ($email === '' && $currentEmail !== '' && preg_match('/@phone\.customer\.local$/i', $currentEmail)) {
            $email = $currentEmail;
        }

        if (empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập email']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
            return;
        }

        // Kiểm tra email đã tồn tại chưa
        if ($userModel->isEmailExists($email, $userId)) {
            echo json_encode(['success' => false, 'message' => 'Email đã được sử dụng']);
            return;
        }

        // Kiểm tra phone đã tồn tại chưa (nếu có nhập)
        if (!empty($phone) && $userModel->isPhoneExists($phone, $userId)) {
            echo json_encode(['success' => false, 'message' => 'Số điện thoại đã được sử dụng']);
            return;
        }

        // Cập nhật thông tin
        $data = [
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone
        ];

        $result = $userModel->updateProfile($userId, $data);

        if ($result) {
            $_SESSION['users_username'] = $fullname;
            $_SESSION['users_email'] = $email;
            $_SESSION['user_name'] = $fullname;
            echo json_encode([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công!',
                'user' => [
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                ],
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại, vui lòng thử lại']);
        }
    }

    private function saveAvatarUpload(?array $file): ?string {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }
        $info = @getimagesize($file['tmp_name']);
        if (!$info || !isset($info[2])) {
            return null;
        }
        $mapExt = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_WEBP => 'webp',
        ];
        if (!isset($mapExt[$info[2]])) {
            return null;
        }
        $uploadDir = PUBLIC_PATH . 'media' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $name = 'u' . (int) ($_SESSION['users_id'] ?? 0) . '_' . time() . '.' . $mapExt[$info[2]];
        $dest = $uploadDir . $name;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return null;
        }
        return 'media/uploads/avatars/' . $name;
    }

    public function uploadAvatar() {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        if (!isset($_SESSION['users_id'])) {
            echo json_encode(['success' => false, 'need_login' => true]);
            return;
        }
        if (!isset($_FILES['avatar'])) {
            echo json_encode(['success' => false, 'message' => 'Chọn ảnh (JPEG, PNG hoặc WebP).']);
            return;
        }
        $rel = $this->saveAvatarUpload($_FILES['avatar']);
        if ($rel === null) {
            echo json_encode(['success' => false, 'message' => 'File ảnh không hợp lệ hoặc quá lớn.']);
            return;
        }
        $userModel = $this->model('UserModel');
        if ($userModel->updateAvatar((int) $_SESSION['users_id'], $rel)) {
            $_SESSION['users_avatar'] = $rel;
            echo json_encode([
                'success' => true,
                'message' => 'Đã cập nhật ảnh đại diện.',
                'avatar_url' => asset_url($rel),
            ]);
            return;
        }
        echo json_encode(['success' => false, 'message' => 'Không lưu được vào hệ thống.']);
    }

    public function changePassword() {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        if (!isset($_SESSION['users_id'])) {
            echo json_encode(['success' => false, 'need_login' => true]);
            return;
        }
        $uid = (int) $_SESSION['users_id'];
        $current = (string) ($_POST['current_password'] ?? '');
        $new = (string) ($_POST['new_password'] ?? '');
        $confirm = (string) ($_POST['confirm_password'] ?? '');
        if ($current === '' || $new === '' || $confirm === '') {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đủ các ô mật khẩu.']);
            return;
        }
        if (strlen($new) < 6) {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu mới tối thiểu 6 ký tự.']);
            return;
        }
        if ($new !== $confirm) {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp.']);
            return;
        }
        $userModel = $this->model('UserModel');
        if (!$userModel->verifyPassword($uid, $current)) {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu hiện tại không đúng.']);
            return;
        }
        if ($userModel->updatePassword($uid, $new)) {
            echo json_encode(['success' => true, 'message' => 'Đã đổi mật khẩu thành công.']);
            return;
        }
        echo json_encode(['success' => false, 'message' => 'Không thể cập nhật mật khẩu.']);
    }
    
    /**
     * Trang đơn hàng của tôi
     */
    public function orders() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;

        // Load Order model
        require_once APP_ROOT . '/models/Order.php';
        $orderModel = new Order();

        // Lấy danh sách đơn hàng
        $ordersData = $orderModel->getOrdersByUserId($userId, 20, 0);

        // Format data cho view
        $orders = [];
        foreach ($ordersData as $order) {
            // Lấy sản phẩm trong đơn hàng
            $items = $orderModel->getOrderProducts($order['order_id']);

            // Format items
            $formattedItems = [];
            foreach ($items as $item) {
                $formattedItems[] = [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['title'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'image' => $item['image_url'] ?? 'media/products/default-book.jpg',
                    'author' => $item['author'] ?? 'N/A'
                ];
            }

            // Map status text
            $statusMap = [
                'pending' => 'Chờ xử lý',
                'processing' => 'Đang xử lý',
                'shipped' => 'Đang giao',
                'completed' => 'Hoàn thành',
                'cancelled' => 'Đã hủy'
            ];

            $orders[] = [
                'order_id' => $order['order_id'],
                'order_date' => $order['created_at'],
                'status' => $order['status'],
                'status_text' => $statusMap[$order['status']] ?? $order['status'],
                'total' => $order['total_amount'],
                'shipping_fee' => $order['shipping_fee'],
                'subtotal' => $order['subtotal'],
                'payment_method' => $order['payment_method'],
                'shipping_address' => $order['shipping_address'],
                'note' => $order['note'],
                'items' => $formattedItems
            ];
        }

        $data = [
            'title' => 'Đơn hàng của tôi - ' . APP_NAME,
            'page' => 'customer',
            'orders' => $orders
        ];

        $this->view('customer/orders', $data);
    }

    // Notifications
    public function notifications() {
        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $nm = $this->model('NotificationModel');
            $notes = $nm->getByUserId($_SESSION['users_id']);
        } else {
            // guest notifications: none (or mock)
            $notes = $_SESSION['guest_notifications'] ?? [];
        }
        $this->view('customer/notifications', ['notifications' => $notes]);
    }

    // Mark single notification read (AJAX)
    public function markNotificationRead() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success' => false]); return; }

        $nid = (int)($_POST['id'] ?? 0);
        if ($nid <= 0) { echo json_encode(['success' => false]); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $nm = $this->model('NotificationModel');
            $ok = $nm->markRead($nid, $_SESSION['users_id']);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // Guest: mark in session
        if (isset($_SESSION['guest_notifications']) && is_array($_SESSION['guest_notifications'])) {
            foreach ($_SESSION['guest_notifications'] as &$n) {
                if ((int)($n['id'] ?? 0) === $nid) {
                    $n['is_read'] = 1;
                    echo json_encode(['success' => true]);
                    return;
                }
            }
        }
        echo json_encode(['success' => false]);
    }

    // Mark all notifications read (AJAX)
    public function markAllNotificationsRead() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success' => false]); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $nm = $this->model('NotificationModel');
            $ok = $nm->markAllRead($_SESSION['users_id']);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // Guest
        if (isset($_SESSION['guest_notifications']) && is_array($_SESSION['guest_notifications'])) {
            foreach ($_SESSION['guest_notifications'] as &$n) $n['is_read'] = 1;
            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }

    // Wishlist page (reads DB for logged users, session for guests)
    public function wishlist() {
        $list = [];
        $productModel = $this->model('ProductModel');

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $wm = $this->model('WishlistModel');
            $rows = $wm->getByUserId($_SESSION['users_id']);
            foreach ($rows as $r) {
                $list[] = [
                    'product_id' => $r['product_id'],
                    'product_name'=> $r['product_name'],
                    'image'=> $r['image'] ?? 'media/products/default-book.jpg',
                    'price'=> $r['price'],
                    'original_price'=> $r['original_price'] ?? 0,
                    'author'=> $r['author'] ?? 'Chưa có thông tin',
                    'discount'=> (isset($r['original_price']) && $r['original_price']>$r['price']) ? round(100-($r['price']/$r['original_price']*100)) : 0
                ];
            }
        } else {
            // guest: use session list of product IDs
            $guest = $_SESSION['guest_wishlist'] ?? [];
            if (!empty($guest)) {
                // Sử dụng ProductModel để lấy sản phẩm
                if (method_exists($productModel, 'getProductsByIds')) {
                    $products = $productModel->getProductsByIds($guest);
                } else {
                    $products = [];
                }
                foreach ($products as $p) {
                    $list[] = [
                        'product_id' => $p['product_id'],
                        'product_name'=> $p['title'],
                        'image'=> $p['image_url'] ?? 'media/products/default-book.jpg',
                        'price'=> $p['price'],
                        'original_price'=> $p['old_price'] ?? 0,
                        'author'=> $p['author'] ?? 'Chưa có thông tin',
                        'discount'=> (isset($p['old_price']) && $p['old_price']>$p['price']) ? round(100-($p['price']/$p['old_price']*100)) : 0
                    ];
                }
            }
        }

        $data = [
            'title' => 'Sản phẩm yêu thích - ' . APP_NAME,
            'page' => 'customer',
            'wishlist' => $list
        ];

        $this->view('customer/wishlist', $data);
    }

    // API add wishlist (POST)
    public function addWishlist() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success'=>false,'message'=>'Method not allowed']); return; }
        $pid = (int)($_POST['product_id'] ?? 0);
        if ($pid <= 0) { echo json_encode(['success'=>false,'message'=>'Invalid product']); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $wm = $this->model('WishlistModel');
            $ok = $wm->add($_SESSION['users_id'], $pid);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // guest: add to session array
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['guest_wishlist']) || !is_array($_SESSION['guest_wishlist'])) $_SESSION['guest_wishlist'] = [];
        if (!in_array($pid, $_SESSION['guest_wishlist'])) $_SESSION['guest_wishlist'][] = $pid;
        $_SESSION['guest_wishlist'] = array_values(array_unique($_SESSION['guest_wishlist']));
        echo json_encode(['success'=>true, 'guest'=>true, 'count'=>count($_SESSION['guest_wishlist'])]);
    }

    // API remove wishlist (POST)
    public function removeWishlist() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success'=>false,'message'=>'Method not allowed']); return; }
        $pid = (int)($_POST['product_id'] ?? 0);
        if ($pid <= 0) { echo json_encode(['success'=>false,'message'=>'Invalid product']); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $wm = $this->model('WishlistModel');
            $ok = $wm->remove($_SESSION['users_id'], $pid);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // guest: remove from session
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['guest_wishlist']) || !is_array($_SESSION['guest_wishlist'])) {
            echo json_encode(['success'=>false,'message'=>'Not found']); return;
        }
        $_SESSION['guest_wishlist'] = array_values(array_diff($_SESSION['guest_wishlist'], [$pid]));
        echo json_encode(['success'=>true, 'guest'=>true, 'count'=>count($_SESSION['guest_wishlist'])]);
    }
}
