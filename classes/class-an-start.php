<?php

/** 
 * Định nghĩa class khởi động website
 */

class AN_Start {

    // Thuộc tính
    private $theme_setup;               // Setup Theme Module
    private $theme_menu;                // Setup Theme Menu

    // Phương thức
    public function __construct() {
        // Triển khai

        // Load code setup theme ===============>
        // Kiểm tra nếu tồn tại class AN_Setup thì tạo một đối tượng Setup

        require get_template_directory() . '/classes/class-an-setup.php';
        if (class_exists("AN_Setup")) {

            // Chạy các hàm setup
            $this->theme_setup = new AN_Setup();
        }

        // Load code menu theme ================>
        // Kiểm tra xem Tạo ra một đối tượng AN_Menu_Admin có thì tạo một đối tượng

        require get_template_directory() . '/classes/controllers/an-menu-admin.php';
        if (class_exists("AN_Menu_Admin")) {

            // Chạy chức năng menu
            $this->theme_menu = new AN_Menu_Admin();

            // Tạo UI Menu quản lý Giao diện > Menu
            $this->theme_menu
                ->add_location('primary', esc_html__('Primary menu', 'ttomvc'))
                ->add_location('secondary', esc_html__('Secondary menu', 'ttomvc'));
        }

        // Load code sidebar theme ================>
        // Kiểm tra xem Tạo ra một đối tượng AN_Sidebar có thì tạo một đối tượng

        require get_template_directory() . '/classes/controllers/an-sidebar.php';
        if (class_exists("AN_Sidebar")) {

            /**
             * Register widget area. 
             *
             * @since Twenty Twenty-One 1.0
             *
             * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
             *
             * @return void
             */
            $main_sidebar = new AN_Sidebar();
            $footer_sidebar = new AN_Sidebar();

            // Tạo UI quản lý Sidebar => Giao diện > Widgets
            $sidebar1 = array(
                'id' => 'sidebar-1',
                'name' => 'Main Sidebar',
                'class' => 'main-sidebar'
            );

            $sidebar2 = array(
                'id' => 'sidebar-2',
                'name' => 'Footer Sidebar',
                'class' => 'footer-sidebar'
            );


            $main_sidebar->add_aside($sidebar1);
            $footer_sidebar->add_aside($sidebar2);       // Reg a widget area with default settings

        }
    }
}
