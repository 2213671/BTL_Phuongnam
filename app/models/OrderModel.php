<?php
class OrderModel extends DB {
    public function getByUserId($uid) {
        return $this->all("SELECT * FROM orders WHERE user_id=:uid ORDER BY created_at DESC", ['uid'=>$uid]);
    }
    public function getItems($orderId) {
        return $this->all("SELECT * FROM order_items WHERE order_id=:oid", ['oid'=>$orderId]);
    }
}
