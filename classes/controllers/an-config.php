<?php

/** 
 * Định nghĩa class chứa các cấu hình web tổng - Global Config
 */

class AN_Config {

    // Thuộc tính
    private $config_data;                      // Config Model

    // Phương thức
    public function __construct() {

        // Loading code từ theme dir /classes/models/an-config-model.php
        require_once get_template_directory() . '/classes/models/an-config-model.php';

        // Thao tác khi bắt đầu
        $this->config_data = new AN_Config_Model();
    }
}
