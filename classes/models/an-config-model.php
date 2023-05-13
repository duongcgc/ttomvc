<?php

/** 
 * Định nghĩa class Config Model
 */

class AN_Config_Model {

    // Thuộc tính
    private $content_width;


    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo model

    }

    // Lấy giá trị của độ rộng content
    public function get_content_width() {
        return get_theme_mod('content_width', 750);
    }
}
