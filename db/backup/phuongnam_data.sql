-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 07, 2025 at 01:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ĐÃ ĐỔI: phuongnam_db -> phuongnam_db
CREATE DATABASE IF NOT EXISTS phuongnam_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE phuongnam_db;

SET FOREIGN_KEY_CHECKS = 0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phuongnam_db`
--

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `author_of_product`
--

CREATE TABLE `author_of_product` (
  `product_id` int(11) NOT NULL,
  `author_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `author_of_product`
--

INSERT INTO `author_of_product` (`product_id`, `author_name`) VALUES
(1, 'Dale Carnegie'),
(2, 'Paulo Coelho'),
(3, 'Robin Sharma'),
(4, 'Robin Sharma'),
(5, 'Daniel Kahneman'),
(6, 'Carol Dweck'),
(7, 'Minh Niệm'),
(8, 'Kishimi Ichiro & Koga Fumitake'),
(9, 'Monty Don'),
(10, 'Trần Quốc Vượng - Nguyễn Thị Bảy'),
(11, 'Will Durant'),
(12, 'Nhóm tác giả');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `cart_items`
--

CREATE TABLE `cart_items` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`user_id`, `product_id`, `quantity`, `added_date`) VALUES
(101, 1, 2, '2025-12-06 15:30:38'),
(101, 2, 1, '2025-12-06 15:30:55'),
(103, 2, 2, '2025-12-06 15:33:20'),
(111, 2, 1, '2025-12-07 19:04:47'),
(111, 3, 1, '2025-12-07 19:05:52'),
(111, 9, 1, '2025-12-07 19:01:43'),
(111, 11, 1, '2025-12-07 19:05:15');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `description`) VALUES
(1, 'Sách Trong Nước', NULL),
(2, 'Văn Học', NULL),
(3, 'Kinh Tế', NULL),
(4, 'Văn Phòng Phẩm', NULL),
(5, 'Truyện Tranh', NULL),
(6, 'Sách Thiếu nhi', ''),
(7, 'Tâm Lý Học', '');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `category_product`
--

CREATE TABLE `category_product` (
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`category_id`, `product_id`) VALUES
(1, 9),
(1, 10),
(2, 1),
(2, 2),
(2, 5),
(2, 6),
(2, 7),
(3, 3),
(3, 4),
(7, 11);

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'Để trả lời bình luận khác',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(20) DEFAULT 'New',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Nguyễn Văn A', 'a@example.com', 'Về vấn đề giao hàng', 'Sản phẩm giao đến bị trễ 2 ngày so với dự kiến.', 'New', '2025-12-02 15:52:40'),
(2, 'Trần Thị B', 'b@example.com', 'Hỏi về sách mới', 'Tôi có thể tìm sách X ở đâu?', 'New', '2025-12-02 15:52:40');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `customer`
--

CREATE TABLE `customer` (
  `user_id` int(11) NOT NULL,
  `member_type` varchar(50) DEFAULT NULL,
  `total_fpoint` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`user_id`, `member_type`, `total_fpoint`) VALUES
