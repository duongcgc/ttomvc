<?php

/** 
 * Định nghĩa class Sidebar Model
 */

class AN_Sidebar_Model {

    // Thuộc tính chính sidebar
    private $sidebar_id;            // ID of sidebar
    private $sidebar_name;          // Name of sidebar
    private $sidebar_class;         // Class of sidebar

    // Khởi tạo
    public function __construct($params = []) {

        // Nếu cung cấp id
        if (array_key_exists('id', $params)) {
            $this->sidebar_id   = $params['id'];
        } else {
            $this->sidebar_id   = 'sidebar-1';
        }

        // Nếu cung cấp name
        if (array_key_exists('name', $params)) {
            $this->sidebar_name   = $params['name'];
        } else {
            $this->sidebar_name   = esc_html__('Footer', 'ttomvc');
        }

        // Nếu cung cấp class
        if (array_key_exists('class', $params)) {
            $this->sidebar_class   = $params['class'];
        } else {
            $this->sidebar_class   = 'an_sidebar';
        }
    }

    // Lấy giá trị id của sidebar
    public function get_id() {
        return $this->sidebar_id;
    }

    // Lấy giá trị name của sidebar
    public function get_name() {
        return $this->sidebar_name;
    }

    // Lấy giá trị class của sidebar
    public function get_class() {
        return $this->sidebar_class;
    }

    // Gán giá trị id của sidebar
    public function set_id($id) {
        $this->sidebar_id = $id;
    }

    // Gán giá trị name của sidebar
    public function set_name($name) {
        $this->sidebar_name = $name;
    }

    // Gán giá trị class của sidebar
    public function set_class($class) {
        $this->sidebar_class = $class;
    }
}
