<?php
/**
 * QA CONTROLLER
 * Trang Hỏi/Đáp
 */

class QaController extends Controller {
    
    /**
     * Trang hỏi đáp chính
     */
    public function index() {
        $category = trim($_GET['category'] ?? 'all');
        
        $data = [
            'title' => 'Hỏi/Đáp - ' . APP_NAME,
            'page' => 'qa',
            'selectedCategory' => $category
        ];
        
        $this->view('qa', $data);
    }
}
