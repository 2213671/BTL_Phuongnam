<?php
/**
 * CONTROLLER BASE CLASS
 * Class cha cho tất cả controller
 */

class Controller {
    
    /**
     * Load Model
     */
    public function model($model) {
        $modelFile = APP_ROOT . '/models/' . $model . '.php';
        
        if(file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        } else {
            die("Model {$model}.php không tồn tại");
        }
    }

    /**
     * Load View
     */
    public function view($view, $data = []) {
        $viewFile = APP_ROOT . '/views/' . $view . '.php';
        
        if(file_exists($viewFile)) {
            // Chuyển array thành biến để dùng trong view
            extract($data);
            require_once $viewFile;
        } else {
            die("View {$view}.php không tồn tại");
        }
    }

    /**
     * Redirect đến URL khác
     */
    public function redirect($path = '') {
        header('Location: ' . BASE_URL . $path);
        exit();
    }

    /**
     * Kiểm tra phương thức request (cho form submit)
     */
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}
