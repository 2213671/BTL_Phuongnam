<?php
require_once APP_ROOT . '/models/UserAddress.php';

class AddressController extends Controller {
    private $userAddressModel;

    public function __construct() {
        $this->userAddressModel = new UserAddress();
    }

    /**
     * Lấy danh sách địa chỉ của user (AJAX)
     */
    public function getAddresses() {
        header('Content-Type: application/json');

        // Kiểm tra đăng nhập - thử cả user_id và users_id
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập',
                'debug' => [
                    'session_keys' => array_keys($_SESSION),
                    'session_id' => session_id()
                ]
            ]);
            return;
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;
        $addresses = $this->userAddressModel->getAddressesByUserId($userId);

        echo json_encode([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    /**
     * Thêm địa chỉ mới (AJAX)
     */
    public function addAddress() {
        header('Content-Type: application/json');

        // Debug session
        error_log("Session data: " . print_r($_SESSION, true));
        error_log("User ID isset: " . (isset($_SESSION['user_id']) ? 'YES' : 'NO'));

        // Kiểm tra đăng nhập - thử cả user_id và users_id
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập',
                'debug' => [
                    'session_keys' => array_keys($_SESSION),
                    'session_id' => session_id()
                ]
            ]);
            return;
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;

        // Validate dữ liệu
        $recipientName = $_POST['recipient_name'] ?? '';
        $recipientPhone = $_POST['recipient_phone'] ?? '';
        $provinceName = $_POST['province_name'] ?? '';
        $wardName = $_POST['ward_name'] ?? '';
        $streetAddress = $_POST['street_address'] ?? '';
        $isDefault = isset($_POST['is_default']) ? (int)$_POST['is_default'] : 0;

        if (empty($recipientName) || empty($recipientPhone) || empty($provinceName) ||
            empty($wardName) || empty($streetAddress)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ thông tin'
            ]);
            return;
        }

        // Validate số điện thoại Việt Nam
        if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $recipientPhone)) {
            echo json_encode([
                'success' => false,
                'message' => 'Số điện thoại không hợp lệ'
            ]);
            return;
        }

        // Tạo địa chỉ đầy đủ
        $fullAddress = trim($streetAddress) . ', ' . trim($wardName) . ', ' . trim($provinceName);

        // Kiểm tra trùng lặp
        $duplicate = $this->userAddressModel->checkDuplicateAddress($userId, $recipientPhone, $fullAddress);
        if ($duplicate) {
            echo json_encode([
                'success' => false,
                'message' => 'Địa chỉ này đã tồn tại',
                'address_id' => $duplicate['address_id']
            ]);
            return;
        }

        // Thêm địa chỉ
        $data = [
            'user_id' => $userId,
            'recipient_name' => trim($recipientName),
            'recipient_phone' => trim($recipientPhone),
            'province_name' => trim($provinceName),
            'ward_name' => trim($wardName),
            'street_address' => trim($streetAddress),
            'full_address' => $fullAddress,
            'is_default' => $isDefault
        ];

        $addressId = $this->userAddressModel->addAddress($data);

        if ($addressId) {
            echo json_encode([
                'success' => true,
                'message' => 'Đã lưu địa chỉ thành công',
                'address_id' => $addressId,
                'address' => array_merge($data, ['address_id' => $addressId])
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi lưu địa chỉ'
            ]);
        }
    }

    /**
     * Cập nhật địa chỉ (AJAX)
     */
    public function updateAddress() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
            return;
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;
        $addressId = $_POST['address_id'] ?? 0;

        // Validate
        if (!$addressId) {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu address_id'
            ]);
            return;
        }

        // Kiểm tra quyền sở hữu
        $existingAddress = $this->userAddressModel->getAddressById($addressId, $userId);
        if (!$existingAddress) {
            echo json_encode([
                'success' => false,
                'message' => 'Địa chỉ không tồn tại hoặc không thuộc về bạn'
            ]);
            return;
        }

        // Lấy dữ liệu mới
        $recipientName = $_POST['recipient_name'] ?? '';
        $recipientPhone = $_POST['recipient_phone'] ?? '';
        $provinceName = $_POST['province_name'] ?? '';
        $wardName = $_POST['ward_name'] ?? '';
        $streetAddress = $_POST['street_address'] ?? '';
        $isDefault = isset($_POST['is_default']) ? (int)$_POST['is_default'] : 0;

        if (empty($recipientName) || empty($recipientPhone) || empty($provinceName) ||
            empty($wardName) || empty($streetAddress)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ thông tin'
            ]);
            return;
        }

        $fullAddress = trim($streetAddress) . ', ' . trim($wardName) . ', ' . trim($provinceName);

        // Cập nhật
        $data = [
            'recipient_name' => trim($recipientName),
            'recipient_phone' => trim($recipientPhone),
            'province_name' => trim($provinceName),
            'ward_name' => trim($wardName),
            'street_address' => trim($streetAddress),
            'full_address' => $fullAddress,
            'is_default' => $isDefault
        ];

        $success = $this->userAddressModel->updateAddress($addressId, $userId, $data);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Đã cập nhật địa chỉ'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi cập nhật địa chỉ'
            ]);
        }
    }

    /**
     * Xóa địa chỉ (AJAX)
     */
    public function deleteAddress() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
            return;
        }

        $userId = $_SESSION['user_id'];
        $addressId = $_POST['address_id'] ?? 0;

        if (!$addressId) {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu address_id'
            ]);
            return;
        }

        $success = $this->userAddressModel->deleteAddress($addressId, $userId);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Đã xóa địa chỉ'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi xóa địa chỉ'
            ]);
        }
    }

    /**
     * Set địa chỉ làm mặc định (AJAX)
     */
    public function setDefaultAddress() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
            return;
        }

        $userId = $_SESSION['user_id'];
        $addressId = $_POST['address_id'] ?? 0;

        if (!$addressId) {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu address_id'
            ]);
            return;
        }

        $success = $this->userAddressModel->setDefaultAddress($addressId, $userId);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Đã đặt làm địa chỉ mặc định'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi đặt địa chỉ mặc định'
            ]);
        }
    }
}
