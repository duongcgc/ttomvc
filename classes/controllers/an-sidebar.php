<?php

/** 
 * Định nghĩa class base cho các sidebar
 */

class AN_Sidebar {

    // Thuộc tính
    private $sidebar_model = array();                 // model của sidebar    
    private $sidebar_content = array();                 // view content của sidebar    
    private $sidebar_data = array();                    // data ngắn hạn
    private $sidebar_view;                              // view của sidebar    

    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo sidebar - Lấy thông tin của Model
        $this->sidebar_model    = new AN_Sidebar_Model();
        $this->sidebar_view     = new AN_Sidebar_View();
    }

    // Tạo mới một sidebar
    // params = array key id, name, view
    public function add_aside($params = []) {

        // Nếu cung cấp id
        $this->sidebar_data['id']       = $params['id'];
        $this->sidebar_model->set_id($params['id']);


        // Nếu cung cấp name
        $this->sidebar_data['name']       = $params['name'];
        $this->sidebar_model->set_name($params['name']);


        // Nếu cung cấp class
        $this->sidebar_data['class']       = $params['class'];
        $this->sidebar_model->set_class($params['class']);


        // Đăng ký tới Admin UI       
        add_action('widgets_init', array($this, 'add_to_admin'));
    }

    // Thêm vào Admin
    public function add_to_admin() {

        // Render to View và trả lại view
        $this->sidebar_content = $this->sidebar_view->render($this->sidebar_data);

        // Đăng ký vào khu Giao diện > Widgets
        register_sidebar($this->sidebar_content);
    }
}
