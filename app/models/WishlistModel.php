<?php
class WishlistModel extends DB {
    public function getByUserId($uid) {
        $sql = "SELECT
                    w.wishlist_id,
                    w.product_id,
                    p.title as product_name,
                    pi.image_url as image,
                    p.price,
                    p.old_price as original_price,
                    aop.author_name as author,
                    w.added_date as created_at
                FROM wishlist w
                LEFT JOIN product p ON p.product_id = w.product_id
                LEFT JOIN (
                    SELECT product_id, image_url
                    FROM product_image
                    GROUP BY product_id
                ) AS pi ON p.product_id = pi.product_id
                LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
                WHERE w.user_id = :uid
                GROUP BY w.wishlist_id
                ORDER BY w.added_date DESC";

        return $this->all($sql, ['uid'=>$uid]);
    }

    public function exists($uid,$pid){
        return (bool)$this->single("SELECT wishlist_id FROM wishlist WHERE user_id=:uid AND product_id=:pid", ['uid'=>$uid, 'pid'=>$pid]);
    }

    public function add($uid,$pid){
        if ($this->exists($uid,$pid)) return false;
        return $this->query("INSERT INTO wishlist (user_id, product_id) VALUES (:uid, :pid)", ['uid'=>$uid,'pid'=>$pid]);
    }

    public function remove($uid,$pid){
        return $this->query("DELETE FROM wishlist WHERE user_id=:uid AND product_id=:pid", ['uid'=>$uid,'pid'=>$pid]);
    }

    public function removeById($id,$uid){
        return $this->query("DELETE FROM wishlist WHERE wishlist_id=:id AND user_id=:uid", ['id'=>$id,'uid'=>$uid]);
    }

    // Lấy danh sách product_id trong wishlist của user
    public function getProductIds($uid) {
        $sql = "SELECT product_id FROM wishlist WHERE user_id = :uid";
        $result = $this->all($sql, ['uid' => $uid]);
        return array_column($result, 'product_id');
    }
}
