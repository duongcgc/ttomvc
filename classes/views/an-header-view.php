<?php

/** 
 * Định nghĩa class Header View của website
 */

class AN_Header_View {


    // Phương thức
    public function __construct() {
        // Thao tác khởi tạo
    }

    // Render View
    public function render() {
        include THEME_TPL . '/header.tpl.php';
    }
}
