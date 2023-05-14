<?php

/** 
 * Định nghĩa class Content View của website
 */

class AN_Content_View {

    // Phương thức
    public function __construct() {
        // Thao tác khởi tạo
    }

    // Render View
    public function render($page) {
        $tpl_file = '/' . $page . '.tpl.php';
        include THEME_TPL . $tpl_file;
    }
}
