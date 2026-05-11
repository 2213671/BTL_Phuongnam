<?php

class AboutController extends Controller {

    public function index() {
        $adminModel = $this->model('Admin');
        $about_blocks = pn_about_parse_blocks($adminModel->getPageContent('about'));

        $this->view('about', [
            'title' => 'Giới thiệu - ' . APP_NAME,
            'page' => 'about',
            'about_blocks' => $about_blocks,
        ]);
    }
}
