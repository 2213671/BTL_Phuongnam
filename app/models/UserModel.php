<?php
/**
 * UserModel - Quản lý thông tin người dùng
 */
class UserModel extends DB {

    /**
     * Lấy thông tin user theo ID
     */
    public function getById($userId) {
        $sql = "SELECT user_id, fullname, email, phone, avatar, role, account_status, note, created_date
                FROM users
                WHERE user_id = :user_id
                LIMIT 1";
        return $this->single($sql, ['user_id' => $userId]);
    }

    /**
     * Lấy thông tin user theo email
     */
    public function getByEmail($email) {
        $sql = "SELECT user_id, fullname, email, phone, avatar, role, account_status, note, created_date
                FROM users
                WHERE email = :email
                LIMIT 1";
        return $this->single($sql, ['email' => $email]);
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function updateProfile($userId, $data) {
        $sql = "UPDATE users
                SET fullname = :fullname,
                    email = :email,
                    phone = :phone
                WHERE user_id = :user_id";

        return $this->query($sql, [
            'user_id' => $userId,
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ]);
    }

    /**
     * Kiểm tra email đã tồn tại chưa (trừ user hiện tại)
     */
    public function isEmailExists($email, $excludeUserId = null) {
        $sql = "SELECT user_id FROM users WHERE email = :email";

        if ($excludeUserId) {
            $sql .= " AND user_id != :exclude_id";
            $result = $this->single($sql, [
                'email' => $email,
                'exclude_id' => $excludeUserId
            ]);
        } else {
            $result = $this->single($sql, ['email' => $email]);
        }

        return $result !== false;
    }

    /**
     * Kiểm tra phone đã tồn tại chưa (trừ user hiện tại)
     */
    public function isPhoneExists($phone, $excludeUserId = null) {
        if (empty($phone)) return false;

        $sql = "SELECT user_id FROM users WHERE phone = :phone";

        if ($excludeUserId) {
            $sql .= " AND user_id != :exclude_id";
            $result = $this->single($sql, [
                'phone' => $phone,
                'exclude_id' => $excludeUserId
            ]);
        } else {
            $result = $this->single($sql, ['phone' => $phone]);
        }

        return $result !== false;
    }

    /**
     * Lấy tất cả users (cho admin)
     */
    public function getAllUsers() {
        $sql = "SELECT user_id, fullname, email, phone, role, created_date
                FROM users
                ORDER BY created_date DESC";
        return $this->all($sql);
    }

    /**
     * Tạo user mới
     */
    public function createUser($data) {
        $userId = $this->nextUsersPrimaryKey();
        $sql = "INSERT INTO users (user_id, fullname, email, phone, password, role, created_date)
                VALUES (:user_id, :fullname, :email, :phone, :password, :role, NOW())";

        return $this->query($sql, [
            'user_id' => $userId,
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => strtolower((string) ($data['role'] ?? 'customer')),
        ]);
    }

    /**
     * Cập nhật mật khẩu
     */
    public function updatePassword($userId, $newPassword) {
        $sql = "UPDATE users
                SET password = :password
                WHERE user_id = :user_id";

        return $this->query($sql, [
            'user_id' => $userId,
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }

    public function verifyPassword($userId, string $plainPassword): bool {
        $row = $this->single(
            "SELECT password FROM users WHERE user_id = :id LIMIT 1",
            ['id' => $userId]
        );
        return $row && password_verify($plainPassword, $row['password']);
    }

    public function updateAvatar($userId, ?string $relativePath) {
        $sql = "UPDATE users SET avatar = :avatar WHERE user_id = :user_id";
        return $this->query($sql, [
            'user_id' => $userId,
            'avatar' => $relativePath
        ]);
    }

    /**
     * Xóa user
     */
    public function deleteUser($userId) {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        return $this->query($sql, ['user_id' => $userId]);
    }

    /**
     * Đảm bảo có dòng trong `customer` cho FK (đánh giá sản phẩm, thanh toán…).
     */
    public function ensureCustomerMembership(int $userId): bool {
        if ($userId <= 0) {
            return false;
        }
        $sql = 'INSERT IGNORE INTO customer (user_id, member_type, total_fpoint) VALUES (:uid, \'Member\', 0)';
        return (bool) $this->query($sql, ['uid' => $userId]);
    }
}