(101, 'Gold', 1500),
(102, 'Silver', 500),
(103, 'Diamond', 3500),
(104, 'Silver', 200),
(105, 'Gold', 1000);

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `author_id` int(11) NOT NULL COMMENT 'ID của admin viết bài',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL COMMENT 'ID đơn hàng',
  `user_id` int(11) NOT NULL COMMENT 'ID người dùng đặt hàng',
  `recipient_name` varchar(255) NOT NULL COMMENT 'Tên người nhận',
  `recipient_phone` varchar(20) NOT NULL COMMENT 'Số điện thoại người nhận',
  `shipping_address` text NOT NULL COMMENT 'Địa chỉ giao hàng đầy đủ',
  `payment_method` varchar(50) DEFAULT 'COD' COMMENT 'Phương thức thanh toán: COD, E-wallet, Credit Card',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Tạm tính (chưa có phí ship)',
  `shipping_fee` decimal(10,2) DEFAULT 30000.00 COMMENT 'Phí vận chuyển',
  `total_amount` decimal(10,2) NOT NULL COMMENT 'Tổng tiền = subtotal + shipping_fee',
  `status` enum('pending','processing','shipped','completed','cancelled') DEFAULT 'pending' COMMENT 'Trạng thái đơn hàng',
  `note` text DEFAULT NULL COMMENT 'Ghi chú của khách hàng',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo đơn',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng lưu thông tin đơn hàng';

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `recipient_name`, `recipient_phone`, `shipping_address`, `payment_method`, `subtotal`, `shipping_fee`, `total_amount`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 111, 'đạt', '0919566866', 'ko biết nữa, Phường Mường Lay, Điện Biên', 'COD', 85000.00, 30000.00, 115000.00, 'completed', '', '2025-12-07 08:10:35', '2025-12-07 08:19:29'),
(2, 111, 'bình', '0919566866', 'ko biết nữa, Phường Tân Giang, Cao Bằng', 'Credit Card', 92000.00, 30000.00, 122000.00, 'cancelled', '', '2025-12-07 08:27:45', '2025-12-07 11:55:04'),
(3, 111, 'đạt', '0919566866', 'ko biết nữa, Phường Mường Lay, Điện Biên', 'E-wallet', 468000.00, 30000.00, 498000.00, 'processing', '', '2025-12-07 09:07:45', '2025-12-07 09:12:00'),
(4, 111, 'đạt', '0919566866', 'ko biết nữa, Phường Mường Lay, Điện Biên', 'COD', 999000.00, 30000.00, 1029000.00, 'pending', '', '2025-12-07 11:48:36', '2025-12-07 11:48:36');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `order_product`
--

CREATE TABLE `order_product` (
  `order_id` int(11) NOT NULL COMMENT 'ID đơn hàng',
  `product_id` int(11) NOT NULL COMMENT 'ID sản phẩm',
  `quantity` int(11) NOT NULL DEFAULT 1 COMMENT 'Số lượng',
  `price` decimal(10,2) NOT NULL COMMENT 'Giá tại thời điểm đặt hàng',
  `subtotal` decimal(10,2) NOT NULL COMMENT 'Thành tiền = price * quantity'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng lưu chi tiết sản phẩm trong đơn hàng';

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 1, 85000.00, 85000.00),
(2, 6, 1, 92000.00, 92000.00),
(3, 9, 1, 468000.00, 468000.00),
(4, 2, 2, 75000.00, 150000.00),
(4, 6, 1, 92000.00, 92000.00),
(4, 9, 1, 468000.00, 468000.00),
(4, 11, 1, 289000.00, 289000.00);

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `order_voucher`
--

