<?php
/**
 * LANDING CONTROLLER
 * Trang chủ/Trang 404
 */

class LandingController extends Controller {
    
    /**
     * Trang landing chính (hoặc 404)
     */
    public function index() {
        $data = [
            'title' => 'Chào mừng đến với ' . APP_NAME,
            'is_404' => isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == '404'
        ];
        
        $this->view('landing', $data);
    }
}
