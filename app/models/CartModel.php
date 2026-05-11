<?php
  // app/models/CartModel.php

  class CartModel extends DB
  {
      /**
       * Lấy tất cả sản phẩm trong giỏ hàng của user
       */
      public function getCartByUserId($userId)
      {
          $sql = "SELECT
                      c.user_id,
                      c.product_id,
                      c.quantity,
                      c.added_date,
                      p.title,
                      p.price,
                      p.stock_quantity,
                      pi.image_url,
                      aop.author_name as author,
                      (p.price * c.quantity) as subtotal
                  FROM cart_items c
                  INNER JOIN product p ON c.product_id = p.product_id
                  LEFT JOIN (
                      SELECT product_id, image_url
                      FROM product_image
                      GROUP BY product_id
                  ) AS pi ON p.product_id = pi.product_id
                  LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
                  WHERE c.user_id = :user_id
                  ORDER BY c.added_date DESC";

          return $this->all($sql, [':user_id' => $userId]);
      }

      /**
       * Thêm sản phẩm vào giỏ hàng
       * Nếu đã có thì tăng quantity
       */
      public function addToCart($userId, $productId, $quantity = 1)
      {
          // Kiểm tra sản phẩm đã có trong giỏ chưa
          $existing = $this->getCartItem($userId, $productId);

          if ($existing) {
              // Tăng quantity
              return $this->updateQuantity($userId, $productId, $existing['quantity'] + $quantity);
          } else {
              // Thêm mới
              $sql = "INSERT INTO cart_items (user_id, product_id, quantity)
                      VALUES (:user_id, :product_id, :quantity)";
              return $this->query($sql, [
                  ':user_id' => $userId,
                  ':product_id' => $productId,
                  ':quantity' => $quantity
              ]);
          }
      }

      /**
       * Lấy 1 item trong giỏ hàng
       */
      public function getCartItem($userId, $productId)
      {
          $sql = "SELECT * FROM cart_items
                  WHERE user_id = :user_id AND product_id = :product_id";
          return $this->single($sql, [
              ':user_id' => $userId,
              ':product_id' => $productId
          ]);
      }

      /**
       * Cập nhật số lượng
       */
      public function updateQuantity($userId, $productId, $quantity)
      {
          if ($quantity <= 0) {
              return $this->removeFromCart($userId, $productId);
          }

          $sql = "UPDATE cart_items
                  SET quantity = :quantity
                  WHERE user_id = :user_id AND product_id = :product_id";
          return $this->query($sql, [
              ':quantity' => $quantity,
              ':user_id' => $userId,
              ':product_id' => $productId
          ]);
      }

      /**
       * Xóa sản phẩm khỏi giỏ hàng
       */
      public function removeFromCart($userId, $productId)
      {
          $sql = "DELETE FROM cart_items
                  WHERE user_id = :user_id AND product_id = :product_id";
          return $this->query($sql, [
              ':user_id' => $userId,
              ':product_id' => $productId
          ]);
      }

      /**
       * Xóa toàn bộ giỏ hàng của user
       */
      public function clearCart($userId)
      {
          $sql = "DELETE FROM cart_items WHERE user_id = :user_id";
          return $this->query($sql, [':user_id' => $userId]);
      }

      /**
       * Đếm số lượng items trong giỏ
       */
      public function getCartCount($userId)
      {
          $sql = "SELECT SUM(quantity) as total FROM cart_items WHERE user_id = :user_id";
          $result = $this->single($sql, [':user_id' => $userId]);
          return (int)($result['total'] ?? 0);
      }

      /**
       * Sync cart từ localStorage khi user login
       */
      public function syncFromLocalStorage($userId, $localCartItems)
      {
          foreach ($localCartItems as $item) {
              $productId = (int)$item['product_id'];
              $quantity = (int)($item['quantity'] ?? 1);

              if ($productId > 0 && $quantity > 0) {
                  $this->addToCart($userId, $productId, $quantity);
              }
          }
          return true;
      }
  }
