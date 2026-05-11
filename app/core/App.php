<?php
/**
 * APP CLASS - Xử lý routing và khởi tạo controller
 */

class App {
    protected $controller = "HomeController"; // Trang mặc định
    protected $method = "index";
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();
        
        // Xử lý Controller
        if(isset($url[0]) && !empty($url[0])) {
            $controllerFile = APP_ROOT . '/controllers/' . ucfirst($url[0]) . 'Controller.php';
            
            if(file_exists($controllerFile)) {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            } else {
                // Controller không tồn tại → chuyển về landing
                $this->redirectToLanding();
                return;
            }
        }
        
        // Load controller
        require_once APP_ROOT . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Xử lý Method
        if(isset($url[1]) && !empty($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                // Method không tồn tại → chuyển về landing
                $this->redirectToLanding();
                return;
            }
        }
        
        // Xử lý Parameters
        $this->params = $url ? array_values($url) : [];

        // Gọi controller → method với params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parse URL thành mảng
     */
    private function parseURL() {
        if(isset($_GET["url"])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    /**
     * Chuyển về trang landing khi lỗi
     */
    private function redirectToLanding() {
        header('Location: ' . BASE_URL . 'landing');
        exit();
    }
}
