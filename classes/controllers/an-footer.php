<?php

/** 
 * Định nghĩa class Footer của website
 */

class AN_Footer {

    // Thuộc tính
    private $footer_view;

    // Phương thức

    public function __construct() {

        // Thao tác khởi tạo
        $this->footer_view = new AN_Footer_View;
        $this->footer_view->render();
    }
}
