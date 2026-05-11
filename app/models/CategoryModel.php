<?php

class CategoryModel extends DB
{
  public function getAllCategories()
  {
    $sql = "SELECT * FROM category";
    $result = $this->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getCategoryById($id)
  {
    $sql = "SELECT * FROM category WHERE category_id = :id";
    $result = $this->query($sql, [':id' => $id]);
    return $result->fetch(PDO::FETCH_ASSOC);
  }
}
