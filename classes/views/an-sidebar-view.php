<?php

/** 
 * Định nghĩa class view cho các sidebar
 */

class AN_Sidebar_View {

    // Thuộc tính đầy đủ
    private $settings = array();

    // Khởi tạo
    public function __construct($params = []) {

        // Tập hợp thông tin từ controller
        if (array_key_exists('id', $params)) {
            $this->settings['id']                       = $params['id'];
        } else {
            $this->settings['id']                       = 'sidebar-id';
        }

        if (array_key_exists('class', $params)) {
            $this->settings['class']                    = $params['class'];
        } else {
            $this->settings['class']                    = 'sidebar-class';
        }

        if (array_key_exists('name', $params)) {
            $this->settings['name']                     = $params['name'];
        } else {
            $this->settings['name']                     = esc_html__('Sidebar Name', 'ttomvc');
        }

        // Thông tin mặc định
        $this->settings['before_widget']        = '<section id="%1$s" class="widget %2$s">';
        $this->settings['after_widget']         = '</section>';
        $this->settings['before_title']         = '<h2 class="widget-title">';
        $this->settings['after_title']          = '</h2>';
        $this->settings['show_in_rest']         = true;
    }

    // Render
    public function render($params = []) {

        // Tập hợp thông tin từ tham số vào
        if (array_key_exists('id', $params)) {
            $this->settings['id']                       = $params['id'];
        } else {
            $this->settings['id']                       = 'sidebar-id';
        }

        if (array_key_exists('class', $params)) {
            $this->settings['class']                    = $params['class'];
        } else {
            $this->settings['class']                    = 'sidebar-class';
        }

        if (array_key_exists('name', $params)) {
            $this->settings['name']                     = $params['name'];
        } else {
            $this->settings['name']                     = esc_html__('Sidebar Name', 'ttomvc');
        }

        // Tập hợp thông tin mặc định      
        $this->settings['before_widget']        = '<section id="%1$s" class="widget %2$s">';
        $this->settings['after_widget']         = '</section>';
        $this->settings['before_title']         = '<h2 class="widget-title">';
        $this->settings['after_title']          = '</h2>';
        $this->settings['show_in_rest']         = true;

        // Trả lại thông tin đầy đủ
        return $this->settings;
    }
}