CREATE TABLE `order_voucher` (
  `order_id` int(11) NOT NULL,
  `voucher_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_voucher`
--

INSERT INTO `order_voucher` (`order_id`, `voucher_code`) VALUES
(1, 'FREE_SHIP'),
(5, 'VIP_20');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ĐÃ SỬA: nội dung pages (bỏ chữ Phương Nam)
--

INSERT INTO `pages` (`id`, `page_name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'about', 'Đây là nội dung trang giới thiệu về Nhà sách Phương Nam.', '2025-12-02 15:53:28', '2025-12-02 15:53:28'),
(2, 'terms', 'Các điều khoản sử dụng của website.', '2025-12-02 15:53:28', '2025-12-02 15:53:28');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `payment_method`, `created_date`) VALUES
(1, 101, 'Credit Card', '2024-11-10'),
(2, 102, 'COD', '2024-11-11'),
(3, 103, 'E-Wallet', '2024-11-12'),
(4, 104, 'Credit Card', '2024-11-13'),
(5, 105, 'COD', '2024-11-14');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `product` (cấu trúc giữ nguyên, data giữ nguyên)
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `publisher` varchar(100) DEFAULT NULL,
  `published_date` date DEFAULT NULL COMMENT 'Date the product was published.',
  `supplier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL COMMENT 'Number of pages in the product.',
  `product_type` varchar(50) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `old_price` decimal(12,2) DEFAULT NULL COMMENT 'The original price before discount. NULL if not on sale.',
  `weight` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(50) DEFAULT NULL COMMENT 'Physical dimensions of the product (e.g., 13 x 20.5 cm).',
  `size` varchar(255) DEFAULT NULL
) ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `title`, `publisher`, `published_date`, `supplier`, `description`, `year`, `language`, `pages`, `product_type`, `stock_quantity`, `price`, `old_price`, `weight`, `dimensions`, `size`) VALUES
(1, 'Đắc Nhân Tâm - Tác phẩm kinh điển về nghệ thuật thu phục và ảnh hưởng người khác', 'NXB Tổng hợp TP.HCM', '2020-06-15', NULL, 'Đắc Nhân Tâm là quyển sách duy nhất về thể loại self-help bán chạy nhất mọi thời đại. Cuốn sách đã và đang thay đổi cuộc sống của hàng triệu người trên thế giới.', NULL, NULL, 400, NULL, 100, 85000.00, 100000.00, NULL, '13 x 20.5 cm', NULL),
(2, 'Nhà Giả Kim - Phiên bản kỷ niệm 25 năm', 'NXB Trẻ', '2019-08-10', NULL, 'Một câu chuyện cổ tích dành cho người lớn, một câu chuyện cổ tích về việc theo đuổi giấc mơ và tìm kiếm ý nghĩa cuộc sống.', NULL, NULL, 162, NULL, 100, 75000.00, 90000.00, NULL, '11 x 18 cm', NULL),
(3, 'Nhà Lãnh Đạo Không Chức Danh', 'NXB Lao Động', '2021-03-05', NULL, 'Cuốn sách truyền cảm hứng cho độc giả rằng ai cũng có thể trở thành một nhà lãnh đạo, không phải bởi chức vụ mà bởi hành động.', NULL, NULL, 224, NULL, 100, 95000.00, 110000.00, NULL, '14 x 20.5 cm', NULL),
(4, 'Đời Ngắn Đừng Ngủ Dài', 'NXB Tổng hợp TP.HCM', '2020-11-20', NULL, 'Cuốn sách giúp bạn khám phá cách thức để thức dậy mỗi ngày với sự hăng hái, hiệu suất và cảm giác tuyệt vời.', NULL, NULL, 208, NULL, 100, 88000.00, 105000.00, NULL, '13 x 20.5 cm', NULL),
(5, 'Tư Duy Nhanh và Tư Duy Chậm', 'NXB Chính Trị Quốc Gia', '2018-07-15', NULL, 'Cuốn sách khám phá hai hệ thống tư duy chi phối cách chúng ta suy nghĩ: hệ thống nhanh và hệ thống chậm.', NULL, NULL, 499, NULL, 100, 120000.00, 140000.00, NULL, '14 x 21 cm', NULL),
(6, 'Tư Duy Tích Cực', 'NXB Trẻ', '2020-05-12', NULL, 'Cuốn sách giải thích cách tư duy ảnh hưởng đến thành công và cách phát triển tư duy tăng trưởng.', NULL, NULL, 320, NULL, 100, 92000.00, 110000.00, NULL, '14 x 21 cm', NULL),
(7, 'Hiểu Về Trái Tim', 'NXB Tổng hợp TP.HCM', '2019-11-30', NULL, 'Cuốn sách giúp người đọc hiểu rõ hơn về bản thân và cảm xúc của mình, từ đó sống an nhiên và hạnh phúc hơn.', NULL, NULL, 280, NULL, 100, 75000.00, 90000.00, NULL, '13 x 20 cm', NULL),
(9, 'Gardening at Longmeadow', 'DK Publishing', '2021-02-08', NULL, 'Cuốn sách hướng dẫn chăm sóc vườn tược với nhiều mẹo hay và kinh nghiệm từ chuyên gia.', NULL, NULL, 352, NULL, 100, 468000.00, 585000.00, NULL, '21 x 25 cm', NULL),
(10, 'Văn Hóa Ẩm Thực Việt Nam', 'NXB Văn Hóa', '2019-06-20', '', 'Khám phá văn hóa ẩm thực đặc sắc của Việt Nam qua từng vùng miền.', 0, '', 208, '', 100, 35000.00, 45000.00, 0.00, '16 x 24 cm', ''),
(11, 'Câu Chuyện Triết Học', 'NXB Thế Giới', '2020-04-10', '', 'Cuốn sách kinh điển giúp bạn nắm trọn tinh hoa triết học phương Tây qua những câu chuyện súc tích, dễ hiểu và đầy cảm hứng', 1900, '', 736, '', 100, 289000.00, 450000.00, 0.00, '15 x 23 cm', '');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `productreview`
--

