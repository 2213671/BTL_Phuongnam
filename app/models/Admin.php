<?php
class Admin extends DB {
    private function normalizePagination(int $page, int $perPage, int $totalRows): array {
        $safePerPage = max(1, min(100, $perPage));
        $totalPages = $totalRows > 0 ? (int) ceil($totalRows / $safePerPage) : 0;
        $safePage = max(1, $page);
        if ($totalPages > 0) {
            $safePage = min($safePage, $totalPages);
        } else {
            $safePage = 1;
        }
        $offset = ($safePage - 1) * $safePerPage;

        return [$safePage, $safePerPage, $offset];
    }

    // ================= TASK 1: QUẢN LÝ CẤU HÌNH (SETTINGS) =================
    
    public function getSettings() {
        $result = $this->all("SELECT * FROM settings");
        $settings = [];
        if ($result) {
            foreach ($result as $row) {
                $settings[$row['key_name']] = $row['value'];
            }
        }
        return $settings;
    }

    public function updateSetting($key, $value) {
        return $this->query("UPDATE settings SET value = :value WHERE key_name = :key",
            ['value' => $value, 'key' => $key]
        );
    }

    /**
     * Gán giá trị setting; insert key mới nếu chưa có (bảng settings có UNIQUE key_name).
     */
    public function setSettingValue(string $key, string $value): bool {
        $row = $this->single('SELECT id FROM settings WHERE key_name = :k LIMIT 1', ['k' => $key]);
        if ($row) {
            return (bool) $this->updateSetting($key, $value);
        }
        $max = (int) (($this->single('SELECT COALESCE(MAX(id), 0) AS m FROM settings')['m'] ?? 0));

        return (bool) $this->query(
            'INSERT INTO settings (id, key_name, value) VALUES (:id, :k, :v)',
            ['id' => $max + 1, 'k' => $key, 'v' => $value]
        );
    }

    // ================= TASK 1: QUẢN LÝ LIÊN HỆ (CONTACTS) =================

    public function getAllContacts() {
        return $this->all("SELECT * FROM contacts ORDER BY id ASC");
    }

