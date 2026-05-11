<?php
class NotificationModel extends DB {
    public function getByUserId($uid) {
        return $this->all("SELECT id, type, title, content, is_read, created_at FROM notifications WHERE user_id = :uid ORDER BY created_at DESC", ['uid'=>$uid]);
    }
    public function markRead($id, $uid) {
        return $this->query("UPDATE notifications SET is_read=1 WHERE id=:id AND user_id=:uid", ['id'=>$id,'uid'=>$uid]);
    }
    public function markAllRead($uid) {
        return $this->query("UPDATE notifications SET is_read=1 WHERE user_id=:uid", ['uid'=>$uid]);
    }
}
