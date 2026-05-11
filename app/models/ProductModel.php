<?php

class ProductModel extends DB
{
  /**
   * Lấy sản phẩm có kèm filter, phân trang và join các bảng liên quan
   */
  public function getFilteredProducts($options = [])
  {
    // Default options
    $search = $options['search'] ?? '';
    $category_id = $options['category_id'] ?? null;
    $sort = $options['sort'] ?? '';
    $limit = $options['limit'] ?? 10;
    $offset = $options['offset'] ?? 0;

    $sql = "SELECT
                p.*,
                pi.image_url,
                aop.author_name as author
            FROM product p
            LEFT JOIN (
                SELECT product_id, image_url
                FROM product_image
                GROUP BY product_id
            ) AS pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            LEFT JOIN category_product cp ON p.product_id = cp.product_id";

    $params = [];
    $whereClauses = [];

    if (!empty($search)) {
      $whereClauses[] = "(p.title LIKE :search1 OR aop.author_name LIKE :search2)";
      $params[':search1'] = '%' . $search . '%';
      $params[':search2'] = '%' . $search . '%';
    }

    if (!empty($category_id) && is_numeric($category_id)) {
      $whereClauses[] = "cp.category_id = :category_id";
      $params[':category_id'] = $category_id;
    }

    if (count($whereClauses) > 0) {
      $sql .= " WHERE " . implode(' AND ', $whereClauses);
    }

    $sql .= " GROUP BY p.product_id";

    // Thêm ORDER BY clause dựa trên sort parameter
    $orderClause = " ORDER BY p.product_id DESC"; // Mặc định
    if ($sort == 'price-asc') {
      $orderClause = " ORDER BY p.price ASC";
    } elseif ($sort == 'price-desc') {
      $orderClause = " ORDER BY p.price DESC";
    } elseif ($sort == 'name-asc') {
      $orderClause = " ORDER BY p.title ASC";
    } elseif ($sort == 'name-desc') {
      $orderClause = " ORDER BY p.title DESC";
    }
    $sql .= $orderClause;

    // Thêm LIMIT và OFFSET trực tiếp vào SQL (đã ép kiểu int nên an toàn)
    $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

    $result = $this->query($sql, $params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Sản phẩm bán chạy: chỉ sách đã có ít nhất 1 lượng bán trong đơn completed; xếp theo tổng quantity giảm dần.
   */
  public function getBestsellerProducts($limit = 8)
  {
    $limit = max(1, min(24, (int) $limit));
    $sql = "SELECT p.*, pi.image_url, aop.author_name AS author, sales.qty AS sold_qty
            FROM product p
            INNER JOIN (
                SELECT op.product_id, SUM(op.quantity) AS qty
                FROM order_product op
                INNER JOIN orders o ON o.order_id = op.order_id AND o.status = 'completed'
                GROUP BY op.product_id
            ) sales ON sales.product_id = p.product_id
            LEFT JOIN (
                SELECT product_id, image_url FROM product_image GROUP BY product_id
            ) pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            GROUP BY p.product_id
            ORDER BY sales.qty DESC, p.product_id ASC
            LIMIT " . $limit;

    return $this->all($sql);
  }

  /**
   * Sản phẩm mới (ưu tiên ngày xuất bản, sau đó ID giảm dần).
   */
  public function getNewestProducts($limit = 8)
  {
    $limit = max(1, min(24, (int) $limit));
    $sql = "SELECT p.*, pi.image_url, aop.author_name AS author
            FROM product p
            LEFT JOIN (
                SELECT product_id, image_url FROM product_image GROUP BY product_id
            ) pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            GROUP BY p.product_id
            ORDER BY COALESCE(p.published_date, '1970-01-01') DESC, p.product_id DESC
            LIMIT " . $limit;

    return $this->all($sql);
  }

  /**
   * Đếm tổng số sản phẩm dựa trên filter (để phân trang)
   */
  public function countFilteredProducts($options = [])
  {
    $search = $options['search'] ?? '';
    $category_id = $options['category_id'] ?? null;

    // A simplified query to count distinct products
    $sql = "SELECT COUNT(DISTINCT p.product_id) as total
            FROM product p
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            LEFT JOIN category_product cp ON p.product_id = cp.product_id";
    
    $params = [];
    $whereClauses = [];

    if (!empty($search)) {
      $whereClauses[] = "(p.title LIKE :search1 OR aop.author_name LIKE :search2)";
      $params[':search1'] = '%' . $search . '%';
      $params[':search2'] = '%' . $search . '%';
    }

    if (!empty($category_id) && is_numeric($category_id)) {
      $whereClauses[] = "cp.category_id = :category_id";
      $params[':category_id'] = $category_id;
    }

    if (count($whereClauses) > 0) {
      $sql .= " WHERE " . implode(' AND ', $whereClauses);
    }

    $result = $this->query($sql, $params);
    return $result->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
  }


  /**
   * Lấy thông tin chi tiết của một sản phẩm
   */
  public function getProductDetailsById($id)
  {
    $sql = "SELECT p.*,
                (SELECT pi.image_url FROM product_image pi
                 WHERE pi.product_id = p.product_id LIMIT 1) AS image_url,
                (SELECT MIN(aop.author_name) FROM author_of_product aop
                 WHERE aop.product_id = p.product_id) AS author,
                (SELECT MIN(cp.category_id) FROM category_product cp
                 WHERE cp.product_id = p.product_id) AS category_id
            FROM product p
            WHERE p.product_id = :id
            LIMIT 1";

    $result = $this->query($sql, [':id' => $id]);
    return $result->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Lấy các sản phẩm liên quan (cùng danh mục)
   */
  public function getRelatedProducts($categoryId, $currentProductId, $limit = 4)
  {
    $sql = "SELECT
                p.*,
                pi.image_url,
                aop.author_name as author
            FROM product p
            JOIN category_product cp ON p.product_id = cp.product_id
            LEFT JOIN (
                SELECT product_id, image_url
                FROM product_image
                GROUP BY product_id
            ) AS pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            WHERE cp.category_id = :category_id AND p.product_id != :current_product_id
            GROUP BY p.product_id
            LIMIT :limit";

    $params = [
        ':category_id' => $categoryId,
        ':current_product_id' => $currentProductId,
        ':limit' => $limit
    ];

    $result = $this->query($sql, $params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * ================= ADMIN CRUD METHODS =================
   */

  /**
   * Lấy tất cả sản phẩm cho admin (với đầy đủ thông tin)
   */
  public function getAllProductsForAdmin()
  {
    $sql = "SELECT
                p.*,
                pi.image_url,
                aop.author_name as author,
                c.category_name,
                cp.category_id
            FROM product p
            LEFT JOIN (
                SELECT product_id, image_url
                FROM product_image
                GROUP BY product_id
            ) AS pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            LEFT JOIN category_product cp ON p.product_id = cp.product_id
            LEFT JOIN category c ON cp.category_id = c.category_id
            GROUP BY p.product_id
            ORDER BY p.product_id ASC";

    return $this->all($sql);
  }

  /**
   * Thêm sản phẩm mới
   */
  public function createProduct($data)
  {
    $sql = "INSERT INTO product (title, price, old_price, description, stock_quantity,
            publisher, published_date, supplier, year, language, pages, product_type, weight, dimensions, size)
            VALUES (:title, :price, :old_price, :description, :stock_quantity,
            :publisher, :published_date, :supplier, :year, :language, :pages, :product_type, :weight, :dimensions, :size)";

    $this->query($sql, $data);
    return $this->con->lastInsertId();
  }

  /**
   * Cập nhật thông tin sản phẩm
   */
  public function updateProduct($productId, $data)
  {
    $sql = "UPDATE product SET
            title = :title,
            price = :price,
            old_price = :old_price,
            description = :description,
            stock_quantity = :stock_quantity,
            publisher = :publisher,
            published_date = :published_date,
            supplier = :supplier,
            year = :year,
            language = :language,
            pages = :pages,
            product_type = :product_type,
            weight = :weight,
            dimensions = :dimensions,
            size = :size
            WHERE product_id = :product_id";

    $data['product_id'] = $productId;
    return $this->query($sql, $data);
  }

  /**
   * Xóa sản phẩm (và các dữ liệu liên quan sẽ tự động xóa nhờ ON DELETE CASCADE)
   */
  public function deleteProduct($productId)
  {
    $sql = "DELETE FROM product WHERE product_id = :product_id";
    return $this->query($sql, [':product_id' => $productId]);
  }

  /**
   * Thêm ảnh cho sản phẩm
   */
  public function addProductImage($productId, $imageUrl)
  {
    $sql = "INSERT INTO product_image (product_id, image_url) VALUES (:product_id, :image_url)";
    return $this->query($sql, [
      ':product_id' => $productId,
      ':image_url' => $imageUrl
    ]);
  }

  /**
   * Xóa tất cả ảnh của sản phẩm
   */
  public function deleteProductImages($productId)
  {
    $sql = "DELETE FROM product_image WHERE product_id = :product_id";
    return $this->query($sql, [':product_id' => $productId]);
  }

  /**
   * Thêm tác giả cho sản phẩm
   */
  public function addProductAuthor($productId, $authorName)
  {
    $sql = "INSERT INTO author_of_product (product_id, author_name) VALUES (:product_id, :author_name)";
    return $this->query($sql, [
      ':product_id' => $productId,
      ':author_name' => $authorName
    ]);
  }

  /**
   * Xóa tác giả của sản phẩm
   */
  public function deleteProductAuthors($productId)
  {
    $sql = "DELETE FROM author_of_product WHERE product_id = :product_id";
    return $this->query($sql, [':product_id' => $productId]);
  }

  /**
   * Thêm danh mục cho sản phẩm
   */
  public function addProductCategory($productId, $categoryId)
  {
    $sql = "INSERT INTO category_product (product_id, category_id) VALUES (:product_id, :category_id)";
    return $this->query($sql, [
      ':product_id' => $productId,
      ':category_id' => $categoryId
    ]);
  }

  /**
   * Xóa danh mục của sản phẩm
   */
  public function deleteProductCategories($productId)
  {
    $sql = "DELETE FROM category_product WHERE product_id = :product_id";
    return $this->query($sql, [':product_id' => $productId]);
  }

  /**
   * Lấy danh sách product_id theo mảng IDs (cho cart localStorage)
   */
  public function getProductsByIds($productIds)
  {
    $ids = array_values(array_unique(array_filter(array_map('intval', (array) $productIds))));
    if (empty($ids)) {
      return [];
    }

    $placeholders = [];
    $params = [];
    foreach ($ids as $i => $id) {
      $key = ':pid' . $i;
      $placeholders[] = $key;
      $params[$key] = $id;
    }
    $inList = implode(',', $placeholders);

    $sql = "SELECT
                p.*,
                pi.image_url,
                aop.author_name AS author
            FROM product p
            LEFT JOIN (
                SELECT product_id, image_url
                FROM product_image
                GROUP BY product_id
            ) AS pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            WHERE p.product_id IN ($inList)
            GROUP BY p.product_id";

    return $this->all($sql, $params);
  }
}