CREATE TABLE `productreview` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `review_date` datetime DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productreview`
--

INSERT INTO `productreview` (`review_id`, `product_id`, `customer_id`, `rating`, `review_text`, `review_date`, `image_url`) VALUES
(1, 1, 101, 5, 'Sách hay, giao hàng nhanh.', '2024-11-12 15:00:00', NULL),
(1, 2, 102, 5, 'Bản dịch tuyệt vời.', '2024-11-13 10:00:00', NULL),
(1, 3, 103, 5, 'Nội dung khoa học, đóng gói chắc chắn.', '2024-11-14 09:00:00', NULL),
(2, 3, 105, 5, 'Mua tặng sếp, sếp rất thích.', '2024-11-15 08:00:00', NULL),
(2, 5, 101, 4, 'Truyện đẹp, đóng gói cẩn thận.', '2024-11-12 16:30:00', NULL);

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `product_image`
--

CREATE TABLE `product_image` (
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `ordinal_number` int(11) DEFAULT NULL,
  `upload_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`product_id`, `image_url`, `ordinal_number`, `upload_date`) VALUES
(1, 'media/products/dac-nhan-tam.jpg', NULL, NULL),
(2, 'media/products/nha-gia-kim.jpg', NULL, NULL),
(3, 'media/products/nha-lanh-dao-khong-chuc-danh.jpg', NULL, NULL),
(4, 'media/products/doi-ngan-dung-ngu-dai.jpg', NULL, NULL),
(5, 'media/products/tu-duy-nhanh-va-cham.jpg', NULL, NULL),
(6, 'media/products/tu-duy-tich-cuc.jpg', NULL, NULL),
(7, 'media/products/hieu-ve-trai-tim.jpg', NULL, NULL),
(9, 'media/products/gardening-at-longmeadow.jpg', NULL, NULL),
(10, 'media/products/van-hoa-am-thuc-viet-nam.jpg', NULL, NULL),
(11, 'media/products/cau-chuyen-triet-hoc.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `qa`
--

CREATE TABLE `qa` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'ID của người dùng đặt câu hỏi',
  `status` varchar(50) NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái: pending, answered',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ĐÃ SỬA: question và answer (bỏ chữ Phương Nam)
--

INSERT INTO `qa` (`id`, `question`, `answer`, `category`, `user_id`, `status`, `created_at`) VALUES
(1, 'Nhà sách hỗ trợ những phương thức thanh toán nào?', 'Chúng tôi chấp nhận thanh toán bằng Thẻ tín dụng, E-Wallet và COD (thanh toán khi nhận hàng).', 'Thanh toán', NULL, 'answered', '2025-12-02 15:50:37'),
(2, 'Làm thế nào để đổi trả sản phẩm?', 'Vui lòng liên hệ bộ phận hỗ trợ trong vòng 7 ngày kể từ ngày nhận hàng để được hướng dẫn chi tiết.', 'Đổi trả', NULL, 'answered', '2025-12-02 15:50:37');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ĐÃ SỬA: thông tin liên hệ (phone, email, address)
--

INSERT INTO `settings` (`id`, `key_name`, `value`) VALUES
(1, 'phone', '028 3832 3456'),
(2, 'email', 'contact@phuongnam.com.vn'),
(3, 'address', '123 Trần Hưng Đạo, Phường Cô Giang, Quận 1, TP. Hồ Chí Minh');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `staff`
--

CREATE TABLE `staff` (
  `user_id` int(11) NOT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `hired_date` date DEFAULT NULL,
  `salary` decimal(12,2) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`user_id`, `branch`, `hired_date`, `salary`, `is_admin`) VALUES
(106, 'Chi nhánh Q.1', '2022-10-01', 50000000.00, 1),
(107, 'Chi nhánh Q.1', '2023-05-15', 15000000.00, 0),
(108, 'Kho Thủ Đức', '2023-08-22', 12000000.00, 0),
(109, 'Trụ sở chính', '2024-02-14', 18000000.00, 0),
(110, 'Kho Thủ Đức', '2024-04-10', 11000000.00, 0);

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Customer',
  `note` text DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ĐÃ SỬA: email của admin và staff (domain @phuongnam.com.vn), fullname admin
--

INSERT INTO `users` (`user_id`, `password`, `fullname`, `email`, `phone`, `role`, `note`, `created_date`) VALUES
(101, '$2y$10$6t7Iv2l13qnBSZvd2efpSOyAqUZZ6zHuR/mUaJWRgyljDNbjbhfby', 'Nguyễn Văn A', 'nguyen.a@example.com', NULL, 'customer', NULL, '2023-01-15'),
(102, '$2y$10$mtHmt7DlmK4CxYr5ineCROaP6K2tqDttJm325JrtzY9Os0KdpGwMy', 'Trần Thị B', 'tran.b@example.com', NULL, 'customer', NULL, '2023-03-20'),
(103, '$2y$10$6t7Iv2l13qnBSZvd2efpSOyAqUZZ6zHuR/mUaJWRgyljDNbjbhfby', 'Lê Hoàng C', 'le.c@example.com', NULL, 'customer', NULL, '2024-01-10'),
(104, '$2y$10$mtHmt7DlmK4CxYr5ineCROaP6K2tqDttJm325JrtzY9Os0KdpGwMy', 'Phạm Minh D', 'pham.d@example.com', NULL, 'customer', NULL, '2024-05-01'),
(105, '$2y$10$6t7Iv2l13qnBSZvd2efpSOyAqUZZ6zHuR/mUaJWRgyljDNbjbhfby', 'Võ Thanh E', 'vo.e@example.com', NULL, 'customer', NULL, '2024-06-12'),
(106, '$2y$10$GrIswAeI.aLpfkqQ.x6C.ulNRqbN7knlCDtJV7yCZNToORt8.DoHe', 'Admin Phương Nam', 'admin@phuongnam.com.vn', NULL, 'admin', NULL, '2022-10-01'),
(107, '$2y$10$8I0BJABP4rEETVQ8GWLGYuRMWxkb6UEGhWBtFryh7y/xA9ZCfso3.', 'Hoàng Thị G', 'hoang.g@phuongnam.com.vn', NULL, 'staff', NULL, '2023-05-15'),
(108, '$2y$10$8I0BJABP4rEETVQ8GWLGYuRMWxkb6UEGhWBtFryh7y/xA9ZCfso3.', 'Bùi Xuân H', 'bui.h@phuongnam.com.vn', NULL, 'staff', NULL, '2023-08-22'),
(109, '$2y$10$8I0BJABP4rEETVQ8GWLGYuRMWxkb6UEGhWBtFryh7y/xA9ZCfso3.', 'Dương Văn I', 'duong.i@phuongnam.com.vn', NULL, 'staff', NULL, '2024-02-14'),
(110, '$2y$10$8I0BJABP4rEETVQ8GWLGYuRMWxkb6UEGhWBtFryh7y/xA9ZCfso3.', 'Mai Thị K', 'mai.k@phuongnam.com.vn', NULL, 'staff', NULL, '2024-04-10'),
(111, '$2y$10$QqRyMiw8F3ylGvmhFj/8L.8Z1d8FG.GSupZtFEbJoOY6.8ZKbufsK', 'Hà Bình', 'binh.hathe2023@hcmut.edu.vn', NULL, 'Customer', NULL, '2025-12-02');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL COMMENT 'Tên người nhận',
  `recipient_phone` varchar(20) NOT NULL COMMENT 'Số điện thoại người nhận',
  `province_name` varchar(255) NOT NULL COMMENT 'Tên Tỉnh/Thành phố',
  `ward_name` varchar(255) NOT NULL COMMENT 'Tên Phường/Xã',
  `street_address` varchar(500) NOT NULL COMMENT 'Số nhà, tên đường',
  `full_address` text NOT NULL COMMENT 'Địa chỉ đầy đủ: Số nhà, Phường/Xã, Tỉnh/TP',
  `is_default` tinyint(1) DEFAULT 0 COMMENT '1 = Địa chỉ mặc định, 0 = Không',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng lưu địa chỉ giao hàng của người dùng';

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`address_id`, `user_id`, `recipient_name`, `recipient_phone`, `province_name`, `ward_name`, `street_address`, `full_address`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 111, 'bình', '0919566866', 'Cao Bằng', 'Phường Tân Giang', 'ko biết nữa', 'ko biết nữa, Phường Tân Giang, Cao Bằng', 0, '2025-12-07 07:42:00', '2025-12-07 07:42:00'),
(2, 111, 'đạt', '0919566866', 'Điện Biên', 'Phường Mường Lay', 'ko biết nữa', 'ko biết nữa, Phường Mường Lay, Điện Biên', 0, '2025-12-07 07:42:39', '2025-12-07 07:42:39');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `user_phone`
--

