<?php
class UserAddress {
    private $db;

    public function __construct() {
        $dbInstance = new DB();
        $this->db = $dbInstance->con;
    }

    /**
     * Lấy tất cả địa chỉ của một user
     */
    public function getAddressesByUserId($userId) {
        $query = "SELECT * FROM user_addresses
                  WHERE user_id = :user_id
                  ORDER BY is_default DESC, created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy địa chỉ mặc định của user
     */
    public function getDefaultAddress($userId) {
        $query = "SELECT * FROM user_addresses
                  WHERE user_id = :user_id AND is_default = 1
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy một địa chỉ theo ID
     */
    public function getAddressById($addressId, $userId) {
        $query = "SELECT * FROM user_addresses
                  WHERE address_id = :address_id AND user_id = :user_id
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':address_id', $addressId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm địa chỉ mới
     */
    public function addAddress($data) {
        // Nếu set làm mặc định, bỏ mặc định của các địa chỉ khác
        if (!empty($data['is_default'])) {
            $this->unsetDefaultAddress($data['user_id']);
        }

        $query = "INSERT INTO user_addresses
                  (user_id, recipient_name, recipient_phone, province_name, ward_name,
                   street_address, full_address, is_default)
                  VALUES
                  (:user_id, :recipient_name, :recipient_phone, :province_name, :ward_name,
                   :street_address, :full_address, :is_default)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':recipient_name', $data['recipient_name'], PDO::PARAM_STR);
        $stmt->bindParam(':recipient_phone', $data['recipient_phone'], PDO::PARAM_STR);
        $stmt->bindParam(':province_name', $data['province_name'], PDO::PARAM_STR);
        $stmt->bindParam(':ward_name', $data['ward_name'], PDO::PARAM_STR);
        $stmt->bindParam(':street_address', $data['street_address'], PDO::PARAM_STR);
        $stmt->bindParam(':full_address', $data['full_address'], PDO::PARAM_STR);

        $isDefault = !empty($data['is_default']) ? 1 : 0;
        $stmt->bindParam(':is_default', $isDefault, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Cập nhật địa chỉ
     */
    public function updateAddress($addressId, $userId, $data) {
        // Nếu set làm mặc định, bỏ mặc định của các địa chỉ khác
        if (!empty($data['is_default'])) {
            $this->unsetDefaultAddress($userId);
        }

        $query = "UPDATE user_addresses
                  SET recipient_name = :recipient_name,
                      recipient_phone = :recipient_phone,
                      province_name = :province_name,
                      ward_name = :ward_name,
                      street_address = :street_address,
                      full_address = :full_address,
                      is_default = :is_default
                  WHERE address_id = :address_id AND user_id = :user_id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':address_id', $addressId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':recipient_name', $data['recipient_name'], PDO::PARAM_STR);
        $stmt->bindParam(':recipient_phone', $data['recipient_phone'], PDO::PARAM_STR);
        $stmt->bindParam(':province_name', $data['province_name'], PDO::PARAM_STR);
        $stmt->bindParam(':ward_name', $data['ward_name'], PDO::PARAM_STR);
        $stmt->bindParam(':street_address', $data['street_address'], PDO::PARAM_STR);
        $stmt->bindParam(':full_address', $data['full_address'], PDO::PARAM_STR);

        $isDefault = !empty($data['is_default']) ? 1 : 0;
        $stmt->bindParam(':is_default', $isDefault, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Xóa địa chỉ
     */
    public function deleteAddress($addressId, $userId) {
        $query = "DELETE FROM user_addresses
                  WHERE address_id = :address_id AND user_id = :user_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':address_id', $addressId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Set địa chỉ làm mặc định
     */
    public function setDefaultAddress($addressId, $userId) {
        // Bỏ mặc định của tất cả địa chỉ khác
        $this->unsetDefaultAddress($userId);

        // Set địa chỉ này làm mặc định
        $query = "UPDATE user_addresses
                  SET is_default = 1
                  WHERE address_id = :address_id AND user_id = :user_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':address_id', $addressId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Bỏ mặc định tất cả địa chỉ của user
     */
    private function unsetDefaultAddress($userId) {
        $query = "UPDATE user_addresses
                  SET is_default = 0
                  WHERE user_id = :user_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Kiểm tra xem địa chỉ đã tồn tại chưa (dựa trên SĐT và địa chỉ đầy đủ)
     */
    public function checkDuplicateAddress($userId, $recipientPhone, $fullAddress, $excludeAddressId = null) {
        $query = "SELECT address_id FROM user_addresses
                  WHERE user_id = :user_id
                  AND recipient_phone = :recipient_phone
                  AND full_address = :full_address";

        if ($excludeAddressId) {
            $query .= " AND address_id != :exclude_address_id";
        }

        $query .= " LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':recipient_phone', $recipientPhone, PDO::PARAM_STR);
        $stmt->bindParam(':full_address', $fullAddress, PDO::PARAM_STR);

        if ($excludeAddressId) {
            $stmt->bindParam(':exclude_address_id', $excludeAddressId, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
