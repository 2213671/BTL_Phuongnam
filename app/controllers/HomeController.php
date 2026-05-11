<?php
/**
 * HOME CONTROLLER
 * Xử lý các trang chính của website
 */

class HomeController extends Controller {

    /**
     * Trang chủ
     */
    public function index() {
        $newsModel = $this->model('NewsModel');
        $productModel = $this->model('ProductModel');

        // Tin nổi bật: lượt xem cao (ảnh lấy theo image_url → media/news/...)
        $featuredNews = $newsModel->getHotNews(3);
        $bestsellerProducts = $productModel->getBestsellerProducts(4);
        $newProducts = $productModel->getNewestProducts(4);

        $data = [
            'title' => 'Trang chủ - ' . APP_NAME,
            'page' => 'home',
            'featuredNews' => $featuredNews,
            'bestsellerProducts' => $bestsellerProducts,
            'newProducts' => $newProducts,
        ];

        $this->view('home', $data);
    }

    public function about() {
        $adminModel = $this->model('Admin');
        $about_blocks = pn_about_parse_blocks($adminModel->getPageContent('about'));

        $this->view('about', [
            'title' => 'Giới thiệu - ' . APP_NAME,
            'page' => 'about',
            'about_blocks' => $about_blocks,
        ]);
    }

    /**
     * Trang hỏi đáp
     */
    public function qa() {
        $data = [
            'title' => 'Hỏi/Đáp - ' . APP_NAME,
            'page' => 'qa'
        ];

        $this->view('qa', $data);
    }

    public function pricing() {
        $data = [
            'title' => 'Bảng giá - ' . APP_NAME,
            'page' => 'pricing',
            'description' => 'Bảng giá tham khảo sách và dịch vụ tại Nhà sách Phương Nam.',
            'keywords' => 'bang gia nha sach, gia sach, phuong nam',
            'ogTitle' => 'Bảng giá - Nhà sách Phương Nam',
            'ogDescription' => 'Cập nhật bảng giá sách và dịch vụ mới nhất tại Nhà sách Phương Nam.'
        ];

        $this->view('pricing', $data);
    }
}
