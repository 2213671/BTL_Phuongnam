<?php
// app/controllers/CartController.php

class CartController extends Controller
  {
      private $cartModel;
      private $productModel;

      public function __construct()
      {
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }

          $this->cartModel = $this->model('CartModel');
          $this->productModel = $this->model('ProductModel');
      }

      /**
       * Hiển thị giỏ hàng
       */
      public function index()
    {
        $cartItems = [];
        $summary = ['subtotal' => 0, 'discount' => 0, 'shipping' => 0, 'total' => 0];
        $isLoggedIn = $this->isLoggedIn();
        $localCartItemsJson = $_COOKIE['local_cart'] ?? '[]';
        $localCartItems = json_decode($localCartItemsJson, true) ?? [];

        if ($isLoggedIn) {
            // 1. User đã đăng nhập → lấy từ database
            $userId = $_SESSION['users_id'];
            $cartItems = $this->cartModel->getCartByUserId($userId);
        } elseif (!empty($localCartItems)) {
            // 2. User chưa đăng nhập → Lấy thông tin chi tiết từ LocalStorage
            $cartItems = $this->getCartItemsFromLocal($localCartItems);
        }
        
        $summary = $this->calculateSummary($cartItems);

        $data = [
            'title' => 'Giỏ hàng - ' . APP_NAME,
            'page' => 'cart',
            'cartItems' => $cartItems,
            'summary' => $summary,
            'isLoggedIn' => $isLoggedIn
        ];

        $this->view('cart/index', $data);
    }
      /**
       * Thêm sản phẩm vào giỏ hàng (AJAX)
       */
      public function add()
      {
          if (!$this->isPost()) {
              $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
          }

          $productId = (int)($_POST['product_id'] ?? 0);
          $quantity = (int)($_POST['quantity'] ?? 1);

          // Validate
          if ($productId <= 0 || $quantity <= 0) {
              $this->jsonResponse(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
          }

          // Kiểm tra sản phẩm tồn tại
          $product = $this->productModel->getProductDetailsById($productId);
          if (!$product) {
              $this->jsonResponse(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
          }

          // Kiểm tra stock
          if ($product['stock_quantity'] < $quantity) {
              $this->jsonResponse(['success' => false, 'message' => 'Số lượng vượt quá tồn kho']);
          }

          if ($this->isLoggedIn()) {
              // User đã đăng nhập → lưu vào database
              $userId = $_SESSION['users_id'];
              $this->cartModel->addToCart($userId, $productId, $quantity);
              $cartCount = $this->cartModel->getCartCount($userId);

              $this->jsonResponse([
                  'success' => true,
                  'message' => 'Đã thêm vào giỏ hàng',
                  'cartCount' => $cartCount,
                  'storage' => 'database'
              ]);
          } else {
              // Chưa đăng nhập → trả về để JS lưu localStorage
              $this->jsonResponse([
                  'success' => true,
                  'message' => 'Đã thêm vào giỏ hàng',
                  'storage' => 'local',
                  'needSync' => true
              ]);
          }
      }

      /**
       * Cập nhật số lượng (AJAX)
       */
      public function updateQuantity()
    {
        if (!$this->isPost()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);
        $isLoggedIn = $this->isLoggedIn();

        if (!$isLoggedIn && (!isset($_POST['is_local']) || $_POST['is_local'] != 'true')) {
             // Nếu chưa đăng nhập, phải có cờ is_local. Nếu không, coi là request lỗi
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized or missing local flag']);
        }

        // Logic xử lý stock... (nên được thêm ở đây)

        if ($isLoggedIn) {
            $userId = (int) $_SESSION['users_id'];
            $this->cartModel->updateQuantity($userId, $productId, $quantity);
        }
        // else: Local Storage xử lý phía client

        $out = ['success' => true, 'message' => 'Đã cập nhật'];
        if ($isLoggedIn) {
            $out['cartCount'] = $this->cartModel->getCartCount((int) $_SESSION['users_id']);
        }
        $this->jsonResponse($out);
    }

      /**
       * Xóa sản phẩm khỏi giỏ (AJAX)
       */
      public function remove()
    {
        if (!$this->isPost()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $isLoggedIn = $this->isLoggedIn();

        if (!$isLoggedIn && (!isset($_POST['is_local']) || $_POST['is_local'] != 'true')) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized or missing local flag']);
        }

        if ($isLoggedIn) {
            $this->cartModel->removeFromCart((int) $_SESSION['users_id'], $productId);
        }

        $out = ['success' => true, 'message' => 'Đã xóa sản phẩm'];
        if ($isLoggedIn) {
            $out['cartCount'] = $this->cartModel->getCartCount((int) $_SESSION['users_id']);
        }
        $this->jsonResponse($out);
    }

      /**
       * Sync cart từ localStorage khi user login (AJAX)
       */
      public function syncFromLocal()
      {
          if (!$this->isPost() || !$this->isLoggedIn()) {
              $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
          }

          // Nhận cart từ localStorage (qua POST JSON)
          $json = file_get_contents('php://input');
          $data = json_decode($json, true);
          $localCart = $data['cart'] ?? [];

          if (!empty($localCart) && is_array($localCart)) {
              $userId = $_SESSION['users_id'];
              $this->cartModel->syncFromLocalStorage($userId, $localCart);
          }

          $cartCount = $this->cartModel->getCartCount($_SESSION['users_id']);

          $this->jsonResponse([
              'success' => true,
              'message' => 'Đã đồng bộ giỏ hàng',
              'cartCount' => $cartCount
          ]);
      }

      /**
       * Helper: Kiểm tra đăng nhập
       */
      private function isLoggedIn()
      {
          return (int) ($_SESSION['users_id'] ?? 0) > 0;
      }

      private function getCartItemsFromLocal($localCartItems)
    {
        $cartItems = [];
        if (empty($localCartItems) || !is_array($localCartItems)) {
            return [];
        }

        // Lấy danh sách ID sản phẩm để truy vấn 1 lần
        $productIds = array_column($localCartItems, 'product_id');
        if (empty($productIds)) {
            return [];
        }

        // Giả sử ProductModel có hàm getProductsByIds
        $productsData = $this->productModel->getProductsByIds($productIds); 
        $productsMap = array_column($productsData, null, 'product_id');

        foreach ($localCartItems as $item) {
            $productId = (int)$item['product_id'];
            $quantity = (int)($item['quantity'] ?? 1);

            if (isset($productsMap[$productId])) {
                $product = $productsMap[$productId];
                $subtotal = $product['price'] * $quantity;

                // Tạo cấu trúc dữ liệu giống như khi lấy từ DB
                $cartItems[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'stock_quantity' => $product['stock_quantity'],
                    'image_url' => $product['image_url'] ?? '', // Giả sử ProductModel có trả về
                    'author' => $product['author'] ?? 'N/A',
                    'subtotal' => $subtotal,
                ];
            }
        }
        return $cartItems;
    }
      /**
       * Helper: Tính tổng tiền
       */
      private function calculateSummary($cartItems)
      {
          $subtotal = 0;
          foreach ($cartItems as $item) {
              $subtotal += $item['subtotal'];
          }

          $discount = 0; // Chưa có chức năng giảm giá
          $shipping = $subtotal > 0 ? 30000 : 0;
          $total = $subtotal - $discount + $shipping;

          return [
              'subtotal' => $subtotal,
              'discount' => $discount,
              'shipping' => $shipping,
              'total' => $total
          ];
      }

      /**
       * Helper: JSON response
       */
      private function jsonResponse($data)
      {
          header('Content-Type: application/json');
          echo json_encode($data);
          exit;
      }
  }
