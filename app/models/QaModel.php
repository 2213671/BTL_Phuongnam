<?php

class QaModel extends DB
{
  /**
   * Gets all questions that have been answered.
   * For public display.
   */
  public function getAnsweredQuestions()
  {
    $sql = "SELECT * FROM qa WHERE status = 'answered' ORDER BY created_at DESC";
    $result = $this->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Allows a user to submit a new question.
   */
  public function createQuestion($question, $userId, $category = null)
  {
    $sql = "INSERT INTO qa (question, user_id, category, answer, status) VALUES (:question, :user_id, :category, '', 'pending')";
    $params = [
      ':question' => $question,
      ':user_id' => $userId,
      ':category' => $category
    ];
    return $this->query($sql, $params);
  }

  // --- Admin Methods ---

  /**
   * Gets all questions, answered or pending.
   * For the admin panel.
   */
  public function getAllQuestionsForAdmin()
  {
    $sql = "SELECT q.*, u.username 
            FROM qa q 
            LEFT JOIN users u ON q.user_id = u.user_id 
            ORDER BY q.status ASC, q.created_at DESC";
    $result = $this->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Allows an admin to answer a pending question.
   */
  public function answerQuestion($id, $answer)
  {
    $sql = "UPDATE qa SET answer = :answer, status = 'answered' WHERE id = :id";
    $params = [
      ':id' => $id,
      ':answer' => $answer
    ];
    return $this->query($sql, $params);
  }

  /**
   * Allows an admin to delete a question.
   */
  public function deleteQuestion($id)
  {
    $sql = "DELETE FROM qa WHERE id = :id";
    return $this->query($sql, [':id' => $id]);
  }
}
