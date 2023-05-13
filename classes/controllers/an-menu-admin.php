<?php

/** 
 * Định nghĩa class base cho các menu admin
 */

class AN_Menu_Admin {

    // Thuộc tính
    private $location = array();

    // Khởi tạo
    public function __construct() {
    }

    // Thêm một vị trí trong Admin
    public function add_location($location_id = 'primary', $locaction_name = 'Primary menu') {

        // Thêm mới location
        $this->location[$location_id] = $locaction_name;

        // Hook vào action after_setup_theme hàm này        
        add_action("after_setup_theme", array($this, 'add_to_admin'));

        return $this;
    }

    // Đăng ký Menu
    public function add_to_admin() {
        register_nav_menus($this->location);
    }
}