    public function getPaginatedContacts(int $page = 1, int $perPage = 10): array {
        $total = (int) (($this->single("SELECT COUNT(*) AS total FROM contacts")['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);

        $sql = "SELECT * FROM contacts ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function deleteContact($id) {
        return $this->query("DELETE FROM contacts WHERE id = :id", ['id' => $id]);
    }

    public function updateContactStatus(int $id, string $status): bool {
        $status = strtolower(trim($status)) === 'processed' ? 'Processed' : 'New';
        $readAt = $status === 'Processed' ? date('Y-m-d H:i:s') : null;
        return (bool) $this->query(
            'UPDATE contacts SET status = :st, read_at = :ra WHERE id = :id',
            ['st' => $status, 'ra' => $readAt, 'id' => $id]
        );
    }

    // ================= TASK 2: QUẢN LÝ TRANG (PAGES) =================

    public function getPageContent($pageName) {
        $result = $this->single("SELECT content FROM pages WHERE page_name = :page", ['page' => $pageName]);
        return $result ? $result['content'] : '';
    }

    public function updatePageContent($pageName, $content) {
        $row = $this->single(
            'SELECT id FROM pages WHERE page_name = :page LIMIT 1',
            ['page' => $pageName]
        );
        if ($row) {
            return $this->query(
                'UPDATE pages SET content = :content, updated_at = NOW() WHERE page_name = :page',
                ['page' => $pageName, 'content' => $content]
            );
        }

        return $this->query(
            'INSERT INTO pages (page_name, content, created_at, updated_at) VALUES (:page, :content, NOW(), NOW())',
            ['page' => $pageName, 'content' => $content]
        );
    }

    // ================= TASK 2: QUẢN LÝ HỎI ĐÁP (QA) =================

    public function getAllQA() {
        return $this->all("SELECT * FROM qa ORDER BY id ASC");
    }

    public function getPaginatedQA(int $page = 1, int $perPage = 10): array {
        $total = (int) (($this->single("SELECT COUNT(*) AS total FROM qa")['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);

        $sql = "SELECT * FROM qa ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function createQA($question, $answer, $category) {
        $sql = "INSERT INTO qa (question, answer, category) VALUES (:q, :a, :c)";
        return $this->query($sql, ['q' => $question, 'a' => $answer, 'c' => $category]);
    }

    public function deleteQA($id) {
        return $this->query("DELETE FROM qa WHERE id = :id", ['id' => $id]);
    }



// ================= QUẢN LÝ TIN TỨC (NEWS) =================
    public function getAllArticles() {
        $sql = "SELECT n.*, u.fullname as author_name
                FROM news n
                LEFT JOIN users u ON n.author_id = u.user_id
                ORDER BY n.id ASC";
        return $this->all($sql);
    }

    public function getPaginatedArticles(int $page = 1, int $perPage = 10): array {
        $total = (int) (($this->single("SELECT COUNT(*) AS total FROM news")['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);

        $sql = "SELECT n.*, u.fullname as author_name
                FROM news n
                LEFT JOIN users u ON n.author_id = u.user_id
                ORDER BY n.id ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function getArticleById($id) {
        $sql = "SELECT n.*, u.fullname as author_name
                FROM news n
                LEFT JOIN users u ON n.author_id = u.user_id
                WHERE n.id = :id
                LIMIT 1";
        return $this->single($sql, ['id' => $id]);
    }

    public function ensureUniqueNewsSlug(string $slug, ?int $excludeId = null): string {
        $base = trim($slug) !== '' ? trim($slug) : 'bai-viet';
        $candidate = $base;
        for ($i = 0; $i < 100; $i++) {
            $sql = 'SELECT id FROM news WHERE slug = :s';
            $params = ['s' => $candidate];
            if ($excludeId !== null) {
                $sql .= ' AND id != :ex';
                $params['ex'] = $excludeId;
            }
            $sql .= ' LIMIT 1';
            $found = $this->single($sql, $params);
            if (!$found) {
                return $candidate;
            }
            $candidate = $base . '-' . ($i + 2);
        }
        return $base . '-' . time();
    }

    public function addArticle($data) {
        $sql = "INSERT INTO news (title, summary, content, category, image_url, published_date, author_id, slug, meta_description, meta_keywords)
                VALUES (:title, :summary, :content, :category, :image_url, :published_date, :author_id, :slug, :meta_description, :meta_keywords)";
        return $this->query($sql, [
            'title' => $data['title'],
            'summary' => $data['summary'] ?? null,
            'content' => $data['content'],
            'category' => $data['category'] ?? null,
            'image_url' => $data['image_url'] ?? null,
            'published_date' => $data['published_date'] ?? date('Y-m-d'),
            'author_id' => $data['author_id'],
            'slug' => $data['slug'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
        ]);
    }

    public function updateArticle($id, $data) {
        $sql = "UPDATE news
                SET title = :title,
                    summary = :summary,
                    content = :content,
                    category = :category,
                    slug = :slug,
                    meta_description = :meta_description,
                    meta_keywords = :meta_keywords";

        $params = [
            'id' => $id,
            'title' => $data['title'],
            'summary' => $data['summary'] ?? null,
            'content' => $data['content'],
            'category' => $data['category'] ?? null,
            'slug' => $data['slug'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
        ];

        if (!empty($data['image_url'])) {
            $sql .= ", image_url = :image_url";
            $params['image_url'] = $data['image_url'];
        }

        $sql .= " WHERE id = :id";

        return $this->query($sql, $params);
    }

    public function deleteArticle($id) {
        return $this->query("DELETE FROM news WHERE id = :id", ['id' => $id]);
    }

    // ================= QUẢN LÝ SẢN PHẨM (PRODUCTS) =================
    public function getAllProducts() {
        return $this->all("SELECT * FROM product ORDER BY product_id ASC");
    }

    public function getProductById($id) {
        return $this->single("SELECT * FROM product WHERE product_id = :id", ['id' => $id]);
    }

    public function addProduct($data) {
        $sql = "INSERT INTO product (title, price, old_price, description, stock_quantity, publisher)
                VALUES (:title, :price, :old_price, :description, :stock_quantity, :publisher)";
        return $this->query($sql, $data);
    }

    public function updateProduct($id, $data) {
        $sql = "UPDATE product SET title=:title, price=:price, old_price=:old_price,
                description=:description, stock_quantity=:stock_quantity, publisher=:publisher
                WHERE product_id=:id";
        $data['id'] = $id;
        return $this->query($sql, $data);
    }

    public function deleteProduct($id) {
        return $this->query("DELETE FROM product WHERE product_id = :id", ['id' => $id]);
    }

    // ================= QUẢN LÝ ĐƠN HÀNG (ORDERS) =================

    public function getAllOrders() {
        $sql = "SELECT
                    o.order_id,
                    o.user_id,
                    o.recipient_name,
                    o.recipient_phone,
                    o.shipping_address,
                    o.payment_method,
                    o.subtotal,
                    o.shipping_fee,
                    o.total_amount as total,
                    o.status,
                    o.note,
                    o.created_at as created_date,
                    o.updated_at,
                    u.fullname as customer_name,
                    u.email as customer_email,
                    u.phone as customer_phone
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.user_id
                ORDER BY o.order_id ASC";
        return $this->all($sql);
    }

    public function getPaginatedOrders(int $page = 1, int $perPage = 10): array {
        $total = (int) (($this->single("SELECT COUNT(*) AS total FROM orders")['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);

        $sql = "SELECT
                    o.order_id,
                    o.user_id,
                    o.recipient_name,
                    o.recipient_phone,
                    o.shipping_address,
                    o.payment_method,
                    o.subtotal,
                    o.shipping_fee,
                    o.total_amount as total,
                    o.status,
                    o.note,
                    o.created_at as created_date,
                    o.updated_at,
                    u.fullname as customer_name,
                    u.email as customer_email,
                    u.phone as customer_phone
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.user_id
                ORDER BY o.order_id ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function getOrderById($orderId) {
        $sql = "SELECT
                    o.order_id,
                    o.user_id,
                    o.recipient_name,
                    o.recipient_phone,
                    o.shipping_address,
                    o.payment_method,
                    o.subtotal,
                    o.shipping_fee,
                    o.total_amount as total,
                    o.status,
                    o.note,
                    o.created_at as created_date,
                    o.updated_at,
                    u.fullname as customer_name,
                    u.email as customer_email,
                    u.phone as customer_phone
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.user_id
                WHERE o.order_id = :order_id";
        return $this->single($sql, ['order_id' => $orderId]);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT
                    op.product_id,
                    op.quantity,
                    op.price,
                    op.subtotal,
                    p.title,
                    pi.image_url,
                    GROUP_CONCAT(ap.author_name SEPARATOR ', ') as author
                FROM order_product op
                JOIN product p ON op.product_id = p.product_id
                LEFT JOIN product_image pi ON p.product_id = pi.product_id
                LEFT JOIN author_of_product ap ON p.product_id = ap.product_id
                WHERE op.order_id = :order_id
                GROUP BY op.product_id, op.order_id";
        return $this->all($sql, ['order_id' => $orderId]);
    }

    /** Các dòng order_product để trừ / hoàn tồn kho. */
    private function getOrderStockLines(int $orderId): array {
        return $this->all(
            'SELECT product_id, quantity FROM order_product WHERE order_id = :oid ORDER BY product_id',
            ['oid' => $orderId]
        );
    }

    /** Hoàn tồn kho khi hủy đơn đã xác nhận (đang xử lý / đang giao). */
    private function restoreStockForOrder(int $orderId): void {
        foreach ($this->getOrderStockLines($orderId) as $row) {
            $pid = (int) ($row['product_id'] ?? 0);
            $qty = (int) ($row['quantity'] ?? 0);
            if ($pid < 1 || $qty < 1) {
                continue;
            }
            $this->query(
                'UPDATE product SET stock_quantity = stock_quantity + :qty WHERE product_id = :pid',
                ['qty' => $qty, 'pid' => $pid]
            );
        }
    }

    /**
     * Đổi trạng thái đơn và đồng bộ kho:
     * - Tồn kho được trừ khi khách đặt hàng (Order::createOrder).
     * - pending|processing|shipped → cancelled: hoàn lại số lượng đã trừ.
     *
     * @return array{ok:bool,message?:string}
     */
    public function updateOrderStatusWithStock(int $orderId, string $status): array {
        try {
            $this->con->beginTransaction();
            $row = $this->single(
                'SELECT status FROM orders WHERE order_id = :id FOR UPDATE',
                ['id' => $orderId]
            );
            if (!$row) {
                $this->con->rollBack();

                return ['ok' => false, 'message' => 'Không tìm thấy đơn hàng.'];
            }
            $old = (string) $row['status'];
            if ($old === $status) {
                $this->con->commit();

                return ['ok' => true];
            }

            if ($status === 'cancelled' && in_array($old, ['pending', 'processing', 'shipped'], true)) {
                $this->restoreStockForOrder($orderId);
            }

            $this->query(
                'UPDATE orders SET status = :status, updated_at = NOW() WHERE order_id = :order_id',
                ['status' => $status, 'order_id' => $orderId]
            );
            $this->con->commit();

            return ['ok' => true];
        } catch (Throwable $e) {
            if ($this->con->inTransaction()) {
                $this->con->rollBack();
            }
            error_log('updateOrderStatusWithStock: ' . $e->getMessage());

            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Xác nhận thanh toán: pending → processing (tồn kho đã trừ khi khách đặt hàng).
     *
     * @return array{ok:bool,message?:string}
     */
    public function confirmOrderPaymentWithStock(int $orderId): array {
        try {
            $this->con->beginTransaction();
            $row = $this->single(
                'SELECT status FROM orders WHERE order_id = :id FOR UPDATE',
                ['id' => $orderId]
            );
            if (!$row) {
                $this->con->rollBack();

                return ['ok' => false, 'message' => 'Không tìm thấy đơn hàng.'];
            }
            if ($row['status'] !== 'pending') {
                $this->con->commit();

                return ['ok' => true];
            }
            $this->query(
                "UPDATE orders SET status = 'processing', updated_at = NOW() WHERE order_id = :order_id",
                ['order_id' => $orderId]
            );
            $this->con->commit();

            return ['ok' => true];
        } catch (Throwable $e) {
            if ($this->con->inTransaction()) {
                $this->con->rollBack();
            }
            error_log('confirmOrderPaymentWithStock: ' . $e->getMessage());

            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }

    public function updateOrderStatus($orderId, $status) {
        $sql = 'UPDATE orders SET status = :status, updated_at = NOW() WHERE order_id = :order_id';

        return $this->query($sql, ['status' => $status, 'order_id' => $orderId]);
    }

    public function confirmOrderPayment($orderId) {
        $sql = "UPDATE orders
                SET status = CASE WHEN status = 'pending' THEN 'processing' ELSE status END,
                    updated_at = NOW()
                WHERE order_id = :order_id";

        return $this->query($sql, ['order_id' => $orderId]);
    }

    public function deleteOrder($orderId) {
        return $this->query("DELETE FROM orders WHERE order_id = :order_id", ['order_id' => $orderId]);
    }

    public function getOrderStats() {
        $sql = "SELECT
                    COUNT(*) as total_orders,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
                    SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing_orders,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_orders,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_orders,
                    SUM(total_amount) as total_revenue
                FROM orders";
        return $this->single($sql);
    }

    // ================= QUẢN LÝ KHÁCH HÀNG (CUSTOMERS) =================

    public function getAllCustomers() {
        $sql = "SELECT
                    u.user_id,
                    u.fullname,
                    u.email,
                    u.phone,
                    u.created_date,
                    c.member_type,
                    c.total_fpoint,
                    COUNT(DISTINCT o.order_id) as total_orders,
                    SUM(CASE WHEN o.status = 'completed' THEN o.total_amount ELSE 0 END) as total_spent
                FROM users u
                LEFT JOIN customer c ON u.user_id = c.user_id
                LEFT JOIN orders o ON u.user_id = o.user_id
                WHERE u.role = 'customer'
                GROUP BY u.user_id
                ORDER BY u.user_id ASC";
        return $this->all($sql);
    }

    public function getPaginatedCustomers(int $page = 1, int $perPage = 10): array {
        $total = (int) (($this->single("SELECT COUNT(*) AS total FROM users WHERE LOWER(role) = 'customer'")['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);

        $sql = "SELECT
                    u.user_id,
                    u.fullname,
                    u.email,
                    u.phone,
                    u.avatar,
                    u.account_status,
                    u.created_date,
                    c.member_type,
                    c.total_fpoint,
                    COUNT(DISTINCT o.order_id) as total_orders,
                    SUM(CASE WHEN o.status = 'completed' THEN o.total_amount ELSE 0 END) as total_spent
                FROM users u
                LEFT JOIN customer c ON u.user_id = c.user_id
                LEFT JOIN orders o ON u.user_id = o.user_id
                WHERE LOWER(u.role) = 'customer'
                GROUP BY u.user_id
                ORDER BY u.user_id ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function getCustomerById($customerId) {
        $sql = "SELECT
                    u.user_id,
                    u.fullname,
                    u.email,
                    u.phone,
                    u.avatar,
                    u.account_status,
                    u.note,
                    u.created_date,
                    c.member_type,
                    c.total_fpoint
                FROM users u
                LEFT JOIN customer c ON u.user_id = c.user_id
                WHERE u.user_id = :customer_id AND u.role = 'customer'";
        return $this->single($sql, ['customer_id' => $customerId]);
    }

    public function getCustomerOrders($customerId) {
        $sql = "SELECT
                    o.order_id,
                    o.created_at as created_date,
                    o.status,
                    o.total_amount as total,
                    o.shipping_fee,
                    o.payment_method,
                    COUNT(DISTINCT op.product_id) as total_items
                FROM orders o
                LEFT JOIN order_product op ON o.order_id = op.order_id
                WHERE o.user_id = :customer_id
                GROUP BY o.order_id
                ORDER BY o.order_id ASC";
        return $this->all($sql, ['customer_id' => $customerId]);
    }

    public function getCustomerStats($customerId) {
        $sql = "SELECT
                    COUNT(DISTINCT o.order_id) as total_orders,
                    SUM(CASE WHEN o.status = 'completed' THEN o.total_amount ELSE 0 END) as total_spent,
                    SUM(CASE WHEN o.status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
                    SUM(CASE WHEN o.status = 'completed' THEN 1 ELSE 0 END) as completed_orders
                FROM orders o
                WHERE o.user_id = :customer_id";
        return $this->single($sql, ['customer_id' => $customerId]);
    }

    public function deleteCustomer($customerId) {
        // Xóa customer record
        $this->query("DELETE FROM customer WHERE user_id = :id", ['id' => $customerId]);
        // Xóa user record
        return $this->query("DELETE FROM users WHERE user_id = :id AND role = 'customer'", ['id' => $customerId]);
    }

    public function setCustomerAccountStatus(int $userId, string $status): bool {
        $status = strtolower($status) === 'locked' ? 'locked' : 'active';
        return (bool) $this->query(
            "UPDATE users SET account_status = :st WHERE user_id = :id AND LOWER(role) = 'customer'",
            ['st' => $status, 'id' => $userId]
        );
    }

    // ================= QUẢN LÝ DANH MỤC (CATEGORIES) =================

    public function getAllCategories() {
        // Kiểm tra xem bảng category_product có tồn tại không
        try {
            $sql = "SELECT
                        c.category_id,
                        c.category_name,
                        c.description,
                        COUNT(DISTINCT cp.product_id) as total_products
                    FROM category c
                    LEFT JOIN category_product cp ON c.category_id = cp.category_id
                    GROUP BY c.category_id
                    ORDER BY c.category_name ASC";
            return $this->all($sql);
        } catch (Exception $e) {
            // Nếu bảng category_product chưa tồn tại, chỉ lấy từ category
            $sql = "SELECT
                        category_id,
                        category_name,
                        description,
                        0 as total_products
                    FROM category
                    ORDER BY category_name ASC";
            return $this->all($sql);
        }
    }

    public function getPaginatedCategories(int $page = 1, int $perPage = 15): array {
        $total = (int) (($this->single('SELECT COUNT(*) AS total FROM category')['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);

        try {
            $sql = 'SELECT
                        c.category_id,
                        c.category_name,
                        c.description,
                        COUNT(DISTINCT cp.product_id) as total_products
                    FROM category c
                    LEFT JOIN category_product cp ON c.category_id = cp.category_id
                    GROUP BY c.category_id
                    ORDER BY c.category_name ASC
                    LIMIT :limit OFFSET :offset';
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $sql = 'SELECT category_id, category_name, description, 0 as total_products
                    FROM category
                    ORDER BY category_name ASC
                    LIMIT :limit OFFSET :offset';
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [
            'items' => $items,
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function getCategoryById($categoryId) {
        $sql = "SELECT * FROM category WHERE category_id = :category_id";
        return $this->single($sql, ['category_id' => $categoryId]);
    }

    public function createCategory($data) {
        $sql = "INSERT INTO category (category_name, description)
                VALUES (:category_name, :description)";
        return $this->query($sql, $data);
    }

    public function updateCategory($categoryId, $data) {
        $sql = "UPDATE category
                SET category_name = :category_name,
                    description = :description
                WHERE category_id = :category_id";
        $data['category_id'] = $categoryId;
        return $this->query($sql, $data);
    }

    public function deleteCategory($categoryId) {
        // Xóa liên kết category-product trước (nếu có ON DELETE CASCADE thì không cần)
        $this->query("DELETE FROM category_product WHERE category_id = :id", ['id' => $categoryId]);
        // Xóa category
        return $this->query("DELETE FROM category WHERE category_id = :id", ['id' => $categoryId]);
    }

    public function getStaffList(): array {
        $sql = "SELECT user_id, fullname, email, phone, role, note, created_date
                FROM users
                WHERE LOWER(role) IN ('admin', 'staff')
                ORDER BY user_id ASC";
        return $this->all($sql);
    }

    public function getPaginatedStaff(int $page = 1, int $perPage = 10): array {
        $total = (int) (($this->single("SELECT COUNT(*) AS total FROM users WHERE LOWER(role) IN ('admin', 'staff')")['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);

        $sql = "SELECT user_id, fullname, email, phone, role, note, created_date
                FROM users
                WHERE LOWER(role) IN ('admin', 'staff')
                ORDER BY user_id ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function getStaffById(int $id) {
        $sql = "SELECT user_id, fullname, email, phone, role, note, created_date
                FROM users
                WHERE user_id = :id AND LOWER(role) IN ('admin', 'staff')";
        return $this->single($sql, ['id' => $id]);
    }

    public function createStaff(array $data): bool {
        $userId = $this->nextUsersPrimaryKey();
        $sql = "INSERT INTO users (user_id, password, fullname, email, phone, role, note, created_date)
                VALUES (:user_id, :password, :fullname, :email, :phone, :role, :note, :created_date)";
        return (bool) $this->query($sql, [
            'user_id' => $userId,
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'role' => strtolower($data['role']),
            'note' => $data['note'] ?? null,
            'created_date' => date('Y-m-d')
        ]);
    }

    public function updateStaff(int $id, array $data): bool {
        $sql = "UPDATE users
                SET fullname = :fullname,
                    email = :email,
                    phone = :phone,
                    role = :role,
                    note = :note
                WHERE user_id = :id AND LOWER(role) IN ('admin', 'staff')";
        $ok = (bool) $this->query($sql, [
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'role' => strtolower($data['role']),
            'note' => $data['note'] ?? null,
            'id' => $id
        ]);

        if (!empty($data['password'])) {
            $this->query(
                "UPDATE users SET password = :password WHERE user_id = :id AND LOWER(role) IN ('admin', 'staff')",
                ['password' => password_hash($data['password'], PASSWORD_DEFAULT), 'id' => $id]
            );
        }

        return $ok;
    }

    public function deleteStaff(int $id): bool {
        return (bool) $this->query("DELETE FROM users WHERE user_id = :id AND LOWER(role) = 'staff'", ['id' => $id]);
    }

    public function staffEmailExists(string $email, ?int $excludeId = null): bool {
        $sql = "SELECT user_id FROM users WHERE email = :email";
        $params = ['email' => $email];
        if ($excludeId !== null) {
            $sql .= " AND user_id != :exclude_id";
            $params['exclude_id'] = $excludeId;
        }

        return !empty($this->single($sql, $params));
    }

    public function getDashboardStats(): array {
        return [
            'total_products' => (int) (($this->single("SELECT COUNT(*) AS total FROM product")['total'] ?? 0)),
            'total_orders' => (int) (($this->single("SELECT COUNT(*) AS total FROM orders")['total'] ?? 0)),
            'total_news' => (int) (($this->single("SELECT COUNT(*) AS total FROM news")['total'] ?? 0)),
            'total_customers' => (int) (($this->single("SELECT COUNT(*) AS total FROM users WHERE LOWER(role) = 'customer'")['total'] ?? 0))
        ];
    }

    public function getMonthlyRevenueLastSixMonths(): array {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_key,
                       SUM(total_amount) AS revenue
                FROM orders
                WHERE status = 'completed'
                  AND created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month_key ASC";
        $rows = $this->all($sql);
        $indexed = [];
        foreach ($rows as $row) {
            $indexed[$row['month_key']] = (float) $row['revenue'];
        }

        $result = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthKey = date('Y-m', strtotime("-{$i} months"));
            $result[] = [
                'month_key' => $monthKey,
                'month_label' => date('m/Y', strtotime($monthKey . '-01')),
                'revenue' => $indexed[$monthKey] ?? 0
            ];
        }

        return $result;
    }

    public function getPaginatedComments(int $page = 1, int $perPage = 10): array {
        $total = (int) (($this->single("SELECT COUNT(*) AS total FROM comments")['total'] ?? 0));
        [$safePage, $safePerPage, $offset] = $this->normalizePagination($page, $perPage, $total);
        $sql = "SELECT c.id, c.news_id, c.user_id, c.content, c.parent_id, c.created_at,
                       n.title AS news_title, u.fullname AS user_name, u.email AS user_email
                FROM comments c
                INNER JOIN news n ON n.id = c.news_id
                INNER JOIN users u ON u.user_id = c.user_id
                ORDER BY c.id ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $safePerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $safePerPage
        ];
    }

    public function deleteComment(int $id): bool {
        return (bool) $this->query("DELETE FROM comments WHERE id = :id", ['id' => $id]);
    }
}
