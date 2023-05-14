<?php

/** 
 * Định nghĩa class Header của website
 */

class AN_Header {

    // Thuộc tính
    private $header_view;

    // Phương thức

    public function __construct() {

        // Thao tác khởi tạo
        $this->header_view = new AN_Header_View;
        $this->header_view->render();
    }
}
