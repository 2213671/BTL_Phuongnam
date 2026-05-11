<?php
require_once APP_ROOT . '/models/Order.php';
require_once APP_ROOT . '/models/CartModel.php';

class OrderController extends Controller {
    private $orderModel;
    private $cartModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->cartModel = new CartModel();
    }

    /**
     * Submit đơn hàng (AJAX)
     */
    public function submitOrder() {
        header('Content-Type: application/json');

        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để đặt hàng'
            ]);
            return;
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;

        // Validate dữ liệu
        $recipientName = $_POST['recipient_name'] ?? '';
        $recipientPhone = $_POST['recipient_phone'] ?? '';
        $shippingAddress = $_POST['shipping_address'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? 'COD';
        $subtotal = (float)($_POST['subtotal'] ?? 0);
        $shippingFee = (float)($_POST['shipping_fee'] ?? 30000);
        $totalAmount = (float)($_POST['total'] ?? 0);
        $productsJson = $_POST['products'] ?? '';
        $note = $_POST['note'] ?? '';

        // Validate thông tin cơ bản
        if (empty($recipientName) || empty($recipientPhone) || empty($shippingAddress)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ thông tin giao hàng'
            ]);
            return;
        }

        $phoneDigits = preg_replace('/\D+/', '', $recipientPhone);
        if (str_starts_with($phoneDigits, '84') && strlen($phoneDigits) >= 10) {
            $phoneDigits = '0' . substr($phoneDigits, 2);
        }
        if (!preg_match('/^0(3|5|7|8|9)[0-9]{8}$/', $phoneDigits)) {
            echo json_encode([
                'success' => false,
                'message' => 'Số điện thoại không hợp lệ'
            ]);
            return;
        }

        // Parse products
        $products = json_decode($productsJson, true);
        if (empty($products) || !is_array($products)) {
            echo json_encode([
                'success' => false,
                'message' => 'Không có sản phẩm nào được chọn'
            ]);
            return;
        }

        // Validate products
        foreach ($products as $product) {
            if (empty($product['product_id']) || empty($product['quantity']) || empty($product['price'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Thông tin sản phẩm không hợp lệ'
                ]);
                return;
            }
        }

        // Chuẩn bị dữ liệu đơn hàng
        $orderData = [
            'user_id' => $userId,
            'recipient_name' => trim($recipientName),
            'recipient_phone' => $phoneDigits,
            'shipping_address' => trim($shippingAddress),
            'payment_method' => $paymentMethod,
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'note' => trim($note)
        ];

        // Tạo đơn hàng
        $orderId = $this->orderModel->createOrder($orderData, $products);

        if ($orderId) {
            // Xóa các sản phẩm đã đặt khỏi giỏ hàng
            foreach ($products as $product) {
                $this->cartModel->removeFromCart($userId, $product['product_id']);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Đặt hàng thành công',
                'order_id' => $orderId,
                'redirect_url' => BASE_URL . 'customer/orders'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi tạo đơn hàng. Vui lòng thử lại!'
            ]);
        }
    }

    /**
     * Hiển thị danh sách đơn hàng của user (trang customer/orders)
     */
    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;

        // Lấy danh sách đơn hàng
        $ordersData = $this->orderModel->getOrdersByUserId($userId, 20, 0);

        // Format data cho view
        $orders = [];
        foreach ($ordersData as $order) {
            // Lấy sản phẩm trong đơn hàng
            $items = $this->orderModel->getOrderProducts($order['order_id']);

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

        // Load view
        $this->view('customer/orders', [
            'orders' => $orders
        ]);
    }

    /**
     * Xem chi tiết đơn hàng
     */
    public function detail($orderId) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;

        // Lấy thông tin đơn hàng
        $order = $this->orderModel->getOrderById($orderId, $userId);

        if (!$order) {
            header('Location: ' . BASE_URL . 'customer/orders');
            exit();
        }

        // Lấy danh sách sản phẩm
        $products = $this->orderModel->getOrderProducts($orderId);

        // Load view
        $this->view('customer/order_detail', [
            'order' => $order,
            'products' => $products
        ]);
    }

    /**
     * Hủy đơn hàng (AJAX)
     */
    public function cancelOrder() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
            return;
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;
        $orderId = $_POST['order_id'] ?? 0;

        if (!$orderId) {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu order_id'
            ]);
            return;
        }

        $success = $this->orderModel->cancelOrder($orderId, $userId);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Đã hủy đơn hàng'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể hủy đơn hàng (Đơn hàng đã được xử lý)'
            ]);
        }
    }
}