CREATE TABLE `user_phone` (
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_phone`
--

INSERT INTO `user_phone` (`user_id`, `phone`) VALUES
(101, '0901234567'),
(101, '0909999999'),
(102, '0912345678'),
(106, '0987654321'),
(110, '0977666555');

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `voucher`
--

CREATE TABLE `voucher` (
  `voucher_code` varchar(50) NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `min_order_value` decimal(12,2) DEFAULT NULL,
  `max_sale_value` decimal(12,2) DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL
) ;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucher_code`, `usage_limit`, `used_count`, `start_time`, `end_time`, `min_order_value`, `max_sale_value`, `discount`) VALUES
('FREE_SHIP', 500, 10, '2024-10-01 00:00:00', '2025-01-01 23:59:59', 150000.00, 30000.00, 15000.00),
('NO_MIN_01', 200, 150, '2024-05-01 00:00:00', '2024-12-31 23:59:59', 0.00, 5000.00, 5000.00),
('SALE_10K', 1000, 50, '2024-11-20 00:00:00', '2024-12-31 23:59:59', 100000.00, 10000.00, 10000.00),
('TEST_OK', 10, 0, '2025-01-01 00:00:00', '2025-03-01 23:59:59', 200000.00, 25000.00, 10000.00),
('VIP_20', 50, 5, '2024-11-01 00:00:00', '2025-11-01 23:59:59', 500000.00, 50000.00, 20000.00);

