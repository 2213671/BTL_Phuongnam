<?php
class AdminModel extends DB {

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

    // ================= TASK 1: QUẢN LÝ LIÊN HỆ (CONTACTS) =================

    public function getAllContacts() {
        return $this->all("SELECT * FROM contacts ORDER BY created_at DESC");
    }

    public function deleteContact($id) {
        return $this->query("DELETE FROM contacts WHERE id = :id", ['id' => $id]);
    }

    // ================= TASK 2: QUẢN LÝ TRANG (PAGES) =================

    public function getPageContent($pageName) {
        $result = $this->single("SELECT content FROM pages WHERE page_name = :page", ['page' => $pageName]);
        return $result ? $result['content'] : '';
    }

    public function updatePageContent($pageName, $content) {
        $check = $this->getPageContent($pageName);
        
        if ($check !== '') {
            $sql = "UPDATE pages SET content = :content, updated_at = NOW() WHERE page_name = :page";
        } else {
            $sql = "INSERT INTO pages (page_name, content, created_at) VALUES (:page, :content, NOW())";
        }
        return $this->query($sql, ['page' => $pageName, 'content' => $content]);
    }

    // ================= TASK 2: QUẢN LÝ HỎI ĐÁP (QA) =================

    public function getAllQA() {
        return $this->all("SELECT * FROM qa ORDER BY id DESC");
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
        return $this->all("SELECT * FROM articles ORDER BY published_date DESC");
    }

    public function getArticleById($id) {
        return $this->single("SELECT * FROM articles WHERE id = :id", ['id' => $id]);
    }

    public function addArticle($data) {
        $sql = "INSERT INTO articles (title, summary, content, image, category, author, published_date) 
                VALUES (:title, :summary, :content, :image, :category, :author, NOW())";
        return $this->query($sql, $data);
    }

    public function updateArticle($id, $data) {
        // Nếu có ảnh mới thì update cả ảnh, không thì giữ nguyên
        if (!empty($data['image'])) {
            $sql = "UPDATE articles SET title=:title, summary=:summary, content=:content, image=:image, category=:category WHERE id=:id";
        } else {
            $sql = "UPDATE articles SET title=:title, summary=:summary, content=:content, category=:category WHERE id=:id";
            unset($data['image']); // Bỏ key image khỏi mảng data
        }
        $data['id'] = $id; // Thêm id vào mảng tham số
        return $this->query($sql, $data);
    }

    public function deleteArticle($id) {
        return $this->query("DELETE FROM articles WHERE id = :id", ['id' => $id]);
    }

    // ================= QUẢN LÝ SẢN PHẨM (PRODUCTS) =================
    public function getAllProducts() {
        return $this->all("SELECT * FROM products ORDER BY id DESC");
    }

    public function getProductById($id) {
        return $this->single("SELECT * FROM products WHERE id = :id", ['id' => $id]);
    }

    public function addProduct($data) {
        $sql = "INSERT INTO products (name, price, old_price, description, image, category) 
                VALUES (:name, :price, :old, :desc, :image, :cat)";
        return $this->query($sql, $data);
    }

    public function updateProduct($id, $data) {
        if (!empty($data['image'])) {
            $sql = "UPDATE products SET name=:name, price=:price, old_price=:old, description=:desc, image=:image, category=:cat WHERE id=:id";
        } else {
            $sql = "UPDATE products SET name=:name, price=:price, old_price=:old, description=:desc, category=:cat WHERE id=:id";
            unset($data['image']);
        }
        $data['id'] = $id;
        return $this->query($sql, $data);
    }

    public function deleteProduct($id) {
        return $this->query("DELETE FROM products WHERE id = :id", ['id' => $id]);
    }

    // ================= QUẢN LÝ ĐƠN HÀNG (ORDERS) =================
    public function getAllOrders() {
        return $this->all("SELECT * FROM orders ORDER BY created_date DESC");
    }

    public function getOrderById($id) {
        return $this->single("SELECT * FROM orders WHERE order_id = :id", ['id' => $id]);
    }

    public function getOrderItems($orderId) {
        return $this->all("SELECT oi.*, p.title as product_name, p.price 
                          FROM order_items oi 
                          JOIN products p ON oi.product_id = p.id 
                          WHERE oi.order_id = :order_id", ['order_id' => $orderId]);
    }

    public function updateOrderStatus($orderId, $status) {
        return $this->query("UPDATE orders SET status = :status WHERE order_id = :id", 
            ['status' => $status, 'id' => $orderId]);
    }

    public function deleteOrder($id) {
        return $this->query("DELETE FROM orders WHERE order_id = :id", ['id' => $id]);
    }

    public function getOrderStats() {
        $stats = $this->single("SELECT 
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
            SUM(CASE WHEN status = 'shipped' THEN 1 ELSE 0 END) as shipped,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
            FROM orders");
        return $stats;
    }

    // ================= QUẢN LÝ KHÁCH HÀNG (CUSTOMERS) =================
    public function getAllCustomers() {
        return $this->all("SELECT * FROM users WHERE role = 'user' ORDER BY created_date DESC");
    }

    public function getCustomerById($id) {
        return $this->single("SELECT * FROM users WHERE user_id = :id AND role = 'user'", ['id' => $id]);
    }

    public function getCustomerOrders($customerId) {
        return $this->all("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_date DESC", ['user_id' => $customerId]);
    }

    public function getCustomerStats($customerId) {
        return $this->single("SELECT 
            COUNT(*) as total_orders,
            SUM(total) as total_spent,
            MAX(created_date) as last_order_date
            FROM orders WHERE user_id = :user_id", ['user_id' => $customerId]);
    }

    public function deleteCustomer($id) {
        return $this->query("DELETE FROM users WHERE user_id = :id AND role = 'user'", ['id' => $id]);
    }

    // ================= QUẢN LÝ DANH MỤC (CATEGORIES) =================
    public function getAllCategories() {
        return $this->all("SELECT * FROM categories ORDER BY category_name ASC");
    }

    public function createCategory($data) {
        $sql = "INSERT INTO categories (category_name, description) VALUES (:name, :description)";
        return $this->query($sql, ['name' => $data['category_name'], 'description' => $data['description']]);
    }

    public function updateCategory($id, $data) {
        $sql = "UPDATE categories SET category_name = :name, description = :description WHERE category_id = :id";
        return $this->query($sql, ['name' => $data['category_name'], 'description' => $data['description'], 'id' => $id]);
    }

    public function deleteCategory($id) {
        return $this->query("DELETE FROM categories WHERE category_id = :id", ['id' => $id]);
    }
}
