<?php

class CommentModel extends DB
{
  public function getCommentsByNewsId($newsId)
  {
    // Lấy tất cả comments và thông tin user
    $sql = "SELECT c.*, u.fullname, u.email, u.role, u.avatar AS user_avatar
            FROM comments c 
            JOIN users u ON c.user_id = u.user_id 
            WHERE c.news_id = :news_id 
            ORDER BY c.created_at ASC";
    $result = $this->query($sql, [':news_id' => $newsId]);
    $comments = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Sắp xếp comments theo cấu trúc cây (parent-child)
    return $this->buildCommentTree($comments);
  }

  public function addComment($newsId, $userId, $content, $parentId = null)
  {
    $sql = "INSERT INTO comments (news_id, user_id, content, parent_id) 
            VALUES (:news_id, :user_id, :content, :parent_id)";
    $params = [
      ':news_id' => $newsId,
      ':user_id' => $userId,
      ':content' => $content,
      ':parent_id' => $parentId
    ];
    return $this->query($sql, $params);
  }

  public function deleteComment($commentId, $userId = null, $isAdmin = false)
  {
    if ($isAdmin) {
      $sql = "DELETE FROM comments WHERE id = :id";
      return $this->query($sql, [':id' => $commentId]);
    } else {
      $sql = "DELETE FROM comments WHERE id = :id AND user_id = :user_id";
      return $this->query($sql, [':id' => $commentId, ':user_id' => $userId]);
    }
  }

  public function getLatestComment($newsId, $userId)
  {
    $sql = "SELECT c.*, u.fullname, u.email, u.role, u.avatar AS user_avatar
            FROM comments c 
            JOIN users u ON c.user_id = u.user_id 
            WHERE c.news_id = :news_id AND c.user_id = :user_id 
            ORDER BY c.created_at DESC 
            LIMIT 1";
    $result = $this->query($sql, [':news_id' => $newsId, ':user_id' => $userId]);
    return $result->fetch(PDO::FETCH_ASSOC);
  }

  public function countCommentsByNewsId($newsId)
  {
    $sql = "SELECT COUNT(*) as total FROM comments WHERE news_id = :news_id";
    $result = $this->query($sql, [':news_id' => $newsId]);
    return $result->fetch(PDO::FETCH_ASSOC)['total'];
  }

  /**
   * Xây dựng cây comment (hỗ trợ trả lời bình luận)
   */
  private function buildCommentTree($comments, $parentId = null)
  {
    $tree = [];
    foreach ($comments as $comment) {
      if ($comment['parent_id'] == $parentId) {
        $children = $this->buildCommentTree($comments, $comment['id']);
        if ($children) {
          $comment['replies'] = $children;
        }
        $tree[] = $comment;
      }
    }
    return $tree;
  }
}