-- --------------------------------------------------------

--
-- GIỮ NGUYÊN: table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author_of_product`
--
ALTER TABLE `author_of_product`
  ADD PRIMARY KEY (`product_id`,`author_name`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD KEY `FK_CtP_Category` (`category_id`),
  ADD KEY `FK_CtP_Product` (`product_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Comment_News` (`news_id`),
  ADD KEY `FK_Comment_User` (`user_id`),
  ADD KEY `FK_Comment_Parent` (`parent_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_News_Author` (`author_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `order_voucher`
--
ALTER TABLE `order_voucher`
  ADD PRIMARY KEY (`order_id`,`voucher_code`),
  ADD KEY `FK_OV_Voucher` (`voucher_code`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_name` (`page_name`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `FK_Payment_Customer` (`customer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `productreview`
--
ALTER TABLE `productreview`
  ADD PRIMARY KEY (`product_id`,`review_id`),
  ADD KEY `FK_PR_Customer` (`customer_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`product_id`,`image_url`);

--
-- Indexes for table `qa`
--
ALTER TABLE `qa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_QA_User` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_name` (`key_name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`address_id`,`user_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_is_default` (`is_default`);

--
-- Indexes for table `user_phone`
--
ALTER TABLE `user_phone`
  ADD PRIMARY KEY (`user_id`,`phone`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucher_code`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `idx_wishlist_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID đơn hàng', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qa`
--
ALTER TABLE `qa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Add new column phone to contacts table
-- 
ALTER TABLE `contacts` 
  ADD COLUMN `phone` VARCHAR(20) DEFAULT NULL;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `author_of_product`
--
ALTER TABLE `author_of_product`
  ADD CONSTRAINT `FK_Au_Product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `category_product`
--
ALTER TABLE `category_product`
  ADD CONSTRAINT `FK_CtP_Category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `FK_CtP_Product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_Comment_News` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Comment_Parent` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Comment_User` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `FK_Customer_User` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `FK_News_Author` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `order_voucher`
--
ALTER TABLE `order_voucher`
  ADD CONSTRAINT `FK_OV_Order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `FK_OV_Voucher` FOREIGN KEY (`voucher_code`) REFERENCES `voucher` (`voucher_code`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_Payment_Customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`user_id`);

--
-- Constraints for table `productreview`
--
ALTER TABLE `productreview`
  ADD CONSTRAINT `FK_PR_Customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`user_id`),
  ADD CONSTRAINT `FK_PR_Product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `FK_PI_Product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `qa`
--
ALTER TABLE `qa`
  ADD CONSTRAINT `FK_QA_User` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `FK_Staff_User` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_phone`
--
ALTER TABLE `user_phone`
  ADD CONSTRAINT `FK_UserPhone_User` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS = 1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;