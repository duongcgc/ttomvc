<?php

/** 
 * Định nghĩa class Footer View của website
 */

class AN_Footer_View {


    // Phương thức
    public function __construct() {
        // Thao tác khởi tạo
    }

    // Render View
    public function render() {
        include THEME_TPL . '/footer.tpl.php';
    }
}
