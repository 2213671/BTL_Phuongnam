<?php
class User extends DB {

    public function findUserByEmailOrPhone($emailOrPhone) {
        $sql = "SELECT * FROM users WHERE email = :email OR phone = :phone LIMIT 1";

        return $this->single($sql, [
            'email' => $emailOrPhone,
            'phone' => $emailOrPhone
        ]);
    }

    /**
     * Tạo tài khoản mới (Dùng cho chức năng Đăng ký)
     */
    public function create($data) {
        // $data: fullname, email_or_phone, password
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $raw = trim($data['email_or_phone']);
        $email = null;
        $phone = null;

        if (strpos($raw, '@') !== false) {
            $email = $raw;
        } else {
            $phone = preg_replace('/\D+/', '', $raw);
            if (str_starts_with($phone, '84') && strlen($phone) >= 10) {
                $phone = '0' . substr($phone, 2);
            }
            // Cột email NOT NULL → email nội bộ khi chỉ có SĐT
            $email = 'u' . ($phone !== '' ? $phone : uniqid('', true)) . '@phone.customer.local';
        }

        $userId = $this->nextUsersPrimaryKey();
        $sql = "INSERT INTO users (user_id, fullname, email, phone, password, role, created_date)
                VALUES (:user_id, :fullname, :email, :phone, :password, :role, CURDATE())";

        return $this->query($sql, [
            'user_id'  => $userId,
            'fullname' => $data['fullname'],
            'email'    => $email,
            'phone'    => $phone,
            'password' => $passwordHash,
            'role'     => 'customer',
        ]);
    }
    // tìm user theo email (trả về assoc hoặc false)
public function findByEmail(string $email)
{
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    return $this->single($sql, ['email' => $email]);
}

// tạo token reset (dùng token dạng chuỗi)
public function createPasswordResetToken(int $userId, string $token, string $expiresAt)
{
    $sql = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (:uid, :token, :exp)";
    return $this->query($sql, [
        'uid' => $userId,
        'token' => $token,
        'exp' => $expiresAt
    ]);
}

// tìm record reset theo token (nối với users)
public function findResetByToken(string $token)
{
    $sql = "SELECT pr.*, u.email, u.id as user_id FROM password_resets pr
            JOIN users u ON pr.user_id = u.id
            WHERE pr.token = :token AND pr.used = 0 AND pr.expires_at > NOW()
            LIMIT 1";
    return $this->single($sql, ['token' => $token]);
}

// đánh dấu token là đã dùng
public function useResetToken(string $token)
{
    $sql = "UPDATE password_resets SET used = 1 WHERE token = :token";
    return $this->query($sql, ['token' => $token]);
}

// cập nhật mật khẩu user bằng user_id
public function updatePassword(int $userId, string $newPassword)
{
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = :pw WHERE id = :id";
    return $this->query($sql, [
        'pw' => $hash,
        'id' => $userId
    ]);
}
    public function getById($id) {
    $sql = "SELECT user_id AS id, username, fullname, email, phone, avatar, gender, birthday, address, created_at
            FROM users
            WHERE user_id = :id
            LIMIT 1";
    return $this->single($sql, ['id' => $id]);
}

    public function updateProfile($id, $data) {
        $sql = "UPDATE users SET fullname=:fullname, phone=:phone, email=:email, gender=:gender, birthday=:birthday, address=:address WHERE id=:id";
        $data['id'] = $id;
        return $this->query($sql, $data);
    }
}
