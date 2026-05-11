-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 06:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phuongnam_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `author_of_product`
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
(12, 'Nguyễn Nhật Ánh'),
(13, 'Nguyễn Đình Thiệu'),
(14, 'Nhiều dịch giả'),
(15, 'Tô Hoài'),
(16, 'Antoine de Saint-Exupéry'),
(17, 'Kim Young Sam'),
(18, 'Antoine de Saint-Exupéry'),
(19, 'Ernest Hemingway'),
(20, 'Émile Zola'),
(21, 'Tập thể biên soạn'),
(22, 'None'),
(24, 'James Clear'),
(25, 'Cal Newport'),
(26, 'Robert C. Martin'),
(27, 'Morgan Housel'),
(28, 'Adam Grant'),
(29, 'Héctor García & Francesc Miralles'),
(30, 'Mihaly Csikszentmihalyi'),
(31, 'Robert T. Kiyosaki'),
(32, 'Simon Sinek'),
(33, 'Eric Ries'),
(34, 'Yuval Noah Harari'),
(35, 'Yuval Noah Harari'),
(36, 'Yuval Noah Harari'),
(37, 'Walter Isaacson'),
(38, 'Michelle Obama'),
(39, 'Arthur Conan Doyle'),
(40, 'Haruki Murakami'),
(41, 'Haruki Murakami'),
(42, 'Haruki Murakami'),
(43, 'Antoine de Saint-Exupéry'),
(55, 'J.R.R.Tolkien');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
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
(110, 1, 1, '2026-04-24 15:30:00'),
(111, 3, 1, '2026-04-24 10:00:00'),
(112, 8, 1, '2026-04-23 20:15:00'),
(113, 4, 1, '2026-04-25 09:45:00'),
(114, 9, 1, '2026-04-22 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
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
-- Table structure for table `category_product`
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
(2, 5),
(2, 6),
(2, 7),
(7, 11),
(6, 12),
(6, 13),
(1, 14),
(6, 15),
(2, 16),
(1, 17),
(2, 18),
(2, 19),
(2, 20),
(6, 21),
(2, 2),
(3, 3),
(3, 4),
(2, 1),
(2, 23),
(3, 65),
(7, 30),
(7, 66),
(7, 67),
(2, 35),
(2, 36),
(2, 38),
(2, 42),
(2, 63),
(2, 64),
(2, 73),
(6, 56),
(6, 57),
(6, 58),
(6, 59),
(6, 60),
(6, 61),
(6, 62),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(3, 24),
(3, 25),
(3, 27),
(7, 28),
(7, 29),
(3, 31),
(3, 32),
(3, 33),
(2, 34),
(2, 37),
(2, 39),
(2, 40),
(2, 41),
(2, 55),
(2, 43);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'Để trả lời bình luận khác',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `user_id`, `content`, `parent_id`, `created_at`) VALUES
(1, 1, 109, 'Chúc mừng nhà sách mở chi nhánh mới! Khi nào có chương trình khuyến mãi đặc biệt ạ?', NULL, '2025-12-05 08:30:00'),
(2, 1, 106, 'Cảm ơn bạn! Chúng tôi sẽ có nhiều ưu đãi trong tháng này, mời bạn ghé thăm nhé!', 1, '2025-12-05 10:15:00'),
(3, 1, 110, 'Tuyệt vời! Địa điểm mới thuận tiện quá, mình sẽ ghé ủng hộ.', NULL, '2025-12-06 14:00:00'),
(4, 2, 111, 'Cho mình hỏi voucher 50k áp dụng cho sách nào ạ?', NULL, '2025-12-08 09:45:00'),
(5, 2, 106, 'Voucher được áp dụng cho tất cả sách trong nhà sách bạn nhé!', 4, '2025-12-08 11:30:00'),
(6, 3, 112, 'Bộ sách này mình mua rồi, rất hay và bổ ích!', NULL, '2026-01-10 15:20:00'),
(7, 1, 110, 'Nội dung bài viết rất hữu ích. Cảm ơn nhà sách!', NULL, '2026-01-12 09:00:00'),
(8, 2, 113, 'Mình áp dụng quy tắc 10 phút và thấy đọc được nhiều hơn.', NULL, '2026-01-14 14:20:00'),
(9, 3, 114, 'Sách thiếu nhi ở đây có nhiều lựa chọn hay.', NULL, '2026-02-01 11:45:00'),
(10, 1, 115, 'Cho hỏi có ship COD về tỉnh không ạ?', NULL, '2026-02-05 16:10:00'),
(11, 2, 116, 'Cảm ơn chia sẻ về đọc sách thời đại số.', NULL, '2026-02-08 08:30:00'),
(12, 3, 109, 'Mình đặt mua cho con rất yên tâm về chất lượng.', NULL, '2026-03-01 13:00:00'),
(48, 90, 110, 'Virtual Threads thực sự là bước ngoặt cho Java. Cảm ơn admin đã chia sẻ!', NULL, '2026-05-11 04:18:50'),
(49, 91, 112, 'Project của mình đang gặp vấn đề về latency khi chia Microservices, bài viết rất đúng lúc.', NULL, '2026-05-11 04:18:50'),
(50, 92, 114, 'Đúng là đánh index bừa bãi làm chậm lệnh Insert hẳn, bài học xương máu.', NULL, '2026-05-11 04:18:50'),
(51, 93, 116, 'React 19 Server Components học hơi khó nhưng hiệu năng thì tuyệt vời.', NULL, '2026-05-11 04:18:50'),
(52, 94, 109, 'Deep Work giúp mình tập trung code 4 tiếng liên tục mà không thấy mệt.', NULL, '2026-05-11 04:18:50'),
(53, 95, 111, 'Mình vừa mua cuốn \"Nhà Giả Kim\" theo gợi ý của bài viết này.', NULL, '2026-05-11 04:18:50'),
(54, 96, 113, 'Đọc sách thay vì lướt TikTok trước khi ngủ giúp mình dễ ngủ hơn nhiều.', NULL, '2026-05-11 04:18:50'),
(55, 98, 115, 'Mình vẫn thích cảm giác lật từng trang sách giấy hơn là đọc Kindle.', NULL, '2026-05-11 04:18:50'),
(56, 103, 110, 'Gen Z như mình đúng là bị phân tâm bởi notification quá nhiều.', NULL, '2026-05-11 04:18:50'),
(57, 104, 111, 'Phương pháp Pomodoro thực sự hiệu quả cho mùa thi này!', NULL, '2026-05-11 04:18:50'),
(58, 105, 112, 'Làm remote sướng nhất là không phải kẹt xe ở Sài Gòn mỗi sáng.', NULL, '2026-05-11 04:18:50'),
(59, 106, 114, 'Quy tắc 50/30/20 rất dễ áp dụng, sinh viên nên biết sớm.', NULL, '2026-05-11 04:18:50'),
(60, 107, 109, 'ChatGPT hỗ trợ mình giải thích các khái niệm thuật toán rất tốt.', NULL, '2026-05-11 04:18:50'),
(61, 108, 116, 'Dế Mèn Phiêu Lưu Ký vẫn là cuốn fantasy đỉnh nhất tuổi thơ mình.', NULL, '2026-05-11 04:18:50'),
(62, 110, 110, 'Sách tương tác AR năm 2050 chắc sẽ thú vị lắm đây.', NULL, '2026-05-11 04:18:50'),
(63, 110, 106, 'Đúng vậy !!!', 62, '2026-05-11 04:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(20) DEFAULT 'New',
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `status`, `read_at`, `created_at`, `phone`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@gmail.com', 'Hỏi về chính sách đổi trả', 'Tôi muốn biết thủ tục đổi sách trong vòng bao nhiêu ngày?', 'Processed', NULL, '2026-04-10 09:00:00', '0988123456'),
(2, 'Trần Thị B', 'tranb@yahoo.com', 'Góp ý về website', 'Website hơi chậm vào giờ cao điểm, mong cải thiện.', 'New', NULL, '2026-04-15 14:30:00', '0978234567'),
(3, 'Phạm Văn C', 'phamc@gmail.com', 'Hợp tác kinh doanh', 'Chúng tôi muốn hợp tác phân phối sách với nhà sách Phương Nam.', 'New', NULL, '2026-04-20 11:15:00', '0934567890'),
(4, 'Lê Minh Khoa', 'khoa.le@gmail.com', 'Đặt hàng số lượng lớn', 'Chúng tôi là trường học, cần báo giá 200 cuốn sách giáo khoa.', 'New', NULL, '2026-04-21 09:20:00', '0911223344'),
(5, 'Shop ABC', 'lienhe@shopabc.vn', 'Đăng ký làm đại lý', 'Xin quy trình và điều kiện làm đại lý sách.', 'New', NULL, '2026-04-22 10:00:00', NULL),
(6, 'Nguyễn Thu Hà', 'ha.nt@gmail.com', 'Khiếu nại giao hàng', 'Đơn hàng đến chậm 3 ngày so với dự kiến.', 'Processed', NULL, '2026-04-23 14:40:00', '0988112233'),
(7, 'Trần Đức Minh', 'minh.tran@gmail.com', 'Tư vấn chọn sách', 'Nhờ tư vấn bộ sách cho học sinh lớp 10.', 'New', NULL, '2026-04-24 08:15:00', '0977665544'),
(8, 'Phạm Lan Anh', 'anh.pl@gmail.com', 'Hoàn tiền', 'Yêu cầu hoàn tiền do đặt nhầm sản phẩm.', 'New', NULL, '2026-04-25 15:50:00', '0966554433'),
(9, 'Hoàng Gia Bảo', 'bao.hg@gmail.com', 'Góp ý giao diện web', 'Nút giỏ hàng trên mobile hơi nhỏ.', 'New', NULL, '2026-04-26 11:05:00', NULL),
(10, 'Võ Thị My', 'my.vo@gmail.com', 'Phiếu quà tặng', 'Hỏi cách mua phiếu quà tặng online.', 'New', NULL, '2026-04-27 09:30:00', '0955443322'),
(11, 'Đặng Quốc An', 'an.dq@gmail.com', 'Sự kiện ký tặng', 'Khi nào có sự kiện ký tặng sách tại TP.HCM?', 'New', NULL, '2026-04-28 13:25:00', NULL),
(12, 'Bùi Khánh Ly', 'ly.bk@gmail.com', 'Thanh toán quốc tế', 'Website có hỗ trợ thẻ Visa nước ngoài không?', 'New', NULL, '2026-04-29 16:00:00', '0944332211');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
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
(106, 'Member', 0),
(109, 'Silver', 150),
(110, 'Gold', 450),
(111, 'Platinum', 1200),
(112, 'Silver', 80),
(113, 'Member', 25),
(114, 'Gold', 680),
(115, 'Member', 45),
(116, 'Silver', 200),
(117, 'Member', 0),
(118, 'Member', 0),
(119, 'Member', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `summary` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `author_id` int(11) NOT NULL COMMENT 'ID của admin viết bài',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `slug` varchar(255) DEFAULT NULL,
  `meta_description` varchar(320) DEFAULT NULL,
  `meta_keywords` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `summary`, `image_url`, `category`, `published_date`, `views`, `author_id`, `created_at`, `updated_at`, `slug`, `meta_description`, `meta_keywords`) VALUES
(1, 'Lợi ích đọc sách đối với trí não', '<p>Khi bạn đọc, não bộ phải thực hiện một quá trình phối hợp phức tạp giữa thị giác và tư duy ngôn ngữ. Quá trình này giúp kích hoạt tính dẻo của thần kinh (neuroplasticity), tạo ra các liên kết mới giữa các neuron. Việc theo dõi cốt truyện yêu cầu não bộ phải ghi nhớ liên tục, từ đó cải thiện đáng kể trí nhớ ngắn hạn. Đọc sách buộc bạn phải hình dung ra bối cảnh, giúp kích thích thùy chẩm và tăng cường trí tưởng tượng. Khác với video, đọc sách rèn luyện khả năng tập trung sâu (deep work) giữa thời đại số đầy xao nhãng. Về mặt sinh học, đọc sách giúp tăng mật độ chất xám ở các vùng não liên quan đến ngôn ngữ và nhận thức. Khoa học chứng minh chỉ cần 6 phút đọc sách có thể giúp giảm mức độ căng thẳng thần kinh tới 68%. Trạng thái đắm chìm khi đọc giúp ổn định nhịp tim và làm dịu hệ thống hạch hạnh nhân trong não. Thói quen đọc sách hàng ngày giúp xây dựng một \"kho dự trữ nhận thức\" bền vững cho tương lai. Những người thường xuyên đọc sách có nguy cơ mắc bệnh Alzheimer thấp hơn gấp 2.5 lần. Đọc sách văn học giúp củng cố \"lý thuyết tâm trí\", giúp bạn hiểu và thấu cảm với cảm xúc người khác. Vốn từ vựng tích lũy qua sách giúp vùng thùy thái dương hoạt động hiệu quả, giao tiếp trôi chảy hơn. Việc phân tích các tình tiết trong sách rèn luyện cho não bộ khả năng tư duy logic và phản biện. Đọc sách giấy trước khi ngủ hỗ trợ não bộ thư giãn tốt hơn hẳn so với việc sử dụng thiết bị điện tử. Nó giúp ngăn chặn sự sản sinh cortisol (hormone căng thẳng) và thúc đẩy cảm giác bình an. Mỗi trang sách là một thử thách nhỏ khiến não bộ phải \"vận động\" thay vì tiếp nhận thụ động. Việc học hỏi kiến thức mới từ sách giúp duy trì sự trẻ trung của các tế bào thần kinh khi về già. Đọc sách còn giúp cải thiện trí thông minh tinh thể, vốn dựa trên kiến thức và kinh nghiệm tích lũy. Đây là phương pháp \"nâng cấp\" phần cứng não bộ ít tốn kém nhưng mang lại hiệu quả bền nhất. Tóm lại, đọc sách chính là bài tập cardio quan trọng nhất để duy trì một trí tuệ minh mẫn suốt đời.1</p>', 'Đọc sách là phương pháp tối ưu để rèn luyện \"sức khỏe\" não bộ, giúp tăng cường kết nối thần kinh, mở rộng tư duy và ngăn ngừa hiệu quả các bệnh suy giảm trí nhớ.1', 'media/news/loi-ich-doc-sach-doi-voi-tri-nao.jpg', 'kien-thuc', NULL, 12, 106, '2025-12-01 02:00:00', '2026-05-11 03:47:44', 'loi-ich-doc-sach-doi-voi-tri-nao', NULL, NULL),
(2, 'Phương pháp đọc sách hiệu quả thời đại số', 'A. Phương pháp \"Đọc đa tầng\" (Inspectional Reading)\r\nTrong thời đại số, đừng vội vã đọc từ trang đầu đến trang cuối ngay lập tức. Hãy áp dụng quy trình:\r\n\r\nĐọc quét (Skimming): Xem mục lục, lời mở đầu và tóm tắt chương để nắm khung sườn.\r\n\r\nĐọc chọn lọc: Nếu là sách phi hư cấu (non-fiction), bạn có thể chỉ tập trung vào những chương giải quyết vấn đề bạn đang quan tâm thay vì đọc hết 100%.\r\n\r\nB. Chiến thuật \"Cai nghiện Dopamine\" khi đọc\r\nNão bộ chúng ta đã quen với những kích thích ngắn từ mạng xã hội, khiến việc đọc sách giấy trở nên \"chậm chạp\" và nhàm chán.\r\n\r\nQuy tắc 10 phút: Cam kết đọc ít nhất 10 phút không chạm vào điện thoại. Sau khi vượt qua ngưỡng này, não sẽ bắt đầu vào trạng thái \"Deep Work\" (làm việc sâu).\r\n\r\nChế độ máy bay: Biến thiết bị đọc (Kindle, iPad) thành một \"ốc đảo\" bằng cách tắt mọi thông báo.\r\n\r\nC. Kết hợp \"Nghe - Đọc\" (Immersive Reading)\r\nTận dụng công nghệ để tăng hiệu suất:\r\n\r\nSách nói (Audiobooks): Tận dụng thời gian \"chết\" (khi lái xe, tập thể dục, làm việc nhà) để nạp kiến thức.\r\n\r\nĐọc song song: Vừa nghe audiobook vừa nhìn vào sách giấy giúp tăng khả năng ghi nhớ và duy trì sự tập trung cao hơn đối với các tác phẩm khó.\r\n\r\nD. Hệ thống ghi chú số (Second Brain)\r\nĐừng để kiến thức trôi đi sau khi đóng sách lại. Hãy biến việc đọc thành dữ liệu có thể truy xuất:\r\n\r\nHighlight thông minh: Nếu đọc trên E-book, hãy dùng tính năng highlight và xuất (export) chúng sang các ứng dụng quản lý kiến thức như Notion, Obsidian hoặc Evernote.\r\n\r\nPhương pháp Zettelkasten: Ghi chép lại những ý tưởng tâm đắc bằng ngôn ngữ của chính mình và kết nối chúng với những gì bạn đã biết trước đó.\r\n\r\nE. Tham gia cộng đồng đọc số\r\nThời đại số cho phép bạn không \"đơn độc\" trên hành trình tri thức:\r\n\r\nGoodreads/Libib: Theo dõi tiến độ đọc và xem review để tránh những cuốn sách rác.\r\n\r\nMicro-learning: Theo dõi các kênh tóm tắt sách uy tín để có cái nhìn tổng quan trước khi quyết định mua sách.', 'Để đọc sách hiệu quả hiện nay, chúng ta cần chuyển dịch từ đọc thụ động sang đọc chủ động', 'media/news/phuong-phap-doc-sach-hieu-qua-thoi-dai-so.jpg', 'van-hoa', NULL, 2, 106, '2025-12-05 03:30:00', '2026-05-10 18:23:41', NULL, NULL, NULL),
(3, 'Sách thiếu nhi và vai trò trong phát triển trí tuệ trẻ em', 'A. Phát triển ngôn ngữ và khả năng giao tiếp\r\nSách là nguồn cung cấp từ vựng phong phú và cấu trúc câu đa dạng hơn nhiều so với ngôn ngữ nói hàng ngày.\r\n\r\nLàm giàu vốn từ: Trẻ tiếp xúc với các từ ngữ miêu tả, trạng thái cảm xúc và các thuật ngữ chuyên biệt.\r\n\r\nHoàn thiện cấu trúc ngữ pháp: Việc nghe hoặc đọc giúp trẻ thẩm thấu cách đặt câu chuẩn mực một cách tự nhiên.\r\n\r\nTự tin giao tiếp: Khi có vốn từ phong phú, trẻ sẽ dễ dàng diễn đạt ý muốn và cảm xúc của mình, giảm bớt sự cáu gắt do \"bí từ\".\r\n\r\nB. Kích thích tư duy logic và sự tập trung\r\nKhác với việc xem video (vốn là sự tiếp nhận thụ động), đọc sách yêu cầu não bộ phải làm việc tích cực.\r\n\r\nPhân tích và phán đoán: Khi theo dõi một câu chuyện, trẻ phải ghi nhớ các tình tiết, kết nối nguyên nhân - kết quả và dự đoán cái kết.\r\n\r\nRèn luyện sự tập trung sâu: Việc lật từng trang sách và dõi theo dòng chữ giúp trẻ rèn luyện khả năng tập trung, một kỹ năng cực kỳ quan trọng khi bước vào môi trường học đường.\r\n\r\nC. Khơi nguồn sáng tạo và trí tưởng tượng\r\nThế giới trong sách thiếu nhi thường đầy ắp những điều kỳ diệu, từ những con vật biết nói đến những chuyến du hành không gian.\r\n\r\nHình ảnh hóa tư duy: Trẻ tự xây dựng \"cuốn phim\" trong đầu dựa trên lời kể. Điều này giúp vỏ não liên quan đến hình ảnh hoạt động mạnh mẽ.\r\n\r\nGiải quyết vấn đề: Những tình huống giả tưởng trong sách khuyến khích trẻ suy nghĩ về những cách giải quyết khác nhau, không đi theo lối mòn.\r\n\r\nD. Phát triển trí tuệ cảm xúc (EQ) và đạo đức\r\nTrí tuệ không chỉ là logic, nó còn là sự thấu hiểu (Empathy).\r\n\r\nNhận diện cảm xúc: Qua các nhân vật, trẻ học được thế nào là vui, buồn, tức giận, sợ hãi và cách đối phó với chúng.\r\n\r\nHình thành giá trị sống: Những bài học về lòng tốt, sự trung thực và lòng dũng cảm được lồng ghép khéo léo, giúp trẻ hình thành thế giới quan nhân văn.\r\n\r\nE. Mở rộng kiến thức đa lĩnh vực\r\nSách thiếu nhi hiện nay rất đa dạng, từ sách tranh (picture books), sách tương tác (pop-up) đến sách bách khoa toàn thư.\r\n\r\nCửa sổ ra thế giới: Trẻ có thể tìm hiểu về các nền văn hóa, các loài động vật dưới đại dương hay các vì sao xa xôi ngay tại nhà.\r\n\r\nXây dựng thói quen tự học: Khi trẻ thấy việc tìm kiếm thông tin từ sách là thú vị, trẻ sẽ có xu hướng tự chủ động học tập trong tương lai.', 'Sách thiếu nhi đóng vai trò là công cụ nền tảng trong việc hình thành tư duy và nhân cách của trẻ', 'media/news/sach-thieu-nhi-va-vai-tro.jpg', 'giao-duc', NULL, 15, 106, '2025-12-06 01:15:00', '2026-04-26 08:06:39', NULL, NULL, NULL),
(4, 'Ưu đãi sách hot trong tháng', 'Tháng 5/2026, Nhà sách Phương Nam triển khai chương trình Sách hot — Giá mềm cho các đầu mục được độc giả quan tâm nhất trên website và tại cửa hàng.\r\n\r\nPhạm vi áp dụng gồm văn học, kinh tế và quản trị, kỹ năng sống, thiếu nhi và một phần sách tham khảo được gắn nhãn khuyến mãi riêng trên kệ và trên trang chi tiết sản phẩm. Mức giảm linh hoạt theo từng mã SKU, phổ biến trong khoảng 15–30%; có thêm ưu đãi combo khi mua nhiều cuốn cùng nhóm và quà kèm bookmark cho một số đơn chỉ định.\r\n\r\nĐơn hàng từ 300.000đ được freeship nội thành TP.HCM và Hà Nội; các khu vực khác áp dụng biểu phí ưu đãi và khung cam kết giao được hiển thị rõ khi đặt hàng. Mã giảm nhập trực tiếp ở bước thanh toán online hoặc quét mã QR tại quầy thu ngân; lượt mã có hạn theo ngày và không áp dụng đồng thời một số chương trình hội viên khác.\r\n\r\nĐể tránh nhầm lẫn về điều kiện (sách đặc biệt, sách giá cố định nhà phát hành), khách nên đọc dòng “Áp dụng khuyến mãi” trên từng sản phẩm. Hotline và chat trên website hỗ trợ kiểm tra mã, hoàn tất đổi trả theo quy định trong vòng bảy ngày với lỗi in ấn.', 'Giảm theo từng đầu sách (thường 15–30%), có combo và freeship đơn từ 300k tại TP.HCM và Hà Nội; áp dụng online và cửa hàng. Luôn kiểm tra điều kiện khuyến mãi trên trang sản phẩm trước khi đặt.', 'media/news/sach-kinh-doanh-va-ky-nang-song-xu-huong-doc-cua-gioi-tre.jpg', 'khuyen-mai', '2026-05-01', 43, 106, '2026-05-01 08:00:00', '2026-05-10 18:25:40', NULL, NULL, NULL),
(5, 'Gợi ý quà tặng sách cho sinh viên', 'Chọn sách làm quà cho sinh viên nên bám ngữ cảnh: tốt nghiệp cấp ba, nhập học đại học, hoặc chuẩn bị đi thực tập. Với ngân sách khoảng 150.000–350.000đ, các nhóm sách thực tế gồm kỹ năng trình bày và làm việc nhóm, tài chính cá nhân căn bản, hoặc một tiểu thuyết đời sống nhẹ để thư giãn sau kỳ thi.\r\n\r\nNếu tặng người mới vào đại học, có thể ghép bộ hai cuốn: một cuốn định hướng học tập hoặc tư duy phản biện và một cuốn kỹ năng mềm (quản lý thời gian, giao tiếp). Trước khi mua, kiểm tra năm xuất bản và nhà xuất bản để tránh nội dung lạc hậu so với quy định hay ví dụ hiện tại.\r\n\r\nTại Phương Nam, khách có thể nhờ nhân viên bọc giấy và gắn thiệp chúc; đặt online ghi chú “Quà tặng” để ship đến ký túc xá trong khung giờ cố định tùy khu vực. Với đơn gấp, chọn nhận tại cửa hoặc điểm lấy hàng để chủ động giờ nhận.\r\n\r\nMột bookmark kim loại hoặc sổ tay nhỏ đồng màu bọc quà thường làm món quà trông chỉn chu hơn mà không phải tăng ngân sách nhiều. Cuối cùng, nhớ hỏi nhanh thể loại người nhận thích đọc để tránh sách quá chuyên sâu hoặc quá “self-help” so với sở thích.', 'Gợi ý sách theo dịp (tốt nghiệp, nhập học, internship), ngân sách 150–350k và cách ghép bộ kỹ năng + định hướng. Có bọc quà và giao nhanh khi đặt online hoặc nhận tại cửa.', 'media/news/sach-va-vai-tro-trong-giao-duc-hien-dai.jpg', 'doi-song', '2026-04-18', 28, 106, '2026-04-18 10:00:00', '2026-04-18 10:00:00', NULL, NULL, NULL),
(6, 'Sự kiện: Giao lưu tác giả tại TP.HCM', 'Buổi giao lưu và ký tặng được tổ chức tại không gian văn hóa trung tâm Quận 1, TP.HCM. Địa chỉ chi tiết, sơ đồ chỗ ngồi và hướng dẫn check-in gửi qua email sau khi độc giả hoàn tất đăng ký online.\r\n\r\nThời gian dự kiến 14:00–16:30, chia làm hai phần: phần một là chia sẻ kinh nghiệm biên tập và viết lách dưới góc nhìn thị trường sách hiện nay; phần hai là hỏi đáp và xếp hàng ký tặng. BTC giới hạn khoảng 80 chỗ để đảm bảo chất lượng âm thanh và an toàn lối thoát hiểm.\r\n\r\nĐộc giả đăng ký trước nhận mã vào cửa và phần quà lưu niệm gồm bookmark in giới hạn và một số sticker nhân vật (tùy đợt phát hành). Trẻ em dưới 14 tuổi đi cùng người lớn cần khai báo khi đăng ký để sắp xếp khu ghế phù hợp.\r\n\r\nGợi ý di chuyển: nên ưu tiên xe máy hoặc Metro và đến sớm 15–20 phút để ổn định chỗ ngồi; khu vực có hướng dẫn gửi xe và lối ramp cho người khó đi lại. Một phần chương trình được livestream ngắn trên fanpage nhưng không thay thế không khí giao lưu trực tiếp và mini-game dành cho khách tại chỗ.', 'Giao lưu ký tặng Q.1, 14h–16h30; giới hạn chỗ, đăng ký online nhận mã và quà. Hướng dẫn đi lại, chỗ ngồi trẻ em và livestream cho khách không đến được.', 'media/news/van-hoa-doc-vietnam.jpg', 'su-kien', '2026-04-10', 160, 106, '2026-04-10 14:00:00', '2026-05-10 04:28:42', NULL, NULL, NULL),
(7, 'Mẹo bảo quản sách lâu bền', 'Tránh ẩm mốc, không để sách dưới ánh nắng trực tiếp, dùng bookmark thay vì gập gáy. Với sách quý có thể bọc bìa và dùng tủ có hút ẩm.', 'Kinh nghiệm', 'media/news/top-10-cuon-sach-nen-doc-trong-doi.jpg', 'meo-hay', '2026-03-22', 67, 106, '2026-03-22 09:30:00', '2026-03-22 09:30:00', NULL, NULL, NULL),
(8, 'Đọc xong một chương thì nghỉ vài phút', 'Không cần ép đọc một mạch; nghỉ giúp não gắn kết thông tin.\r\n\r\nThử áp dụng khi đọc sách học thuật hoặc ebook dài.', 'Chia nhỏ thời gian đọc cho đỡ mỏi mắt.', 'media/news/doc-sach-hieu-qua.jpg', 'meo-hay', '2026-05-05', 96, 106, '2026-05-05 09:00:00', '2026-05-10 04:28:38', NULL, NULL, NULL),
(9, 'Vài lý do mình vẫn mua sách giấy', 'Sách giấy dễ ghi chú lề, ít bị thông báo làm gián đoạn.\r\n\r\nTất nhiên ebook cũng tiện — quan trọng là chọn hình thức hợp từng lúc.', 'So sánh ngắn gọn giữa giấy và file đọc.', 'media/news/loi-ich-doc-sach.jpg', 'doi-song', '2026-05-04', 105, 106, '2026-05-04 11:20:00', '2026-05-10 08:40:48', NULL, NULL, NULL),
(10, 'Gợi ý sách nên đọc trong năm học mới', 'Ưu tiên một cuốn kỹ năng, một cuốn văn học ngắn và một cuốn chuyên ngành.\r\n\r\nDanh sách chỉ mang tính tham khảo — bạn chỉnh lại theo ngân sách.', 'Ba \"cột\" sách cho sinh viên hoặc người đi làm.', 'media/news/top-10-cuon-sach-nen-doc.jpg', 'giao-duc', '2026-05-03', 96, 106, '2026-05-03 08:40:00', '2026-05-10 03:18:50', NULL, NULL, NULL),
(70, 'Lộ trình học Java Backend cho người mới', '<p>Bắt đầu với Java Core, nắm vững hướng đối tượng (OOP). Sau đó tiến tới Servlet/JSP và quan trọng nhất là Spring Framework. Đừng quên học cách quản lý cơ sở dữ liệu với Hibernate và JPA.</p>', 'Hướng dẫn chi tiết từ zero đến hero cho các lập trình viên Java tương lai.', 'media/uploads/1778437945_java.jpg', 'giao-duc', '2026-05-11', 121, 106, '2026-05-10 18:23:03', '2026-05-10 18:32:25', 'lo-trinh-hoc-java-backend', NULL, NULL),
(71, 'Clean Code: Quy tắc vàng trong lập trình', '<p>Viết code cho máy hiểu thì dễ, viết cho con người hiểu mới khó. Hãy đặt tên biến có ý nghĩa, hàm chỉ nên làm một việc duy nhất và hạn chế tối đa các câu lệnh lồng nhau.</p>', 'Tóm tắt các nguyên tắc cốt lõi từ cuốn sách kinh điển Clean Code.', 'media/uploads/1778437988_clean-code.png', 'kien-thuc', '2026-05-11', 86, 106, '2026-05-10 18:23:03', '2026-05-10 18:33:08', 'clean-code-quy-tac-vang', NULL, NULL),
(72, 'Ảnh hưởng của AI đến ngành viết lách', '<p>AI có thể tạo ra văn bản nhanh chóng, nhưng cảm xúc và trải nghiệm cá nhân vẫn là thứ duy nhất con người có thể mang lại. Chúng ta nên coi AI là cộng sự thay vì đối thủ.</p>', 'Phân tích sự thay đổi của thị trường sách và báo chí trước làn sóng AI.', 'media/uploads/1778438093_Viet-lach-trong-thoi-dai-AI.png', 'van-hoa', '2026-05-10', 211, 106, '2026-05-10 18:23:03', '2026-05-10 18:34:53', 'anh-huong-ai-nganh-viet-lach', NULL, NULL),
(82, 'Lợi ích của việc viết lách hàng ngày', '<p>Viết giúp bạn sắp xếp lại tư duy, giảm căng thẳng và lưu giữ những kỷ niệm quý giá. Chỉ cần 15 phút viết nhật ký mỗi tối để thấy sự khác biệt.</p>', 'Cách việc viết lách cải thiện sức khỏe tinh thần và khả năng tư duy.', 'media/uploads/1778439876_loi-ich-viet-lach.jpg', 'kien-thuc', '2026-04-30', 64, 106, '2026-05-10 18:23:03', '2026-05-10 19:04:36', 'loi-ich-viet-lach-hang-ngay', NULL, NULL),
(86, 'Nghệ thuật đàm phán từ cuốn Never Split the Difference', '<p>Đừng bao giờ thỏa hiệp ở giữa. Hãy sử dụng kỹ thuật Mirroring và Labeling để hiểu được mục đích thực sự của đối phương.</p>', 'Review những bài học đắt giá từ cựu chuyên gia đàm phán FBI.', 'media/uploads/1778439915_nghe-thuat-dam-phan.jpg', 'ky-nang', '2026-04-26', 115, 106, '2026-05-10 18:23:03', '2026-05-10 19:05:15', 'nghe-thuat-dam-phan-fbi', NULL, NULL),
(87, 'Tại sao sinh viên nên tham gia nghiên cứu khoa học?', '<p>Nghiên cứu giúp bạn rèn luyện tư duy phản biện, kỹ năng tìm kiếm tài liệu và làm quen với cách giải quyết các vấn đề phức tạp một cách hệ thống.</p>', 'Lời khuyên dành cho sinh viên đại học về việc nghiên cứu.', 'media/uploads/1778439984_nghien-cuu-kh.png', 'giao-duc', '2026-04-25', 99, 106, '2026-05-10 18:23:03', '2026-05-10 19:06:24', 'sinh-vien-nghien-cuu-khoa-hoc', NULL, NULL),
(89, 'Kỹ năng quản lý thời gian Pomodoro', '<p>Làm việc tập trung trong 25 phút, sau đó nghỉ 5 phút. Phương pháp này giúp não bộ luôn ở trạng thái tỉnh táo và đạt hiệu suất cao nhất.</p>', 'Cách áp dụng kỹ thuật Pomodoro để đánh bại sự trì hoãn.', 'media/uploads/1778440053_What-Is-the-Pomodoro-Technique.png', 'ky-nang', '2026-04-23', 276, 106, '2026-05-10 18:23:03', '2026-05-10 19:07:33', 'ky-nang-quan-ly-thoi-gian-pomodoro', NULL, NULL),
(90, 'Kỷ nguyên của Spring Boot 3 và Java 21: Tại sao bạn nên nâng cấp ngay?', '<h3>Sự trỗi dậy của Virtual Threads</h3>\r\n<p>Java 21 đánh dấu một cột mốc lịch sử với Project Loom, giới thiệu Virtual Threads. Thay vì bị giới hạn bởi số lượng Platform Threads tương ứng với hệ điều hành, giờ đây một ứng dụng Spring Boot có thể xử lý hàng triệu request đồng thời với chi phí tài nguyên cực thấp. Điều này loại bỏ hoàn toàn bài toán nghẽn cổ chai (blocking) truyền thống trong các ứng dụng web IO-intensive.</p>\r\n<h3>Native Image với GraalVM</h3>\r\n<p>Spring Boot 3 mang đến sự hỗ trợ tuyệt vời cho GraalVM. Việc biên dịch ứng dụng thành Native Executable giúp thời gian khởi động (startup time) giảm từ vài chục giây xuống còn vài mili giây. Điều này không chỉ giúp tối ưu chi phí trên Cloud (Serverless, Kubernetes) mà còn giảm đáng kể lượng RAM tiêu thụ.</p>\r\n<h3>Bảo mật và Quan sát (Observability)</h3>\r\n<p>Với Micrometer Observation API mới, việc giám sát hệ thống trở nên nhất quán hơn. Bạn có thể dễ dàng trace log từ lúc request đi vào gateway cho đến khi xuống database mà không cần cấu hình thủ công phức tạp. Ngoài ra, việc yêu cầu Java 17 làm tiêu chuẩn tối thiểu giúp các nhà phát triển tận dụng được Records, Pattern Matching và Sealed Classes để viết code ngắn gọn, an toàn hơn.</p>', 'Phân tích những cải tiến vượt trội về hiệu suất nhờ Virtual Threads và GraalVM Native Image trong hệ sinh thái Java hiện đại.', 'media/uploads/1778438585_springboot.png', 'kien-thuc', '2026-05-11', 451, 106, '2026-05-10 18:27:06', '2026-05-10 18:43:05', 'ky-nguyen-spring-boot-3-java-21', NULL, NULL),
(91, 'Từ Monolith đến Microservices: Những sai lầm đắt giá và bài học xương máu', '<h3>Cái bẫy mang tên \"Hợp thời\"</h3>\r\n<p>Nhiều đội ngũ kỹ thuật vội vã chia tách hệ thống thành hàng chục microservices ngay khi dự án còn ở giai đoạn sơ khai. Kết quả là họ phải đối mặt với độ trễ mạng (network latency), sự phức tạp của phân tán giao dịch (distributed transactions) và gánh nặng quản lý hạ tầng (DevOps) trong khi logic nghiệp vụ chưa thực sự cần sự tách biệt đó.</p>\r\n<h3>Giao dịch phân tán và bài toán dữ liệu</h3>\r\n<p>Khi tách database, việc đảm bảo tính nhất quán dữ liệu trở thành ác mộng. Sử dụng Saga Pattern hay Two-Phase Commit? Mỗi giải pháp đều có cái giá của nó. Bài viết này đề xuất phương tiếp cận \"Database per Service\" nhưng cần sự hỗ trợ mạnh mẽ của Event-Driven Architecture (như Kafka hoặc RabbitMQ) để đồng bộ trạng thái.</p>\r\n<h3>Khi nào bạn thực sự cần Microservices?</h3>\r\n<p>Chỉ nên chuyển đổi khi: 1. Team của bạn quá lớn và việc dẫm chân lên code của nhau thường xuyên xảy ra. 2. Các thành phần trong hệ thống có nhu cầu scale khác nhau (ví dụ: module xử lý video cần nhiều CPU hơn module quản lý user). 3. Bạn cần sự cô lập lỗi (fault isolation) để đảm bảo một module hỏng không kéo sập toàn bộ hệ thống.</p>', 'Chia sẻ kinh nghiệm thực tế về việc chia tách dịch vụ và những cái bẫy mà các startup thường mắc phải khi chạy theo xu hướng.', 'media/uploads/1778438530_microservice.jpg', 'kien-thuc', '2026-05-11', 381, 106, '2026-05-10 18:27:10', '2026-05-10 18:42:10', 'sai-lam-khi-trien-khai-microservices', NULL, NULL),
(92, 'Tối ưu hóa Database: Đánh Index đúng cách hay đang tự làm chậm hệ thống?', '<h3>Bản chất của Index</h3>\r\n<p>Nhiều người lầm tưởng rằng cứ đánh Index vào tất cả các cột trong bảng là query sẽ nhanh. Thực tế, Index giống như một cuốn sổ mục lục. Nếu mục lục quá dài, việc tra cứu mục lục đôi khi còn tốn thời gian hơn đọc cả cuốn sách. Mỗi thao tác INSERT, UPDATE, DELETE đều yêu cầu database phải cập nhật lại cây Index, gây áp lực lên ổ đĩa IO.</p>\r\n<h3>Chiến lược Composite Index</h3>\r\n<p>Thứ tự các cột trong Composite Index (Index đa cột) cực kỳ quan trọng. Quy tắc \"Left-most prefix\" quyết định liệu Index đó có được sử dụng hay không. Ví dụ: Index trên (A, B) sẽ hoạt động cho query theo A, hoặc A và B, nhưng sẽ hoàn toàn vô dụng nếu bạn chỉ query theo B.</p>\r\n<h3>Giải pháp cho dữ liệu lớn</h3>\r\n<p>Với các bảng có hàng triệu dòng, bạn cần xem xét đến Covering Index để tránh việc \"Key Lookup\" vào bảng chính. Ngoài ra, việc sử dụng EXPLAIN ANALYZE để đọc thực thi của Database là kỹ năng bắt buộc để phát hiện ra những câu SQL đang thực hiện \"Table Scan\" một cách lãng phí.</p>', 'Hướng dẫn chuyên sâu về cách thức hoạt động của Index và chiến lược tối ưu hóa database cho các hệ thống có tải trọng lớn.', 'media/uploads/1778438453_toi-uu-database-la-gi-2.webp', 'kien-thuc', '2026-05-10', 520, 106, '2026-05-10 18:27:20', '2026-05-10 18:40:53', 'toi-uu-hoa-database-indexing', NULL, NULL),
(93, 'React 19: Server Components và cuộc cách mạng thay đổi tư duy làm Front-end', '<h3>Không còn khái niệm \"Client-only\"</h3>\r\n<p>Với React 19, ranh giới giữa Client và Server trở nên mờ nhạt hơn bao giờ hết. React Server Components (RSC) cho phép bạn fetch dữ liệu trực tiếp trong component mà không cần thông qua API trung gian hoặc các hook như useEffect. Điều này giúp giảm đáng kể kích thước gói tin JavaScript gửi xuống trình duyệt, giúp trang web load nhanh tức thì.</p>\r\n<h3>Actions và Form Handling</h3>\r\n<p>Việc xử lý form giờ đây trở nên cực kỳ đơn giản với Server Actions. Bạn có thể định nghĩa logic xử lý dữ liệu ngay tại server và gọi nó như một function bình thường từ client. Không còn cần quản lý loading state, error state thủ công bằng useState vì React đã hỗ trợ sẵn các hook như useFormStatus và useActionState.</p>\r\n<h3>Trải nghiệm người dùng là ưu tiên số 1</h3>\r\n<p>Bằng cách kết hợp linh hoạt giữa Client Components (cho tương tác) và Server Components (cho nội dung), lập trình viên có thể tạo ra những ứng dụng có độ mượt mà như Single Page Application (SPA) nhưng lại có khả năng SEO và tốc độ khởi tạo tốt như Static Site. Đây là tương lai tất yếu của phát triển web hiện đại.</p>', 'Khám phá cách React 19 thay đổi cuộc chơi Front-end bằng cách tối ưu hóa hiệu suất thông qua Server Components và Actions.', 'media/uploads/1778438416_reacy-19.jpg', 'kien-thuc', '2026-05-11', 291, 106, '2026-05-10 18:27:28', '2026-05-10 18:40:16', 'react-19-server-components-future', NULL, NULL),
(94, 'Deep Work: Siêu năng lực để sống sót và bứt phá trong kỷ nguyên AI', '<h3>Sự khan hiếm của sự tập trung</h3>\r\n<p>Trong một thế giới đầy xao nhãng bởi Facebook, TikTok và các thông báo từ Slack, khả năng tập trung liên tục trong 3-4 giờ vào một vấn đề khó (như debug một hệ thống phân tán hoặc thiết kế một thuật toán tối ưu) đang trở thành một loại tài sản cực kỳ khan hiếm. Tác giả Cal Newport gọi đó là \"Deep Work\" - làm việc sâu.</p>\r\n<h3>Tại sao AI không thể thay thế Deep Work?</h3>\r\n<p>AI có thể viết code nhanh, nhưng nó không có khả năng thấu hiểu bối cảnh kinh doanh phức tạp hoặc sáng tạo ra các giải pháp đột phá từ con số 0. Những công việc đòi hỏi sự kết nối tinh tế giữa các mảng kiến thức khác nhau chỉ có thể được thực hiện khi bộ não con người đạt đến trạng thái tập trung tuyệt đối. Người làm việc sâu tạo ra giá trị cao, khó bị sao chép và không thể bị thay thế.</p>\r\n<h3>Luyện tập khả năng tập trung</h3>\r\n<p>Để đạt được Deep Work, bạn cần thiết lập những nghi thức nghiêm ngặt: Tắt toàn bộ thông báo điện thoại, chọn một khung giờ cố định trong ngày (thường là sáng sớm) và học cách nói \"không\" với những cuộc họp vô nghĩa. Hãy coi sự tập trung như một cơ bắp, nếu bạn không luyện tập nó hàng ngày, nó sẽ yếu đi. Hãy bắt đầu với 60 phút mỗi ngày và tăng dần lên.</p>', 'Khám phá lý do tại sao khả năng tập trung sâu lại là chìa khóa giúp các kỹ sư phần mềm tạo ra giá trị khác biệt và không bị thay thế.', 'media/uploads/1778438379_deep-work.png', 'ky-nang', '2026-05-09', 610, 106, '2026-05-10 18:27:34', '2026-05-10 18:39:39', 'deep-work-sieu-nang-luc-ky-nguyen-ai', NULL, NULL),
(95, 'Nghệ thuật chọn sách: Làm sao để không lạc lối giữa \"Rừng tri thức\"?', '<h3>Cái bẫy của những cuốn sách \"Best-seller\"</h3>\r\n<p>Mỗi năm có hàng triệu cuốn sách được xuất bản, và các chiến dịch marketing rầm rộ dễ khiến chúng ta tin rằng cuốn sách đang đứng đầu bảng xếp hạng là cuốn sách mình cần. Tuy nhiên, đọc sách theo trào lưu đôi khi chỉ mang lại sự thỏa mãn nhất thời mà không bồi đắp được nền tảng tư duy bạn đang tìm kiếm. Bước đầu tiên để chọn sách đúng là hiểu rõ \"Lỗ hổng kiến thức\" của chính mình.</p>\r\n<h3>Quy tắc \"Tiên đọc kinh điển\"</h3>\r\n<p>Các cuốn sách kinh điển đã vượt qua sự đào thải của thời gian vì chúng chứa đựng những chân lý cốt lõi về con người và xã hội. Thay vì đọc 10 cuốn sách self-help mới xuất bản với cùng một thông điệp, hãy thử tìm về gốc rễ trong những tác phẩm của các triết gia hoặc các tác giả lớn. Khi có nền tảng vững chắc, bạn sẽ có bộ lọc sắc bén để đánh giá các đầu sách hiện đại nhanh chóng và chính xác hơn.</p>\r\n<h3>Xây dựng \"Thực đơn đọc\" cá nhân</h3>\r\n<p>Hãy coi việc đọc sách như việc ăn uống. Bạn cần một thực đơn cân bằng: 50% sách chuyên môn/kỹ năng để phát triển sự nghiệp, 30% sách văn học/triết học để nuôi dưỡng tâm hồn, và 20% sách giải trí hoặc chủ đề hoàn toàn mới để mở rộng biên giới tư duy. Đừng ngại bỏ dở một cuốn sách nếu sau 50 trang đầu bạn cảm thấy nó không mang lại giá trị; thời gian của bạn là hữu hạn, hãy dành nó cho những trang viết thực sự xứng đáng.</p>', 'Hướng dẫn cách xây dựng một danh mục đọc cá nhân có hệ thống và tiêu chí lựa chọn sách thông minh thay vì chạy theo số đông.', 'media/uploads/1778438343_anh-mo-ta.png', 'van-hoa', '2026-05-11', 420, 106, '2026-05-10 18:29:55', '2026-05-10 18:39:03', 'nghe-thuat-chon-sach-thong-minh', NULL, NULL),
(96, 'Bibliotherapy: Khi mỗi trang sách là một liều thuốc chữa lành tâm hồn', '<h3>Sức mạnh của sự thấu cảm qua trang giấy</h3>\r\n<p>Bibliotherapy, hay liệu pháp đọc sách, không phải là một khái niệm mới nhưng đang dần trở nên quan trọng trong xã hội hiện đại đầy áp lực. Khi chúng ta đọc về nỗi đau, sự cô độc hay thất bại của một nhân vật trong tiểu thuyết, não bộ sẽ trải qua quá trình \"đồng nhất hóa\". Cảm giác \"mình không đơn độc\" chính là bước đầu tiên trong việc xoa dịu các tổn thương tâm lý, giúp người đọc tìm thấy sự an ủi mà đôi khi lời nói trực tiếp không làm được.</p>\r\n<h3>Từ hiểu biết đến thay đổi hành vi</h3>\r\n<p>Không chỉ có văn học, các dòng sách tâm lý học ứng dụng giúp chúng ta gọi tên được các cảm xúc phức tạp bên trong. Việc hiểu rõ cơ chế của nỗi sợ, sự lo âu hay trầm cảm thông qua các phân tích khoa học giúp giảm bớt sự hoang mang. Sách cung cấp một không gian an toàn để người đọc tự đối thoại với chính mình, từ đó hình thành các cơ chế phòng vệ và đối phó tích cực hơn trước những biến cố cuộc đời.</p>\r\n<h3>Xây dựng tủ sách \"Tủ thuốc tinh thần\"</h3>\r\n<p>Một tủ sách trị liệu không nhất thiết phải là sách giáo khoa tâm lý. Đó có thể là những cuốn tản văn nhẹ nhàng về thiên nhiên, những câu chuyện vượt khó truyền cảm hứng, hay thậm chí là những cuốn sách thiếu nhi đầy trong sáng. Điều quan trọng là tìm thấy sự kết nối giữa nội dung sách và tình trạng tâm trí hiện tại của bạn. Hãy dành ít nhất 20 phút mỗi ngày để đắm mình vào thế giới của con chữ, bạn sẽ thấy nhịp tim chậm lại và tâm trí trở nên tĩnh lặng hơn.</p>', 'Khám phá liệu pháp đọc sách (Bibliotherapy) và cách những tác phẩm phù hợp có thể giúp con người vượt qua khủng hoảng tâm lý.', 'media/uploads/1778438281_what-is-bibliotherapy-4687157_withtitlev22-82608c690d92429c8800120550216b1a.png', 'van-hoa', '2026-05-11', 531, 106, '2026-05-10 18:30:03', '2026-05-10 18:38:01', 'sach-va-tri-lieu-tam-hon', NULL, NULL),
(97, 'Đọc lại sách cũ: Hành trình khám phá lại chính bản thân mình', '<h3>Sách không đổi, nhưng chúng ta đã khác</h3>\r\n<p>Có bao giờ bạn đọc lại một cuốn sách mình từng yêu thích cách đây 5 hay 10 năm và ngỡ ngàng nhận ra những thông điệp hoàn toàn mới? Cuốn sách vẫn nằm đó với những con chữ cũ kỹ, nhưng \"bộ lọc\" trải nghiệm của bạn đã thay đổi. Đọc lại không phải là một sự lãng phí thời gian, mà là một thước đo chính xác nhất cho sự trưởng thành về nhận thức và tâm hồn của bạn qua năm tháng.</p>\r\n<h3>Tìm thấy những tầng nghĩa ẩn giấu</h3>\r\n<p>Lần đầu đọc một tác phẩm, chúng ta thường bị cuốn theo cốt truyện và cái kết. Nhưng ở lần đọc thứ hai, thứ ba, tâm trí sẽ tự do hơn để quan sát những chi tiết ẩn dụ, những nhịp điệu trong ngôn từ và những triết lý sâu xa mà tác giả cài cắm. Đây là lúc chúng ta thực sự \"thưởng thức\" văn chương thay vì chỉ \"tiêu thụ\" nội dung. Những cuốn sách vĩ đại luôn có khả năng tiết lộ những bí mật mới cho mỗi lần chúng ta lật mở lại.</p>\r\n<h3>Sự an tâm trong những điều quen thuộc</h3>\r\n<p>Trong một thế giới đầy biến động và không chắc chắn, việc trở lại với một cuốn sách quen thuộc mang lại cảm giác an toàn giống như trở về nhà. Những nhân vật cũ, những bối cảnh cũ đóng vai trò như những người bạn tâm giao, giúp chúng ta định vị lại giá trị bản thân. Hãy thử mở lại cuốn sách tâm đắc nhất của bạn và đọc nó với tâm thế của một người mới, bạn sẽ ngạc nhiên với những gì mình tìm thấy.</p>', 'Phân tích giá trị sâu sắc của việc đọc lại những tác phẩm cũ và cách nó giúp chúng ta nhận ra sự trưởng thành của chính mình.', 'media/uploads/1778438243_sach-cu.jpg', 'van-hoa', '2026-05-10', 315, 106, '2026-05-10 18:30:11', '2026-05-10 18:37:23', 'tai-sao-can-doc-lai-sach-cu', NULL, NULL),
(98, 'Kỷ nguyên đọc đa phương thức: Sách giấy, E-book và Audiobook ai sẽ thắng?', '<h3>Sách giấy - Giá trị vật lý không thể thay thế</h3>\r\n<p>Dù công nghệ có tiến xa đến đâu, sách giấy vẫn giữ vững vị thế nhờ trải nghiệm đa giác quan: mùi giấy mới, cảm giác xúc giác khi lật trang và khả năng tập trung tuyệt đối không có thông báo đẩy. Đối với nhiều người, tủ sách gia đình còn là biểu tượng của tri thức và là di sản tinh thần để lại cho thế hệ sau. Sách giấy hiện nay đang dần dịch chuyển sang phân khúc sưu tầm với thiết kế sang trọng, bìa cứng và chất liệu giấy cao cấp.</p>\r\n<h3>Sách điện tử và Sách nói - Sự tiện dụng lên ngôi</h3>\r\n<p>E-book đã giải quyết bài toán không gian cho những người sống trong căn hộ nhỏ hoặc thường xuyên di chuyển. Trong khi đó, Audiobook đang bùng nổ mạnh mẽ trong thời đại bận rộn, cho phép con người nạp kiến thức khi đang lái xe, tập gym hay nấu ăn. Sự phát triển của AI trong việc tạo ra những giọng đọc truyền cảm đã khiến ranh giới giữa việc \"đọc\" và \"nghe\" trở nên mong manh hơn bao giờ hết.</p>\r\n<h3>Sự cộng sinh thay vì triệt tiêu</h3>\r\n<p>Thực tế cho thấy các hình thức này không tiêu diệt lẫn nhau mà đang bổ trợ cho nhau. Một độc giả có thể nghe bản tóm tắt qua Audiobook, đọc chi tiết trên Kindle và cuối cùng mua bản sách giấy đẹp nhất để lưu trữ. Tương lai của ngành xuất bản nằm ở việc tối ưu hóa trải nghiệm người dùng trên mọi nền tảng, giúp tri thức tiếp cận con người ở bất cứ đâu và trong bất kỳ hoàn cảnh nào.</p>', 'Cái nhìn toàn cảnh về sự chuyển dịch của các hình thức đọc trong kỷ nguyên số và lý do sách giấy vẫn tồn tại bền bỉ.', 'media/uploads/1778438174_so-sanh-giua-sach-giay-va-sach-dien-tu_1703153028.jpg', 'kien-thuc', '2026-05-11', 482, 106, '2026-05-10 18:30:21', '2026-05-10 18:48:28', 'tuong-lai-nganh-xuat-ban', NULL, NULL),
(99, 'Hiện tượng #BookTok: Khi mạng xã hội làm sống lại những tác phẩm bị lãng quên', '<h3>Sức mạnh của những video ngắn</h3>\r\n<p>TikTok không chỉ có nhảy múa; hashtag #BookTok đã trở thành một trong những cộng đồng lớn nhất thế giới, nơi những người trẻ chia sẻ cảm xúc về sách chỉ trong 15-30 giây. Điều kỳ lạ là BookTok không tập trung vào các bài phê bình học thuật khô khan, mà nhấn mạnh vào trải nghiệm cảm xúc: \"Cuốn sách này sẽ làm bạn khóc\", \"Cuốn sách này khiến bạn thay đổi suy nghĩ về tình yêu\". Chính sự chân thật này đã tạo ra sức ảnh hưởng khủng khiếp đến doanh số bán hàng tại các nhà sách truyền thống.</p>\r\n<h3>Cơ hội cho các tác giả trẻ và độc lập</h3>\r\n<p>Trước đây, một cuốn sách cần sự công nhận của các nhà phê bình tên tuổi để thành công. Giờ đây, chỉ cần một vài video viral từ các \"BookTokers\", một tác phẩm vô danh có thể trở thành hiện tượng toàn cầu chỉ sau một đêm. Điều này mở ra cánh cửa cho các tác giả độc lập và những thể loại sách vốn bị coi là \"ngách\". BookTok đang góp phần trẻ hóa cộng đồng đọc sách, biến việc đọc trở thành một hoạt động \"cool\" và mang tính kết nối xã hội cao.</p>\r\n<h3>Thách thức về chiều sâu tư duy</h3>\r\n<p>Tuy nhiên, mặt trái của hiện tượng này là xu hướng \"đọc nhanh, đọc lướt\" để kịp chạy theo các trend. Nhiều người mua sách chỉ vì bìa đẹp để quay video (Aesthetic) mà không thực sự đọc hết nội dung. Câu hỏi đặt ra là làm thế nào để chuyển hóa sự hào hứng nhất thời trên mạng xã hội thành thói quen đọc sâu và bền vững. Các nhà sách và nhà xuất bản cần khéo léo tận dụng làn sóng này để dẫn dắt độc giả trẻ tìm đến những giá trị nội dung cốt lõi thay vì chỉ dừng lại ở phần hình ảnh hào nhoáng.</p>', 'Phân tích tầm ảnh hưởng của cộng đồng #BookTok đến thói quen đọc của thế hệ Gen Z và những tác động hai mặt đến ngành xuất bản.', 'media/uploads/1778438139_book-tok.jpg', 'van-hoa', '2026-05-09', 590, 106, '2026-05-10 18:30:28', '2026-05-10 18:35:39', 'van-hoa-doc-thoi-booktok', NULL, NULL),
(100, 'Sách Kinh Điển: Tại sao chúng ta cần đọc những tư tưởng từ trăm năm trước?', '<h3>Giá trị vĩnh cửu trong một thế giới biến động</h3>\r\n<p>Nhiều người trẻ đặt câu hỏi: \"Tại sao phải đọc Plato hay Marcus Aurelius khi thế giới đã có AI và Blockchain?\". Câu trả lời nằm ở bản chất con người. Dù công nghệ thay đổi, nhưng những nỗi sợ về cái chết, khát vọng về hạnh phúc hay những mâu thuẫn trong đạo đức vẫn không hề thay đổi sau hàng thiên niên kỷ. Sách kinh điển không cung cấp cho bạn câu trả lời nhanh chóng, nhưng chúng dạy bạn cách đặt những câu hỏi đúng để thấu thị bản chất của mọi vấn đề.</p>\r\n<h3>Rèn luyện tư duy phản biện tầng sâu</h3>\r\n<p>Khác với các dòng sách \"mì ăn liền\" tóm tắt kiến thức, việc trực tiếp đọc các tác phẩm kinh điển yêu cầu một sự nỗ lực trí tuệ cao độ. Bạn phải đối mặt với những cấu trúc lập luận phức tạp, những hệ thống tư duy đồ sộ. Quá trình \"vật lộn\" với con chữ này giúp hình thành các nếp nhăn não bộ về tư duy logic và khả năng phân tích đa chiều. Khi bạn đã hiểu được logic của Aristotle, bạn sẽ thấy những bài viết phân tích trên mạng xã hội trở nên nông cạn và dễ dàng nhận ra các lỗi ngụy biện thường gặp.</p>\r\n<h3>Xây dựng một \"Hệ điều hành\" tư duy vững chắc</h3>\r\n<p>Hãy coi sách kinh điển là lớp nền của hệ điều hành, còn các kiến thức kỹ năng là các ứng dụng. Nếu hệ điều hành lỏng lẻo, các ứng dụng sẽ không bao giờ chạy ổn định. Đọc kinh điển giúp bạn xây dựng một nhân sinh quan vững vàng, một bộ lọc giá trị để không bị cuốn đi bởi các trào lưu nhất thời. Đó là lý do tại sao những nhà lãnh đạo xuất chúng nhất thế giới, từ các chính trị gia đến các tỷ phú công nghệ, đều dành phần lớn thời gian để quay lại với những giá trị tri thức gốc rễ của nhân loại.</p>', 'Phân tích sức mạnh bền vững của các tác phẩm kinh điển và cách chúng giúp rèn luyện tư duy phản biện trong kỷ nguyên thông tin nhiễu loạn.', 'media/uploads/1778438763_sach-kinh-dien.jpg', 'van-hoa', '2026-05-11', 413, 106, '2026-05-10 18:43:34', '2026-05-10 18:48:23', 'tai-sao-can-doc-sach-kinh-dien', NULL, NULL),
(101, 'Thư viện gia đình: Xây dựng di sản tri thức và không gian chữa lành', '<h3>Hơn cả một món đồ nội thất</h3>\r\n<p>Trong thiết kế nội thất hiện đại, thư viện gia đình thường bị coi nhẹ và thay thế bằng các thiết bị giải trí số. Tuy nhiên, một bức tường đầy sách mang lại một nguồn năng lượng tĩnh lặng mà không màn hình nào có thể thay thế. Thư viện không cần phải quá lớn hay cầu kỳ, nó có thể chỉ là một góc nhỏ với ánh sáng vàng ấm áp, nhưng đó phải là nơi bạn cảm thấy được bảo vệ khỏi sự ồn ào của thế giới bên ngoài. Sự hiện diện của sách trong không gian sống nhắc nhở chúng ta về việc học hỏi không ngừng và giá trị của sự chiêm nghiệm.</p>\r\n<h3>Nghệ thuật tuyển chọn và lưu giữ</h3>\r\n<p>Một thư viện gia đình chất lượng không đo bằng số lượng đầu sách, mà đo bằng sự gắn kết giữa chủ nhân và những cuốn sách đó. Hãy bắt đầu bằng việc phân loại: Khu vực cho những cuốn sách thay đổi tư duy, khu vực cho những cuốn từ điển/bách khoa toàn thư tra cứu, và một kệ riêng cho sách thiếu nhi để nuôi dưỡng tâm hồn con trẻ. Việc cùng con cái sắp xếp và chăm sóc sách hàng tuần không chỉ giúp bảo quản sách khỏi ẩm mốc mà còn là cách giáo dục về sự trân trọng tri thức một cách tự nhiên nhất.</p>\r\n<h3>Di sản cho thế hệ mai sau</h3>\r\n<p>Chúng ta mua sách không chỉ cho mình đọc. Những ghi chú bên lề trang sách, những dấu gạch chân của bạn ngày hôm nay sẽ là những lời nhắn gửi vô giá cho con cháu bạn sau này. Thư viện gia đình chính là một dòng chảy ký ức, nơi lưu giữ quá trình phát triển tư duy của nhiều thế hệ. Giữa một thế giới số hóa hoàn toàn, việc sở hữu những cuốn sách vật lý có giá trị sưu tầm chính là bạn đang nắm giữ một phần \"di sản cứng\" của văn minh nhân loại ngay trong ngôi nhà của mình.</p>', 'Hướng dẫn cách xây dựng và bài trí thư viện tại gia để biến nó thành một không gian nuôi dưỡng tư duy và lưu giữ giá trị gia đình.', 'media/uploads/1778438725_thu-vien-gia-dinh.png', 'ky-nang', '2026-05-11', 326, 106, '2026-05-10 18:43:43', '2026-05-10 18:48:16', 'xay-dung-thu-vien-gia-dinh-di-san', NULL, NULL),
(102, 'Phương pháp đọc sách của một Kỹ sư: Từ nạp thông tin đến thực thi giải pháp', '<h3>Đọc sách với tư duy giải quyết vấn đề</h3>\r\n<p>Rất nhiều người gặp tình trạng đọc xong một cuốn sách nhưng vài tuần sau không còn nhớ gì. Đó là do chúng ta đang đọc một cách thụ động. Với tư duy của một kỹ sư, mỗi cuốn sách nên được coi là một \"Project\". Trước khi mở trang đầu tiên, hãy tự hỏi: \"Cuốn sách này giải quyết vấn đề gì mà mình đang gặp phải?\". Việc đọc có mục đích giúp não bộ kích hoạt chế độ tìm kiếm từ khóa, khiến các thông tin quan trọng được ưu tiên ghi nhớ và xử lý sâu hơn so với việc đọc giải trí thông thường.</p>\r\n<h3>Kỹ thuật \"Ghi chú phi tuyến tính\" (Zettelkasten)</h3>\r\n<p>Thay vì gạch chân một cách vô nghĩa, hãy sử dụng phương pháp ghi chú nguyên tử. Mỗi khi gặp một ý tưởng hay, hãy viết lại nó bằng ngôn ngữ của chính bạn vào một thẻ ghi chú (digital hoặc vật lý). Quan trọng nhất là bước kết nối: Ý tưởng này liên quan gì đến những gì mình đã biết? Nó có thể áp dụng vào dự án nào hiện tại không? Việc tạo ra mạng lưới liên kết giữa các mảng kiến thức giúp bạn xây dựng được một \"kho tài sản trí tuệ\" có thể truy xuất bất cứ khi nào cần thiết để sáng tạo ra những giải pháp mới.</p>\r\n<h3>Mô hình \"Học đi đôi với Hành\" (Active Recall)</h3>\r\n<p>Sau mỗi chương sách, hãy đóng sách lại và tự giải thích nội dung đó cho một người khác (hoặc giả tưởng). Nếu bạn không thể giải thích đơn giản, nghĩa là bạn chưa thực sự hiểu. Đối với sách kỹ thuật hoặc kỹ năng, hãy bắt tay vào làm một \"Mini-project\" ngay lập tức dựa trên những gì vừa đọc. Đừng đợi đến khi đọc hết cả cuốn sách mới thực hành. Việc va chạm với thực tế sẽ làm lộ ra những điểm mờ trong lý thuyết, và đó chính là lúc sự học thực sự diễn ra hiệu quả nhất.</p>', 'Hướng dẫn phương pháp đọc sách chủ động và kỹ thuật ghi chú thông minh giúp chuyển hóa tri thức thành hành động thực tế hiệu quả.', 'media/uploads/1778438676_1._Ph____ng_ph__p_SQ3R.jpg', 'kien-thuc', '2026-05-10', 580, 106, '2026-05-10 18:43:50', '2026-05-10 18:44:36', 'phuong-phap-doc-sach-kieu-ky-su', NULL, NULL),
(103, 'Vì sao người trẻ ngày càng khó tập trung khi đọc sách?', '<h3>Kỷ nguyên của sự phân mảnh chú ý</h3>\r\n<p>Trong thời đại điện thoại thông minh và mạng xã hội phát triển mạnh mẽ, khả năng tập trung của con người đang bị bào mòn từng ngày. Những đoạn video ngắn kéo dài chỉ vài chục giây khiến não bộ quen với việc tiếp nhận thông tin nhanh, liên tục và ít chiều sâu. Khi quay lại với một cuốn sách dài hàng trăm trang, rất nhiều người cảm thấy khó duy trì sự tập trung quá 10 phút. Đây không phải do họ thiếu thông minh, mà bởi môi trường kỹ thuật số đang huấn luyện não bộ theo cơ chế phản xạ nhanh thay vì tư duy sâu.</p>\r\n<h3>Đọc sách chậm không phải là thất bại</h3>\r\n<p>Nhiều người có thói quen so sánh tốc độ đọc của mình với người khác và cảm thấy áp lực khi không thể đọc nhanh. Tuy nhiên, mục tiêu thực sự của việc đọc không nằm ở số trang đã hoàn thành mà ở lượng tri thức được hấp thụ. Một người đọc chậm nhưng hiểu sâu, ghi chú cẩn thận và áp dụng được kiến thức vào thực tế sẽ có lợi thế lớn hơn nhiều so với việc chỉ đọc để hoàn thành mục tiêu số lượng.</p>\r\n<h3>Cách xây dựng lại khả năng tập trung</h3>\r\n<p>Một phương pháp hiệu quả là tạo ra “khoảng thời gian đọc sâu” mỗi ngày. Hãy bắt đầu bằng 20 phút không điện thoại, không thông báo và không đa nhiệm. Trong thời gian đó, chỉ tập trung hoàn toàn vào cuốn sách đang đọc. Ngoài ra, việc ghi chú bằng tay hoặc tóm tắt sau mỗi chương sẽ giúp não bộ duy trì trạng thái xử lý thông tin chủ động, từ đó cải thiện khả năng tập trung lâu dài.</p>\r\n<h3>Biến việc đọc thành một thói quen bền vững</h3>\r\n<p>Thay vì đặt mục tiêu đọc thật nhiều sách trong thời gian ngắn, hãy ưu tiên tính đều đặn. Chỉ cần đọc 15 đến 30 phút mỗi ngày, sau một năm bạn vẫn có thể hoàn thành hàng chục cuốn sách giá trị. Quan trọng hơn cả là xây dựng được mối liên kết tự nhiên giữa việc đọc và cuộc sống hàng ngày, biến sách trở thành một phần của quá trình phát triển bản thân lâu dài.</p>', 'Phân tích nguyên nhân khiến người trẻ mất khả năng tập trung khi đọc sách và các phương pháp giúp xây dựng lại thói quen đọc sâu hiệu quả.', 'media/uploads/1778439288_tre-kho-doc.jpg', 'kien-thuc', '2026-05-10', 742, 106, '2026-05-10 18:54:00', '2026-05-10 18:54:48', 'vi-sao-nguoi-tre-ngay-cang-kho-tap-trung-khi-doc-sach', NULL, NULL),
(104, '5 thói quen giúp sinh viên học nhanh hơn mà không cần thức khuya', '<h3>Học theo chu kỳ ngắn thay vì nhồi nhét</h3>\r\n<p>Nhiều sinh viên thường đợi đến sát ngày thi mới bắt đầu học dồn, dẫn đến việc thức khuya kéo dài và hiệu quả ghi nhớ rất thấp. Phương pháp Pomodoro — học tập trung 25 phút và nghỉ 5 phút — đã được chứng minh giúp não bộ duy trì hiệu suất ổn định trong thời gian dài. Việc chia nhỏ nội dung học thành nhiều phiên ngắn cũng giúp giảm cảm giác quá tải.</p>\r\n<h3>Ngủ đủ giấc là một phần của việc học</h3>\r\n<p>Não bộ cần thời gian để củng cố trí nhớ. Nếu bạn học suốt đêm nhưng chỉ ngủ vài tiếng, khả năng ghi nhớ sẽ giảm đáng kể. Các nghiên cứu thần kinh học cho thấy giấc ngủ sâu đóng vai trò cực kỳ quan trọng trong việc chuyển thông tin từ trí nhớ ngắn hạn sang dài hạn. Vì vậy, ngủ đủ không phải là lười biếng mà là một phần của chiến lược học tập hiệu quả.</p>\r\n<h3>Ôn tập chủ động thay vì đọc đi đọc lại</h3>\r\n<p>Đọc lại tài liệu nhiều lần tạo cảm giác quen thuộc nhưng không đồng nghĩa với việc hiểu sâu. Một cách hiệu quả hơn là tự đặt câu hỏi và cố gắng trả lời mà không nhìn tài liệu. Kỹ thuật này gọi là Active Recall — kích hoạt việc truy xuất thông tin từ não bộ, giúp ghi nhớ lâu hơn rất nhiều.</p>\r\n<h3>Giảm đa nhiệm trong lúc học</h3>\r\n<p>Việc vừa học vừa nghe nhạc có lời, kiểm tra điện thoại hoặc mở quá nhiều tab trình duyệt khiến não liên tục chuyển đổi ngữ cảnh. Điều này làm giảm đáng kể khả năng tập trung và tăng thời gian hoàn thành công việc. Tạo ra một môi trường học tối giản sẽ giúp tăng hiệu suất rõ rệt chỉ sau vài ngày áp dụng.</p>', 'Tổng hợp những phương pháp học tập khoa học giúp sinh viên tăng hiệu quả ghi nhớ mà không cần thức khuya liên tục.', 'media/uploads/1778439328_hoc-tapupsplash-1643902562791.webp', 'giao-duc', '2026-05-09', 891, 106, '2026-05-10 18:54:00', '2026-05-10 19:10:17', '5-thoi-quen-giup-sinh-vien-hoc-nhanh-hon', NULL, NULL),
(105, 'Làm việc từ xa: Xu hướng hay thách thức mới của giới trẻ?', '<h3>Sự bùng nổ của mô hình Remote Work</h3>\r\n<p>Sau đại dịch, làm việc từ xa đã trở thành lựa chọn phổ biến trong nhiều ngành nghề, đặc biệt là công nghệ thông tin, thiết kế và marketing. Không còn bị giới hạn bởi vị trí địa lý, nhiều bạn trẻ có thể làm việc cho công ty quốc tế ngay tại nhà. Điều này mở ra cơ hội tiếp cận mức thu nhập tốt hơn cũng như môi trường làm việc linh hoạt hơn.</p>\r\n<h3>Tự do đi kèm với kỷ luật</h3>\r\n<p>Mặc dù làm việc từ xa mang lại sự linh hoạt, nhưng nó cũng đòi hỏi khả năng quản lý bản thân rất cao. Không có sự giám sát trực tiếp, nhiều người dễ rơi vào trạng thái trì hoãn hoặc làm việc thiếu cấu trúc. Việc xây dựng lịch trình cố định, thiết lập không gian làm việc riêng và quản lý thời gian hiệu quả là yếu tố sống còn đối với người làm remote.</p>\r\n<h3>Áp lực vô hình của sự cô lập</h3>\r\n<p>Một trong những vấn đề ít được nhắc đến là cảm giác cô đơn khi làm việc từ xa quá lâu. Thiếu tương tác trực tiếp với đồng nghiệp khiến nhiều người cảm thấy mất kết nối và giảm động lực làm việc. Vì vậy, việc duy trì các hoạt động xã hội, tham gia cộng đồng hoặc làm việc tại coworking space đôi khi là giải pháp cần thiết để cân bằng tinh thần.</p>\r\n<h3>Tương lai của môi trường làm việc</h3>\r\n<p>Nhiều chuyên gia dự đoán mô hình hybrid — kết hợp giữa làm việc tại văn phòng và từ xa — sẽ trở thành xu hướng chủ đạo trong tương lai. Điều này cho phép doanh nghiệp tận dụng lợi ích của công nghệ đồng thời vẫn duy trì sự kết nối giữa các thành viên trong tổ chức.</p>', 'Phân tích những cơ hội và áp lực mà xu hướng làm việc từ xa đang mang lại cho giới trẻ hiện nay.', 'media/uploads/1778439498_lam-viec-tu-xa-la-gi.png', 'cong-nghe', '2026-05-08', 1034, 106, '2026-05-10 18:54:00', '2026-05-10 19:10:24', 'lam-viec-tu-xa-xu-huong-hay-thach-thuc', NULL, NULL),
(106, 'Kỹ năng quản lý tài chính cá nhân mà sinh viên nên biết sớm', '<h3>Thu nhập nhỏ vẫn cần quản lý</h3>\r\n<p>Nhiều sinh viên cho rằng chỉ khi đi làm với mức lương cao mới cần quản lý tài chính. Tuy nhiên, việc hình thành thói quen kiểm soát chi tiêu từ sớm sẽ giúp tránh được rất nhiều áp lực trong tương lai. Dù chỉ có tiền trợ cấp hoặc làm thêm bán thời gian, việc ghi lại thu nhập và chi phí mỗi tháng vẫn mang lại lợi ích lớn.</p>\r\n<h3>Nguyên tắc 50/30/20 đơn giản nhưng hiệu quả</h3>\r\n<p>Một phương pháp phổ biến là chia ngân sách thành ba nhóm: 50% cho nhu cầu thiết yếu, 30% cho giải trí và 20% để tiết kiệm hoặc đầu tư. Mô hình này giúp người trẻ tránh tình trạng chi tiêu cảm tính mà vẫn duy trì được chất lượng cuộc sống.</p>\r\n<h3>Quỹ khẩn cấp quan trọng hơn bạn nghĩ</h3>\r\n<p>Nhiều người chỉ nhận ra giá trị của tiền tiết kiệm khi gặp sự cố bất ngờ như hỏng laptop, tai nạn hoặc mất việc làm thêm. Việc xây dựng quỹ dự phòng dù nhỏ sẽ tạo cảm giác an toàn và giảm áp lực tài chính đáng kể.</p>\r\n<h3>Đầu tư vào kiến thức trước khi đầu tư tài sản</h3>\r\n<p>Trong giai đoạn đầu sự nghiệp, khoản đầu tư có lợi nhuận cao nhất thường là kỹ năng và kiến thức. Một khóa học ngoại ngữ, kỹ năng lập trình hoặc giao tiếp đôi khi mang lại giá trị lâu dài hơn nhiều so với những khoản đầu tư ngắn hạn theo xu hướng.</p>', 'Những nguyên tắc tài chính cơ bản giúp sinh viên xây dựng thói quen quản lý tiền bạc hiệu quả từ sớm.', 'media/uploads/1778439541_quan-ly-tai-chinh.jpg', 'ky-nang', '2026-05-07', 656, 106, '2026-05-10 18:54:00', '2026-05-10 19:10:29', 'ky-nang-quan-ly-tai-chinh-ca-nhan', NULL, NULL),
(107, 'Trí tuệ nhân tạo đang thay đổi cách con người học tập như thế nào?', '<h3>AI không còn là công nghệ của tương lai</h3>\r\n<p>Trong vài năm gần đây, trí tuệ nhân tạo đã xuất hiện mạnh mẽ trong giáo dục và đời sống hằng ngày. Các công cụ AI có thể hỗ trợ tóm tắt tài liệu, giải thích kiến thức phức tạp, tạo bài kiểm tra và thậm chí đóng vai trò như một gia sư cá nhân. Điều này giúp việc tiếp cận tri thức trở nên nhanh chóng và cá nhân hóa hơn bao giờ hết.</p>\r\n<h3>Người học cần thay đổi tư duy</h3>\r\n<p>Trước đây, giáo dục thường tập trung vào việc ghi nhớ thông tin. Nhưng khi AI có thể truy xuất dữ liệu chỉ trong vài giây, kỹ năng quan trọng hơn là biết đặt câu hỏi đúng, đánh giá độ tin cậy của thông tin và áp dụng kiến thức vào thực tế. Điều này đòi hỏi người học phải phát triển tư duy phản biện thay vì phụ thuộc hoàn toàn vào công cụ.</p>\r\n<h3>Cơ hội và rủi ro song hành</h3>\r\n<p>AI giúp tiết kiệm thời gian học tập, nhưng cũng dễ khiến người dùng phụ thuộc quá mức. Nếu chỉ sao chép câu trả lời mà không tự suy nghĩ, khả năng phân tích và sáng tạo có thể suy giảm theo thời gian. Vì vậy, AI nên được xem là công cụ hỗ trợ chứ không phải sự thay thế cho quá trình tư duy của con người.</p>\r\n<h3>Tương lai của giáo dục cá nhân hóa</h3>\r\n<p>Nhiều chuyên gia tin rằng AI sẽ mở ra kỷ nguyên học tập cá nhân hóa hoàn toàn, nơi mỗi người có lộ trình học phù hợp với tốc độ và phong cách riêng của mình. Tuy nhiên, vai trò của giáo viên vẫn rất quan trọng trong việc định hướng tư duy, truyền cảm hứng và xây dựng kỹ năng xã hội cho người học.</p>', 'Khám phá cách trí tuệ nhân tạo đang tác động đến giáo dục và thay đổi phương pháp học tập của con người hiện đại.', 'media/uploads/1778439582_ai-giao-duc.jpg', 'cong-nghe', '2026-05-06', 1421, 106, '2026-05-10 18:54:00', '2026-05-11 04:20:06', 'ai-dang-thay-doi-cach-con-nguoi-hoc-tap', NULL, NULL);
INSERT INTO `news` (`id`, `title`, `content`, `summary`, `image_url`, `category`, `published_date`, `views`, `author_id`, `created_at`, `updated_at`, `slug`, `meta_description`, `meta_keywords`) VALUES
(108, 'Văn học giả tưởng: Khi những thế giới không có thực soi rọi thực tại', '<h3>Sức mạnh của trí tưởng tượng vượt thoát</h3>\r\n<p>Từ những vùng đất trung địa của Tolkien đến các thiên hà xa xôi của Isaac Asimov, văn học giả tưởng thường bị lầm tưởng là sự trốn chạy khỏi thực tại. Tuy nhiên, sự thực hoàn toàn ngược lại. Những thế giới này cung cấp một \"phòng thí nghiệm đạo đức\" nơi tác giả có thể cô lập các vấn đề nhức nhối của nhân loại như lòng tham, sự phân biệt đối xử, hay tham vọng quyền lực và đặt chúng dưới một lăng kính cực đoan hơn. Khi đọc về một xã hội dystopian nơi cảm xúc bị cấm đoán, chúng ta thực chất đang tự vấn về sự tự do và bản sắc cá nhân trong thế giới thực đầy rẫy sự kiểm soát từ thuật toán.</p>\r\n<h3>Khoa học viễn tưởng - Bản dự báo cho tương lai công nghệ</h3>\r\n<p>Nhiều công nghệ ngày nay như máy tính bảng, trí tuệ nhân tạo hay thám hiểm không gian đều từng xuất hiện trong trang sách từ hàng chục năm trước. Các tác giả khoa học viễn tưởng không chỉ dự đoán công nghệ, họ dự báo cả những hệ lụy xã hội. Qua những câu chuyện về robot có ý thức, con người được cảnh báo về ranh giới giữa máy móc và sự sống. Đây là nguồn tư liệu vô giá để các kỹ sư phần mềm và nhà hoạch định chính sách tham chiếu khi thiết kế các hệ thống AI hiện đại. Việc đọc thể loại này giúp mở rộng biên giới của sự khả thi, khuyến khích những tư duy đột phá \"out of the box\" mà các dòng sách kỹ thuật khô khan không thể làm được.</p>\r\n<h3>Xây dựng sự thấu cảm qua những \"người lạ\"</h3>\r\n<p>Văn học kỳ ảo buộc chúng ta phải thấu cảm với những nhân vật có hình dáng, ngôn ngữ và văn hóa hoàn toàn khác biệt. Quá trình này giúp xóa tan những rào cản định kiến trong thế giới thực. Khi bạn có thể khóc cho nỗi đau của một sinh vật ngoài hành tinh, bạn sẽ dễ dàng bao dung hơn với những sự khác biệt giữa người với người. Trong một thế giới đang ngày càng phân cực, văn học giả tưởng đóng vai trò như một nhịp cầu văn hóa, kết nối con người thông qua những trải nghiệm cảm xúc nguyên bản nhất.</p>', 'Một bài phân tích chuyên sâu về tầm quan trọng của thể loại Fantasy và Sci-Fi trong việc dự báo tương lai và giáo dục đạo đức con người.', 'media/uploads/1778439747_van-hoc-gia-tuong.jpg', 'van-hoa', '2026-05-11', 720, 106, '2026-05-10 19:00:07', '2026-05-10 19:02:27', 'suc-manh-van-hoc-gia-tuong', NULL, NULL),
(109, 'Hậu trường ngành xuất bản: Một cuốn sách được \"thai nghén\" như thế nào?', '<h3>Giai đoạn biên tập - Cuộc chiến của những con chữ</h3>\r\n<p>Một bản thảo tốt chưa chắc đã trở thành một cuốn sách hay nếu thiếu đi bàn tay của người biên tập. Quá trình này có thể kéo dài từ vài tháng đến hàng năm, nơi tác giả và biên tập viên phải làm việc cực kỳ áp lực để tinh chỉnh cấu trúc, kiểm chứng sự kiện và mài giũa văn phong. Biên tập viên không chỉ sửa lỗi chính tả, họ là những \"kiến trúc sư\" giúp bản thảo trở nên mạch lạc và cuốn hút hơn. Đây là giai đoạn quan trọng nhất quyết định linh hồn của tác phẩm, nơi những ý tưởng thô sơ được gọt giũa thành những thông điệp sắc sảo.</p>\r\n<h3>Thiết kế và Mỹ thuật - Chiếc áo làm nên thầy tu</h3>\r\n<p>Trong thời đại thị giác, bìa sách là yếu tố then chốt thu hút độc giả ngay từ cái nhìn đầu tiên. Đội ngũ họa sĩ thiết kế phải đọc hiểu nội dung để tạo ra một biểu tượng hình ảnh tóm gọn được tinh thần của cuốn sách. Từ việc chọn font chữ, chất liệu giấy in (giấy xốp nhẹ, giấy kem hay giấy mĩ thuật) đến các kỹ thuật gia công như ép kim, phủ UV gân hay dập nổi đều được tính toán tỉ mỉ. Một cuốn sách đẹp không chỉ để đọc, nó còn là một tác phẩm nghệ thuật trang trí, kích thích khao khát sở hữu của người yêu sách.</p>\r\n<h3>Phát hành và Marketing - Đưa tri thức đến đúng người</h3>\r\n<p>Sau khi rời nhà in, cuốn sách bước vào một cuộc chiến khác: thị trường. Làm sao để giữa hàng ngàn đầu sách mới mỗi tháng, cuốn sách của bạn được chú ý? Đó là lúc vai trò của các chiến dịch truyền thông lên ngôi. Từ việc gửi bản đọc thử cho những người có sức ảnh hưởng (KOLs/Reviewers), tổ chức các buổi ra mắt sách (Book Launch) đến việc tối ưu hóa sự hiện diện trên các trang thương mại điện tử. Ngành xuất bản hiện đại đòi hỏi sự kết hợp nhuần nhuyễn giữa giá trị nội dung truyền thống và các công cụ marketing kỹ thuật số để đảm bảo tri thức không bị lãng quên trên kệ sách.</p>', 'Khám phá quy trình khép kín và đầy công phu để tạo ra một cuốn sách hoàn chỉnh, từ khâu duyệt bản thảo đến khi lên kệ nhà sách.', 'media/uploads/1778439794_nganh-xuat-ban.jpg', 'kien-thuc', '2026-05-11', 450, 106, '2026-05-10 19:00:15', '2026-05-10 19:03:14', 'hanh-trinh-mot-cuon-sach-xuat-ban', NULL, NULL),
(110, 'Tương lai của việc đọc năm 2050: Khi ranh giới giữa thực và ảo bị xóa nhòa', '<h3>Sách tương tác và thực tế tăng cường (AR)</h3>\r\n<p>Đến năm 2050, việc đọc một cuốn sách lịch sử sẽ không còn là nhìn vào những dòng chữ tĩnh. Với kính AR hoặc kính áp tròng thông minh, các trận đánh kinh điển sẽ hiện lên ngay trên bàn làm việc của bạn dưới dạng mô hình 3D sinh động. Bạn có thể tương tác với các nhân vật, thay đổi góc nhìn và thậm chí nghe thấy âm thanh của bối cảnh lịch sử đó. Sách sẽ không còn là một chiều, mà trở thành một trải nghiệm nhập vai đa giác quan (Immersive Experience), giúp việc học tập và tiếp nhận thông tin trở nên nhanh chóng và khó quên hơn bao giờ hết.</p>\r\n<h3>Cá nhân hóa nội dung bằng AI thời gian thực</h3>\r\n<p>Hãy tưởng tượng một cuốn tiểu thuyết có thể tự thay đổi tình tiết dựa trên nhịp tim và phản ứng cảm xúc của người đọc. Trí tuệ nhân tạo sẽ phân tích trạng thái tâm lý của bạn để điều chỉnh nhịp độ câu chuyện, thậm chí thay đổi cái kết để phù hợp nhất với kỳ vọng hoặc để thử thách giới hạn của bạn. Mỗi người sẽ sở hữu một phiên bản sách duy nhất dành riêng cho mình. Điều này đặt ra những câu hỏi lớn về tính nguyên bản của tác phẩm nhưng đồng thời mở ra một kỷ nguyên sáng tạo vô tận, nơi người đọc và AI cùng nhau viết nên câu chuyện.</p>\r\n<h3>Kết nối trực tiếp qua não bộ (Neuralink)</h3>\r\n<p>Ở mức độ cao hơn, thông tin có thể được truyền tải trực tiếp vào vỏ não thông qua các giao diện não - máy tính. Thay vì dành hàng tuần để đọc một bộ bách khoa toàn thư, bạn có thể \"tải\" kiến thức cơ bản về một ngôn ngữ hoặc một kỹ năng trong vài phút. Tuy nhiên, điều này không làm mất đi giá trị của việc đọc sâu. Con người sẽ vẫn tìm đến sách như một cách để rèn luyện tư duy và tận hưởng vẻ đẹp ngôn từ - những thứ mà việc tải dữ liệu thuần túy không thể mang lại. Việc đọc khi đó sẽ trở thành một hình thức \"thiền định kỹ thuật số\" cao cấp, giúp duy trì sự nhân bản của con người trong một thế giới tràn ngập máy móc.</p>', 'Những dự báo đầy tham vọng về cách công nghệ sẽ thay đổi hoàn toàn thói quen đọc sách và tiếp nhận tri thức của nhân loại trong tương lai.', 'media/uploads/1778439825_goc-nhin-doc-ve-the-gioi-trong-nam-2050.webp', 'kien-thuc', '2026-05-11', 893, 106, '2026-05-10 19:00:23', '2026-05-11 04:23:42', 'tuong-lai-viec-doc-nam-2050', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `recipient_name`, `recipient_phone`, `shipping_address`, `payment_method`, `subtotal`, `shipping_fee`, `total_amount`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh', 'COD', 85000.00, 30000.00, 115000.00, 'completed', 'Gọi trước khi giao', '2026-04-01 10:30:00', '2026-04-26 10:30:00'),
(2, 110, 'Nguyễn Văn Bình', '0912345678', '45 Nguyễn Văn Hưởng, Phường Thảo Điền, Quận 2, TP. Hồ Chí Minh', 'Momo', 120000.00, 0.00, 120000.00, 'completed', NULL, '2026-04-05 14:20:00', '2026-04-26 10:30:00'),
(3, 111, 'Trần Thị Mai', '0923456789', '78 Kim Mã, Phường Kim Mã, Quận Ba Đình, Hà Nội', 'COD', 289000.00, 40000.00, 329000.00, 'shipped', 'Giao hàng giờ hành chính', '2026-04-10 09:15:00', '2026-04-26 10:30:00'),
(4, 112, 'Phạm Văn Tuấn', '0934567890', '234 Nguyễn Hữu Thọ, Phường Hòa Cường, Quận Hải Châu, Đà Nẵng', 'Credit Card', 95000.00, 30000.00, 125000.00, 'processing', NULL, '2026-04-15 16:45:00', '2026-04-26 10:30:00'),
(5, 113, 'Hoàng Thị Lan', '0945678901', '89 Kha Vạn Cân, Phường Linh Trung, Thủ Đức, TP. Hồ Chí Minh', 'ZaloPay', 88000.00, 0.00, 88000.00, 'pending', NULL, '2026-04-18 11:00:00', '2026-04-26 10:30:00'),
(6, 114, 'Vũ Minh Đức', '0956789012', '12 Lê Hồng Phong, Phường Đằng Giang, Quận Ngô Quyền, Hải Phòng', 'COD', 75000.00, 35000.00, 110000.00, 'completed', 'Giao vào buổi tối', '2026-04-20 08:30:00', '2026-04-26 10:30:00'),
(7, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh', 'Momo', 199000.00, 0.00, 199000.00, 'completed', NULL, '2026-04-22 13:20:00', '2026-04-26 10:30:00'),
(8, 115, 'Ngô Thị Hồng', '0967890123', '456 Cách Mạng Tháng 8, Phường 10, Quận 3, TP. Hồ Chí Minh', 'COD', 35000.00, 30000.00, 65000.00, 'cancelled', 'Đơn hàng bị hủy', '2026-04-23 09:00:00', '2026-04-26 10:30:00'),
(9, 111, 'Trần Thị Mai', '0923456789', '78 Kim Mã, Phường Kim Mã, Quận Ba Đình, Hà Nội', 'COD', 160000.00, 40000.00, 200000.00, 'completed', NULL, '2026-03-02 11:00:00', '2026-04-26 10:30:00'),
(10, 112, 'Phạm Văn Tuấn', '0934567890', '234 Nguyễn Hữu Thọ, Phường Hòa Cường, Quận Hải Châu, Đà Nẵng', 'Momo', 468000.00, 0.00, 468000.00, 'completed', 'Giao cuối tuần', '2026-03-18 14:30:00', '2026-04-26 10:30:00'),
(11, 113, 'Hoàng Thị Lan', '0945678901', '89 Kha Vạn Cân, Phường Linh Trung, Thủ Đức, TP. Hồ Chí Minh', 'ZaloPay', 209000.00, 30000.00, 239000.00, 'completed', NULL, '2026-02-10 09:15:00', '2026-04-26 10:30:00'),
(12, 114, 'Vũ Minh Đức', '0956789012', '12 Lê Hồng Phong, Phường Đằng Giang, Quận Ngô Quyền, Hải Phòng', 'Credit Card', 92000.00, 35000.00, 127000.00, 'processing', NULL, '2026-04-28 08:00:00', '2026-04-26 10:30:00'),
(13, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh', 'COD', 145000.00, 0.00, 145000.00, 'shipped', 'Kiểm tra hàng trước khi nhận', '2026-04-29 16:20:00', '2026-04-26 10:30:00'),
(14, 116, 'Đỗ Văn Hùng', '0978901234', '88 Nguyễn Huệ, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh', 'COD', 289000.00, 30000.00, 319000.00, 'pending', NULL, '2026-05-01 10:00:00', '2026-04-26 10:30:00'),
(15, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh', 'COD', 529000.00, 0.00, 529000.00, 'completed', NULL, '2026-05-06 10:00:00', '2026-05-06 10:00:00'),
(16, 110, 'Nguyễn Văn Bình', '0912345678', '45 Nguyễn Văn Hưởng, Phường Thảo Điền, Quận 2, TP. Hồ Chí Minh', 'COD', 464000.00, 30000.00, 494000.00, 'completed', NULL, '2026-05-07 14:30:00', '2026-05-07 14:30:00'),
(17, 111, 'Trần Thị Mai', '0923456789', '78 Kim Mã, Phường Kim Mã, Quận Ba Đình, Hà Nội', 'Momo', 360000.00, 0.00, 360000.00, 'completed', NULL, '2026-05-08 09:15:00', '2026-05-08 09:15:00'),
(18, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Đông Hòa, Thành phố Hồ Chí Minh', 'E-wallet', 259000.00, 30000.00, 289000.00, 'cancelled', '', '2026-05-10 03:24:18', '2026-05-10 03:25:02'),
(19, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Thục Phán, Cao Bằng', 'COD', 170000.00, 30000.00, 200000.00, 'completed', '', '2026-05-10 03:26:31', '2026-05-10 03:27:34'),
(20, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Nùng Trí Cao, Cao Bằng', 'COD', 340000.00, 30000.00, 370000.00, 'completed', '', '2026-05-10 03:28:54', '2026-05-10 03:29:35'),
(22, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Nùng Trí Cao, Cao Bằng', 'COD', 120000.00, 30000.00, 150000.00, 'cancelled', '', '2026-05-10 04:17:45', '2026-05-10 04:17:49'),
(23, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Nùng Trí Cao, Cao Bằng', 'COD', 344000.00, 30000.00, 374000.00, 'completed', '', '2026-05-10 08:34:36', '2026-05-10 08:35:14'),
(26, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Phường Ba Đình, Thành phố Hà Nội', 'E-wallet', 258000.00, 30000.00, 288000.00, 'cancelled', '', '2026-05-10 11:28:26', '2026-05-10 11:28:53'),
(28, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Quận 1, TP.HCM', 'Momo', 247000.00, 0.00, 247000.00, 'completed', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(29, 110, 'Nguyễn Văn Bình', '0912345678', '45 Nguyễn Văn Hưởng, Quận 2, TP.HCM', 'COD', 189000.00, 30000.00, 219000.00, 'processing', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(30, 111, 'Trần Thị Mai', '0923456789', '78 Kim Mã, Ba Đình, Hà Nội', 'Credit Card', 128000.00, 30000.00, 158000.00, 'shipped', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(31, 112, 'Phạm Văn Tuấn', '0934567890', '234 Nguyễn Hữu Thọ, Hải Châu, Đà Nẵng', 'COD', 119000.00, 30000.00, 149000.00, 'pending', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(32, 113, 'Hoàng Thị Lan', '0945678901', '89 Kha Vạn Cân, Thủ Đức, TP.HCM', 'ZaloPay', 225000.00, 0.00, 225000.00, 'completed', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(33, 114, 'Vũ Minh Đức', '0956789012', '12 Lê Hồng Phong, Ngô Quyền, Hải Phòng', 'COD', 198000.00, 30000.00, 228000.00, 'processing', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(34, 115, 'Ngô Thị Hồng', '0967890123', '456 Cách Mạng Tháng 8, Quận 3, TP.HCM', 'Momo', 260000.00, 0.00, 260000.00, 'completed', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(35, 116, 'Đỗ Văn Hùng', '0978901234', '88 Nguyễn Huệ, Quận 1, TP.HCM', 'COD', 175000.00, 30000.00, 205000.00, 'shipped', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(36, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Quận 1, TP.HCM', 'ZaloPay', 310000.00, 0.00, 310000.00, 'completed', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(37, 110, 'Nguyễn Văn Bình', '0912345678', '45 Nguyễn Văn Hưởng, Quận 2, TP.HCM', 'COD', 142000.00, 30000.00, 172000.00, 'cancelled', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(38, 111, 'Trần Thị Mai', '0923456789', '78 Kim Mã, Ba Đình, Hà Nội', 'Momo', 149000.00, 0.00, 149000.00, 'completed', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(39, 112, 'Phạm Văn Tuấn', '0934567890', '234 Nguyễn Hữu Thọ, Hải Châu, Đà Nẵng', 'COD', 99000.00, 30000.00, 129000.00, 'processing', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(40, 113, 'Hoàng Thị Lan', '0945678901', '89 Kha Vạn Cân, Thủ Đức, TP.HCM', 'Credit Card', 185000.00, 0.00, 185000.00, 'completed', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(41, 114, 'Vũ Minh Đức', '0956789012', '12 Lê Hồng Phong, Ngô Quyền, Hải Phòng', 'COD', 78000.00, 30000.00, 108000.00, 'pending', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50'),
(42, 109, 'Khách hàng Demo', '0901234567', '123 Lê Lợi, Quận 1, TP.HCM', 'Momo', 138000.00, 0.00, 138000.00, 'completed', NULL, '2026-05-11 04:18:50', '2026-05-11 04:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `order_id` int(11) NOT NULL COMMENT 'ID đơn hàng',
  `product_id` int(11) NOT NULL COMMENT 'ID sản phẩm',
  `quantity` int(11) NOT NULL DEFAULT 1 COMMENT 'Số lượng',
  `price` decimal(10,2) NOT NULL COMMENT 'Giá tại thời điểm đặt hàng',
  `subtotal` decimal(10,2) NOT NULL COMMENT 'Thành tiền = price * quantity'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 1, 85000.00, 85000.00),
(2, 5, 1, 120000.00, 120000.00),
(3, 11, 1, 289000.00, 289000.00),
(4, 3, 1, 95000.00, 95000.00),
(5, 4, 1, 88000.00, 88000.00),
(6, 7, 1, 75000.00, 75000.00),
(7, 2, 1, 75000.00, 75000.00),
(7, 8, 1, 89000.00, 89000.00),
(7, 10, 1, 35000.00, 35000.00),
(8, 10, 1, 35000.00, 35000.00),
(9, 1, 1, 85000.00, 85000.00),
(9, 2, 1, 75000.00, 75000.00),
(10, 9, 1, 468000.00, 468000.00),
(11, 5, 1, 120000.00, 120000.00),
(11, 8, 1, 89000.00, 89000.00),
(12, 6, 1, 92000.00, 92000.00),
(13, 2, 1, 75000.00, 75000.00),
(13, 5, 1, 70000.00, 70000.00),
(14, 11, 1, 289000.00, 289000.00),
(15, 12, 4, 62000.00, 248000.00),
(15, 13, 2, 48000.00, 96000.00),
(15, 14, 1, 185000.00, 185000.00),
(15, 24, 1, 128000.00, 128000.00),
(15, 25, 1, 119000.00, 119000.00),
(16, 19, 8, 58000.00, 464000.00),
(16, 34, 1, 198000.00, 198000.00),
(16, 44, 1, 145000.00, 145000.00),
(17, 21, 3, 120000.00, 360000.00),
(17, 56, 2, 155000.00, 310000.00),
(18, 2, 1, 75000.00, 75000.00),
(18, 6, 2, 92000.00, 184000.00),
(19, 1, 2, 85000.00, 170000.00),
(19, 59, 3, 28000.00, 84000.00),
(20, 1, 4, 85000.00, 340000.00),
(20, 70, 1, 275000.00, 275000.00),
(21, 21, 1, 120000.00, 120000.00),
(22, 21, 1, 120000.00, 120000.00),
(23, 1, 4, 86000.00, 344000.00),
(23, 65, 2, 112000.00, 224000.00),
(24, 21, 1, 120000.00, 120000.00),
(25, 23, 1, 20000.00, 20000.00),
(26, 1, 3, 86000.00, 258000.00),
(28, 24, 1, 128000.00, 128000.00),
(28, 25, 1, 119000.00, 119000.00),
(29, 26, 1, 189000.00, 189000.00),
(30, 24, 1, 128000.00, 128000.00),
(31, 25, 1, 119000.00, 119000.00),
(32, 37, 1, 225000.00, 225000.00),
(33, 34, 1, 198000.00, 198000.00),
(34, 39, 1, 260000.00, 260000.00),
(35, 40, 1, 175000.00, 175000.00),
(36, 27, 1, 135000.00, 135000.00),
(36, 40, 1, 175000.00, 175000.00),
(37, 28, 1, 142000.00, 142000.00),
(38, 33, 1, 149000.00, 149000.00),
(39, 29, 1, 99000.00, 99000.00),
(40, 14, 1, 185000.00, 185000.00),
(41, 43, 1, 78000.00, 78000.00),
(42, 55, 1, 138000.00, 138000.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_voucher`
--

CREATE TABLE `order_voucher` (
  `order_id` int(11) NOT NULL,
  `voucher_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_voucher`
--

INSERT INTO `order_voucher` (`order_id`, `voucher_code`) VALUES
(1, 'SALE_10K'),
(2, 'FREE_SHIP'),
(4, 'SALE_10K'),
(7, 'FREE_SHIP');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'about', '{\"hero_title\":\"Về Nhà sách Phương Nam\",\"hero_text\":\"Nhà sách Phương Nam là đơn vị uy tín trong lĩnh vực phát hành và phân phối sách tại Việt Nam. Với cam kết mang đến nguồn tri thức phong phú, chúng tôi phục vụ hàng nghìn độc giả với chất lượng dịch vụ tốt nhất và giá cả hợp lý.\",\"intro_lead\":\"\",\"mission_text\":\"Phát triển văn hóa đọc trong cộng đồng, góp phần nâng cao dân trí, xây dựng một xã hội học tập. Chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng cao với giá cả hợp lý và dịch vụ tốt nhất.\",\"vision_text\":\"Trở thành hệ thống phát hành sách hàng đầu Việt Nam, tiên phong trong việc ứng dụng công nghệ vào kinh doanh sách. Mở rộng mạng lưới phân phối đến mọi miền đất nước, đưa tri thức đến gần hơn với mọi người.\",\"value_cards\":[{\"title\":\"Uy tín\",\"text\":\"Luôn đặt uy tín lên hàng đầu trong mọi hoạt động kinh doanh, xây dựng niềm tin với khách hàng và đối tác.\"},{\"title\":\"Chất lượng\",\"text\":\"Cam kết cung cấp sản phẩm chính hãng, chất lượng cao, đáp ứng nhu cầu đa dạng của khách hàng.\"},{\"title\":\"Đổi mới\",\"text\":\"Không ngừng đổi mới, sáng tạo trong kinh doanh và dịch vụ, ứng dụng công nghệ hiện đại.\"},{\"title\":\"Tận tâm\",\"text\":\"Phục vụ khách hàng với sự tận tâm, chu đáo, luôn lắng nghe và đáp ứng mọi nhu cầu.\"},{\"title\":\"Trách nhiệm\",\"text\":\"Có trách nhiệm với cộng đồng, xã hội và môi trường, góp phần xây dựng xã hội phát triển bền vững.\"},{\"title\":\"Đoàn kết\",\"text\":\"Xây dựng môi trường làm việc đoàn kết, hợp tác, tạo điều kiện cho nhân viên phát triển.\"}],\"service_cards\":[{\"title\":\"Giao hàng nhanh\",\"text\":\"Giao hàng toàn quốc trong 2-3 ngày. Miễn phí vận chuyển cho đơn hàng từ 150.000đ.\"},{\"title\":\"Đổi trả dễ dàng\",\"text\":\"Chính sách đổi trả linh hoạt trong vòng 7 ngày nếu sản phẩm có lỗi từ nhà sản xuất.\"},{\"title\":\"Hỗ trợ 24\\/7\",\"text\":\"Đội ngũ chăm sóc khách hàng chuyên nghiệp, sẵn sàng hỗ trợ bạn mọi lúc mọi nơi.\"}]}', '2025-12-02 15:53:28', '2026-05-10 18:03:33'),
(2, 'terms', 'Các điều khoản sử dụng của website Nhà sách Phương Nam. Vui lòng đọc kỹ trước khi sử dụng dịch vụ.', '2025-12-02 15:53:28', '2025-12-07 10:00:00'),
(3, 'privacy', 'Chính sách bảo mật thông tin khách hàng của Nhà sách Phương Nam. Chúng tôi cam kết bảo vệ thông tin cá nhân của quý khách.', '2025-12-07 10:00:00', '2025-12-07 10:00:00'),
(4, 'shipping', 'Chính sách vận chuyển và giao hàng: Miễn phí vận chuyển cho đơn hàng từ 300.000đ trong nội thành TP.HCM. Thời gian giao hàng từ 2-5 ngày làm việc.', '2025-12-07 10:00:00', '2025-12-07 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
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
(1, 109, 'COD', '2026-04-01'),
(2, 110, 'Momo', '2026-04-05'),
(3, 111, 'COD', '2026-04-10'),
(4, 112, 'Credit Card', '2026-04-15'),
(5, 114, 'COD', '2026-04-20'),
(6, 109, 'Momo', '2026-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `publisher` varchar(100) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `product_type` varchar(50) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `old_price` decimal(12,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(50) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `title`, `publisher`, `published_date`, `supplier`, `description`, `year`, `language`, `pages`, `product_type`, `stock_quantity`, `price`, `old_price`, `weight`, `dimensions`, `size`) VALUES
(1, 'Đắc Nhân Tâm - Tác phẩm kinh điển về nghệ thuật thu phục và ảnh hưởng người khác', 'NXB Tổng hợp TP.HCM', '2020-06-15', '', 'Đắc Nhân Tâm là quyển sách duy nhất về thể loại self-help bán chạy nhất mọi thời đại. Cuốn sách đã và đang thay đổi cuộc sống của hàng triệu người trên thế giới.', 2001, '', 400, '', 3, 86000.00, 100000.00, 0.00, '13 x 20.5 cm', ''),
(2, 'Nhà Giả Kim - Phiên bản kỷ niệm 25 năm', 'NXB Trẻ', '2019-08-10', '', '<p>Một câu chuyện cổ tích dành cho người lớn, một câu chuyện cổ tích về việc theo đuổi giấc mơ và tìm kiếm ý nghĩa cuộc sống tươi đẹp</p>', 2008, '', 162, '', 100, 75000.00, 90000.00, 0.00, '11 x 18 cm', ''),
(3, 'Nhà Lãnh Đạo Không Chức Danh', 'NXB Lao Động', '2021-03-05', '', '<p>Cuốn sách truyền cảm hứng cho độc giả rằng ai cũng có thể trở thành một nhà lãnh đạo, không phải bởi chức vụ mà bởi hành động.</p>', 2016, '', 224, '', 100, 95000.00, 110000.00, 0.00, '14 x 20.5 cm', ''),
(4, 'Đời Ngắn Đừng Ngủ Dài', 'NXB Tổng hợp TP.HCM', '2020-11-20', '', '<p>Cuốn sách giúp bạn khám phá cách thức để thức dậy mỗi ngày với sự hăng hái, hiệu suất và cảm giác tuyệt vời.</p>', 2020, '', 208, '', 100, 88000.00, 105000.00, 0.00, '13 x 20.5 cm', ''),
(5, 'Tư Duy Nhanh và Tư Duy Chậm', 'NXB Chính Trị Quốc Gia', '2018-07-15', NULL, 'Cuốn sách khám phá hai hệ thống tư duy chi phối cách chúng ta suy nghĩ: hệ thống nhanh và hệ thống chậm.', NULL, NULL, 499, NULL, 100, 120000.00, 140000.00, NULL, '14 x 21 cm', NULL),
(7, 'Hiểu Về Trái Tim', 'NXB Tổng hợp TP.HCM', '2019-11-30', NULL, 'Cuốn sách giúp người đọc hiểu rõ hơn về bản thân và cảm xúc của mình, từ đó sống an nhiên và hạnh phúc hơn.', NULL, NULL, 280, NULL, 100, 75000.00, 90000.00, NULL, '13 x 20 cm', NULL),
(8, 'Dám Bị Ghét', 'NXB Lao Động', '2021-08-20', NULL, 'Cuốn sách về tâm lý học giúp bạn giải phóng bản thân khỏi những áp lực xã hội và sống tự do hơn.', NULL, NULL, 280, NULL, 100, 89000.00, 105000.00, NULL, '13 x 20.5 cm', NULL),
(9, 'Gardening at Longmeadow', 'DK Publishing', '2021-02-08', NULL, 'Cuốn sách hướng dẫn chăm sóc vườn tược với nhiều mẹo hay và kinh nghiệm từ chuyên gia.', NULL, NULL, 352, NULL, 100, 468000.00, 585000.00, NULL, '21 x 25 cm', NULL),
(10, 'Văn Hóa Ẩm Thực Việt Nam', 'NXB Văn Hóa', '2019-06-20', '', 'Khám phá văn hóa ẩm thực đặc sắc của Việt Nam qua từng vùng miền.', 0, '', 208, '', 100, 35000.00, 45000.00, 0.00, '16 x 24 cm', ''),
(11, 'Câu Chuyện Triết Học', 'NXB Thế Giới', '2020-04-10', '', 'Cuốn sách kinh điển giúp bạn nắm trọn tinh hoa triết học phương Tây qua những câu chuyện súc tích, dễ hiểu và đầy cảm hứng', 1900, '', 736, '', 100, 289000.00, 450000.00, 0.00, '15 x 23 cm', ''),
(14, 'Đại Việt sử ký toàn thư', 'NXB Khoa học Xã hội', '2024-11-20', NULL, 'Bản khổ nhỏ rút gọn, tiện tra cứu sự kiện lịch sử Việt Nam.', NULL, NULL, 920, NULL, 60, 185000.00, 210000.00, NULL, '14 x 20 cm', NULL),
(16, 'Hoàng tử bé', 'NXB Trẻ', '2025-01-15', NULL, 'Bản dịch phổ biến, câu chuyện ngắn nhưng đầy ẩn dụ.', NULL, NULL, 128, NULL, 95, 55000.00, 65000.00, NULL, '13 x 18 cm', NULL),
(18, 'Night flights', 'NXB Hội Nhà văn', '2024-07-10', NULL, 'Tập truyện ngắn của Saint-Exupéry, gần gũi với Hoàng tử bé.', NULL, NULL, 160, NULL, 55, 72000.00, NULL, NULL, '13 x 20 cm', NULL),
(19, 'Ông già và biển cả', 'NXB Trẻ', '2025-02-18', NULL, 'Tiểu thuyết ngắn của Hemingway; bản in mới, giấy kem.', NULL, NULL, 136, NULL, 100, 58000.00, 69000.00, NULL, '13 x 19 cm', NULL),
(20, 'Tâm hồn cao thượng', 'NXB Văn học', '2024-12-05', NULL, 'Tiểu thuyết của Émile Zola, thích hợp độc giả thích văn học cổ điển.', NULL, NULL, 320, NULL, 65, 65000.00, NULL, NULL, '13 x 19 cm', NULL),
(24, 'Atomic Habits', 'NXB Trẻ', '2025-01-05', '', 'Sách phát triển bản thân nổi tiếng về xây dựng thói quen.', 2025, 'Tiếng Việt', 320, 'Book', 120, 128000.00, 150000.00, NULL, '14 x 20 cm', ''),
(25, 'Deep Work', 'NXB Lao Động', '2025-01-10', '', 'Kỹ năng tập trung trong thời đại số.', 2025, 'Tiếng Việt', 304, 'Book', 100, 119000.00, 140000.00, NULL, '14 x 20 cm', ''),
(26, 'Clean Code', 'NXB CNTT', '2025-01-12', '', 'Sách kinh điển cho lập trình viên.', 2025, 'Tiếng Việt', 464, 'Book', 80, 189000.00, 220000.00, NULL, '16 x 24 cm', ''),
(27, 'The Psychology of Money', 'NXB Thế Giới', '2025-01-15', '', 'Tâm lý học về tiền bạc và đầu tư.', 2025, 'Tiếng Việt', 256, 'Book', 95, 135000.00, 155000.00, NULL, '14 x 20 cm', ''),
(28, 'Think Again', 'NXB Trẻ', '2025-01-18', '', 'Khả năng tư duy lại và phản biện.', 2025, 'Tiếng Việt', 352, 'Book', 90, 142000.00, 165000.00, NULL, '14 x 20 cm', ''),
(29, 'Ikigai', 'NXB Văn Học', '2025-01-20', '', 'Bí quyết sống hạnh phúc của người Nhật.', 2025, 'Tiếng Việt', 208, 'Book', 100, 99000.00, 120000.00, NULL, '13 x 19 cm', ''),
(31, 'Rich Dad Poor Dad', 'NXB Trẻ', '2025-01-25', '', 'Kiến thức tài chính cá nhân căn bản.', 2025, 'Tiếng Việt', 336, 'Book', 140, 110000.00, 130000.00, NULL, '14 x 20 cm', ''),
(32, 'Start With Why', 'NXB Lao Động', '2025-01-28', '', 'Tìm lý do để tạo động lực.', 2025, 'Tiếng Việt', 300, 'Book', 90, 118000.00, 145000.00, NULL, '14 x 20 cm', ''),
(33, 'The Lean Startup', 'NXB Công Thương', '2025-02-01', '', 'Khởi nghiệp tinh gọn.', 2025, 'Tiếng Việt', 380, 'Book', 75, 149000.00, 170000.00, NULL, '15 x 23 cm', ''),
(34, 'Sapiens', 'NXB Thế Giới', '2025-02-03', '', 'Lược sử loài người.', 2025, 'Tiếng Việt', 520, 'Book', 110, 198000.00, 240000.00, NULL, '16 x 24 cm', ''),
(37, 'Steve Jobs', 'NXB Trẻ', '2025-02-06', '', 'Tiểu sử Steve Jobs.', 2025, 'Tiếng Việt', 656, 'Book', 60, 225000.00, 270000.00, NULL, '16 x 24 cm', ''),
(39, 'Sherlock Holmes Toàn Tập', 'NXB Văn Học', '2025-02-10', '', 'Tuyển tập trinh thám kinh điển.', 2025, 'Tiếng Việt', 780, 'Book', 50, 260000.00, 320000.00, NULL, '16 x 24 cm', ''),
(40, 'Kafka Bên Bờ Biển', 'NXB Hội Nhà Văn', '2025-02-12', '', 'Tiểu thuyết nổi tiếng của Murakami.', 2025, 'Tiếng Việt', 540, 'Book', 65, 175000.00, 210000.00, NULL, '15 x 23 cm', ''),
(41, 'Rừng Na Uy', 'NXB Hội Nhà Văn', '2025-02-13', '', 'Tác phẩm văn học Nhật Bản nổi tiếng.', 2025, 'Tiếng Việt', 500, 'Book', 70, 168000.00, 195000.00, NULL, '15 x 23 cm', ''),
(43, 'The Little Prince English Edition', 'NXB Trẻ', '2025-02-16', '', 'Hoàng tử bé bản tiếng Anh.', 2025, 'English', 128, 'Book', 90, 78000.00, 95000.00, NULL, '13 x 18 cm', ''),
(55, 'The Hobbit', 'NXB Văn Học', '2025-03-07', '', 'Tiểu thuyết fantasy kinh điển.', 2025, 'Tiếng Việt', 390, 'Book', 85, 138000.00, 160000.00, NULL, '14 x 20 cm', '');

-- --------------------------------------------------------

--
-- Table structure for table `productreview`
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
(1, 1, 109, 5, 'lại nữa nha', '2026-05-10 15:34:01', NULL),
(2, 2, 110, 4, 'Câu chuyện ý nghĩa, truyền cảm hứng theo đuổi ước mơ. Giao hàng nhanh.', '2026-04-10 09:00:00', NULL),
(3, 3, 111, 5, 'Sách hay cho những ai muốn phát triển bản thân và khả năng lãnh đạo.', '2026-04-15 11:20:00', NULL),
(4, 5, 112, 4, 'Kiến thức sâu sắc về tâm lý học, nhưng hơi khó đọc.', '2026-04-18 08:15:00', NULL),
(5, 7, 113, 5, 'Cuốn sách chữa lành tâm hồn, rất phù hợp cho người trẻ.', '2026-04-20 20:30:00', NULL),
(6, 1, 114, 5, 'Mình đã mua tặng bạn và rất thích! Sách đẹp, nội dung xuất sắc.', '2026-04-22 16:45:00', NULL),
(7, 4, 109, 4, 'Cuốn sách giúp thay đổi thói quen ngủ, mình thấy hiệu quả.', '2026-04-25 10:00:00', NULL),
(10, 22, 109, 5, 'Hay nha', '2026-05-10 11:04:16', NULL),
(20, 24, 109, 5, 'Sách cực kỳ thực tế và dễ áp dụng.', '2026-05-11 01:10:03', NULL),
(21, 25, 110, 5, 'Rất phù hợp cho sinh viên cần tập trung học tập.', '2026-05-11 01:10:03', NULL),
(22, 26, 111, 5, 'Clean Code đúng là sách nên đọc cho dev.', '2026-05-11 01:10:03', NULL),
(23, 27, 112, 4, 'Nội dung hay và dễ đọc.', '2026-05-11 01:10:03', NULL),
(24, 28, 113, 5, 'Mở rộng góc nhìn rất nhiều.', '2026-05-11 01:10:03', NULL),
(25, 34, 114, 5, 'Cuốn sách lịch sử đáng đọc.', '2026-05-11 01:10:03', NULL),
(26, 44, 109, 4, 'Python dễ hiểu cho người mới.', '2026-05-11 01:10:03', NULL),
(27, 56, 110, 5, 'Bản in đẹp.', '2026-05-11 01:10:03', NULL),
(28, 59, 111, 5, 'Manga in rõ nét.', '2026-05-11 01:10:03', NULL),
(29, 70, 112, 5, 'Spring Boot trình bày rất thực tế.', '2026-05-11 01:10:03', NULL),
(30, 24, 111, 5, 'Cuốn sách thay đổi tư duy của mình về những thói quen nhỏ nhất.', '2026-05-11 11:18:50', NULL),
(31, 25, 112, 5, 'Kỹ năng tập trung sâu là thứ cực kỳ quan trọng trong thời đại này.', '2026-05-11 11:18:50', NULL),
(32, 26, 113, 5, 'Mọi lập trình viên đều nên đọc cuốn này nếu muốn nâng tầm kỹ năng.', '2026-05-11 11:18:50', NULL),
(33, 27, 114, 4, 'Tâm lý học về tiền rất hay, giúp mình bớt chi tiêu cảm tính.', '2026-05-11 11:18:50', NULL),
(34, 28, 115, 5, 'Adam Grant viết rất lôi cuốn, học cách tư duy lại không bao giờ là thừa.', '2026-05-11 11:18:50', NULL),
(35, 31, 116, 4, 'Kiến thức tài chính vỡ lòng, rất dễ hiểu cho người mới.', '2026-05-11 11:18:50', NULL),
(36, 32, 110, 5, 'Start with why giúp mình tìm lại động lực trong công việc.', '2026-05-11 11:18:50', NULL),
(37, 34, 109, 5, 'Lược sử loài người quá đồ sộ và lôi cuốn, mở mang tầm mắt.', '2026-05-11 11:18:50', NULL),
(38, 39, 111, 5, 'Bản in Sherlock Holmes này rất đẹp, bìa cứng cầm chắc tay.', '2026-05-11 11:18:50', NULL),
(39, 40, 112, 4, 'Phong cách của Murakami luôn mang lại cảm giác hư ảo đặc biệt.', '2026-05-11 11:18:50', NULL),
(40, 55, 113, 5, 'The Hobbit là khởi đầu tuyệt vời cho những ai yêu thích Fantasy.', '2026-05-11 11:18:50', NULL),
(41, 11, 114, 5, 'Câu chuyện triết học giúp mình hiểu về các triết gia một cách nhẹ nhàng.', '2026-05-11 11:18:50', NULL),
(42, 16, 115, 5, 'Hoàng tử bé - Đọc lại lần nào cũng thấy xúc động như lần đầu.', '2026-05-11 11:18:50', NULL),
(43, 19, 116, 4, 'Văn phong của Hemingway mạnh mẽ và đầy nghị lực.', '2026-05-11 11:18:50', NULL),
(44, 7, 110, 5, 'Hiểu về trái tim giúp mình bình an hơn rất nhiều.', '2026-05-11 11:18:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
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
(1, 'media/products/dac-nhan-tam.jpg', 1, '2025-12-01 00:00:00'),
(2, 'media/products/nha-gia-kim.jpg', 1, '2025-12-01 00:00:00'),
(3, 'media/products/nha-lanh-dao-khong-chuc-danh.jpg', 1, '2025-12-01 00:00:00'),
(4, 'media/products/doi-ngan-dung-ngu-dai.jpg', 1, '2025-12-01 00:00:00'),
(5, 'media/products/tu-duy-nhanh-va-cham.jpg', 1, '2025-12-01 00:00:00'),
(6, 'media/products/tu-duy-tich-cuc.jpg', 1, '2025-12-01 00:00:00'),
(7, 'media/products/hieu-ve-trai-tim.jpg', 1, '2025-12-01 00:00:00'),
(8, 'media/products/dam-bi-ghet.jpg', 1, '2025-12-01 00:00:00'),
(9, 'media/products/gardening-at-longmeadow.jpg', 1, '2025-12-01 00:00:00'),
(10, 'media/products/van-hoa-am-thuc-viet-nam.jpg', 1, '2025-12-01 00:00:00'),
(11, 'media/products/cau-chuyen-triet-hoc.jpg', 1, '2025-12-01 00:00:00'),
(12, 'media/products/cho-toi-xin-mot-ve-di-tuoi-tho.jpg', 1, '2026-05-01 00:00:00'),
(13, 'media/products/chu-chim-ti-hon.jpg', 1, '2026-05-01 00:00:00'),
(14, 'media/products/dai-viet-su-ky-toan-thu.jpg', 1, '2026-05-01 00:00:00'),
(15, 'media/products/de-men-phieu-luu-ky.jpg', 1, '2026-05-01 00:00:00'),
(16, 'media/products/hoang-tu-be.jpg', 1, '2026-05-01 00:00:00'),
(17, 'media/products/ky-thuat-lap-trinh-c.jpg', 1, '2026-05-01 00:00:00'),
(18, 'media/products/night-flights.jpg', 1, '2026-05-01 00:00:00'),
(19, 'media/products/ong-gia-va-bien-ca.jpg', 1, '2026-05-01 00:00:00'),
(20, 'media/products/tam-hon-cao-thuong.jpg', 1, '2026-05-01 00:00:00'),
(21, 'media/products/bach-khoa-khoa-hoc-cho-tre-em.jpg', 1, '2026-05-01 00:00:00'),
(22, 'media/uploads/1778410950_18.jpg', NULL, NULL),
(23, 'media/uploads/1778410962_12.jpg', NULL, NULL),
(24, 'media/uploads/1778440323_atomic-habit.jpg', NULL, NULL),
(25, 'media/uploads/1778440401_deep-work-book.png', NULL, NULL),
(26, 'media/uploads/1778471424_clean-code-book.png', NULL, NULL),
(27, 'media/uploads/1778471464_tam-li-hoc-ve-tien.jpg', NULL, NULL),
(28, 'media/uploads/1778471534_THINKAGAINcover.jpg', NULL, NULL),
(29, 'media/uploads/1778471570_ikigai_the_japanese_secret_to_a_long_and_happy_life_1_2019_01_21_16_02_28.webp', NULL, NULL),
(31, 'media/uploads/1778471702_rich-dad-poor-dad-10.jpg', NULL, NULL),
(32, 'media/uploads/1778471759_start-with-why.jpg', NULL, NULL),
(33, 'media/uploads/1778471792_khoi-nghiep-tinh-gon-1.jpg', NULL, NULL),
(34, 'media/uploads/1778471893_sapiens.jpg', NULL, NULL),
(37, 'media/uploads/1778471964_steve-job.jpg', NULL, NULL),
(39, 'media/uploads/1778472024_tron-bo-3-tap-sherlock-holmes-toan-tap-tap-123-bia-cung.jpg', NULL, NULL),
(40, 'media/uploads/1778472149_kafka-ben-bo-bien.jpg', NULL, NULL),
(41, 'media/uploads/1778472210_rung-na-uy.jpg', NULL, NULL),
(43, 'media/uploads/1778472553_the-littile-princess.jpg', NULL, NULL),
(55, 'media/uploads/1778472401_th-hobbit.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `qa`
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
-- Dumping data for table `qa`
--

INSERT INTO `qa` (`id`, `question`, `answer`, `category`, `user_id`, `status`, `created_at`) VALUES
(1, 'Nhà sách Phương Nam hỗ trợ những phương thức thanh toán nào?', 'Chúng tôi chấp nhận thanh toán bằng Thẻ tín dụng (Visa, Mastercard), E-Wallet (Momo, ZaloPay) và COD (thanh toán khi nhận hàng).', 'Thanh toán', NULL, 'answered', '2025-12-02 15:50:37'),
(2, 'Làm thế nào để đổi trả sản phẩm?', 'Quý khách vui lòng liên hệ bộ phận hỗ trợ trong vòng 7 ngày kể từ ngày nhận hàng để được hướng dẫn chi tiết. Sản phẩm cần còn nguyên tem mác và chưa qua sử dụng.', 'Đổi trả', NULL, 'answered', '2025-12-02 15:50:37'),
(3, 'Nhà sách có giao hàng toàn quốc không?', 'Có, chúng tôi giao hàng trên toàn quốc. Thời gian giao hàng từ 2-7 ngày tùy khu vực. Phí vận chuyển sẽ được tính dựa trên địa chỉ nhận hàng.', 'Vận chuyển', NULL, 'answered', '2025-12-07 10:00:00'),
(4, 'Làm sao để tích lũy điểm thưởng FPoint?', 'Quý khách sẽ tích lũy 1 điểm cho mỗi 10.000đ chi tiêu. Điểm thưởng có thể đổi thành voucher giảm giá cho các đơn hàng tiếp theo.', 'Thành viên', NULL, 'answered', '2025-12-07 10:00:00'),
(5, 'Có xuất hóa đơn VAT không?', 'Có. Quý khách vui lòng cung cấp thông tin công ty và email nhận hóa đơn trong vòng 24 giờ sau khi đặt hàng.', 'Thanh toán', NULL, 'answered', '2026-01-08 11:00:00'),
(6, 'Thời gian xử lý đơn trung bình bao lâu?', 'Đơn nội thành TP.HCM thường giao trong 1-3 ngày; đơn liên tỉnh 3-7 ngày tùy đơn vị vận chuyển.', 'Vận chuyển', NULL, 'answered', '2026-01-15 09:20:00'),
(7, 'Có cho xem sách tại cửa hàng trước khi mua online không?', 'Có. Quý khách có thể đến các cửa hàng trong hệ thống để xem sách; đặt online vẫn được áp dụng khuyến mãi website.', 'Mua hàng', NULL, 'answered', '2026-02-01 14:45:00'),
(8, 'Làm sao để đổi địa chỉ nhận hàng sau khi đặt?', 'Nếu đơn chưa chuyển giao, vui lòng gọi hotline hoặc chat CSKH ngay với mã đơn để được hỗ trợ.', 'Đơn hàng', NULL, 'answered', '2026-02-14 08:50:00'),
(9, 'Sách có bản ebook không?', 'Một số đầu có bản ebook chính thức; vui lòng xem ghi chú trên trang sản phẩm hoặc liên hệ nhân viên.', 'Sản phẩm', NULL, 'answered', '2026-03-03 16:10:00'),
(10, 'Chính sách bảo hành với văn phòng phẩm?', 'Sản phẩm lỗi do nhà sản xuất được đổi trong 7 ngày kể từ ngày mua, kèm hóa đơn.', 'Đổi trả', NULL, 'answered', '2026-03-20 10:25:00'),
(11, 'Có giao hàng nhanh trong ngày không?', 'Hiện chỉ áp dụng cho một số quận trung tâm TP.HCM với đơn đặt trước 12h; phụ phí có thể phát sinh.', 'Vận chuyển', NULL, 'answered', '2026-04-05 13:40:00'),
(12, 'Test', 'Câu hỏi test', 'Chung', NULL, 'pending', '2026-05-10 10:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key_name`, `value`) VALUES
(1, 'phone', '028 3832 3457'),
(2, 'email', 'hotro@pnc.com.vn'),
(3, 'address', 'Lầu 1, Số 940 Đường 3/2, Phường Phú Thọ, TP. Hồ Chí Minh'),
(4, 'hotline', '1900 6656'),
(5, 'fanpage', 'https://facebook.com/nhasachphuongnam'),
(6, 'business_hours', 'Thứ 2 - Thứ 7: 8:00 - 21:00\r\nChủ Nhật: 8:00 - 18:00'),
(7, 'instagram_url', 'https://www.instagram.com/nhasachphuongnam.official/'),
(8, 'youtube_url', 'https://www.youtube.com/@nhasachphuongnam.official'),
(9, 'tiktok_url', 'https://www.tiktok.com/@nhasach.phuongnam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'customer',
  `account_status` varchar(20) NOT NULL DEFAULT 'active',
  `note` text DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `fullname`, `email`, `phone`, `avatar`, `role`, `account_status`, `note`, `created_date`) VALUES
(106, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Admin Demo', 'admin@phuongnam.com.vn', '0987654321', NULL, 'admin', 'active', 'DemoBTLSieuTot123 — xóa khi production', '2022-10-01'),
(107, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Nhân viên Demo', 'staff@phuongnam.com.vn', '0987000001', NULL, 'staff', 'active', 'DemoBTLSieuTot123 — xóa khi production', '2023-03-15'),
(109, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Khách hàng Demo', 'khachhang.demo@phuongnam.com.vn', '0912345679', 'media/uploads/avatars/u109_1778385734.jpg', 'customer', 'active', 'Đăng nhập test chính cho khách', '2026-04-26'),
(110, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Nguyễn Văn Bình', 'binh.nguyen@gmail.com', '0912345678', NULL, 'customer', 'active', NULL, '2026-04-01'),
(111, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Trần Thị Mai', 'mai.tran@gmail.com', '0923456789', NULL, 'customer', 'active', NULL, '2026-04-05'),
(112, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Phạm Văn Tuấn', 'tuan.pham@gmail.com', '0934567890', NULL, 'customer', 'active', NULL, '2026-04-10'),
(113, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Hoàng Thị Lan', 'lan.hoang@gmail.com', '0945678901', NULL, 'customer', 'active', NULL, '2026-04-12'),
(114, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Vũ Minh Đức', 'duc.vu@gmail.com', '0956789012', NULL, 'customer', 'active', NULL, '2026-04-15'),
(115, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Ngô Thị Hồng', 'hong.ngo@gmail.com', '0967890123', NULL, 'customer', 'active', NULL, '2026-04-18'),
(116, '$2y$10$tQAl.TVT2SUhhA2VSIxxUeGMd7S6okq81jvyAP4yQ2hujpNUPg/qa', 'Đỗ Văn Hùng', 'hung.do@gmail.com', '0978901234', NULL, 'customer', 'active', NULL, '2026-04-20');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL COMMENT 'Tên người nhận',
  `recipient_phone` varchar(20) NOT NULL COMMENT 'Số điện thoại người nhận',
  `province_name` varchar(255) NOT NULL COMMENT 'Tên Tỉnh/Thành phố',
  `ward_name` varchar(255) NOT NULL COMMENT 'Tên Phường/Xã',
  `street_address` varchar(500) NOT NULL COMMENT 'Số nhà, tên đường',
  `full_address` text NOT NULL COMMENT 'Địa chỉ đầy đủ',
  `is_default` tinyint(1) DEFAULT 0 COMMENT '1 = Địa chỉ mặc định',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`address_id`, `user_id`, `recipient_name`, `recipient_phone`, `province_name`, `ward_name`, `street_address`, `full_address`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 109, 'Khách hàng Demo', '0901234567', 'TP. Hồ Chí Minh', 'Phường Bến Nghé', '123 Lê Lợi', '123 Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh', 1, '2026-04-26 10:30:00', '2026-04-26 10:30:00'),
(2, 110, 'Nguyễn Văn Bình', '0912345678', 'TP. Hồ Chí Minh', 'Phường Thảo Điền', '45 Nguyễn Văn Hưởng', '45 Nguyễn Văn Hưởng, Phường Thảo Điền, Quận 2, TP. Hồ Chí Minh', 1, '2026-04-26 10:30:00', '2026-04-26 10:30:00'),
(3, 111, 'Trần Thị Mai', '0923456789', 'Hà Nội', 'Phường Kim Mã', '78 Kim Mã', '78 Kim Mã, Phường Kim Mã, Quận Ba Đình, Hà Nội', 1, '2026-04-26 10:30:00', '2026-04-26 10:30:00'),
(4, 112, 'Phạm Văn Tuấn', '0934567890', 'Đà Nẵng', 'Phường Hòa Cường', '234 Nguyễn Hữu Thọ', '234 Nguyễn Hữu Thọ, Phường Hòa Cường, Quận Hải Châu, Đà Nẵng', 1, '2026-04-26 10:30:00', '2026-04-26 10:30:00'),
(5, 113, 'Hoàng Thị Lan', '0945678901', 'TP. Hồ Chí Minh', 'Phường Tân Định', '567 Hai Bà Trưng', '567 Hai Bà Trưng, Phường Tân Định, Quận 1, TP. Hồ Chí Minh', 0, '2026-04-26 10:30:00', '2026-04-26 10:30:00'),
(6, 113, 'Hoàng Thị Lan', '0945678901', 'TP. Hồ Chí Minh', 'Phường Linh Trung', '89 Kha Vạn Cân', '89 Kha Vạn Cân, Phường Linh Trung, Thủ Đức, TP. Hồ Chí Minh', 1, '2026-04-26 10:30:00', '2026-04-26 10:30:00'),
(7, 114, 'Vũ Minh Đức', '0956789012', 'Hải Phòng', 'Phường Đằng Giang', '12 Lê Hồng Phong', '12 Lê Hồng Phong, Phường Đằng Giang, Quận Ngô Quyền, Hải Phòng', 1, '2026-04-26 10:30:00', '2026-04-26 10:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_phone`
--

CREATE TABLE `user_phone` (
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_phone`
--

INSERT INTO `user_phone` (`user_id`, `phone`) VALUES
(106, '0987654321'),
(109, '0909876543'),
(110, '0912987654'),
(111, '0923876543'),
(112, '0934765432'),
(114, '0956654321');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucher_code`, `usage_limit`, `used_count`, `start_time`, `end_time`, `min_order_value`, `max_sale_value`, `discount`) VALUES
('FREE_SHIP', 500, 2, '2025-12-01 00:00:00', '2025-12-31 23:59:59', 150000.00, 30000.00, 30000.00),
('SALE_10K', 1000, 2, '2025-12-01 00:00:00', '2025-12-31 23:59:59', 100000.00, 10000.00, 10000.00),
('SALE_15PERCENT', 300, 0, '2025-12-10 00:00:00', '2025-12-25 23:59:59', 300000.00, 100000.00, 45000.00),
('SALE_20K', 500, 0, '2025-12-01 00:00:00', '2025-12-31 23:59:59', 200000.00, 20000.00, 20000.00),
('WELCOME50', 200, 0, '2025-12-01 00:00:00', '2026-01-31 23:59:59', 0.00, 50000.00, 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`, `added_date`) VALUES
(1, 109, 5, '2026-04-01 10:00:00'),
(2, 109, 11, '2026-04-15 14:30:00'),
(3, 110, 2, '2026-04-05 09:00:00'),
(4, 110, 7, '2026-04-10 11:00:00'),
(5, 111, 1, '2026-04-08 16:30:00'),
(6, 111, 3, '2026-04-12 08:45:00'),
(7, 112, 6, '2026-04-18 13:20:00'),
(8, 113, 8, '2026-04-20 10:15:00'),
(9, 114, 4, '2026-04-22 17:00:00'),
(20, 109, 24, '2026-05-11 01:10:03'),
(21, 109, 34, '2026-05-11 01:10:03'),
(22, 110, 44, '2026-05-11 01:10:03'),
(23, 111, 56, '2026-05-11 01:10:03'),
(24, 112, 70, '2026-05-11 01:10:03'),
(25, 113, 65, '2026-05-11 01:10:03'),
(26, 114, 73, '2026-05-11 01:10:03');

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
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `uniq_product_customer` (`product_id`,`customer_id`),
  ADD KEY `FK_PR_Product` (`product_id`),
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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID đơn hàng', AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `productreview`
--
ALTER TABLE `productreview`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `qa`
--
ALTER TABLE `qa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
