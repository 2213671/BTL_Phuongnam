<?php
/**
 * ROUTER - File định tuyến chính
 * Nhiệm vụ: Kết nối các core class và khởi tạo ứng dụng
 * Không chứa logic nghiệp vụ, chỉ làm cầu nối
 */
// Bước 1: Load cấu hình
require_once __DIR__ . "/config/config.php";

// Bước 2: Load các core class
require_once __DIR__ . "/core/App.php";
require_once __DIR__ . "/core/Controller.php";
require_once __DIR__ . "/core/DB.php";

// Không cần code gì thêm - router chỉ làm nhiệm vụ kết nối!
