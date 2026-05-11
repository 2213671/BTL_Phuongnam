<?php

class ProductReviewModel extends DB {

    public function getReviewsForProduct(int $productId): array {
        $sql = 'SELECT pr.*, u.fullname, u.avatar AS user_avatar
                FROM productreview pr
                INNER JOIN users u ON u.user_id = pr.customer_id
                WHERE pr.product_id = :pid
                ORDER BY pr.review_date DESC, pr.review_id DESC';
        return $this->all($sql, ['pid' => $productId]);
    }

    public function getAverageRating(int $productId): ?float {
        $row = $this->single(
            'SELECT AVG(rating) AS a FROM productreview WHERE product_id = :p AND rating IS NOT NULL',
            ['p' => $productId]
        );
        if (!$row || $row['a'] === null) {
            return null;
        }
        return round((float) $row['a'], 1);
    }

    public function upsertReview(int $productId, int $customerId, int $rating, ?string $text): bool {
        $text = trim((string) $text);
        $sql = 'INSERT INTO productreview (product_id, customer_id, rating, review_text, review_date)
                VALUES (:pid, :cid, :r, :t, NOW())
                ON DUPLICATE KEY UPDATE rating = VALUES(rating), review_text = VALUES(review_text), review_date = NOW()';
        return (bool) $this->query($sql, [
            'pid' => $productId,
            'cid' => $customerId,
            'r' => $rating,
            't' => $text !== '' ? $text : null,
        ]);
    }

    public function deleteReview(int $reviewId): bool {
        return (bool) $this->query('DELETE FROM productreview WHERE review_id = :id', ['id' => $reviewId]);
    }

    public function getPaginatedReviewsForAdmin(int $page = 1, int $perPage = 15): array {
        $total = (int) (($this->single('SELECT COUNT(*) AS total FROM productreview')['total'] ?? 0));
        $perPage = max(1, min(100, $perPage));
        $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 0;
        $safePage = $totalPages > 0 ? max(1, min($page, $totalPages)) : 1;
        $offset = ($safePage - 1) * $perPage;

        $sql = 'SELECT pr.*, p.title AS product_title, u.fullname AS customer_name, u.email AS customer_email
                FROM productreview pr
                LEFT JOIN product p ON p.product_id = pr.product_id
                LEFT JOIN users u ON u.user_id = pr.customer_id
                ORDER BY pr.review_id DESC
                LIMIT :limit OFFSET :offset';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'page' => $safePage,
            'per_page' => $perPage,
        ];
    }
}
